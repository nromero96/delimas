<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageSetting;
use Illuminate\Support\Facades\Storage;


class LandingPageSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Obtener el menú guardado desde la base de datos
        $menuSetting = LandingPageSetting::where('key', 'weekly_menu')->first();
        $menus = $menuSetting ? json_decode($menuSetting->value, true) : [];


        $almuerzos = LandingPageSetting::where('key', 'almuerzos_saludables')->first();
        $dieta = LandingPageSetting::where('key', 'dieta_saludable')->first();

        // Decodificar JSON si existen datos
        $almuerzosData = $almuerzos ? json_decode($almuerzos->value, true) : [];
        $dietaData = $dieta ? json_decode($dieta->value, true) : [];

        return view('landing-promo/setting_page')->with(compact('menus', 'almuerzosData', 'dietaData'));
    }

    public function viewPage()
    {

        // Obtener el menú guardado desde la base de datos
        $menuSetting = LandingPageSetting::where('key', 'weekly_menu')->first();
        $menus = $menuSetting ? json_decode($menuSetting->value, true) : [];

        $almuerzos = LandingPageSetting::where('key', 'almuerzos_saludables')->first();
        $dieta = LandingPageSetting::where('key', 'dieta_saludable')->first();

        // Decodificar JSON si existen datos
        $almuerzosData = $almuerzos ? json_decode($almuerzos->value, true) : [];
        $dietaData = $dieta ? json_decode($dieta->value, true) : [];

        return view('landing-promo/index')->with(compact('menus', 'almuerzosData', 'dietaData'));
    }

    public function saveMenu(Request $request)
    {
        $menus = $request->input('menus', []);

        // Obtener los registros existentes
        $existingMenu = LandingPageSetting::where('key', 'weekly_menu')->first();
        $existingMenus = $existingMenu ? json_decode($existingMenu->value, true) : [];

        // Procesar imágenes y mantener las anteriores
        foreach ($menus as $menuIndex => $menu) {
            foreach ($menu['days'] as $day => $dayData) {
                if ($request->hasFile("menus.$menuIndex.days.$day.opt1_image")) {
                    $opt1_image = $request->file("menus.$menuIndex.days.$day.opt1_image");
                    $opt1_imagePath = $opt1_image->store('public/menu-semanal');
                    $menus[$menuIndex]['days'][$day]['opt1_image'] = str_replace('public/', 'storage/', $opt1_imagePath);
                } else {
                    $menus[$menuIndex]['days'][$day]['opt1_image'] = $existingMenus[$menuIndex]['days'][$day]['opt1_image'] ?? null;
                }

                if ($request->hasFile("menus.$menuIndex.days.$day.opt2_image")) {
                    $opt2_image = $request->file("menus.$menuIndex.days.$day.opt2_image");
                    $opt2_imagePath = $opt2_image->store('public/menu-semanal');
                    $menus[$menuIndex]['days'][$day]['opt2_image'] = str_replace('public/', 'storage/', $opt2_imagePath);
                } else {
                    $menus[$menuIndex]['days'][$day]['opt2_image'] = $existingMenus[$menuIndex]['days'][$day]['opt2_image'] ?? null;
                }

            }
        }

        // Guardar `menus` en otra fila separada
        $menuData = json_encode($menus, JSON_PRETTY_PRINT);
        if ($existingMenu) {
            $existingMenu->update(['value' => $menuData]);
        } else {
            LandingPageSetting::create([
                'key' => 'weekly_menu',
                'value' => $menuData,
            ]);
        }

        // Guardar en archivo JSON (opcional)
        Storage::put('public/menu.json', json_encode(['menus' => $menus], JSON_PRETTY_PRINT));

        return back()->with('success', 'Menú actualizado correctamente');
    }

    public function saveHealthPlans(Request $request)
    {
        $almuerzosSaludables = $request->input('almuerzos_saludables', []);
        $dietaSaludable = $request->input('dieta_saludable', []);

        // Obtener registros existentes
        $existingAlmuerzos = LandingPageSetting::where('key', 'almuerzos_saludables')->first();
        $existingDieta = LandingPageSetting::where('key', 'dieta_saludable')->first();

        // Convertir a JSON
        $almuerzosJson = json_encode($almuerzosSaludables, JSON_PRETTY_PRINT);
        $dietaJson = json_encode($dietaSaludable, JSON_PRETTY_PRINT);

        // Guardar `almuerzos_saludables`
        if ($existingAlmuerzos) {
            $existingAlmuerzos->update(['value' => $almuerzosJson]);
        } else {
            LandingPageSetting::create([
                'key' => 'almuerzos_saludables',
                'value' => $almuerzosJson,
            ]);
        }

        // Guardar `dieta_saludable`
        if ($existingDieta) {
            $existingDieta->update(['value' => $dietaJson]);
        } else {
            LandingPageSetting::create([
                'key' => 'dieta_saludable',
                'value' => $dietaJson,
            ]);
        }

        // Guardar en archivo JSON (opcional)
        Storage::put('public/planes_saludables.json', json_encode([
            'almuerzos_saludables' => $almuerzosSaludables,
            'dieta_saludable' => $dietaSaludable
        ], JSON_PRETTY_PRINT));

        return back()->with('success', 'Planes de salud actualizados correctamente');
    }

    public function getListHealthPlans(Request $request)
    {
        try {
            $product = $request->query('product'); // Obtener el parámetro product
            
            // Mapeo de nombres de producto a claves en la base de datos
            $map = [
                'Almuerzos saludables Estándar' => ['key' => 'almuerzos', 'type' => 'estandar'],
                'Almuerzos saludables Personalizado' => ['key' => 'almuerzos', 'type' => 'personalizado'],
                'Dieta saludable Estándar' => ['key' => 'dieta', 'type' => 'estandar'],
                'Dieta saludable Personalizado' => ['key' => 'dieta', 'type' => 'personalizado'],
            ];

            // Validar si el producto enviado es válido
            if (!isset($map[$product])) {
                return response()->json(['error' => 'Producto no encontrado'], 400);
            }

            $selectedKey = $map[$product]['key'];
            $selectedType = $map[$product]['type'];

            // Obtener los datos de la base de datos
            $settings = LandingPageSetting::whereIn('key', ['almuerzos_saludables', 'dieta_saludable'])
                ->pluck('value', 'key');

            // Decodificar JSON
            $almuerzosData = isset($settings['almuerzos_saludables']) ? json_decode($settings['almuerzos_saludables'], true) : [];
            $dietaData = isset($settings['dieta_saludable']) ? json_decode($settings['dieta_saludable'], true) : [];

            // Seleccionar los datos correctos
            $data = ($selectedKey === 'almuerzos') ? ($almuerzosData[$selectedType] ?? []) : ($dietaData[$selectedType] ?? []);

            // Solo devolver reducción y mantenimiento
            return response()->json([
                'pequeno' => $data['pequeno'] ?? [],
                'mediano' => $data['mediano'] ?? [],
                'reduccion' => $data['reduccion'] ?? [],
                'mantenimiento' => $data['mantenimiento'] ?? [],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los datos',
                'message' => $e->getMessage(),
            ], 500);
        }
    }





}

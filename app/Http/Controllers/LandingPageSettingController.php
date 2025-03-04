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

        $weeklyTitleSetting = LandingPageSetting::where('key', 'weekly_title')->first();
        $weekly_title = $weeklyTitleSetting ? $weeklyTitleSetting->value : '';

        // Obtener el menú guardado desde la base de datos
        $menuSetting = LandingPageSetting::where('key', 'weekly_menu')->first();
        $menus = $menuSetting ? json_decode($menuSetting->value, true) : [];

        return view('landing-promo/setting_page')->with(compact('menus', 'weekly_title'));
    }

    public function viewPage()
    {

        $weeklyTitleSetting = LandingPageSetting::where('key', 'weekly_title')->first();
        $weekly_title = $weeklyTitleSetting ? $weeklyTitleSetting->value : '';

        // Obtener el menú guardado desde la base de datos
        $menuSetting = LandingPageSetting::where('key', 'weekly_menu')->first();
        $menus = $menuSetting ? json_decode($menuSetting->value, true) : [];

        return view('landing-promo/index')->with(compact('menus', 'weekly_title'));
    }

    public function saveMenu(Request $request)
{
    $weeklyTitle = $request->input('weekly_title', 'Menú Semanal');
    $menus = $request->input('menus', []);

    // Obtener los registros existentes
    $existingTitle = LandingPageSetting::where('key', 'weekly_title')->first();
    $existingMenu = LandingPageSetting::where('key', 'weekly_menu')->first();
    $existingMenus = $existingMenu ? json_decode($existingMenu->value, true) : [];

    // Procesar imágenes y mantener las anteriores
    foreach ($menus as $menuIndex => $menu) {
        foreach ($menu['days'] as $day => $dayData) {
            if ($request->hasFile("menus.$menuIndex.days.$day.image")) {
                $image = $request->file("menus.$menuIndex.days.$day.image");
                $imagePath = $image->store('public/menu-semanal');
                $menus[$menuIndex]['days'][$day]['image'] = str_replace('public/', 'storage/', $imagePath);
            } else {
                $menus[$menuIndex]['days'][$day]['image'] = $existingMenus[$menuIndex]['days'][$day]['image'] ?? null;
            }
        }
    }

    // Guardar `weekly_title` en una fila separada
    if ($existingTitle) {
        $existingTitle->update(['value' => $weeklyTitle]);
    } else {
        LandingPageSetting::create([
            'key' => 'weekly_title',
            'value' => $weeklyTitle,
        ]);
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
    Storage::put('public/menu.json', json_encode(['weekly_title' => $weeklyTitle, 'menus' => $menus], JSON_PRETTY_PRINT));

    return back()->with('success', 'Menú actualizado correctamente');
}



}

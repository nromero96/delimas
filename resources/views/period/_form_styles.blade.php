<style>
    .period-form-panel {
        border: 0;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 6px 22px rgba(33, 52, 29, .10);
        overflow: hidden;
    }
    .period-form-panel__header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.25rem;
        color: #fff;
        background: linear-gradient(135deg, #659a20, #8ec500);
    }
    .period-form-panel__header i { font-size: 1.35rem; }
    .period-form-panel__header h5 { margin: 0; font-weight: 700; }
    .period-form-panel__body { padding: 1rem 1.25rem 1.25rem; }
    .period-schedule-table { margin-bottom: .5rem; }
    .period-schedule-table thead th {
        border: 0;
        color: #506047;
        background: #eef5e7;
        font-size: .76rem;
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .period-schedule-table tbody tr { border-bottom: 1px solid #edf0eb; }
    .period-schedule-table tbody tr:last-child { border-bottom: 0; }
    .period-schedule-table td { padding: .65rem .5rem; }
    .period-schedule-table .day-name { font-weight: 600; text-transform: capitalize; }
    .billing-toggle { border-radius: 10px; font-weight: 600; }
    .billing-card {
        border: 1px solid #dce8d3;
        border-radius: 14px;
        background: linear-gradient(180deg, #fbfdf9, #f3f8ef);
        box-shadow: 0 5px 16px rgba(56, 86, 45, .08);
    }
    .billing-card__title {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin-bottom: 1rem;
        color: #477a32;
        font-weight: 700;
    }
    .billing-card label { color: #53634c; font-size: .82rem; font-weight: 600; }
    .billing-card .form-control {
        border-color: #cddac5;
        background-color: #fff;
        font-weight: 600;
    }
    .billing-card .form-control:focus {
        border-color: #8ec500;
        box-shadow: 0 0 0 .2rem rgba(142, 197, 0, .16);
    }
    .billing-card #valtotalprice { color: #477a32; font-size: 1.15rem; }
    @media (max-width: 767.98px) {
        .period-form-panel__body { padding: .75rem; }
        .period-schedule-table { min-width: 500px; }
    }
</style>

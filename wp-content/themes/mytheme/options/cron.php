<?php
/*add_action('montheme_import_content', function () {
     touch(__DIR__ . '/demo-' . time());
});

//création d'un nouveau système de temps
add_filter('cron_schedules', function () {
    $schedules['ten seconds'] = [
        'interval' => 10,
        'display' => __('Toutes les 10 secondes', 'montheme'),
    ];
    return $schedules;
});

//supprimer l'enregistrement: wp_unschedule_event()
if ($timestamp = wp_next_scheduled('montheme_import_content')) {
    wp_unschedule_event($timestamp, 'montheme_import_content');
}


//fonction qui permet de renvoyer l'ensemble de cron: _get_cron_array()
echo '<pre>';
var_dump(_get_cron_array());
echo '</pre>';
die();

//renseignement d'un nouvel évènement
if (!wp_next_scheduled('montheme_import_content')) {
    wp_schedule_event(time(), 'hourly', 'montheme_import_content');
}*/
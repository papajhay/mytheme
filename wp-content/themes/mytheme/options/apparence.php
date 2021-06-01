<?php
add_action('customize_register', function(WP_Customize_Manager $manager){
      $manager->add_section('montheme_apparence', [
            'title'=> 'Personnalisation de l\'apparence',
      ]);

      $manager->add_setting('header_background', [
             'default' => '#FF0000',
             'sanitize_callback' => 'sanitize_hex_color'
      ]);

      // WP_Customize_Color_Control(): affichage de pic color sur la personnalisation de l'apparence
      $manager->add_control(new WP_Customize_Color_Control($manager, 'header_background', [
        'section' => 'montheme_apparence',
        'setting' => 'header_background',
   ]));
});

add_action('customize_preview_init', function () {
     wp_enqueue_script('montheme_apparence', get_template_directory_uri() . '/assets/apparence.js', ['jquery', 'customize-preview'], '', true);
});
<?php

class SponsoMetaBox {

    const META_KEY = "montheme_sponso";
     
    //permet d'enregistrer la boîte
    public static function register(){
        add_action('add_meta_boxes', [self::class, 'add']);
        add_action('save_post', [self::class, 'save']);
    }

    public static function add() {
        add_meta_box('montheme_sponso', 'Sponsoring', [self::class, 'render'], 'post', 'side');
    }

    public static function render($post) {
        $value=get_post_meta($post->ID, self::META_KEY, true);
        ?>
        <input type="hidden" value="0" name="<?= self::META_KEY ?>">
        <input type="checkbox" value="1" name="<?= self::META_KEY ?>" <?php checked($value, '1') ?>>
        <label for="monthemesponso">Cet article est sponsorisé</label>
        <?php
    }

    public static function save($post){
        
        if (array_key_exists(self::META_KEY, $_POST) && current_user_can('edit_post', $post)) {
            if ($_POST[self::META_KEY] === '0') {
                  delete_post_meta($post, self::META_KEY);
            }else {
                  update_post_meta($post, self::META_KEY, 1);
            }
      }
    }
}


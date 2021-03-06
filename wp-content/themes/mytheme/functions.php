<?php 

require_once('walker/CommentWalker.php');
require_once('options/apparence.php');
require_once('options/cron.php');

//add_theme_support(): fonction permet de rajouter qlq support de fonctionalité
function montheme_supports(){
      add_theme_support('title-tag');//afficher un titre
      add_theme_support( 'post-thumbnails' );//afficher une image
      add_theme_support('menus');//afficher le fichier menu dans l'apparence de tableau de bord
      add_theme_support('html5');
      register_nav_menu('header', 'En tête du menu');//pour enregistrer le menu la partie gestion(tableau de bord)
      register_nav_menu('footer', 'Pied de page');
      add_image_size('post_thumbnail', 1920, 1080, true);
     
}

function montheme_register_assets(){
      //wp_register_style: fonction permet d'enregistrer le style
      wp_register_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', []);
      wp_register_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', ['popper', 'jquery'], false, true);
      wp_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', [], false, true);
      if(!is_customize_preview()) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', [], false, true);
      }   
      //wp_enqueue_style: fonction permet d'utiliser le style
      wp_enqueue_style('bootstrap');
      wp_enqueue_script('bootstap');
}

function montheme_title_separator(){
      return '|';
}

/*function montheme_title_document_parts($title){
      return $title;
} */

function montheme_menu_class($classes){
    $classes[] = 'nav-item';
    return $classes;
}

function montheme_menu_link_class($attrs){
      $attrs['class'] = 'nav-link';
      return $attrs;
  }

function montheme_pagination(){
      $pages = paginate_links(['type' => 'array']);
      if ($pages === null) {
            return;
      }
      echo '<nav aria-label="Pagination">';
      echo '<ul class="pagination my-4">';
      foreach($pages as $page) {
            $active = strpos($page, 'current') !== false;
            $class = 'page-item';
            if ($active) {
                  $class .= ' active';
            }
            echo '<li class="'. $class .'">';
            echo str_replace('page-numbers','page-link', $page );
            echo '</li>';
      }
      echo '</ul>';
      echo '</nav>';

} 

function montheme_init() {
      register_taxonomy('sport', 'post', [
          'labels' => [
                'name' => 'Sport',
                'singular_name' => 'Sport',
                'plural_name'   => 'Sports',
                'search_items'  => 'Rechercher des sports',
                'all_items'     => 'Tous les sports',
                'edit_item'     => 'Editer le sport',
                'update_item'   => 'Mettre à jour le sport',
                'add_new_item'  => 'Ajouter un nouveau sport',
                'new_item_name' => 'Ajouter un nouveau sport',
                'menu_name'     => 'Sport',
          ],
          'show_in_rest'      => true,
          'hierarchical'      => true,
          'show_admin_column' => true,
      ]);

    
}

add_action('init', 'montheme_init');
//after_setup_theme : permet d'afficher le titre de site sur la barre de nvigation (ex:Mythemewp)
add_action('after_setup_theme','montheme_supports');
//wp_enqueue_scripts : fil d'attente de script et de styles censés apparaître sur le front-end 
add_action('wp_enqueue_scripts', 'montheme_register_assets');
//récupération de la séparation de la barre de navigation (ex: |)
add_filter('document_title_separator', 'montheme_title_separator');
//add_filter('document_title_parts', 'montheme_title_document_parts');
add_filter('nav_menu_css_class', 'montheme_menu_class');
add_filter('nav_menu_link_attributes', 'montheme_menu_link_class');

require_once('metaboxes/sponso.php');
require_once('options/agence.php');

SponsoMetaBox::register();
//déclaration des pages
AgenceMenuPage::register();

//ajouter des colonnes dans l'admnistration
add_filter('manage_bien_posts_columns', function ($columns){
      return [
            'cb' => $columns ['cb'],
            'thumbnail' => 'Minuature',
            'title' => $columns ['title'],
            'date' => $columns ['date']
      ];
});

add_filter('manage_bien_posts_custom_column', function ($column, $postId){
      if($column === 'thumbnail'){
               the_post_thumbnail('thumbnail', $postId);
      }
}, 10, 2);

add_action('admin_enqueue_scripts', function () {
      wp_enqueue_style('admin_montheme', get_template_directory_uri() . '/assets/admin.css');
});


add_filter('manage_post_posts_columns', function ($columns){
     $newColumns = [];
     foreach ($columns as $k => $v) {
           if ($k === 'date') {
               $newColumns['sponso'] = 'Article sponsorisé ?';
           }
           $newColumns[$k] = $v;
     }
        return $newColumns;
});

add_filter('manage_post_posts_custom_column', function ($column, $postId){
      if($column === 'sponso'){
            if (!empty(get_post_meta($postId, SponsoMetaBox::META_KEY, true))) {
                  $class = 'yes';
            }
            else {
                  $class = 'no';
            }
            echo '<div class = "bullet bullet-' . $class . '"></div>';
               
      }
}, 10, 2);

/**
 * @param WP_Query $query
 */
function montheme_pre_get_posts($query) {
      if (is_admin() || is_search() || !$query->is_main_query()) {
            return;
      }
      if (get_query_var('sponso') === '1') {
            $meta_query = $query->get('posts_per_page', []); 
            $meta_query[] = [
                  'key' => SponsoMetaBox::META_KEY,
                  'compare' => 'EXISTS',
            ];
            $query->set('meta_query', $meta_query);
      }
      
}

function montheme_query_vars($params){
     $params[] = 'sponso';
     return $params;
}

add_action('pre_get_posts', 'montheme_pre_get_posts');
add_filter('query_vars', 'montheme_query_vars');


require_once 'widgets/YoutubeWidget.php';
function montheme_register_widget () {
      register_widget(YoutubeWidget::class);
      register_sidebar([
             'id' => 'homepage',
             'name' => __('Sidebar Accueil', 'montheme'),
             'before_widget' => '<div class="p-4 %2$s" id="%1$s">',
             'after_widget' => '</div>',
             'before_title' => '<h4 class="font-italic">',
             'after_title' => '</h4>',
       ]);
}

add_action('widgets_init', 'montheme_register_widget');


add_filter('comment_form_default_fields', function($fields){
     $fields['email'] = <<<HTML
        <div class="form-group">
           <label for="email">Email</label>
           <input class='form-control' name='email' id='email' required>
        </div>
HTML;
      return $fields;
});


add_action('after_switch_theme', ' flush_rewrite_rules');
add_action('switch_theme', ' flush_rewrite_rules');
 

//pour la traduction pour une autre langue
//https://developer.wordpress.org/apis/handbook/internationalization/
add_action('after_setup_theme', function () {
     load_theme_textdomain('montheme', get_template_directory() . '/languages');
});


//API: https://developer.wordpress.org/rest-api
add_action('rest_api_init', function () {
      //enregistrement de route
      register_rest_route('mythemewp/v1', '/demo/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => function (WP_REST_Request $Request) {
                  $postID = (int)$Request->get_param('id');
                  $post = get_post($postID);
                  if ($post === null) {
                        return new WP_error('rien', 'On a rien à dire', ['status' => '404']);
                  } 
                 return $post->post_title;
            },
            'permission_callback' => function () {
                  return current_user_can('edit_posts');
            }
      ]);
});


add_filter( 'rest_authentication_errors', function( $result ) {
      if ( true === $result || is_wp_error( $result ) ) {
            return $result;
        }

     /** @var WP $wp */
     global $wp;
     //desactivation de l'authentification
     if (strpos($wp->query_vars ['rest_route'], 'mythemewp/v1') !== false) {
           return true;
     }
     return $result;
  }, 9);


  //fonction de lire le fichier et de nous renvoyer son contenu
  function mythemeReadData () {
        //vérification de lecture
        $data = wp_cache_get('data', 'mytheme');
        if ($data === false) {
            var_dump('Je lis');
            $data = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data');
            //Enregistre les données dans le cache. (60:nb de seconde)
            wp_cache_set('data', $data, 'mytheme', 60);
            //pour sauvegarder le requête entre les données en cache il faut ajouter une extension cache: w3 Total Cachetg 
        }
        return $data;
  }

  if (isset($_GET['cachetest'])) {
        var_dump(mythemeReadData ());
        var_dump(mythemeReadData ());
        var_dump(mythemeReadData ());
        die();
  }

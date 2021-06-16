<?php get_header() ?> <!--fonction d'insérer la partie en tête -->

   <?php if(have_posts()):  while (have_posts()):the_post() ;?>
       <h1><?php the_title()?></h1>
       <p>
          <img src="<?php the_post_thumbnail_url(); ?>" alt="" style="width:100%; height:auto;">
       </p>
       <?php the_content() ?>

      <!--fonction liée à l' ACF: récupértion de l'information dans la partie front--> 
       <?php if (get_field('jardin')==="true"): ?> 
          <p>
             <strong>Jardin:</strong><?= get_field('surface_jardin') ?>m²
          </p>
       <?php endif ?>
              
   <?php endwhile;
   endif; ?>
    

<?php get_footer() ?> <!--fonction d'insérer la partie pied de page -->
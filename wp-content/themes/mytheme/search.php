<?php get_header() ?> <!--fonction d'insérer la partie en tête -->


   <?php if (have_posts()) : ?>
      <div class="row">

          <?php while (have_posts()) : the_post(); ?><!--the_post():permet d'afficher l'article -->             
             <div class="col-sm-4">
                 <!--get_template_part():permet d'inclure d'un autre élément -->
                <?php get_template_part('parts/card', 'post'); ?>
            </div>  
          <?php endwhile ?>

      </div>

      <?php montheme_pagination() ?>

      <?= paginate_links() ?>

     <?php else : ?>
      <h1>Pas d'articles</h1> 
    <?php endif; ?>  

<?php get_footer() ?> <!--fonction d'insérer la partie pied de page -->
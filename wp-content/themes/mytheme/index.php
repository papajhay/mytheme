<?php get_header() ?> <!--fonction d'insérer la partie en tête -->
<form class="form-inline">
      <input type="search" name="s" class="form-control mb-2 mr-sm-2" value="<?= get_search_query() ?>" placeholder="Votre recherche">
      <div class="form-check mb-2 mr-sm-2">
            <input class="form-check-input" type="checkbox" value="1" name="sponso" id="inlineFormCheck" <?= checked('1', get_query_var('sponso')) ?> >
            <label class="form-check-label" for="inlineFormCheck">
               Article sponsorisé seulement.
            </label>
      </div>

      <button type="submit" class="btn btn-primary mb-2">Rechercher</button>
</form>

<h1 class="mb-4"><?= sprintf(apply_filters('montheme_search_title', "Resultat pour votre recherche \"%s\""), get_search_query()) ?></h1>
   <?php if(have_posts()): ?>
      <div class="row">
          <?php while (have_posts()):the_post(); ?><!--the_post():permet d'afficher l'article -->
             
             <div class="col-sm-4">
                 <!--get_template_part():permet d'inclure d'un autre élément -->
                <?php get_template_part('parts/card', 'post'); ?>
            </div>  
          <?php endwhile ?>
      </div>

      <?php montheme_pagination() ?>

      <?= paginate_links() ?>

     <?php else: ?>
      <h1>Pas d'articles</h1> 
    <?php endif; ?>  

<?php get_footer() ?> <!--fonction d'insérer la partie pied de page -->
<?php get_header() ?> <!--fonction d'insérer la partie en tête -->
<h1><?= esc_html(get_queried_object()->name)  ?></h1>

<p>
     <?= esc_html(get_queried_object()->description) ?> 
</p>
 <!-- get_terms()=>Récupère les termes de la taxonomie qui sont attachés à la publication.-->
<?php $sports = get_terms(['taxonomy' => 'sport']); ?>
<ul class="nav nav-pills my-4">
   <?php foreach ($sports as $sport): ?>
    <li class="nav-item">
     <!--get_term_link() => Générez un lien permanent pour une archive de termes de taxonomie
      is_tax() => Détermine si la requête concerne une page d'archive de taxonomie personnalisée existante-->
       <a href="<?= get_term_link($sport) ?>" class="nav-link <?= is_tax('sport', $sport->term_id) ? 'active' : '' ?>"> <?= $sport->name ?></a>
    </li>
   <?php endforeach; ?>
</ul>


   <?php if(have_posts()): ?>
      <div class="row">
          <?php while (have_posts()):the_post() ;?><!--the_post():permet d'afficher l'article -->
             
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
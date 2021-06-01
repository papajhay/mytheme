<?php 
//comptage des nombres de commentaire 

use Montheme\CommentWalker;

$count = absint(get_comments_number()); 
?>

<?php if ($count >0): ?>
<!--affichage nbs de commentaire si le nb de coms > 1 il prend un 's' -->
  <h2> <?= $count ?> Commentaire<?= $count > 1 ? 's' : '' ?></h2>
<?php else: ?> 
<h2>Laisser un commentaire</h2> 
<?php endif; ?>

<?php if (comments_open()): ?>
<!--affichage de formulaire sur le commentaire-->
   <?php comment_form(['total_reply' => '']) ?>
<?php endif; ?>

<!--affichage listes des commentaires-->
<?php wp_list_comments(['style' => 'div', 'walker' => new CommentWalker()]) ?>

<?php paginate_comments_links() ?>
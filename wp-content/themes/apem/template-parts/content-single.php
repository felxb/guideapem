<h1 class="post-title"><?php the_title(); ?></h1>

<div class="trait2px trait-rose"></div>

<h3 class="post-title-1"><?=__('Resume de l\'utilisation')?></h3>

<div>
  <?php the_field('resume_de_lutilisation_ui'); ?> 
</div>

<h3 class="post-title-1"><?=__('Procedure legale et administrative')?></h3>

<div class="single-procedure">
  <?php the_field('procedure_legale_et_administrative_ui'); ?> 
</div>

<h3 class="post-title-1"><?=__('Mises en garde et utilisations liees')?></h3>

<div>
  <?php the_field('mise_en_garde_et_utilisations_liees_ui'); ?> 
</div>


<?php

// check if the repeater field has rows of data
if( have_rows('utilisations_liees') ):

?>


<?php
 



$post_objects = get_field('utilisations_liees');

if( $post_objects ): ?>

	<h4 class="post-title-2"><?=__('Utilisation liées')?></h4>

    <ul class="list-utilisations-liees">
    <?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) 
      $post = $post['utilisation_liee'];
      ?>
        <li>
        	<li><a href="<?=get_permalink( $post->ID )?>" class="button">- <?=get_the_title( $post->ID )?></a></li>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif;


?>


<?php

endif;

?>

<div class="trait2px trait-rose margin-top"></div>



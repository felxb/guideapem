<?php

$args = array(
  'taxonomy' => 'types',
  'hide_empty' => true
);
foreach( get_terms( $args ) as $cat ) {
?>

    <li class="menu-sub-element-1 has-sub">
      <input style="display:none;" type="checkbox" id="input-submenu-<?=$cat->term_id;?>"/> 
      <label for="input-submenu-<?=$cat->term_id;?>" class="button">
        <div class="chevron">
        <?php
                      get_template_part( 'template-parts/svgs/chevron', 'content' );
                      ?>
                    </div>
        <span><?=$cat->name;?></span>
      </label>
      <ul class="sub">
        
<?php 
 $args = array(
  'post_type' => 'use',
  'tax_query' => array(
    array(
      'taxonomy' => 'types',
      'terms'    => $cat->term_id,
    ),
  ),
);
$query = new WP_Query( $args );

  while ( $query->have_posts() ) : $query->the_post(); 

  ?>
        <li class="menu-sub-element-2">
          <a class="button" href="<?=get_permalink()?>"><?=the_title()?></a>
        </li>
<?php 
  endwhile;

  echo '</ul>';
  }
  echo '</ul>';
?>
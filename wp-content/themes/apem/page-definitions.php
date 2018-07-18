<?php
get_header();
$query = new WP_Query( 
	array( 
		'post_type' => 'definitions',
		'orderby' => 'title',
		'order'   => 'ASC', 
	) 
);

$all_definitions =  $query->posts;
$letters = array();


echo '<table id="letters"><tr>';
foreach ($all_definitions as $definition) {
	$first_letter = strtoupper( substr( $definition->post_title, 0, 1) );
	if(!in_array($first_letter, $letters)) {
		$letters[] = $first_letter;
		?>
			<td class="lexique-letter">
				<a href="#<?= $definition->post_title ?>" >
					<?= $first_letter ?>
				</a>
			</td>
		<?php
	}
}
echo '</table></tr>';

echo '<div class="trait"></div>';

echo '<div class="definition-list">';

if ( $query->have_posts() ) :

 while ( $query->have_posts() ) : $query->the_post(); ?>   
    <div class="definition-container">
        <a id="<?php the_title(); ?>"></a><h2><?php the_title(); ?></h2>
        <?php echo get_field('definition'); ?>
    </div>
<?php endwhile; wp_reset_postdata();

endif;
echo '</div>';

get_footer();
?>

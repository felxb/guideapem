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

$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Œ' => 'o' );



echo '<table id="letters"><tr>';

foreach ($all_definitions as $definition) {

	$first_letter = strtoupper( substr( strtr( $definition->post_title , $unwanted_array ), 0, 1) );


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

<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package moonshine
 */

get_header(); 

?>


			<?php
				// Start the Loop.
			while ( have_posts() ) :
				the_post();
				?>

<div class="content"><?php the_content();?></div>

<?php
endwhile;

get_footer();

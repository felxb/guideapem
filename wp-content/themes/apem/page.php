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

get_header(); ?>

 <h1>Hello Page!</h1>

	<div id="primary" class="content-area">
	
		<div id="main" class="site-main ms-grid" role="main">

			<?php

				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', 'page' );
				endwhile; // End of the loop.
			
			?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

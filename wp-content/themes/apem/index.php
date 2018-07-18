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
 * @package shfl
 */
 get_header();?>

 <h1>Hello Index!</h1>
 
<?php if (get_field('no_margins')===true) {
	the_content();
} else { ?>
<div class="section-page section-default">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 content-wrapper">
			<?php if ( post_password_required() ) {
				echo "<div class='col-xs-12'>";
			 	echo get_the_password_form();
			 	echo "</div>";
		 	} else {
				while ( have_posts() ) : the_post();
					get_template_part( 'partials/content' , 'page');
				endwhile;		 		
		 	}
?>
			</div><!-- / col-xs-12 -->
		</div><!-- / row -->
	</div><!-- / container -->
</div><!-- / container-fluid -->
<?php } ?>
<?php get_footer();?>

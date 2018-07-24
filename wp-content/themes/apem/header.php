<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package moonshine
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php $siteTitle = wp_title('', false).(wp_title('', false)? ' | ':'').get_bloginfo('name');?>
	<title><?php echo $siteTitle; ?></title>
	<?php $description = get_bloginfo('description')?>
	<meta name="description" content="<?php echo $description; ?>">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if (wp_is_mobile()): ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<?php else: ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php endif; ?>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<script>
			$(document).ready(function(){
				$('[data-toggle="popover"]').popover(); 
				$("#share-input").change(function() {
					console.log('input changed')
					if(this.checked && $('#search-input').is(":checked")) {
						$('#search-input').prop('checked', false);
					}
				});
				$("#search-input").change(function() {
					if(this.checked && $('#share-input').is(":checked")) {
						$('#share-input').prop('checked', false);
					}
				});
			});
		</script>


		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<meta property="og:title" content="<?php echo $siteTitle; ?>" />
		<meta property="og:description" content="<?php echo $description; ?>" />

		<link rel="stylesheet" href="https://use.typekit.net/mog3aor.css">

		<?php $current_url = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";?>
		<?php $current_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];?>
		<meta property="og:url" content="<?php echo $current_url; ?>" />

		<?php if (is_singular(array('post','product'))) {?>
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<?php $image_id = get_post_thumbnail_id();?>
				<?php $image_url = wp_get_attachment_image_src($image_id,'large', true);?>
				<?php $image_url = $image_url[0];?>
				<meta property="og:image" content="<?php echo $image_url;?>"/>
				<meta property="og:type" content="article"/>
			<?php endwhile; endif; wp_reset_postdata();?>
		<?php } else {?>
			<meta property="og:image" content="<?php echo get_stylesheet_directory_uri();?>/images/guide-apem.png"/>
			<meta property="og:type" content="website"/>
		<?php }?>


		<?php 

		wp_reset_postdata();

		?>

		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_stylesheet_directory_uri(); ?>/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon-16x16.png">
		<link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(); ?>/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">


		<script src="https://use.typekit.net/vmp3qca.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>

		<?php wp_head();?>



</head>

	<body>

	<input id="menu-input" style="display:none;" type="checkbox"/>

	<nav id="sidebar">

		<label for="menu-input" id="menu-button-bar">
			<span id="menu-open-button">
				<div class="button button">
					<?php
					get_template_part( 'template-parts/svgs/menu', 'content' );
					?>


				</div>
			</span>
			<span id="menu-close-button">
				<div class="button button">
					<?php
					get_template_part( 'template-parts/svgs/close', 'content' );
					?>


				</div>
			</span>
		</label>
		
		<?php
		get_template_part( 'template-parts/menu/main', 'content' );
		?>

	</nav>

	<div id="page" class="site">

		<div id="page-header-and-content">

			<div id="page-title">

				<table width="100%">
					<tr>
						<td>
							<?php
							if( is_page('definitions')) {
								echo __('Lexique');
							}
							else if(is_page() && !is_page('Accueil')){
								wp_title('', true, '');
							} else {
								?>

								<div>
									<span class="header-title"><?=__('Guide d\'utilisation de la musique de l\'','shfl')?></span><span class="header-title-responsive"></span>


									<img style="vertical-align:middle; height:1em; width: inherit;" src="<?php echo get_template_directory_uri() . '/images/logo-header.svg'; ?>" />
								</div>

								<?php

							}
							?>
						</td>
						<td class="header-buttons-container">

							<div id="header-button-bar">

								<div>

									<label for="share-input" class="icon button button">

										<?php
										get_template_part( 'template-parts/svgs/share', 'content' );
										?>

										

									</label>

								</div>

								<div>
									<label for="search-input" class="icon button button">
										<?php
										get_template_part( 'template-parts/svgs/search', 'content' );
										?>
									</label>
								</div>
							</div>

						</td>
					</tr>
				</table>


			</div>


			<input id="search-input" style="display: none;" <?php 

			if ( is_search() ) {
				echo 'checked';
			}

			?> type="checkbox"/>

			<div id="search-bar" class="top-button-bar">
				<form role="search" method="get"  id="searchform" action="<?php echo home_url( '/' ); ?>">
					<input type="hidden" name="post_type" value="use" />
					<label for="s"><?=__('RECHERCHE: ')?></label>
					<input value="<?=get_search_query()?>" name="s"  type="text" 
					<?php 

					if ( !is_search() ) {
						echo 'autofocus';
					}

					?> 

					>
				</form>

				<label for="search-input" class="button">
					<?php
					get_template_part( 'template-parts/svgs/close', 'content' );
					?>
				</label>

			</div>

			<input id="share-input" style="display: none;" type="checkbox"/>

			<div id="share-bar">

				<div id="share-buttons-container" class="top-button-bar">

					<label for="share-input" class="button inline">
						<?php
						get_template_part( 'template-parts/svgs/close', 'content' );
						?>
					</label>

					<span>
						<?=__('Partagez avec ')?>
					</span>

					<span>
						<a href="https://twitter.com/share?url=<?php global $wp; echo home_url( $wp->request );?>&amp;text=APEM&amp;hashtags=APEM" target="_blank" class="button button">
							<?php
							get_template_part( 'template-parts/svgs/twitter', 'content' );
							?>

						</a>
					</span>
					<span>

						<a href="https://www.facebook.com/sharer/sharer.php?u=
						<?php global $wp; echo home_url( $wp->request );?>
						" target="_blank" class="icon button">
						<?php
						get_template_part( 'template-parts/svgs/facebook', 'content' );
						?>

					</a>
				</span>
				<span>

					<a href="mailto:?subject=APEM&amp;body=<?php global $wp; echo home_url( $wp->request );?>"
						title="APEM" class="icon button">
						<?php
						get_template_part( 'template-parts/svgs/mail', 'content' );
						?>

					</a>
				</span>
			</div>

		</div>

		<div id="content" class="site-content">
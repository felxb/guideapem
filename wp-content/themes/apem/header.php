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
	<?php if ( is_singular( array('masterpropage','propage') ) ): ?>
		<meta name="robots" content="noindex,nofollow">
	<?php endif; ?>
	<?php $siteTitle = 'APEM';
//  wp_title('',false).(is_product()&&get_field("hide_artist_in_title")!==1?' by '. get_the_title(get_field('product_artist')):'').(wp_title('', false)? ' | ':'').get_bloginfo('name') ;
// if (is_shop()) $siteTitle = 'Shop | Moonshine';
// $siteTitle = sanitize_text_field($siteTitle);
	?>
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
						console.log('if good')

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

		<meta property="fb:app_id" content="812344492225904"/>
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
			<meta property="og:image" content="<?php echo get_stylesheet_directory_uri();?>/img/moonshine-grey-on-purple-1280x943.png"/>
			<meta property="og:type" content="website"/>
		<?php }?>

		<?php

		$video_type=false;
		if (get_field('news_embed')){
			$newsEmbed = get_field('news_embed');
			$videoId = '';
			$video_type = false;
			if ( strpos($newsEmbed, 'youtube.com') !== false ) {
				$video_type = 'youtube';
				preg_match('/embed\/([\w+\-+]+)[\"\?]/',$newsEmbed,$videoId,PREG_OFFSET_CAPTURE,0); 
				$videoId = $videoId[1][0];
			}
		}

		if ($video_type=="youtube"){ ?>
			<meta property="og:type" content="video.other" />
			<meta property="og:video:url" content="https://www.youtube.com/embed/<?php echo $videoId; ?>" />
			<meta property="og:video:secure_url" content="https://www.youtube.com/embed/<?php echo $videoId; ?>" />
			<meta property="og:video:type" content="text/html" />
			<meta property="og:video:width" content="1280" />
			<meta property="og:video:height" content="720" />
			<meta property="og:video:url" content="http://www.youtube.com/v/<?php echo $videoId; ?>?version=3&amp;autohide=1" />
			<meta property="og:video:secure_url" content="https://www.youtube.com/v/<?php echo $videoId; ?>?version=3&amp;autohide=1" />
			<meta property="og:video:type" content="application/x-shockwave-flash" />
			<meta property="og:video:width" content="1280" />
			<meta property="og:video:height" content="720" />
		<?php } ?>


		<?php 
		/*Structured data for SEO*/
// if (is_home()||is_page(array('music','videos','events'))||is_archive()||is_singular(array('post','product')):

// 	$markup = '<script type="application/ld+json">';

// 	if (have_posts()): while (have_posts()) : the_post();

// 		$itemTitle = get_the_title().(get_post_type()=='product'&&!get_field("hide_artist_in_title")?' by '. get_the_title(get_field('product_artist')):'').' | '.get_bloginfo('name') ;

// 		$description = get_the_excerpt();

// 		$image_id = get_post_thumbnail_id();
// 		$image_url = wp_get_attachment_image_src($image_id,'large', true);
// 		$image_url = $image_url[0];

// 		$itemUrl = get_the_permalink();

// 		$id = get_the_ID();
// 		$itemDate = (get_post_type()=='product'?get_field('release_date'):get_field('moon_date'));
// 		$itemDate = date('Y-m-d\TH:i:sO',strtotime($itemDate));
// 		$publishDate = get_the_date('Y-m-d\TH:i:sO');

// 		$isEvent = get_field('event_bool');

// 		$isVideo = false ;
// 		$videoCategories = moonshine_get_category_ids(array('videos'));
// 		if (count($videoCategories[0])>0 && has_term( $videoCategories[0], 'category' ) ) $isVideo = true;
// 		if (count($videoCategories[1])>0 && has_term( $videoCategories[1], 'product_cat' ) ) $isVideo = true;



// 		$availabilityString = "OutOfStock";
// 		if (get_post_type()=='product'){
// 			$product = wc_get_product( $id );
// 			$availability = $product->is_in_stock();
// 			if ($availability==1&&get_field('hide_buy_button')!==1) $availabilityString = "InStock";
// 		} else if (time()<=strtotime($itemDate)){
// 			$availabilityString = "InStock";
// 		} 


// 		$availabilityString = "OutOfStock";
// 		$upcoming = time()<=strtotime($itemDate);

// 		if (get_post_type()=='product'){

// 			$product = wc_get_product( $id );
// 			$price = intVal($product->get_regular_price());
// 			$availability = $product->is_in_stock();

// 			if ($availability&&!get_field('hide_buy')) $availabilityString = "InStock";
// 			else $availabilityString = "OutOfStock";

// 		} else if ($isEvent && $upcoming){
// 			$availabilityString = "InStock";
// 		} else if ($isEvent && !$upcoming){
// 			$availabilityString = "OutOfStock";
// 		} else if ($id == 6210) { //for mixtape (special case)
// 			$availabilityString = "InStock";
// 		}

// 		/*music products, to be finished and then declared to google*/
// 		// if (get_post_type()=='product'&&get_field("music_product_boolean")){

// 		// 	$sameAsUrl = '';
// 		// 	$sameAsUrl = get_field("product_links")[0]["product_link_url"];
// 		// 	$markup = '
// 		// 	{
// 		// 	  "@context": "http://schema.org",
// 		// 	  "@type": "MusicAlbum",
// 		// 	  "url": "'.$itemUrl.'",
// 		// 	  "image": [
// 		// 	    "'.$image_url.'"
// 		// 	   ],
// 		// 	  "name": "'.$itemTitle.'",
// 		// 	  "sameAs": "'.$sameAsUrl.'",
// 		// 	  "description": "'.$description.'"
// 		// 	}';


// 		// } 

// 		/*other types of content*/

// 		if ($isVideo) {
// 			$markup .= '
// 			{
// 			  "@context": "http://schema.org",
// 			  "@type": "VideoObject",
// 			  "name": "'.$itemTitle.'",
// 			  "description": "'.$description.'",
// 			  "thumbnailUrl": "'.$image_url.'",
// 			  "uploadDate": "'.$itemDate.'",
// 			  "datePublished": "'.$publishDate.'",
// 			  "dateModified": "'.get_the_modified_date('Y-m-d\TH:i:sO').'",
// 			  "author": {
// 			    "@type": "Organization",
// 			    "name": "Moonshine",
// 			    "logo": {
// 			      "@type": "ImageObject",
// 			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png",
// 			    }	  
// 			  },
// 			  "publisher": {
// 			    "@type": "Organization",
// 			    "name": "Moonshine",
// 			    "logo": {
// 			      "@type": "ImageObject",
// 			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png"
// 			    }
// 			  },
// 			  "embedUrl": "'.get_field('news_embed',$id,false).'",
// 			}';

// 		} else if ($isEvent==1) {
// 			$ticketUrl = $itemUrl;
// 			if (get_field('main_ticket_url') && get_field('main_ticket_url') !== '') $ticketUrl = get_field('main_ticket_url');

// 			$markup .= '
// 			{
// 			  "@context": "http://schema.org",
// 			  "@type": "MusicEvent",
// 			  "location": {
// 			    "@type": "MusicVenue",
// 			    "name": "'.get_field('venue_name').'",
// 			    "address": "'.get_field('venue_address').'"
// 			  },
// 			  "name": "'.$itemTitle.'",
// 			  "image": "'.$image_url.'",
// 			  "offers": {
// 			    "@type": "Offer",
// 			    "url": "'.$ticketUrl.'",
// 			    "price": "'.get_field('event_price').'",
// 			    "priceCurrency": "'.get_field('event_currency').'",
// 			    "availability": "http://schema.org/'.$availabilityString.'"
// 			  },
// 			  "datePublished": "'.$publishDate.'",
// 			  "dateModified": "'.get_the_modified_date('Y-m-d\TH:i:sO').'",
// 			  "author": {
// 			    "@type": "Organization",
// 			    "name": "Moonshine",
// 			    "logo": {
// 			      "@type": "ImageObject",
// 			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png",
// 			    }	  
// 			  },
// 			  "performer": [';

// 			if (have_rows('event_performers')):
// 			  	while (have_rows('event_performers')): the_row();
// 			    $markup .= '{
// 			      "@type": "MusicGroup",
// 			      "name": "'.get_sub_field("performer_name").'",
// 			      "sameAs": "'.get_sub_field("performer_url").'"
// 			    }';
// 				endwhile;
// 			endif;

// 			$markup .= ' ],
// 				"startDate": "'.$itemDate.'",
// 			}';

// 		} else if (get_post_type()=='product') {
// 			$markup .= '
// 			{
// 			  "@context": "http://schema.org/",
// 			  "@type": "Product",
// 			  "name": "'.$itemTitle.'",
// 			  "image": "'.$image_url.'",
// 			  "description": "'.$description.'",
// 			  "mpn": "'.get_field('product_upc').'",
// 			  "brand": {
// 			    "@type": "Thing",
// 			    "name": "Moonshine"
// 			  },
// 			  "datePublished": "'.$publishDate.'",
// 			  "dateModified": "'.get_the_modified_date('Y-m-d\TH:i:sO').'",
// 			  "author": {
// 			    "@type": "Organization",
// 			    "name": "Moonshine",
// 			    "logo": {
// 			      "@type": "ImageObject",
// 			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png"
// 			    }	  
// 			  },
// 			  "offers": {
// 			    "@type": "Offer",
// 			    "priceCurrency": "CAD",
// 			    "price": "'.$price.'",
// 			    "priceValidUntil": "'.date('Y-m-d',time()+3600*24*30).'",
// 			    "itemCondition": "http://schema.org/NewCondition",
// 			    "availability": "http://schema.org/'.$availabilityString.'",
// 			    "seller": {
// 			      "@type": "Organization",
// 			      "name": "Moonshine"
// 			    }
// 			  }
// 			}';

// 		} else if (get_post_type()=='post') {
// 			$markup .= '
// 			{
// 			  "@context": "http://schema.org",
// 			  "@type": "NewsArticle",
// 			  "mainEntityOfPage": {
// 			    "@type": "WebPage",
// 			    "@id": "'.$current_url.'"
// 			  },
// 			  "headline": "'.$itemTitle.'",
// 			  "image": "'.$image_url.'",
// 			  "datePublished": "'.$publishDate.'",
// 			  "dateModified": "'.get_the_modified_date('Y-m-d\TH:i:sO').'",
// 			  "publisher": {
// 			    "@type": "Organization",
// 			    "name": "Moonshine",
// 			    "logo": {
// 			      "@type": "ImageObject",
// 			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png"
// 			    }
// 			  },
// 			  "author": {
// 			    "@type": "Organization",
// 			    "name": "Moonshine",
// 			    "logo": {
// 			      "@type": "ImageObject",
// 			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png",
// 			    }	  
// 			  },
// 			  "description": "'.$description.'"
// 			}';
// 		} 
// 		$markup .= ',';
// 	endwhile; endif;

// 	$markup .= '</script>';
// 	echo $markup;

// endif;
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


		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Work+Sans:400,700" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">


		<script src="https://use.typekit.net/vmp3qca.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>

		<?php wp_head();?>

		<?php if ( is_singular( array('masterpropage','propage') ) && get_field('propage_primary_color') ): ?>
		<style>
		.primary-color-text {
			color:<?php echo get_field('propage_primary_color');?>;
		}
		.primary-color-border {
			border-color:<?php echo get_field('propage_primary_color');?>;
		}
		.primary-color-background {
			background-color:<?php echo get_field('propage_primary_color');?>;
		}		
		.primary-color-bullet li::before {
			color:<?php echo get_field('propage_primary_color');?>;
		}
		.ms-post-container a, .ms-post-container a:link, .ms-post-container a:visited {
			color:<?php echo get_field('propage_secondary_color');?>;
		}
		.ms-post-container a:hover, .ms-post-container a:focus {
			color:<?php $color = get_field('propage_secondary_color'); echo moonshine_adjust_brightness($color,50);?>;
		}
		.secondary-color-text {
			color:<?php echo get_field('propage_secondary_color');?>;
		}
	</style>
<?php endif; ?>

<script>
// @TODO: Insert ga code
  // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  // (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  // m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  // })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  // ga('create', 'UA-77902920-1', 'auto');
  // ga('send', 'pageview');

</script>
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
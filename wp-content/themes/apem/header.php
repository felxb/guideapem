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
<?php $siteTitle = wp_title('',false).(is_product()&&get_field("hide_artist_in_title")!==1?' by '. get_the_title(get_field('product_artist')):'').(wp_title('', false)? ' | ':'').get_bloginfo('name') ;
if (is_shop()) $siteTitle = 'Shop | Moonshine';
$siteTitle = sanitize_text_field($siteTitle);
?>
<title><?php echo $siteTitle; ?></title>
<?php $description = (is_singular(array('post','product'))?get_the_excerpt():get_bloginfo('description'));
$description = sanitize_text_field($description);
?>
<meta name="description" content="<?php echo $description; ?>">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php if (wp_is_mobile()): ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<?php else: ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php endif; ?>

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<meta property="fb:app_id" content="812344492225904"/>
<meta property="og:title" content="<?php echo $siteTitle; ?>" />
<meta property="og:description" content="<?php echo $description; ?>" />

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
if (is_home()||is_page(array('music','videos','events'))||is_archive()||is_singular(array('post','product'))||is_shop()):

	$markup = '<script type="application/ld+json">';

	if (have_posts()): while (have_posts()) : the_post();

		$itemTitle = get_the_title().(get_post_type()=='product'&&!get_field("hide_artist_in_title")?' by '. get_the_title(get_field('product_artist')):'').' | '.get_bloginfo('name') ;

		$description = get_the_excerpt();

		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id,'large', true);
		$image_url = $image_url[0];

		$itemUrl = get_the_permalink();

		$id = get_the_ID();
		$itemDate = (get_post_type()=='product'?get_field('release_date'):get_field('moon_date'));
		$itemDate = date('Y-m-d\TH:i:sO',strtotime($itemDate));
		$publishDate = get_the_date('Y-m-d\TH:i:sO');

		$isEvent = get_field('event_bool');

		$isVideo = false ;
		$videoCategories = moonshine_get_category_ids(array('videos'));
		if (count($videoCategories[0])>0 && has_term( $videoCategories[0], 'category' ) ) $isVideo = true;
		if (count($videoCategories[1])>0 && has_term( $videoCategories[1], 'product_cat' ) ) $isVideo = true;



		$availabilityString = "OutOfStock";
		if (get_post_type()=='product'){
			$product = wc_get_product( $id );
			$availability = $product->is_in_stock();
			if ($availability==1&&get_field('hide_buy_button')!==1) $availabilityString = "InStock";
		} else if (time()<=strtotime($itemDate)){
			$availabilityString = "InStock";
		} 


		$availabilityString = "OutOfStock";
		$upcoming = time()<=strtotime($itemDate);

		if (get_post_type()=='product'){

			$product = wc_get_product( $id );
			$price = intVal($product->get_regular_price());
			$availability = $product->is_in_stock();
			
			if ($availability&&!get_field('hide_buy')) $availabilityString = "InStock";
			else $availabilityString = "OutOfStock";

		} else if ($isEvent && $upcoming){
			$availabilityString = "InStock";
		} else if ($isEvent && !$upcoming){
			$availabilityString = "OutOfStock";
		} else if ($id == 6210) { //for mixtape (special case)
			$availabilityString = "InStock";
		}

		/*music products, to be finished and then declared to google*/
		// if (get_post_type()=='product'&&get_field("music_product_boolean")){

		// 	$sameAsUrl = '';
		// 	$sameAsUrl = get_field("product_links")[0]["product_link_url"];
		// 	$markup = '
		// 	{
		// 	  "@context": "http://schema.org",
		// 	  "@type": "MusicAlbum",
		// 	  "url": "'.$itemUrl.'",
		// 	  "image": [
		// 	    "'.$image_url.'"
		// 	   ],
		// 	  "name": "'.$itemTitle.'",
		// 	  "sameAs": "'.$sameAsUrl.'",
		// 	  "description": "'.$description.'"
		// 	}';


		// } 

		/*other types of content*/

		if ($isVideo) {
			$markup .= '
			{
			  "@context": "http://schema.org",
			  "@type": "VideoObject",
			  "name": "'.$itemTitle.'",
			  "description": "'.$description.'",
			  "thumbnailUrl": "'.$image_url.'",
			  "uploadDate": "'.$itemDate.'",
			  "datePublished": "'.$publishDate.'",
			  "dateModified": "'.get_the_modified_date('Y-m-d\TH:i:sO').'",
			  "author": {
			    "@type": "Organization",
			    "name": "Moonshine",
			    "logo": {
			      "@type": "ImageObject",
			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png",
			    }	  
			  },
			  "publisher": {
			    "@type": "Organization",
			    "name": "Moonshine",
			    "logo": {
			      "@type": "ImageObject",
			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png"
			    }
			  },
			  "embedUrl": "'.get_field('news_embed',$id,false).'",
			}';

		} else if ($isEvent==1) {
			$ticketUrl = $itemUrl;
			if (get_field('main_ticket_url') && get_field('main_ticket_url') !== '') $ticketUrl = get_field('main_ticket_url');

			$markup .= '
			{
			  "@context": "http://schema.org",
			  "@type": "MusicEvent",
			  "location": {
			    "@type": "MusicVenue",
			    "name": "'.get_field('venue_name').'",
			    "address": "'.get_field('venue_address').'"
			  },
			  "name": "'.$itemTitle.'",
			  "image": "'.$image_url.'",
			  "offers": {
			    "@type": "Offer",
			    "url": "'.$ticketUrl.'",
			    "price": "'.get_field('event_price').'",
			    "priceCurrency": "'.get_field('event_currency').'",
			    "availability": "http://schema.org/'.$availabilityString.'"
			  },
			  "datePublished": "'.$publishDate.'",
			  "dateModified": "'.get_the_modified_date('Y-m-d\TH:i:sO').'",
			  "author": {
			    "@type": "Organization",
			    "name": "Moonshine",
			    "logo": {
			      "@type": "ImageObject",
			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png",
			    }	  
			  },
			  "performer": [';
			  
			if (have_rows('event_performers')):
			  	while (have_rows('event_performers')): the_row();
			    $markup .= '{
			      "@type": "MusicGroup",
			      "name": "'.get_sub_field("performer_name").'",
			      "sameAs": "'.get_sub_field("performer_url").'"
			    }';
				endwhile;
			endif;

			$markup .= ' ],
				"startDate": "'.$itemDate.'",
			}';

		} else if (get_post_type()=='product') {
			$markup .= '
			{
			  "@context": "http://schema.org/",
			  "@type": "Product",
			  "name": "'.$itemTitle.'",
			  "image": "'.$image_url.'",
			  "description": "'.$description.'",
			  "mpn": "'.get_field('product_upc').'",
			  "brand": {
			    "@type": "Thing",
			    "name": "Moonshine"
			  },
			  "datePublished": "'.$publishDate.'",
			  "dateModified": "'.get_the_modified_date('Y-m-d\TH:i:sO').'",
			  "author": {
			    "@type": "Organization",
			    "name": "Moonshine",
			    "logo": {
			      "@type": "ImageObject",
			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png"
			    }	  
			  },
			  "offers": {
			    "@type": "Offer",
			    "priceCurrency": "CAD",
			    "price": "'.$price.'",
			    "priceValidUntil": "'.date('Y-m-d',time()+3600*24*30).'",
			    "itemCondition": "http://schema.org/NewCondition",
			    "availability": "http://schema.org/'.$availabilityString.'",
			    "seller": {
			      "@type": "Organization",
			      "name": "Moonshine"
			    }
			  }
			}';

		} else if (get_post_type()=='post') {
			$markup .= '
			{
			  "@context": "http://schema.org",
			  "@type": "NewsArticle",
			  "mainEntityOfPage": {
			    "@type": "WebPage",
			    "@id": "'.$current_url.'"
			  },
			  "headline": "'.$itemTitle.'",
			  "image": "'.$image_url.'",
			  "datePublished": "'.$publishDate.'",
			  "dateModified": "'.get_the_modified_date('Y-m-d\TH:i:sO').'",
			  "publisher": {
			    "@type": "Organization",
			    "name": "Moonshine",
			    "logo": {
			      "@type": "ImageObject",
			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png"
			    }
			  },
			  "author": {
			    "@type": "Organization",
			    "name": "Moonshine",
			    "logo": {
			      "@type": "ImageObject",
			      "url": "https://moonshine.mu/ms/wp-content/uploads/2018/01/moonshine-tickets-app-logo.png",
			    }	  
			  },
			  "description": "'.$description.'"
			}';
		} 
		$markup .= ',';
	endwhile; endif;

	$markup .= '</script>';
	echo $markup;

endif;
wp_reset_postdata();

?>

<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans:400,700" rel="stylesheet">
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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-77902920-1', 'auto');
  ga('send', 'pageview');

</script>
</head>

<?php $additionalClasses = array('woocommerce','ms-initial-load','no-js');
if (isset($_REQUEST["solo"])){
	$additionalClasses[]="solo";
}

if (is_page('music')) $_REQUEST["in"] = 'music';
if (is_page('videos')) $_REQUEST["in"] = 'videos';
if (is_page('events')) $_REQUEST["in"] = 'events';
if (is_shop()) $_REQUEST["in"] = 'shop';

if (isset($_REQUEST["in"])) {
	//if (strpos($_REQUEST["in"],',') ) $categories = explode(',',$_REQUEST["in"]);
	//else 
	$categories = explode(' ',$_REQUEST["in"]);
}
else $categories = [];

if (count($categories)==1) $currentCategory = $_REQUEST["in"];
else $currentCategory = "default";

$geoInfo = "";
if ( class_exists( 'WooCommerce' ) ) {
	$geolocation = new WC_Geolocation();
	$geoInfo = $geolocation->geolocate_ip();
	if(is_array($geoInfo)&&array_key_exists("country", $geoInfo)&&$geoInfo["country"]!==''){
		$countryCode = $geoInfo["country"];
	} else {
		$countryCode = "CA";
	}
}
?>

<body <?php body_class($additionalClasses); ?> data-current_category="<?php echo $currentCategory;?>" data-country="<?php echo $countryCode;?>" data-initial_pinned="<?php echo (is_singular(array('post','product'))?get_permalink( $post->ID ):'false');?>">


<div class="main-navigation">
	<div class="ms-site-branding ms-corner-menu" id="ms-site-branding">
		<a href="<?php bloginfo('url');?>" aria-label="Navigate to home page">
			<img src="<?php echo get_stylesheet_directory_uri();?>/img/moonshine.png" width="50" height="45" alt=Moonshine/>
		</a>
	</div><!-- .site-branding -->
	<div class="main-menu ms-hidden" aria-label="Main menu">
		<a href="https://moonshine.mu/events/" aria-label="Videos">Events</a>
		<a href="https://moonshine.mu/music/" aria-label="Videos">Music</a>
		<a href="https://moonshine.mu/videos/" aria-label="Videos">Videos</a>
		<a href="https://moonshine.mu/shop/" aria-label="Videos">Shop</a>
	</div>

	<div class="ms-moon-menu ms-corner-menu ms-closes">
		<div class="ms-menu-icon">
			<?php $count = WC()->cart->get_cart_contents_count();?>
			<span class="ms-cart-counter <?php echo ($count==0?'ms-hide-when-empty':'');?>" id="ms-cart-counter">
				<?php echo $count;?>
			</span>
			<div class="ms-moon-icon ms-moon-icon-raw" data-width="30" data-moondate="<?php echo time();?>"><div></div></div>
		</div>
		<div class="ms-moon-menu-content ms-menu-content">
			<div class="ms-moon-menu-content-header">
				<div class="ms-close-menu-container">
					<a href="#" class="ms-close-menu" aria-label="Close user and cart menu"><span class="ms-icon ms-icon-close"></span></a>
				</div>
				<div class="ms-moon-icon-container">
					<div class="ms-moon-icon ms-moon-icon-raw" data-width="30" data-moondate="<?php echo time();?>"><div></div></div>		
					<div class="ms-moon-text">
						<span class="ms-moon-date"><?php echo date('Y.m.d');?></span><span class="ms-moon-sep">-</span><span class="ms-moon-state"></span></span><span class="ms-moon-sep">-</span>
						<?php 
						if ( is_user_logged_in() ) {
						$login = '<span class="menu-item menu-item-account"><a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'" title="'.__('Dashboard','moonshine').'">'.__('Dashboard','moonshine').'</a></span>';
						} 
						 else {
						 	$login = '<span class="menu-item menu-item-account"><a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'" title="'.__('Login','moonshine').'">'.__('Login','moonshine').'</a></span>';
						}
						echo $login;?>
					</div>
				</div>
			</div>			
			<div class="ms-moon-minicart" id="ms-moon-minicart">
				<?php echo woocommerce_mini_cart();?>
			</div>
		</div>
	</div>
	<div class="ms-share-menu ms-corner-menu ms-closes">
		<div class="ms-share-icon ms-menu-icon">
			<!-- <span class="ms-icon-constellation ms-icon"></span> -->
			<svg width="30" height="30" viewBox="0 0 30 30" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
			    <defs>
			        <path d="M0,15.089434 C0,16.3335929 5.13666091,24.1788679 14.9348958,24.1788679 C24.7325019,24.1788679 29.8697917,16.3335929 29.8697917,15.089434 C29.8697917,13.8456167 24.7325019,6 14.9348958,6 C5.13666091,6 0,13.8456167 0,15.089434 Z" id="outline"></path>
			        <mask id="mask">
			          <rect width="100%" height="100%" fill="white"></rect>
			          <use xlink:href="#outline" id="lid" fill="black"/>
			        </mask>
			    </defs>
			    <g id="eye">
			        <path d="M0,15.089434 C0,16.3335929 5.13666091,24.1788679 14.9348958,24.1788679 C24.7325019,24.1788679 29.8697917,16.3335929 29.8697917,15.089434 C29.8697917,13.8456167 24.7325019,6 14.9348958,6 C5.13666091,6 0,13.8456167 0,15.089434 Z M14.9348958,22.081464 C11.2690863,22.081464 8.29688487,18.9510766 8.29688487,15.089434 C8.29688487,11.2277914 11.2690863,8.09740397 14.9348958,8.09740397 C18.6007053,8.09740397 21.5725924,11.2277914 21.5725924,15.089434 C21.5725924,18.9510766 18.6007053,22.081464 14.9348958,22.081464 L14.9348958,22.081464 Z M18.2535869,15.089434 C18.2535869,17.0200844 16.7673289,18.5857907 14.9348958,18.5857907 C13.1018339,18.5857907 11.6162048,17.0200844 11.6162048,15.089434 C11.6162048,13.1587835 13.1018339,11.593419 14.9348958,11.593419 C15.9253152,11.593419 14.3271242,14.3639878 14.9348958,15.089434 C15.451486,15.7055336 18.2535869,14.2027016 18.2535869,15.089434 L18.2535869,15.089434 Z" fill="#FFFFFF"></path>
			        <use xlink:href="#outline" mask="url(#mask)" fill="#FFFFFF"/>
			    </g>
			</svg>
		</div>
		<div class="ms-share-menu-content ms-menu-content">
			<div class="ms-social-links" aria-label="Social Links">
			<a href="mailto:wagwan@moonshine.mu" target="_blank" class="tooltip"><span class="ms-icon ms-icon-mail"></span><span class="tooltiptext">Email</span></a>
				<a href="https://www.facebook.com/moonshinemu/" target="_blank" class="tooltip"><span class="ms-icon ms-icon-facebook"></span><span class="tooltiptext">Facebook</span></a>
				<a href="http://twitter.com/moonshinemu" target="_blank" class="tooltip"><span class="ms-icon ms-icon-twitter"></span><span class="tooltiptext">Twitter</span></a>
				<a href="http://instagram.com/moonshine.mu" target="_blank"  class="tooltip"><span class="ms-icon ms-icon-instagram"></span><span class="tooltiptext">Instagram</span></a>
				<a href="http://soundcloud.com/moonshinemu" target="_blank"  class="tooltip"><span class="ms-icon ms-icon-soundcloud"></span><span class="tooltiptext">Soundcloud</span></a>
<!-- 			<a href="http://www.snapchat.com/add/moonshinemu" target="_blank"  class="tooltip"><span class="ms-icon ms-icon-snapchat"></span><span class="tooltiptext">Snapchat</span></a>
 -->				
 				<a href="https://www.youtube.com/channel/UCEo1tEJiOi2ZbwynieLT7rw/" target="_blank"  class="tooltip"><span class="ms-icon ms-icon-youtube"></span><span class="tooltiptext">Youtube</span></a>
				<a href="https://open.spotify.com/artist/6uZcG9ex8hJKEo3XUyMxEX?si=9XfayGvRR5ejvQOFjwXe-A" target="_blank"  class="tooltip"><span class="ms-icon ms-icon-spotify"></span><span class="tooltiptext">Spotify</span></a>		
			</div>
			<div class="ms-close-menu-container">
				<a href="#" class="ms-close-menu" aria-label="Close Social Links"><span class="ms-icon ms-icon-close"></span></a>
			</div>
		</div>			
	</div>
	<div class="ms-phone-menu ms-corner-menu ms-closes">
		<div class="ms-phone-icon ms-menu-icon">
			<span class="ms-icon-phone ms-icon"></span>	
		</div>
		<div class="ms-phone-menu-content ms-menu-content">
			<span class="ms-close-menu-container"><a href="#" class="ms-close-menu" aria-label="Close Phone List Subscription Menu"><span class="ms-icon ms-icon-close"></span></a></span><span class="ms-type-in">Type in your phone number</span><span class="ms-tel-input" id="ms-tel-input-1"><input class="ms-phone-input" type="tel" autocomplete="off"/><span class="ms-hidden"><input class="ms-phone-hidden" type="tel" autocomplete="off"/></span><button class="phone_subscription_button" aria-label="Submit phone number">OK</button><span class="moon-small ms-hidden"></span><span class="ms-phone-message-container ms-hidden"><span class="ms-phone-message ms-hidden"></span></span></span>
			<span class="ms-or-text">Or text +1 514 612 5648 to stay informed</span>
		</div>			
	</div>

	<?php

	if (is_singular(array('post','product'))||is_home()||is_page(array('music','videos','events'))||is_shop()){
		$sideMenus = array ('events','music','videos', 'shop');
		foreach($sideMenus as $value) { ?>
		<div class="ms-<?php echo $value;?>-menu ms-side-menu <?php echo (empty($categories)||is_array($categories)&&in_array($value,$categories)?'ms-active-category':'');?>" data-category="<?php echo $value;?>">
			<span class="ms-icon-validate ms-icon"></span>
			<span class="ms-icon-<?php echo $value;?> ms-icon ms-menu-text"></span>
		</div>
	<?php } 
	}
	?>
</div>
<div id="page" class="site">	
	<div id="initialTitle" class='ms-hidden'><?php echo $siteTitle;?></div>
	<div id="content" class="site-content">
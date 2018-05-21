<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package moonshine
 */

?>

	</div><!-- #content -->
	<div id="infscr-loading"><div><span class="moon-medium"></span></div></div>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php if (is_single(array('cart','checkout'))){ ?>
<!-- 			<div class="mcafee-stamp">
				<script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>
			</div>
			<div class="godaddy-stamp">
				<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=e7oMMMeQFFhk9oteiGVKJTlJazSkz3vGPsqpXHRl0gm4Ir8ICzU4H9qhrgqD"></script></span>
			</div> -->
			<?php } ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>

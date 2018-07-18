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


</div><!-- #page -->

<footer id="footer" >

 <table width="100%">
    <tr>
        <td width="50%" style="text-align: left;">


         <a href="mailto:info@apem.ca"><?=__('Questions ou suggestions?','shfl')?></a>


         <span style="padding-left: 5px; padding-right: 5px">-</span>

         <a href="/?page_id=95"><?=__('Conditions d\'utilisation','shfl')?></a>


     </td>
     <td width="50%" style="text-align: right;">
        <a href="https://apem.ca">
           <span style=""><?=__('Un guide concu par l\'','shfl')?></span>


           <img style="vertical-align:middle; height:2em; width: inherit;" src="<?php echo get_template_directory_uri() . '/images/logo-footer.svg'; ?>" />
       </a>
   </td>
</tr>
</table>

</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

  <div id="menu-content">

    <div id="menu-header">
       <a href="/" class="button">
      <img id="menu-header-image" src="<?php echo get_template_directory_uri() . '/images/logo-menu.svg'; ?>" />
    </a>
    </div>

    <div class="trait trait-rouge menu-trait"></div>


    <div class="menu-element">
      <a href="/" class="button">

        <?php
        get_template_part( 'template-parts/svgs/home', 'content' );
        ?>

        <span class="menu-menu-title"><?=__('Guide d\'utilisation de la musique')?></span>
      </a>
    </div>

    <div class="menu-element">
      <a class="button"> 
        <?php
        get_template_part( 'template-parts/svgs/tag', 'content' );
        ?>

        <span class="menu-menu-title"><?=__('Parcourir les utilisations')?></span>
      </a>
      <?php
      get_template_part( 'template-parts/menu/categories', 'content' );
      ?>
    </div>



    <div class="menu-element">
      <a href="<?php echo get_permalink(160);?>" class="button">

        <?php
        get_template_part( 'template-parts/svgs/identification', 'content' );
        ?>

        <span class="menu-menu-title"><?=__('Identification des détenteurs des droits musicaux')?></span>
      </a>
    </div>



    <div class="menu-element">
      <a href="<?php echo get_permalink(44);?>" class="button">

        <?php
        get_template_part( 'template-parts/svgs/bookmark', 'content' );
        ?>

        <span class="menu-menu-title"><?=__('Lexique')?></span>
      </a>
    </div>

    <div class="menu-element">
      <a href="<?php echo get_permalink(39);?>" class="button">

        <?php
        get_template_part( 'template-parts/svgs/mail', 'content' );
        ?>

        <span class="menu-menu-title"><?=__('Contact & Crédits')?></span>
      </a>
    </div>

    <div class="trait trait-rouge menu-trait"></div>

    <div class="menu-footer-text"><?=__('C&P APEM 2018')?></div>

  </div>

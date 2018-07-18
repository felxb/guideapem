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

        <span class="menu-menu-title">Guide d'utilisation de la musique</span>
      </a>
    </div>

    <div class="menu-element">
      <a class="button"> 
        <?php
        get_template_part( 'template-parts/svgs/tag', 'content' );
        ?>

        <span class="menu-menu-title">Parcourir les utilisations</span>
      </a>
      <?php
      get_template_part( 'template-parts/menu/categories', 'content' );
      ?>
    </div>

    <div class="menu-element">
      <a href="/?page_id=44" class="button">

        <?php
        get_template_part( 'template-parts/svgs/bookmark', 'content' );
        ?>

        <span class="menu-menu-title">Lexique</span>
      </a>
    </div>

    <div class="menu-element">
      <a href="/?page_id=39" class="button">

        <?php
        get_template_part( 'template-parts/svgs/mail', 'content' );
        ?>

        <span class="menu-menu-title">Content & Credits</span>
      </a>
    </div>

    <div class="trait trait-rouge menu-trait"></div>

    <div class="menu-footer-text"><?=__('C&P APEM 2018')?></div>

  </div>

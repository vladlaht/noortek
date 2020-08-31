<header>
    <div class="container">


        <div class="header-content">
                <div class="header-logo">
                    <div class="header-logo__image">
                        <img src="
                        <?php echo get_stylesheet_directory_uri(); ?>/images/logos/nnk-logo.png" alt="">
                    </div>
                    <div class="header-logo__title">
                        <div class="header-logo__title-main">
                            <span class="color-green">Narva</span> <span class="color-orange">Noortekeskus</span>
                        </div>
                        <span class="header-logo__title-sub">Ida-Virumaa noorteportaal</span>
                    </div>
                </div>
            <div class="header-right-side">
                <div class="header-language-switch">
                    <ul class="languages">
                        <?php pll_the_languages(array('show_flags' => 1, 'show_names' => 1)); ?>
                    </ul>
                </div>
                <div class="header-social-links">
                    <a class="header-social-links__item" href="https://www.facebook.com/NOORTEKESKUS/?fref=ts"
                       target="_blank"
                       rel="noreferrer">
                        <i class="fab fa-facebook-f"> </i>
                    </a>
                    <a class="header-social-links__item" href="https://vk.com/narvanoortekeskus" target="_blank"
                       rel="noreferrer">
                        <i class="fab fa-vk"> </i>
                    </a>
                    <a class="header-social-links__item" href="https://www.instagram.com/narva_noortekeskus/"
                       target="_blank"
                       rel="noreferrer">
                        <i class="fab fa-instagram"> </i>
                    </a>
                    <a class="header-social-links__item" href="https://www.youtube.com/user/NoortekTV" target="_blank"
                       rel="noreferrer">
                        <i class="fab fa-youtube"> </i>
                    </a>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-light main-menu" role="navigation">
            <div class="container">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'depth' => 2,
                    'container' => 'div',
                    'container_class' => 'collapse navbar-collapse',
                    'container_id' => 'bs-example-navbar-collapse-1',
                    'menu_class' => 'nav navbar-nav',
                    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                    'walker' => new WP_Bootstrap_Navwalker(),
                ));
                ?>
            </div>
        </nav>
</header>

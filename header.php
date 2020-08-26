<header>
    <div class="container">
        <div class="row header-content">
            <div class="col-md-9 col-lg-6">
                <div class="logo-container">
                    <a href="/noortek/">
                        <div class="logo">
                                 <span class="title">
                            <span class="color-green">Narva</span> <span class="color-orange">Noortekeskus</span>
                        </span>
                            <span class="sub-title">Ida-Virumaa noorteportaal</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-lg-6 ">
                <div class="language-switch">
                    <ul class="languages"><?php pll_the_languages(array('show_flags' => 1, 'show_names' => 1)); ?></ul>
                </div>

                <div class="social-links">
                    <a class="social-links__item" href="https://www.facebook.com/NOORTEKESKUS/?fref=ts" target="_blank"
                       rel="noreferrer">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="social-links__item" href="https://vk.com/narvanoortekeskus" target="_blank"
                       rel="noreferrer">
                        <i class="fab fa-vk"></i>
                    </a>
                    <a class="social-links__item" href="https://www.instagram.com/narva_noortekeskus/" target="_blank"
                       rel="noreferrer">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="social-links__item" href="https://www.youtube.com/user/NoortekTV" target="_blank"
                       rel="noreferrer">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
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

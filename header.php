<header>
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-lg-6">
                <div class="logo-container">
                    <div class="logo">
                        <span class="title">
                            <span class="color-green">Narva</span> <span class="color-orange">Noortekeskus</span>
                        </span>
                        <span class="sub-title">Ida-Virumaa noorteportaal</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-6 ">
                <div class="language-switch">
                    <ul class="languages"><?php pll_the_languages();?></ul>
                </div>

                <div class="social-links">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-vk"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md navbar-light bg-light main-menu" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#"><i class="fa fa-home"></i></a>
            <?php
            wp_nav_menu( array(
                'theme_location'    => 'main-menu',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker(),
            ) );
            ?>
        </div>
    </nav>
</header>

<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freehand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Decol&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
	
	  <script>
        document.addEventListener('DOMContentLoaded', function () {
            // JavaScript code here
            const subMenus = document.querySelectorAll('.menu-container .sub-menu');
            subMenus.forEach(function (submenu, index) {
                submenu.classList.add('submenu-' + (index + 1));
            });
        });
    </script>

	
	
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="wrapper" class="hfeed">
        <header id="header" role="banner">
            <div id="branding">
                <div id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url">
                        <img id='logo-crl-home' src="https://dev.relationalearning.com/wp-content/uploads/2024/02/CRL-REMASTERED-LOGO-2024-31.png" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" itemprop="image">
                    </a>
                </div>
            </div>
            <nav id="menu" class="desktop-menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>' ) ); ?>
            </nav>
            <!-- Hamburger menu for mobile -->
            <div class='hamburger-container'>
                <button id="menu-toggle" class="menu-toggle">
                    <span class="hamburger"></span>
                </button>
            </div>
            <div id="mobile-menu-container" class="menu-container">
                <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>' ) ); ?>
            </div>
        </header>
        <div id="container">
            <main id="content" role="main">
                <!-- Your content here -->
            </main>
        </div>
    </div>

    <?php wp_footer(); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const menuContainer = document.getElementById('mobile-menu-container');

            menuToggle.addEventListener('click', function () {
                menuToggle.classList.toggle('active'); // Toggle the active class on the hamburger button
                menuContainer.classList.toggle('show-menu');
            });
        });
    </script>
</body>
</html>

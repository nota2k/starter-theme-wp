<?php
/**
 * Template part pour l'en-tête du site
 */

$logo = theme_moderne_get_logo();
$contact_info = theme_moderne_get_contact_info();
?>

<header class="site-header">
    <div class="container">
        <div class="header-content flex items-center justify-between py-4">
            
            <!-- Logo et nom du site -->
            <div class="site-branding flex items-center">
                <?php if ($logo) : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link" rel="home">
                        <img src="<?php echo esc_url($logo['url']); ?>" 
                             alt="<?php echo esc_attr($logo['alt'] ?: get_bloginfo('name')); ?>"
                             class="custom-logo h-12 w-auto">
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title-link" rel="home">
                        <h1 class="site-title text-2xl font-bold text-gray-900 m-0">
                            <?php bloginfo('name'); ?>
                        </h1>
                    </a>
                <?php endif; ?>
                
                <?php if (get_bloginfo('description')) : ?>
                    <p class="site-description text-sm text-gray-600 ml-4 hidden md:block">
                        <?php bloginfo('description'); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Navigation principale -->
            <nav class="main-navigation hidden lg:block" role="navigation" aria-label="<?php esc_attr_e('Menu principal', 'theme-moderne'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class' => 'main-menu flex items-center gap-6',
                    'container' => false,
                    'fallback_cb' => false,
                ]);
                ?>
            </nav>

            <!-- Actions de l'en-tête -->
            <div class="header-actions flex items-center gap-4">
                
                <!-- Recherche -->
                <button class="search-toggle btn btn-ghost btn-icon-only" 
                        aria-label="<?php esc_attr_e('Ouvrir la recherche', 'theme-moderne'); ?>"
                        aria-expanded="false">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Informations de contact (mobile caché) -->
                <?php if ($contact_info && $contact_info['phone']) : ?>
                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $contact_info['phone'])); ?>" 
                       class="contact-phone hidden xl:flex items-center gap-2 text-primary hover:text-primary-dark">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm font-medium"><?php echo esc_html($contact_info['phone']); ?></span>
                    </a>
                <?php endif; ?>

                <!-- Menu mobile toggle -->
                <button class="mobile-menu-toggle btn btn-ghost btn-icon-only lg:hidden" 
                        aria-label="<?php esc_attr_e('Ouvrir le menu', 'theme-moderne'); ?>"
                        aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Barre de recherche (cachée par défaut) -->
        <div class="search-form-container hidden border-t border-gray-200 py-4">
            <form role="search" method="get" class="search-form flex gap-2" action="<?php echo esc_url(home_url('/')); ?>">
                <label class="sr-only" for="header-search"><?php esc_html_e('Rechercher', 'theme-moderne'); ?></label>
                <input type="search" 
                       id="header-search"
                       class="search-field flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" 
                       placeholder="<?php esc_attr_e('Rechercher...', 'theme-moderne'); ?>" 
                       value="<?php echo get_search_query(); ?>" 
                       name="s">
                <button type="submit" class="search-submit btn btn-primary">
                    <?php esc_html_e('Rechercher', 'theme-moderne'); ?>
                </button>
            </form>
        </div>

        <!-- Menu mobile (caché par défaut) -->
        <div class="mobile-menu hidden lg:hidden border-t border-gray-200 py-4">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class' => 'mobile-menu-list flex flex-col gap-2',
                'container' => false,
                'fallback_cb' => false,
            ]);
            ?>
            
            <!-- Réseaux sociaux en mobile -->
            <?php 
            $social_links = theme_moderne_get_social_links();
            if ($social_links) :
            ?>
                <div class="mobile-social-links flex gap-4 mt-6 pt-4 border-t border-gray-200">
                    <?php foreach ($social_links as $social) : ?>
                        <a href="<?php echo esc_url($social['url']); ?>" 
                           class="social-link text-gray-600 hover:text-primary"
                           aria-label="<?php echo esc_attr($social['label'] ?: $social['platform']); ?>"
                           target="_blank" 
                           rel="noopener noreferrer">
                            <?php get_template_part('template-parts/icons/social', $social['platform']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php
/**
 * Template part pour le pied de page du site
 */

$footer_text = theme_moderne_get_footer_text();
$contact_info = theme_moderne_get_contact_info();
$social_links = theme_moderne_get_social_links();
?>

<footer class="site-footer bg-gray-900 text-white">
    <div class="container">
        
        <!-- Contenu principal du footer -->
        <div class="footer-content py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- Informations du site -->
                <div class="footer-info">
                    <?php if (has_custom_logo()) : ?>
                        <div class="footer-logo mb-4">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h3 class="footer-title text-xl font-bold mb-4">
                            <?php bloginfo('name'); ?>
                        </h3>
                    <?php endif; ?>
                    
                    <?php if ($footer_text) : ?>
                        <p class="footer-description text-gray-300 mb-4">
                            <?php echo wp_kses_post($footer_text); ?>
                        </p>
                    <?php elseif (get_bloginfo('description')) : ?>
                        <p class="footer-description text-gray-300 mb-4">
                            <?php bloginfo('description'); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Réseaux sociaux -->
                    <?php if ($social_links) : ?>
                        <div class="social-links flex gap-3">
                            <?php foreach ($social_links as $social) : ?>
                                <a href="<?php echo esc_url($social['url']); ?>" 
                                   class="social-link w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-300 hover:bg-primary hover:text-white transition-colors"
                                   aria-label="<?php echo esc_attr($social['label'] ?: $social['platform']); ?>"
                                   target="_blank" 
                                   rel="noopener noreferrer">
                                    <?php get_template_part('template-parts/icons/social', $social['platform']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Liens rapides -->
                <div class="footer-links">
                    <h3 class="footer-widget-title text-lg font-semibold mb-4">
                        <?php esc_html_e('Liens rapides', 'theme-moderne'); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'menu_class' => 'footer-menu flex flex-col gap-2',
                        'container' => false,
                        'fallback_cb' => false,
                        'depth' => 1,
                    ]);
                    ?>
                </div>

                <!-- Informations de contact -->
                <?php if ($contact_info) : ?>
                    <div class="footer-contact">
                        <h3 class="footer-widget-title text-lg font-semibold mb-4">
                            <?php esc_html_e('Contact', 'theme-moderne'); ?>
                        </h3>
                        <div class="contact-info space-y-3">
                            
                            <?php if ($contact_info['address']) : ?>
                                <div class="contact-item flex items-start gap-3">
                                    <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <address class="contact-address text-gray-300 not-italic">
                                        <?php echo wp_kses_post(nl2br($contact_info['address'])); ?>
                                    </address>
                                </div>
                            <?php endif; ?>

                            <?php if ($contact_info['phone']) : ?>
                                <div class="contact-item flex items-center gap-3">
                                    <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $contact_info['phone'])); ?>" 
                                       class="contact-phone text-gray-300 hover:text-white">
                                        <?php echo esc_html($contact_info['phone']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($contact_info['email']) : ?>
                                <div class="contact-item flex items-center gap-3">
                                    <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>" 
                                       class="contact-email text-gray-300 hover:text-white">
                                        <?php echo esc_html($contact_info['email']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Widget zone -->
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widgets">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Barre de copyright -->
        <div class="footer-bottom border-t border-gray-800 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="copyright text-gray-400 text-sm">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                    <?php esc_html_e('Tous droits réservés.', 'theme-moderne'); ?></p>
                </div>
                
                <div class="footer-links-bottom text-gray-400 text-sm">
                    <!-- Liens légaux -->
                    <nav class="legal-links flex gap-4">
                        <?php
                        // Essayer d'afficher les pages de mentions légales automatiquement
                        $legal_pages = get_pages([
                            'meta_key' => '_wp_page_template',
                            'meta_value' => 'page-legal.php'
                        ]);
                        
                        if (empty($legal_pages)) {
                            // Chercher par titre si pas de template spécifique
                            $legal_titles = ['mentions légales', 'politique de confidentialité', 'conditions d\'utilisation'];
                            foreach ($legal_titles as $title) {
                                $page = get_page_by_title($title);
                                if ($page) {
                                    echo '<a href="' . get_permalink($page) . '" class="hover:text-white">' . get_the_title($page) . '</a>';
                                }
                            }
                        } else {
                            foreach ($legal_pages as $page) {
                                echo '<a href="' . get_permalink($page) . '" class="hover:text-white">' . get_the_title($page) . '</a>';
                            }
                        }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>
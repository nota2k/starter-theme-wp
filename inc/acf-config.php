<?php
/**
 * Configuration et intégration d'Advanced Custom Fields
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Vérification de la présence d'ACF
 */
function theme_moderne_check_acf() {
    if (!class_exists('ACF')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>';
            echo __('Le thème moderne nécessite le plugin Advanced Custom Fields pour fonctionner correctement.', 'theme-moderne');
            echo '</p></div>';
        });
        return false;
    }
    return true;
}

/**
 * Configuration des options ACF
 */
function theme_moderne_acf_init() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    // Page d'options principale du thème
    acf_add_options_page([
        'page_title' => __('Options du Thème', 'theme-moderne'),
        'menu_title' => __('Thème Moderne', 'theme-moderne'),
        'menu_slug' => 'theme-options',
        'capability' => 'edit_theme_options',
        'icon_url' => 'dashicons-admin-customizer',
        'position' => 59,
        'autoload' => true,
    ]);

    // Sous-page pour les réseaux sociaux
    acf_add_options_sub_page([
        'page_title' => __('Réseaux Sociaux', 'theme-moderne'),
        'menu_title' => __('Réseaux Sociaux', 'theme-moderne'),
        'parent_slug' => 'theme-options',
    ]);

    // Sous-page pour les scripts
    acf_add_options_sub_page([
        'page_title' => __('Scripts & Analytics', 'theme-moderne'),
        'menu_title' => __('Scripts', 'theme-moderne'),
        'parent_slug' => 'theme-options',
    ]);
}
add_action('acf/init', 'theme_moderne_acf_init');

/**
 * Enregistrement des groupes de champs
 */
function theme_moderne_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Groupe de champs pour les options du thème
    acf_add_local_field_group([
        'key' => 'group_theme_options',
        'title' => __('Options du Thème', 'theme-moderne'),
        'fields' => [
            [
                'key' => 'field_site_logo',
                'label' => __('Logo du site', 'theme-moderne'),
                'name' => 'site_logo',
                'type' => 'image',
                'instructions' => __('Logo affiché dans l\'en-tête du site', 'theme-moderne'),
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_footer_text',
                'label' => __('Texte du pied de page', 'theme-moderne'),
                'name' => 'footer_text',
                'type' => 'textarea',
                'instructions' => __('Texte affiché dans le pied de page', 'theme-moderne'),
                'rows' => 3,
            ],
            [
                'key' => 'field_contact_info',
                'label' => __('Informations de contact', 'theme-moderne'),
                'name' => 'contact_info',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_contact_phone',
                        'label' => __('Téléphone', 'theme-moderne'),
                        'name' => 'phone',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_contact_email',
                        'label' => __('Email', 'theme-moderne'),
                        'name' => 'email',
                        'type' => 'email',
                    ],
                    [
                        'key' => 'field_contact_address',
                        'label' => __('Adresse', 'theme-moderne'),
                        'name' => 'address',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-options',
                ],
            ],
        ],
    ]);

    // Groupe de champs pour les réseaux sociaux
    acf_add_local_field_group([
        'key' => 'group_social_media',
        'title' => __('Réseaux Sociaux', 'theme-moderne'),
        'fields' => [
            [
                'key' => 'field_social_links',
                'label' => __('Liens des réseaux sociaux', 'theme-moderne'),
                'name' => 'social_links',
                'type' => 'repeater',
                'instructions' => __('Ajoutez vos liens de réseaux sociaux', 'theme-moderne'),
                'layout' => 'table',
                'button_label' => __('Ajouter un réseau social', 'theme-moderne'),
                'sub_fields' => [
                    [
                        'key' => 'field_social_platform',
                        'label' => __('Plateforme', 'theme-moderne'),
                        'name' => 'platform',
                        'type' => 'select',
                        'choices' => [
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'instagram' => 'Instagram',
                            'linkedin' => 'LinkedIn',
                            'youtube' => 'YouTube',
                            'tiktok' => 'TikTok',
                            'pinterest' => 'Pinterest',
                            'whatsapp' => 'WhatsApp',
                        ],
                        'default_value' => 'facebook',
                    ],
                    [
                        'key' => 'field_social_url',
                        'label' => __('URL', 'theme-moderne'),
                        'name' => 'url',
                        'type' => 'url',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_social_label',
                        'label' => __('Libellé', 'theme-moderne'),
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => __('Texte alternatif pour l\'accessibilité', 'theme-moderne'),
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-réseaux-sociaux',
                ],
            ],
        ],
    ]);

    // Groupe de champs pour les scripts
    acf_add_local_field_group([
        'key' => 'group_scripts',
        'title' => __('Scripts & Analytics', 'theme-moderne'),
        'fields' => [
            [
                'key' => 'field_google_analytics',
                'label' => __('Google Analytics ID', 'theme-moderne'),
                'name' => 'google_analytics_id',
                'type' => 'text',
                'instructions' => __('ID de suivi Google Analytics (ex: G-XXXXXXXXXX)', 'theme-moderne'),
            ],
            [
                'key' => 'field_google_tag_manager',
                'label' => __('Google Tag Manager ID', 'theme-moderne'),
                'name' => 'google_tag_manager_id',
                'type' => 'text',
                'instructions' => __('ID Google Tag Manager (ex: GTM-XXXXXXX)', 'theme-moderne'),
            ],
            [
                'key' => 'field_facebook_pixel',
                'label' => __('Facebook Pixel ID', 'theme-moderne'),
                'name' => 'facebook_pixel_id',
                'type' => 'text',
                'instructions' => __('ID du pixel Facebook', 'theme-moderne'),
            ],
            [
                'key' => 'field_custom_head_scripts',
                'label' => __('Scripts personnalisés (head)', 'theme-moderne'),
                'name' => 'custom_head_scripts',
                'type' => 'textarea',
                'instructions' => __('Scripts à insérer dans le <head>', 'theme-moderne'),
                'rows' => 5,
            ],
            [
                'key' => 'field_custom_footer_scripts',
                'label' => __('Scripts personnalisés (footer)', 'theme-moderne'),
                'name' => 'custom_footer_scripts',
                'type' => 'textarea',
                'instructions' => __('Scripts à insérer avant </body>', 'theme-moderne'),
                'rows' => 5,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-scripts',
                ],
            ],
        ],
    ]);
}
add_action('acf/init', 'theme_moderne_register_acf_fields');

/**
 * Fonctions utilitaires pour récupérer les options ACF
 */

// Récupérer le logo du site
function theme_moderne_get_logo() {
    if (!function_exists('get_field')) {
        return false;
    }
    $logo = get_field('site_logo', 'option');
    return $logo ? $logo : false;
}

// Récupérer les informations de contact
function theme_moderne_get_contact_info() {
    if (!function_exists('get_field')) {
        return false;
    }
    return get_field('contact_info', 'option');
}

// Récupérer les liens de réseaux sociaux
function theme_moderne_get_social_links() {
    if (!function_exists('get_field')) {
        return false;
    }
    return get_field('social_links', 'option');
}

// Récupérer le texte du footer
function theme_moderne_get_footer_text() {
    if (!function_exists('get_field')) {
        return false;
    }
    return get_field('footer_text', 'option');
}

/**
 * Ajout des scripts d'analytics et tracking
 */
function theme_moderne_add_tracking_scripts() {
    // Vérifier si ACF est disponible
    if (!function_exists('get_field')) {
        return;
    }
    
    // Google Analytics
    $ga_id = get_field('google_analytics_id', 'option');
    if ($ga_id) {
        ?>
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo esc_js($ga_id); ?>');
        </script>
        <?php
    }

    // Google Tag Manager
    $gtm_id = get_field('google_tag_manager_id', 'option');
    if ($gtm_id) {
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?php echo esc_js($gtm_id); ?>');</script>
        <?php
    }

    // Facebook Pixel
    $fb_pixel = get_field('facebook_pixel_id', 'option');
    if ($fb_pixel) {
        ?>
        <!-- Facebook Pixel -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo esc_js($fb_pixel); ?>');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=<?php echo esc_attr($fb_pixel); ?>&ev=PageView&noscript=1"
        /></noscript>
        <?php
    }

    // Scripts personnalisés head
    $custom_head = get_field('custom_head_scripts', 'option');
    if ($custom_head) {
        echo $custom_head;
    }
}
add_action('wp_head', 'theme_moderne_add_tracking_scripts');

/**
 * Scripts footer personnalisés
 */
function theme_moderne_add_footer_scripts() {
    // Vérifier si ACF est disponible
    if (!function_exists('get_field')) {
        return;
    }
    
    // Google Tag Manager (noscript)
    $gtm_id = get_field('google_tag_manager_id', 'option');
    if ($gtm_id) {
        ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($gtm_id); ?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <?php
    }

    // Scripts personnalisés footer
    $custom_footer = get_field('custom_footer_scripts', 'option');
    if ($custom_footer) {
        echo $custom_footer;
    }
}
add_action('wp_body_open', 'theme_moderne_add_footer_scripts');

/**
 * Champs ACF pour les posts
 */
function theme_moderne_register_post_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Champs pour les articles
    acf_add_local_field_group([
        'key' => 'group_post_options',
        'title' => __('Options de l\'article', 'theme-moderne'),
        'fields' => [
            [
                'key' => 'field_featured_post',
                'label' => __('Article en vedette', 'theme-moderne'),
                'name' => 'featured_post',
                'type' => 'true_false',
                'instructions' => __('Marquer cet article comme étant en vedette', 'theme-moderne'),
                'ui' => 1,
            ],
            [
                'key' => 'field_post_subtitle',
                'label' => __('Sous-titre', 'theme-moderne'),
                'name' => 'post_subtitle',
                'type' => 'text',
                'instructions' => __('Sous-titre optionnel pour l\'article', 'theme-moderne'),
            ],
            [
                'key' => 'field_hide_featured_image',
                'label' => __('Masquer l\'image mise en avant', 'theme-moderne'),
                'name' => 'hide_featured_image',
                'type' => 'true_false',
                'instructions' => __('Masquer l\'image mise en avant sur la page de l\'article', 'theme-moderne'),
                'ui' => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ],
            ],
        ],
        'position' => 'side',
        'style' => 'default',
    ]);
}
add_action('acf/init', 'theme_moderne_register_post_fields');

/**
 * Vérifier le plugin ACF au chargement
 */
add_action('after_setup_theme', 'theme_moderne_check_acf');
<?php
/**
 * Fonctions principales du thème moderne
 */

if (!defined('ABSPATH')) {
    exit;
}

// Inclusion des fichiers de configuration
require_once get_template_directory() . '/inc/acf-config.php';
require_once get_template_directory() . '/inc/debug-patterns.php';

// TEMPORAIRE : Forcer le rafraîchissement des patterns
if (file_exists(get_template_directory() . '/refresh-patterns.php')) {
    require_once get_template_directory() . '/refresh-patterns.php';
}

// TEMPORAIRE : Debug des patterns
if (file_exists(get_template_directory() . '/debug-patterns-info.php')) {
    require_once get_template_directory() . '/debug-patterns-info.php';
}

// Constantes du thème
define('THEME_VERSION', '1.0.0');
define('THEME_URI', get_template_directory_uri());
define('THEME_PATH', get_template_directory());

/**
 * Configuration du thème
 */
function theme_moderne_setup() {
    // Support pour les fonctionnalités du thème
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo', [
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => ['site-title', 'site-description'],
    ]);
    
    // Support HTML5
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    
    // Support pour les blocs Gutenberg
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-color-palette', [
        [
            'name' => __('Primary', 'theme-moderne'),
            'slug' => 'primary',
            'color' => '#2563eb',
        ],
        [
            'name' => __('Secondary', 'theme-moderne'),
            'slug' => 'secondary',
            'color' => '#10b981',
        ],
        [
            'name' => __('Gray 900', 'theme-moderne'),
            'slug' => 'gray-900',
            'color' => '#111827',
        ],
        [
            'name' => __('Gray 600', 'theme-moderne'),
            'slug' => 'gray-600',
            'color' => '#4b5563',
        ],
        [
            'name' => __('Gray 100', 'theme-moderne'),
            'slug' => 'gray-100',
            'color' => '#f3f4f6',
        ],
        [
            'name' => __('White', 'theme-moderne'),
            'slug' => 'white',
            'color' => '#ffffff',
        ],
    ]);
    
    // Support pour les tailles d'images personnalisées
    add_image_size('hero-image', 1920, 800, true);
    add_image_size('card-image', 400, 250, true);
    add_image_size('thumbnail-large', 300, 300, true);
    
    // Support pour les extraits sur les pages
    add_post_type_support('page', 'excerpt');
    
    // Enregistrement des menus
    register_nav_menus([
        'primary' => __('Menu Principal', 'theme-moderne'),
        'footer' => __('Menu Pied de page', 'theme-moderne'),
        'social' => __('Liens sociaux', 'theme-moderne')
    ]);
    
    // Support pour les formats d'articles
    add_theme_support('post-formats', [
        'aside',
        'gallery',
        'link',
        'image',
        'quote',
        'status',
        'video',
        'audio',
        'chat'
    ]);
    
    // Chargement de la traduction
    load_theme_textdomain('theme-moderne', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'theme_moderne_setup');

/**
 * Enregistrement et chargement des styles et scripts
 */
function theme_moderne_scripts() {
    // Styles CSS
    wp_enqueue_style(
        'theme-moderne-style',
        THEME_URI . '/assets/css/main.css',
        [],
        THEME_VERSION
    );
    
    // Scripts JavaScript
    wp_enqueue_script(
        'theme-moderne-script',
        THEME_URI . '/assets/js/main.js',
        [],
        THEME_VERSION,
        true
    );
    

}
add_action('wp_enqueue_scripts', 'theme_moderne_scripts');



/**
 * Enregistrement des patterns HTML
 */
function theme_moderne_register_patterns() {
    $patterns_dir = THEME_PATH . '/patterns';
    
    if (is_dir($patterns_dir)) {
        // Charger les patterns HTML (nouvelle syntaxe)
        $html_patterns = glob($patterns_dir . '/*.html');
        
        foreach ($html_patterns as $pattern_file) {
            $pattern_content = file_get_contents($pattern_file);
            
            // Extraire les métadonnées du header PHP
            if (preg_match('/\/\*\*(.*?)\*\//s', $pattern_content, $matches)) {
                $header = $matches[1];
                $metadata = [];
                
                // Parser les métadonnées
                if (preg_match('/Title:\s*(.+)/i', $header, $title_match)) {
                    $metadata['title'] = trim($title_match[1]);
                }
                if (preg_match('/Slug:\s*(.+)/i', $header, $slug_match)) {
                    $metadata['slug'] = trim($slug_match[1]);
                }
                if (preg_match('/Description:\s*(.+)/i', $header, $desc_match)) {
                    $metadata['description'] = trim($desc_match[1]);
                }
                if (preg_match('/Categories:\s*(.+)/i', $header, $cat_match)) {
                    $metadata['categories'] = array_map('trim', explode(',', $cat_match[1]));
                }
                if (preg_match('/Keywords:\s*(.+)/i', $header, $keywords_match)) {
                    $metadata['keywords'] = array_map('trim', explode(',', $keywords_match[1]));
                }
                if (preg_match('/Viewport Width:\s*(\d+)/i', $header, $viewport_match)) {
                    $metadata['viewportWidth'] = intval($viewport_match[1]);
                }
                if (preg_match('/Block Types:\s*(.+)/i', $header, $block_types_match)) {
                    $metadata['blockTypes'] = array_map('trim', explode(',', $block_types_match[1]));
                }
                if (preg_match('/Inserter:\s*(.+)/i', $header, $inserter_match)) {
                    $metadata['inserter'] = trim(strtolower($inserter_match[1])) === 'yes';
                }
                
                // Extraire le contenu HTML (après le header PHP)
                $content_start = strpos($pattern_content, '?>');
                if ($content_start !== false) {
                    $metadata['content'] = trim(substr($pattern_content, $content_start + 2));
                }
                
                // Enregistrer le pattern si on a au minimum titre et contenu
                if (!empty($metadata['title']) && !empty($metadata['content'])) {
                    $pattern_name = !empty($metadata['slug']) ? $metadata['slug'] : 'theme-moderne/' . basename($pattern_file, '.html');
                    
                    // Forcer l'insertion et rendre le pattern visible
                    $metadata['inserter'] = true;
                    $metadata['postTypes'] = ['page', 'post'];
                    
                    // Assurer une visibilité maximale
                    $metadata['source'] = 'plugin';  // WordPress traite mieux les patterns de plugins
                    
                    $result = register_block_pattern($pattern_name, $metadata);
                    
                    // Debug : vérifier l'enregistrement
                    if (WP_DEBUG && current_user_can('manage_options')) {
                        if ($result) {
                            error_log("✅ Pattern HTML enregistré avec succès : $pattern_name");
                        } else {
                            error_log("❌ Erreur lors de l'enregistrement du pattern HTML : $pattern_name");
                        }
                    }
                }
            }
        }
        
        // Maintenir la compatibilité avec les anciens patterns PHP
        $php_patterns = glob($patterns_dir . '/*.php');
        
        foreach ($php_patterns as $pattern_file) {
            $pattern_name = basename($pattern_file, '.php');
            
            // Inclure le fichier pattern pour obtenir sa configuration
            $pattern_data = include $pattern_file;
            
            if (is_array($pattern_data) && isset($pattern_data['title'], $pattern_data['content'])) {
                $result = register_block_pattern(
                    'theme-moderne/' . $pattern_name,
                    $pattern_data
                );
                
                // Debug : vérifier l'enregistrement
                if (WP_DEBUG && current_user_can('manage_options')) {
                    if ($result) {
                        error_log("✅ Pattern PHP enregistré avec succès : theme-moderne/$pattern_name");
                    } else {
                        error_log("❌ Erreur lors de l'enregistrement du pattern PHP : theme-moderne/$pattern_name");
                    }
                }
            }
        }
    }
}
add_action('init', 'theme_moderne_register_patterns');

/**
 * Ajout de la catégorie de patterns personnalisée
 */
function theme_moderne_register_pattern_categories() {
    register_block_pattern_category(
        'theme-moderne',
        [
            'label' => __('Thème Moderne', 'theme-moderne'),
            'description' => __('Patterns du thème moderne', 'theme-moderne'),
        ]
    );
}
add_action('init', 'theme_moderne_register_pattern_categories');

/**
 * Personnalisation de l'éditeur
 */
function theme_moderne_editor_styles() {
    add_editor_style('assets/css/editor-style.css');
}
add_action('after_setup_theme', 'theme_moderne_editor_styles');

/**
 * Enregistrement des zones de widgets
 */
function theme_moderne_widgets_init() {
    register_sidebar([
        'name'          => __('Barre latérale', 'theme-moderne'),
        'id'            => 'sidebar-1',
        'description'   => __('Ajoutez des widgets ici.', 'theme-moderne'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
    
    register_sidebar([
        'name'          => __('Pied de page', 'theme-moderne'),
        'id'            => 'footer-1',
        'description'   => __('Zone de widgets du pied de page.', 'theme-moderne'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'theme_moderne_widgets_init');

/**
 * Optimisations de performance
 */
function theme_moderne_performance_optimizations() {
    // Supprimer les styles et scripts WordPress inutiles
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
    
    // Supprimer les emoji si pas nécessaires
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Supprimer les liens inutiles du head
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Déplacer les scripts jQuery en footer
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), false, null, true);
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'theme_moderne_performance_optimizations');

/**
 * Sécurité et nettoyage
 */
function theme_moderne_security_cleanup() {
    // Masquer la version WordPress
    add_filter('the_generator', '__return_empty_string');
    
    // Supprimer l'API REST pour les utilisateurs non connectés (optionnel)
    if (!is_user_logged_in()) {
        add_filter('rest_authentication_errors', function($result) {
            if (!empty($result)) {
                return $result;
            }
            if (!is_user_logged_in()) {
                return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', ['status' => 401]);
            }
            return $result;
        });
    }
}
add_action('init', 'theme_moderne_security_cleanup');

/**
 * Personnalisation de l'administration
 */
function theme_moderne_admin_customization() {
    // Ajouter des styles pour l'éditeur
    add_editor_style('assets/css/editor-style.css');
    
    // Personnaliser le logo de connexion
    function theme_moderne_login_logo() {
        $logo = theme_moderne_get_logo();
        if ($logo) {
            echo '<style type="text/css">
                #login h1 a {
                    background-image: url(' . esc_url($logo['url']) . ');
                    background-size: contain;
                    background-repeat: no-repeat;
                    width: 100%;
                    height: 80px;
                }
            </style>';
        }
    }
    add_action('login_enqueue_scripts', 'theme_moderne_login_logo');
    
    // Changer l'URL du logo
    function theme_moderne_login_logo_url() {
        return home_url();
    }
    add_filter('login_headerurl', 'theme_moderne_login_logo_url');
    
    // Changer le titre du logo
    function theme_moderne_login_logo_title() {
        return get_option('blogname');
    }
    add_filter('login_headertitle', 'theme_moderne_login_logo_title');
}
add_action('after_setup_theme', 'theme_moderne_admin_customization');

/**
 * Fonctions utilitaires du thème
 */

// Récupérer l'extrait personnalisé
function theme_moderne_get_excerpt($post_id = null, $length = 155) {
    $post = get_post($post_id);
    if (!$post) return '';
    
    if ($post->post_excerpt) {
        return wp_trim_words($post->post_excerpt, $length);
    }
    
    return wp_trim_words(strip_tags($post->post_content), $length);
}

// Vérifier si on est sur une page de blog
function theme_moderne_is_blog() {
    return (is_home() || is_archive() || is_category() || is_tag() || is_author() || is_date());
}

// Récupérer les articles en vedette
function theme_moderne_get_featured_posts($limit = 3) {
    if (!function_exists('get_field')) {
        return new WP_Query();
    }
    
    return new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'meta_query' => [
            [
                'key' => 'featured_post',
                'value' => '1',
                'compare' => '='
            ]
        ]
    ]);
}

// Afficher le temps de lecture
function theme_moderne_reading_time($post_id = null) {
    $post = get_post($post_id);
    if (!$post) return 0;
    
    $word_count = str_word_count(strip_tags($post->post_content));
    $reading_time = ceil($word_count / 200); // 200 mots par minute
    
    return $reading_time;
}

// Pagination personnalisée
function theme_moderne_pagination() {
    global $wp_query;
    
    $big = 999999999;
    
    echo paginate_links([
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => __('&laquo; Précédent', 'theme-moderne'),
        'next_text' => __('Suivant &raquo;', 'theme-moderne'),
        'type' => 'list',
        'class' => 'pagination flex justify-center space-x-2'
    ]);
}

/**
 * Hooks personnalisés du thème
 */

// Hook après la configuration du thème
do_action('theme_moderne_after_setup');

// Hook pour ajouter des scripts/styles personnalisés
function theme_moderne_custom_assets() {
    do_action('theme_moderne_custom_assets');
}
add_action('wp_enqueue_scripts', 'theme_moderne_custom_assets', 100);

<?php
/**
 * Theme Moderne - Block Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

// Inclusion de la configuration ACF
require_once get_template_directory() . '/inc/acf-config.php';

/**
 * Configuration du thème basé sur les blocs
 */
function theme_moderne_setup() {
    // Support pour les traductions
    load_theme_textdomain('theme-moderne', get_template_directory() . '/languages');
    
    // Support pour les images à la une
    add_theme_support('post-thumbnails');
    
    // Support pour le titre de page automatique
    add_theme_support('title-tag');
    
    // Support pour les liens dans les commentaires et posts
    add_theme_support('automatic-feed-links');
    
    // Support pour le HTML5
    add_theme_support('html5', [
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    
    // Support pour les extraits sur les pages
    add_post_type_support('page', 'excerpt');
    
    // Enregistrement des menus de navigation pour la compatibilité
    register_nav_menus([
        'primary' => __('Menu Principal', 'theme-moderne'),
        'footer'  => __('Menu Pied de page', 'theme-moderne')
    ]);
}
add_action('after_setup_theme', 'theme_moderne_setup');

/**
 * Enregistrement des styles et scripts
 */
function theme_moderne_scripts() {
    // Style principal (pour les ajustements personnalisés)
    wp_enqueue_style(
        'theme-moderne-style',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        wp_get_theme()->get('Version')
    );
    
    // Script principal
    wp_enqueue_script(
        'theme-moderne-script',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_moderne_scripts');

/**
 * Enregistrement des catégories de patterns
 */
function theme_moderne_register_pattern_categories() {
    register_block_pattern_category(
        'theme-moderne',
        [
            'label' => __('Thème Moderne', 'theme-moderne'),
            'description' => __('Patterns du thème moderne', 'theme-moderne'),
        ]
    );
    
    register_block_pattern_category(
        'theme-moderne-pages',
        [
            'label' => __('Pages Complètes', 'theme-moderne'),
            'description' => __('Modèles de pages complètes', 'theme-moderne'),
        ]
    );
}
add_action('init', 'theme_moderne_register_pattern_categories');

/**
 * Ajouter des tailles d'images personnalisées
 */
function theme_moderne_custom_image_sizes() {
    add_image_size('hero-image', 1920, 800, true);
    add_image_size('card-image', 400, 300, true);
}
add_action('after_setup_theme', 'theme_moderne_custom_image_sizes');

/**
 * Support étendu pour l'éditeur de blocs
 */
function theme_moderne_editor_setup() {
    // Support pour les styles d'éditeur
    add_theme_support('editor-styles');
    
    // Ajout des styles de l'éditeur
    add_editor_style('assets/css/editor-style.css');
    
    // Support pour les alignements larges
    add_theme_support('align-wide');
    
    // Support pour les blocs responsive
    add_theme_support('responsive-embeds');
    
    // Désactiver les styles de blocs par défaut (géré par theme.json)
    add_theme_support('wp-block-styles');
}
add_action('after_setup_theme', 'theme_moderne_editor_setup');

/**
 * Enregistrement automatique des patterns depuis le dossier /patterns/
 */
function theme_moderne_register_patterns_from_files() {
    $pattern_dir = get_template_directory() . '/patterns/';
    if (!is_dir($pattern_dir)) {
        return;
    }
    $pattern_files = glob($pattern_dir . '*.html');
    foreach ($pattern_files as $file) {
        $content = file_get_contents($file);
        preg_match('/\/\*\*(.*?)\*\//s', $content, $matches);
        if (!isset($matches[1])) {
            continue;
        }
        $header = $matches[1];
        $title = '';
        $slug = '';
        $description = '';
        $categories = array();
        $keywords = array();
        if (preg_match('/Title:\s*(.+)/', $header, $m)) {
            $title = trim($m[1]);
        }
        if (preg_match('/Slug:\s*(.+)/', $header, $m)) {
            $slug = trim($m[1]);
        }
        if (preg_match('/Description:\s*(.+)/', $header, $m)) {
            $description = trim($m[1]);
        }
        if (preg_match('/Categories:\s*(.+)/', $header, $m)) {
            $categories = array_map('trim', explode(',', $m[1]));
        }
        if (preg_match('/Keywords:\s*(.+)/', $header, $m)) {
            $keywords = array_map('trim', explode(',', $m[1]));
        }
        $pattern_content = preg_replace('/^.*?\?>\s*/s', '', $content);
        if (!empty($slug) && !empty($title) && !empty($pattern_content)) {
            register_block_pattern(
                $slug,
                array(
                    'title' => $title,
                    'description' => $description,
                    'content' => trim($pattern_content),
                    'categories' => $categories,
                    'keywords' => $keywords,
                )
            );
        }
    }
}
add_action('init', 'theme_moderne_register_patterns_from_files');

/**
 * Forcer la création des template-parts par défaut
 */
function theme_moderne_create_default_template_parts() {
    // Force la détection des template-parts du thème
    if (function_exists('_build_block_template_result_from_file')) {
        // Vider tous les caches liés aux templates
        wp_cache_flush();
        wp_cache_delete('theme_json', 'themes');
        wp_cache_delete('get_block_template', 'wp-block-templates');
        
        // Forcer WordPress à rescanner les template-parts
        if (function_exists('wp_clean_template_part_cache')) {
            wp_clean_template_part_cache();
        }
    }
}
add_action('init', 'theme_moderne_create_default_template_parts', 20);
add_action('after_setup_theme', 'theme_moderne_create_default_template_parts', 20);

/**
 * Création forcée des template-parts en base de données
 */
function theme_moderne_force_create_template_parts() {
    // Template-parts à créer
    $template_parts = [
        'header-minimal' => [
            'area' => 'header',
            'title' => 'Header Minimal',
            'content' => '<!-- wp:group --><div class="wp-block-group"><!-- wp:site-title /--><!-- wp:navigation /--></div><!-- /wp:group -->'
        ],
        'footer-simple' => [
            'area' => 'footer',
            'title' => 'Footer Simple',
            'content' => '<!-- wp:group {"backgroundColor":"contrast","textColor":"base"} --><div class="wp-block-group has-contrast-background-color has-base-color has-text-color has-background"><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">© 2024 - Tous droits réservés</p><!-- /wp:paragraph --></div><!-- /wp:group -->'
        ]
    ];
    
    foreach ($template_parts as $slug => $part) {
        // Supprimer l'ancien s'il existe
        $existing = get_posts([
            'post_type' => 'wp_template_part',
            'name' => $slug,
            'post_status' => ['publish', 'draft'],
            'numberposts' => 1
        ]);
        
        if (!empty($existing)) {
            wp_delete_post($existing[0]->ID, true);
        }
        
        // Créer le nouveau template-part
        $post_id = wp_insert_post([
            'post_title' => $part['title'],
            'post_name' => $slug,
            'post_content' => $part['content'],
            'post_type' => 'wp_template_part',
            'post_status' => 'publish',
            'post_author' => 1
        ]);
        
        if ($post_id && !is_wp_error($post_id)) {
            // Ajouter les métadonnées nécessaires
            update_post_meta($post_id, 'theme', get_stylesheet());
            update_post_meta($post_id, 'area', $part['area']);
            
            // Forcer la taxonomie wp_template_part_area
            wp_set_object_terms($post_id, $part['area'], 'wp_template_part_area');
        }
    }
    
    // Vider le cache après création
    wp_cache_flush();
}

// Exécuter une seule fois à l'activation ou au changement de thème
function theme_moderne_on_theme_activation() {
    theme_moderne_force_create_template_parts();
    // Marquer comme exécuté
    update_option('theme_moderne_template_parts_created', true);
}

// Vérifier si les template-parts ont déjà été créés
if (!get_option('theme_moderne_template_parts_created')) {
    add_action('after_setup_theme', 'theme_moderne_on_theme_activation', 10);
}

/**
 * Afficher un lien direct vers la création des template-parts dans l'admin
 */
function theme_moderne_admin_notices() {
    $screen = get_current_screen();
    if ($screen && ($screen->id === 'appearance_page_create-template-parts' || strpos($screen->id, 'appearance') !== false)) {
        $existing_parts = get_posts(['post_type' => 'wp_template_part', 'numberposts' => 1]);
        if (empty($existing_parts)) {
            echo '<div class="notice notice-warning">';
            echo '<p><strong>⚠️ Template-parts manquants!</strong></p>';
            echo '<p>Cliquez ici pour les créer: <a href="' . add_query_arg('force_template_parts', '1', home_url()) . '" class="button button-primary">Créer maintenant</a></p>';
            echo '</div>';
        }
    }
}
add_action('admin_notices', 'theme_moderne_admin_notices');

// Debug avancé pour les template-parts
function debug_template_parts() {
    if (current_user_can('administrator')) {
        echo '<div style="background:#f0f0f0;border:1px solid #ccc;padding:10px;margin:10px;font-family:monospace;">';
        echo '<h4>🔍 Diagnostic Template-Parts:</h4>';
        
        // Vérifier les fichiers
        $template_parts_dir = get_template_directory() . '/template-parts/';
        echo '<strong>Fichiers dans /template-parts/:</strong><br>';
        if (is_dir($template_parts_dir)) {
            $files = glob($template_parts_dir . '*.html');
            foreach ($files as $file) {
                echo '• ' . basename($file) . '<br>';
            }
        }
        
        // Vérifier les template-parts WordPress
        if (function_exists('get_block_templates')) {
            $templates = get_block_templates(array(), 'wp_template_part');
            echo '<br><strong>Template-parts WordPress détectées:</strong><br>';
            foreach ($templates as $template) {
                echo '• ' . $template->slug . ' (' . $template->area . ')<br>';
            }
        } else {
            echo '<br><strong>Fonction get_block_templates non disponible</strong><br>';
        }
        
        echo '</div>';
    }
}
add_action('wp_footer', 'debug_template_parts');

/**
 * Ajouter une page d'administration pour créer les template-parts
 */
function theme_moderne_admin_menu() {
    add_theme_page(
        'Créer Template-Parts',
        'Template-Parts',
        'administrator',
        'create-template-parts',
        'theme_moderne_create_template_parts_page'
    );
}
add_action('admin_menu', 'theme_moderne_admin_menu');

function theme_moderne_create_template_parts_page() {
    if (isset($_POST['create_template_parts'])) {
        theme_moderne_force_create_template_parts();
        echo '<div class="notice notice-success"><p>✅ Template-parts créés avec succès!</p></div>';
    }
    
    echo '<div class="wrap">';
    echo '<h1>🔧 Création des Template-Parts</h1>';
    echo '<p>Ce script va créer les template-parts nécessaires directement en base de données.</p>';
    echo '<form method="post">';
    echo '<input type="submit" name="create_template_parts" class="button button-primary" value="Créer les Template-Parts">';
    echo '</form>';
    echo '</div>';
}

/**
 * Forcer la création via URL (pour déboguer)
 */
function theme_moderne_force_template_parts_via_url() {
    if (isset($_GET['force_template_parts']) && current_user_can('administrator')) {
        theme_moderne_force_create_template_parts();
        wp_die('✅ Template-parts créés! <a href="' . admin_url('site-editor.php?postType=wp_template_part') . '">Voir les template-parts</a>');
    }
}
add_action('init', 'theme_moderne_force_template_parts_via_url');

require_once get_template_directory() . '/debug-patterns-status.php';
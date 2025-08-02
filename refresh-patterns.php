<?php
/**
 * Script temporaire pour forcer le rafraîchissement des patterns
 * À exécuter une fois via wp-cli ou en incluant dans functions.php temporairement
 */

// Désactiver puis réactiver l'enregistrement des patterns
remove_action('init', 'theme_moderne_register_patterns');

// Vider le cache des patterns
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

// Réenregistrer les patterns avec force
add_action('init', function() {
    // Supprimer tous les patterns existants du thème
    $registry = WP_Block_Patterns_Registry::get_instance();
    $registered_patterns = $registry->get_all_registered();
    
    foreach ($registered_patterns as $pattern_name => $pattern_data) {
        if (strpos($pattern_name, 'theme-moderne/') === 0) {
            $registry->unregister($pattern_name);
        }
    }
    
    // Réenregistrer les patterns
    theme_moderne_register_patterns();
}, 5);

// Forcer l'invalidation du cache des patterns
add_action('init', function() {
    if (current_user_can('manage_options')) {
        delete_transient('_wp_block_patterns');
        delete_option('_transient__wp_block_patterns');
        
        // Afficher un message de debug
        add_action('admin_notices', function() {
            echo '<div class="notice notice-info"><p><strong>Patterns rafraîchis !</strong> Les patterns du thème ont été réenregistrés.</p></div>';
        });
    }
}, 1);
?>
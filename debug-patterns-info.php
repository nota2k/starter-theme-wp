<?php
/**
 * Script de debug pour vérifier l'état des patterns
 * À copier-coller dans l'admin WordPress ou exécuter via wp-cli
 */

// Fonction de debug des patterns
function debug_theme_patterns() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    echo "<h2>Debug des Patterns</h2>";
    
    // 1. Vérifier les patterns enregistrés
    $registry = WP_Block_Patterns_Registry::get_instance();
    $all_patterns = $registry->get_all_registered();
    
    echo "<h3>Patterns enregistrés :</h3>";
    $theme_patterns = [];
    foreach ($all_patterns as $name => $pattern) {
        if (strpos($name, 'theme-moderne/') === 0) {
            $theme_patterns[$name] = $pattern;
            echo "<p><strong>$name</strong><br>";
            echo "Titre: " . ($pattern['title'] ?? 'N/A') . "<br>";
            echo "Inserter: " . (isset($pattern['inserter']) ? ($pattern['inserter'] ? 'true' : 'false') : 'N/A') . "<br>";
            echo "PostTypes: " . (isset($pattern['postTypes']) ? implode(', ', $pattern['postTypes']) : 'N/A') . "<br>";
            echo "</p>";
        }
    }
    
    if (empty($theme_patterns)) {
        echo "<p style='color: red;'>❌ Aucun pattern du thème trouvé !</p>";
    }
    
    // 2. Vérifier les fichiers de patterns
    echo "<h3>Fichiers de patterns :</h3>";
    $patterns_dir = get_template_directory() . '/patterns';
    if (is_dir($patterns_dir)) {
        $files = glob($patterns_dir . '/*.html');
        foreach ($files as $file) {
            $filename = basename($file);
            echo "<p>📄 $filename</p>";
        }
    }
    
    // 3. Instructions de correction
    echo "<h3>Actions correctives :</h3>";
    echo "<ol>";
    echo "<li>Vider le cache : <code>wp cache flush</code></li>";
    echo "<li>Recharger la page d'administration</li>";
    echo "<li>Vérifier dans Apparence > Éditeur de thèmes</li>";
    echo "<li>Essayer d'insérer un pattern dans une page/article</li>";
    echo "</ol>";
}

// Ajouter un bouton de debug dans l'admin
add_action('admin_menu', function() {
    if (current_user_can('manage_options')) {
        add_submenu_page(
            'themes.php',
            'Debug Patterns Moderne',
            'Debug Patterns',
            'manage_options',
            'debug-patterns-moderne',
            'debug_theme_patterns'
        );
    }
});

// Afficher le debug automatiquement si WP_DEBUG est activé
if (WP_DEBUG && is_admin() && current_user_can('manage_options')) {
    add_action('admin_notices', function() {
        $screen = get_current_screen();
        if ($screen && in_array($screen->base, ['themes', 'appearance_page_debug-patterns-moderne'])) {
            echo '<div class="notice notice-info">';
            echo '<p><strong>Mode debug activé.</strong> ';
            echo '<a href="' . admin_url('themes.php?page=debug-patterns-moderne') . '">Voir le debug des patterns →</a>';
            echo '</p></div>';
        }
    });
}
?>
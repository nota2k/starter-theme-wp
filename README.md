# Thème Moderne WordPress

Un thème WordPress moderne avec support pour Gutenberg, ACF et les dernières technologies web.

## 🚀 Fonctionnalités

- ✅ **CSS moderne** avec variables CSS et architecture modulaire
- ✅ **JavaScript vanilla** (sans jQuery) pour les performances
- ✅ **Blocks Gutenberg** personnalisés (Hero, Témoignages)
- ✅ **Patterns WordPress** prêts à utiliser
- ✅ **Template-parts** modernes et réutilisables
- ✅ **Responsive design** mobile-first
- ✅ **Performance optimisée** (lazy loading, préchargement)
- ✅ **Accessibilité** (ARIA, navigation clavier)
- ✅ **SEO optimisé**

## 📋 Prérequis

- WordPress 6.0+
- PHP 8.0+
- **Advanced Custom Fields (ACF) Pro** (recommandé)

## 🔧 Installation

1. **Téléchargez le thème** dans votre dossier `/wp-content/themes/`
2. **Activez le thème** depuis l'administration WordPress
3. **Installez ACF Pro** pour utiliser toutes les fonctionnalités

### Installation d'ACF Pro

Le thème fonctionne sans ACF mais vous perdrez certaines fonctionnalités :
- Options du thème (logo, réseaux sociaux, scripts)
- Champs personnalisés pour les articles
- Configuration des analytics

**Pour installer ACF Pro :**
1. Achetez une licence sur [advancedcustomfields.com](https://www.advancedcustomfields.com/pro/)
2. Téléchargez et installez le plugin
3. Activez le plugin
4. Le thème configurera automatiquement les champs nécessaires

## 🎨 Configuration

### Options du thème
Accédez à **Thème Moderne** dans l'administration pour configurer :
- Logo du site
- Informations de contact
- Réseaux sociaux
- Scripts d'analytics (Google Analytics, GTM, Facebook Pixel)
- Scripts personnalisés

### Blocks personnalisés
Le thème inclut des blocks Gutenberg personnalisés :
- **Hero Section** : Bannière avec titre, description et CTA
- **Témoignages** : Carousel de témoignages clients

### Patterns inclus
- Hero avec CTA
- Grille de services
- Section témoignages
- Section contact

## 🎯 Utilisation

### Créer une page d'accueil
1. Créez une nouvelle page
2. Utilisez les patterns inclus :
   - Insérez un pattern "Hero avec CTA"
   - Ajoutez une "Grille de services"
   - Terminez avec "Section témoignages"

### Personnaliser les couleurs
Les couleurs sont définies dans `assets/css/_variables.css` :
```css
:root {
  --color-primary: #2563eb;
  --color-secondary: #10b981;
  /* ... */
}
```

### Ajouter des styles personnalisés
Utilisez le hook `theme_moderne_custom_assets` :
```php
function mon_theme_styles() {
    wp_enqueue_style('mon-style', get_template_directory_uri() . '/mon-style.css');
}
add_action('theme_moderne_custom_assets', 'mon_theme_styles');
```

## 📱 Structure du thème

```
theme-moderne-wp/
├── assets/
│   ├── css/              # Styles CSS modulaires
│   └── js/               # JavaScript moderne
├── blocks/               # Blocks Gutenberg personnalisés
├── inc/                  # Fichiers de configuration
├── patterns/             # Patterns WordPress
├── template-parts/       # Composants réutilisables
├── functions.php         # Configuration principale
├── index.php            # Template principal
├── single.php           # Template d'article
├── page.php             # Template de page
├── header.php           # En-tête
└── footer.php           # Pied de page
```

## 🎨 Personnalisation CSS

### Variables disponibles
- Couleurs : `--color-primary`, `--color-secondary`, etc.
- Typographie : `--font-family-primary`, `--font-size-*`
- Espacement : `--spacing-*`
- Bordures : `--border-radius-*`
- Ombres : `--shadow-*`

### Classes utilitaires
- Espacement : `m-4`, `p-6`, `mx-auto`, etc.
- Flexbox : `flex`, `items-center`, `justify-between`
- Grilles : `grid`, `grid-cols-3`, `gap-4`
- Couleurs : `text-primary`, `bg-gray-100`

## ⚡ Performance

Le thème est optimisé pour la performance :
- **CSS minifié** avec variables CSS modernes
- **JavaScript vanilla** sans dépendances
- **Lazy loading** des images
- **Préchargement** des liens au hover
- **Optimisations WordPress** (suppression de scripts inutiles)

## 🔧 Développement

### Hooks disponibles
- `theme_moderne_after_setup` : Après la configuration du thème
- `theme_moderne_custom_assets` : Pour ajouter des styles/scripts

### Fonctions utilitaires
- `theme_moderne_get_excerpt($post_id, $length)` : Extrait personnalisé
- `theme_moderne_is_blog()` : Vérifier si on est sur le blog
- `theme_moderne_get_featured_posts($limit)` : Articles en vedette
- `theme_moderne_reading_time($post_id)` : Temps de lecture

## 🐛 Dépannage

### Le thème ne s'affiche pas correctement
1. Vérifiez que WordPress est en version 6.0+
2. Installez ACF Pro pour toutes les fonctionnalités
3. Vérifiez les erreurs dans les logs PHP

### Les blocks personnalisés n'apparaissent pas
1. Assurez-vous que Gutenberg est activé
2. Vérifiez que les fichiers `block.json` sont présents
3. Rechargez la page d'édition

### Les options du thème sont vides
1. Installez et activez ACF Pro
2. Les champs se créeront automatiquement
3. Accédez à **Thème Moderne** dans l'admin

## 📄 Licence

Ce thème est sous licence GPL v2 ou ultérieure.

## 🆘 Support

Pour toute question ou problème, consultez :
1. Ce fichier README
2. Les commentaires dans le code
3. La documentation WordPress/ACF
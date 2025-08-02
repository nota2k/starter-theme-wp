# 🔓 Instructions pour débloquer les patterns

## ⚡ Actions immédiates à faire dans WordPress

### 1. **Vider le cache WordPress**
```bash
# Via WP-CLI (si disponible)
wp cache flush

# Ou via l'admin WordPress :
```
- Aller dans le tableau de bord WordPress
- Si vous avez un plugin de cache → le vider
- Aller dans **Outils > Site Health** et vider les caches

### 2. **Forcer le rafraîchissement des patterns**
- Aller dans **Apparence > Thèmes**
- Cliquer sur **"Debug Patterns"** (nouveau menu ajouté)
- Suivre les instructions affichées

### 3. **Vérifier les patterns**
- Aller dans **Pages > Ajouter une nouvelle**
- Cliquer sur **"+"** pour ajouter un bloc
- Chercher **"Thème Moderne"** dans les catégories
- Les patterns doivent apparaître : Hero, Services, Témoignages, Contact

### 4. **Tester l'édition**
- Insérer le pattern "Hero avec appel à l'action"
- Cliquer dessus → il doit être **modifiable**
- Changer le titre, la description, les couleurs
- ✅ Succès si tout est éditable !

## 🔧 Si ça ne marche toujours pas

### Méthode 1 : Désactiver/Réactiver le thème
1. **Apparence > Thèmes**
2. Activer un autre thème (ex: Twenty Twenty-Four)
3. Réactiver **Thème Moderne**

### Méthode 2 : Debug mode
1. Vérifier que `WP_DEBUG = true` dans `wp-config.php`
2. Aller dans **Apparence > Debug Patterns**
3. Noter les erreurs éventuelles

### Méthode 3 : Cleanup des patterns existants
```php
// Ajouter temporairement dans functions.php :
add_action('init', function() {
    $registry = WP_Block_Patterns_Registry::get_instance();
    $patterns = $registry->get_all_registered();
    foreach ($patterns as $name => $data) {
        if (strpos($name, 'theme-moderne/') === 0) {
            $registry->unregister($name);
        }
    }
}, 5);
```

## ✅ Résultat attendu

Après ces actions, vous devriez avoir :
- ✅ Patterns visibles dans l'inserter
- ✅ Catégorie "Thème Moderne" disponible
- ✅ Hero et Témoignages entièrement éditables
- ✅ Aucun cadenas ou "Non synchronisée"

## 🆘 Dernière solution

Si rien ne fonctionne, suppresser les fichiers temporaires :
```bash
rm refresh-patterns.php
rm debug-patterns-info.php
```

Et relancer WordPress. Les patterns de base devraient fonctionner.
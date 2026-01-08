# 🏠 Guide d'Installation - Pages Publiques

## 📦 Fichiers Fournis

### Pages Vue (resources/js/Pages/)
- ✅ **Welcome.vue** - Page d'accueil avec hero, recherche, catégories et biens
- ✅ **Biens.vue** - Liste des biens avec filtres et pagination
- ✅ **Contact.vue** - Page de contact avec formulaire
- ✅ **APropos.vue** - Page à propos de l'application

### Composants Layout (resources/js/Components/Layout/)
- ✅ **PublicNavbar.vue** - Navbar pour les visiteurs
- ✅ **PublicFooter.vue** - Footer avec liens et contact

### Controllers (app/Http/Controllers/)
- ✅ **PublicPropertyController.php** - Gestion des biens publics
- ✅ **ContactController.php** - Gestion du formulaire de contact

### Routes
- ✅ **routes_publiques.php** - Routes à ajouter dans web.php

---

## ⚡ Installation Rapide (5 minutes)

### Étape 1 : Créer les répertoires

```bash
cd /home/whitehack/projetweblaravel/projet_immobilier_groupe7_gsi

# Créer les dossiers nécessaires
mkdir -p resources/js/Pages
mkdir -p resources/js/Components/Layout
mkdir -p app/Http/Controllers
```

### Étape 2 : Copier les fichiers Pages

```bash
# Pages principales
cp Welcome.vue resources/js/Pages/
cp Biens.vue resources/js/Pages/
cp Contact.vue resources/js/Pages/
cp APropos.vue resources/js/Pages/
```

### Étape 3 : Copier les composants Layout

```bash
# Composants Layout
cp PublicNavbar.vue resources/js/Components/Layout/
cp PublicFooter.vue resources/js/Components/Layout/
```

### Étape 4 : Copier les Controllers

```bash
# Controllers
cp PublicPropertyController.php app/Http/Controllers/
cp ContactController.php app/Http/Controllers/
```

### Étape 5 : Ajouter les routes publiques

Ouvrez `routes/web.php` et ajoutez le contenu de `routes_publiques.php` **AU DÉBUT DU FICHIER** (avant les routes authentifiées) :

```php
<?php

use App\Http\Controllers\PublicPropertyController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ===== ROUTES PUBLIQUES (COMMENCEZ ICI) =====

// Page d'accueil
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'featuredProperties' => \App\Models\Property::where('status', 'available')
            ->latest()
            ->limit(6)
            ->get(),
        'propertiesCount' => [
            'appartement' => \App\Models\Property::where('type', 'appartement')->where('status', 'available')->count(),
            'maison' => \App\Models\Property::where('type', 'maison')->where('status', 'available')->count(),
            'bureau' => \App\Models\Property::where('type', 'bureau')->where('status', 'available')->count(),
            'commerce' => \App\Models\Property::where('type', 'commerce')->where('status', 'available')->count(),
            'terrain' => \App\Models\Property::where('type', 'terrain')->where('status', 'available')->count(),
        ],
    ]);
})->name('home');

// Biens disponibles
Route::get('/biens', [PublicPropertyController::class, 'index'])->name('public.properties.index');
Route::get('/biens/{property}', [PublicPropertyController::class, 'show'])->name('public.properties.show');

// À propos
Route::get('/a-propos', function () {
    return Inertia::render('APropos');
})->name('about');

// Contact
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ===== FIN DES ROUTES PUBLIQUES =====

// Le reste de vos routes...
require __DIR__.'/auth.php';
```

### Étape 6 : Ajouter les propriétés au modèle Property

Assurez-vous que votre modèle `Property` a ces accesseurs :

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    // ... autres codes ...

    /**
     * Accesseur pour l'URL de la photo principale
     */
    public function getPrimaryPhotoUrlAttribute()
    {
        $primaryPhoto = $this->photos()->where('is_primary', true)->first();
        
        if ($primaryPhoto) {
            return asset('storage/' . $primaryPhoto->path);
        }
        
        // Photo par défaut si pas de photo
        return null;
    }

    /**
     * Relation avec les photos
     */
    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    /**
     * Relation avec le propriétaire
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

### Étape 7 : Compiler les assets

```bash
npm run dev
```

### Étape 8 : Tester !

Accédez à votre application :
```
http://localhost:8000/
```

Vous devriez voir :
- ✅ Page d'accueil avec navbar, hero, catégories et biens
- ✅ Page /biens avec liste des biens et filtres
- ✅ Page /a-propos
- ✅ Page /contact avec formulaire fonctionnel

---

## 📋 Structure des Pages

### 1. Welcome.vue (Page d'accueil)
- **Hero Section** avec recherche
- **Catégories** de biens (5 types)
- **Biens en vedette** (6 biens maximum)
- **Call to Action** pour les propriétaires
- **Navbar** et **Footer** inclus

### 2. Biens.vue (Liste des biens)
- **Sidebar** avec filtres :
  - Recherche par texte
  - Type de bien
  - Prix maximum
  - Surface minimum
  - Nombre de chambres
- **Liste paginée** des biens
- **Tri** (récent, prix, surface)
- **Responsive** mobile/desktop

### 3. Contact.vue
- **Formulaire** complet :
  - Nom, email, téléphone
  - Sujet (dropdown)
  - Message
- **Informations** de contact
- **Réseaux sociaux**

### 4. APropos.vue
- **Mission** de l'entreprise
- **Valeurs** (3 cartes)
- **Fonctionnalités** (6 points)
- **Statistiques** (biens, utilisateurs, satisfaction)
- **Call to Action**

---

## 🎨 Design et Fonctionnalités

### Design Moderne
- ✅ **Tailwind CSS** pour le style
- ✅ **Gradient** indigo pour les headers
- ✅ **Ombres** et effets hover
- ✅ **Animations** fluides
- ✅ **Icons SVG** natifs

### Responsive
- ✅ **Mobile** : menu hamburger, grille 1 colonne
- ✅ **Tablet** : grille 2 colonnes
- ✅ **Desktop** : grille 3 colonnes, sidebar

### Fonctionnalités
- ✅ **Recherche** en temps réel
- ✅ **Filtres** multiples
- ✅ **Pagination** avec Inertia.js
- ✅ **Tri** des résultats
- ✅ **Messages** de succès/erreur

---

## 🔧 Personnalisation

### Changer les couleurs
Dans tous les fichiers Vue, remplacez `indigo` par votre couleur :

```vue
<!-- Avant -->
<div class="bg-indigo-600">

<!-- Après (exemple avec blue) -->
<div class="bg-blue-600">
```

### Modifier les types de biens
Dans `Welcome.vue` et `Biens.vue`, modifiez le tableau des types :

```javascript
const types = {
    'appartement': 'Appartement',
    'maison': 'Maison',
    'bureau': 'Bureau',
    'commerce': 'Commerce',
    'terrain': 'Terrain',
    // Ajoutez vos types ici
};
```

### Changer le logo
Dans `PublicNavbar.vue`, ligne 6-11, remplacez le SVG par votre logo :

```vue
<img src="/images/logo.png" alt="Logo" class="h-10 w-10" />
```

### Modifier les informations de contact
Dans `PublicFooter.vue` et `Contact.vue`, modifiez :
- L'adresse
- L'email
- Le téléphone
- Les liens des réseaux sociaux

---

## 🐛 Résolution de Problèmes

### Erreur "Class PublicPropertyController not found"
```bash
composer dump-autoload
```

### Erreur "Route [public.properties.index] not defined"
Vérifiez que vous avez bien ajouté les routes dans `web.php`

### Images ne s'affichent pas
```bash
php artisan storage:link
```

### Page blanche
```bash
# Vérifier les logs
tail -f storage/logs/laravel.log

# Vérifier la console (F12)
```

### Filtres ne fonctionnent pas
Assurez-vous que le modèle `Property` a les colonnes :
- `status` (pour filtrer les biens disponibles)
- `type`, `rent_amount`, `surface`, `bedrooms`

---

## ✅ Checklist de Vérification

### Fichiers copiés
- [ ] Welcome.vue dans resources/js/Pages/
- [ ] Biens.vue dans resources/js/Pages/
- [ ] Contact.vue dans resources/js/Pages/
- [ ] APropos.vue dans resources/js/Pages/
- [ ] PublicNavbar.vue dans resources/js/Components/Layout/
- [ ] PublicFooter.vue dans resources/js/Components/Layout/
- [ ] PublicPropertyController.php dans app/Http/Controllers/
- [ ] ContactController.php dans app/Http/Controllers/

### Configuration
- [ ] Routes publiques ajoutées dans web.php
- [ ] Modèle Property avec accesseur primary_photo_url
- [ ] Relation photos() dans Property
- [ ] Relation owner() dans Property
- [ ] npm run dev exécuté

### Tests
- [ ] Page d'accueil accessible (/)
- [ ] Liste des biens accessible (/biens)
- [ ] Filtres fonctionnent
- [ ] Page contact accessible (/contact)
- [ ] Formulaire de contact envoie
- [ ] Page à propos accessible (/a-propos)
- [ ] Navbar responsive
- [ ] Footer avec liens

---

## 🎯 Prochaines Étapes

### Phase 1 : Compléter les données
1. Ajouter des biens dans la base de données
2. Ajouter des photos aux biens
3. Tester avec des données réelles

### Phase 2 : Créer la page de détails
1. Créer `BienDetails.vue` (page détaillée d'un bien)
2. Ajouter galerie photo
3. Ajouter formulaire de demande de visite

### Phase 3 : Fonctionnalités avancées
1. Ajouter favoris (coeur)
2. Ajouter comparaison de biens
3. Ajouter carte interactive (Google Maps)
4. Ajouter partage sur réseaux sociaux

---

## 📚 Ressources

- [Inertia.js Documentation](https://inertiajs.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Vue 3 Documentation](https://vuejs.org/)
- [Laravel Documentation](https://laravel.com/docs)

---

## 🆘 Support

Si vous rencontrez des problèmes :

1. Vérifiez les logs Laravel : `storage/logs/laravel.log`
2. Vérifiez la console du navigateur (F12)
3. Vérifiez que toutes les dépendances sont installées
4. Assurez-vous que la base de données est configurée

---

**Bon courage avec votre projet ! 🚀**

*Groupe 7 - GSI - Application de Gestion Immobilière*

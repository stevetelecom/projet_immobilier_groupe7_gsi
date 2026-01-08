# Installation des fichiers d'authentification

## Fichiers créés

✅ **GuestLayout.vue** - Layout pour les pages d'authentification
✅ **Login.vue** - Page de connexion
✅ **Register.vue** - Page d'inscription avec sélection du rôle
✅ **ForgotPassword.vue** - Page mot de passe oublié
✅ **ResetPassword.vue** - Page de réinitialisation du mot de passe
✅ **VerifyEmail.vue** - Page de vérification d'email

## Instructions d'installation

### 1. Créer les répertoires nécessaires (si ils n'existent pas)

```bash
mkdir -p resources/js/Components/Layout
mkdir -p resources/js/Pages/Auth
```

### 2. Copier les fichiers dans votre projet

**GuestLayout.vue :**
```bash
# Copier dans : resources/js/Components/Layout/GuestLayout.vue
```

**Fichiers Auth :**
```bash
# Copier les fichiers suivants dans : resources/js/Pages/Auth/
# - Login.vue
# - Register.vue
# - ForgotPassword.vue
# - ResetPassword.vue
# - VerifyEmail.vue
```

### 3. Vérifier votre fichier vite.config.js

Assurez-vous que vous avez l'alias `@` configuré :

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
});
```

### 4. Vérifier les routes dans web.php

Assurez-vous d'avoir les routes d'authentification Laravel Breeze :

```php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
```

### 5. Redémarrer Vite

```bash
npm run dev
```

### 6. Tester les pages

Accédez à :
- http://localhost:8000/login
- http://localhost:8000/register
- http://localhost:8000/forgot-password

## Fonctionnalités incluses

✅ Formulaires de connexion et d'inscription
✅ Validation des erreurs côté client
✅ Sélection du rôle lors de l'inscription (Propriétaire, Locataire, Agent)
✅ Mot de passe oublié et réinitialisation
✅ Vérification d'email
✅ Design moderne avec Tailwind CSS
✅ Responsive et accessible
✅ Messages de succès et d'erreur
✅ Intégration complète avec Inertia.js

## Notes importantes

- Les pages utilisent **Tailwind CSS** pour le style
- Les formulaires utilisent **useForm** d'Inertia.js
- Tous les chemins utilisent **Ziggy** pour les routes nommées
- Le layout **GuestLayout** est réutilisable pour toutes les pages publiques

## Personnalisation

Vous pouvez personnaliser :
- Le logo dans `GuestLayout.vue` (ligne 6-11)
- Les couleurs (remplacer `indigo-` par votre couleur)
- Les champs du formulaire d'inscription
- Les messages de validation

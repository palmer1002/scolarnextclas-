# 💬 Discussion Générale - Documentation

## 📋 Vue d'ensemble

Un système de **discussion générale** style WhatsApp a été implémenté pour permettre à tous les utilisateurs de l'application (administrateurs, enseignants, parents et élèves) de communiquer ensemble dans un espace commun.

## ✨ Fonctionnalités

### 1. **Interface Style WhatsApp**
- Design moderne avec bulles de messages
- Messages alignés à droite pour l'utilisateur connecté (vert)
- Messages alignés à gauche pour les autres utilisateurs (blanc)
- Avatars avec initiales colorées
- Horodatage des messages

### 2. **Envoi de Messages**
- Zone de saisie avec bouton d'envoi
- Support des messages jusqu'à 5000 caractères
- Envoi via AJAX sans rechargement de page
- Animation d'apparition des nouveaux messages

### 3. **Actualisation en Temps Réel**
- Polling automatique toutes les 3 secondes
- Récupération des nouveaux messages sans action utilisateur
- Scroll automatique vers le bas pour les nouveaux messages
- Notification visuelle des messages double-checkés (✓✓)

### 4. **Gestion des Messages**
- Suppression possible de ses propres messages
- Confirmation avant suppression
- Affichage du nom et du rôle de l'expéditeur

### 5. **Responsive et Accessible**
- Compatible mobile, tablette et desktop
- Scrollbar personnalisée
- Design adaptatif

## 🗂️ Structure des Fichiers

### Migration
- **`database/migrations/2026_02_03_155200_create_group_messages_table.php`**
  - Table `group_messages` avec colonnes :
    - `id` : Clé primaire
    - `user_id` : Lien vers l'utilisateur
    - `message` : Contenu du message (texte)
    - `fichier` : Pour les pièces jointes futures (nullable)
    - `created_at`, `updated_at` : Timestamps

### Modèle
- **`app/Models/GroupMessage.php`**
  - Relations : `user()` (BelongsTo)
  - Accesseurs : `formatted_time`, `formatted_date`
  - Fillable : `user_id`, `message`, `fichier`

### Contrôleur
- **`app/Http/Controllers/GroupChatController.php`**
  - `index()` : Affiche la page avec les 100 derniers messages
  - `store()` : Envoie un nouveau message (AJAX)
  - `getNewMessages()` : Récupère les nouveaux messages pour le polling
  - `destroy()` : Supprime un message (seulement le sien)

### Vues
- **`resources/views/group-chat/index.blade.php`**
  - Interface principale du chat
  - JavaScript pour AJAX et polling
  - Styles CSS personnalisés
  
- **`resources/views/group-chat/partials/message.blade.php`**
  - Template pour afficher chaque message
  - Différenciation visuelle messages propres/autres

### Routes
- **`routes/web.php`** (ajouté)
  ```php
  Route::get('/group-chat', [GroupChatController::class, 'index'])->name('group-chat.index');
  Route::post('/group-chat', [GroupChatController::class, 'store'])->name('group-chat.store');
  Route::get('/group-chat/new-messages', [GroupChatController::class, 'getNewMessages'])->name('group-chat.new-messages');
  Route::delete('/group-chat/{id}', [GroupChatController::class, 'destroy'])->name('group-chat.destroy');
  ```

### Menu Navigation
- **`resources/views/layouts/menu.blade.php`** (modifié)
  - Ajout du lien "Discussion Générale" avec icône `fa-user-group`
  - Accessible à tous les rôles

### Seeder
- **`database/seeders/GroupMessageSeeder.php`**
  - Crée des messages de bienvenue pour tester

## 🚀 Utilisation

### Accéder à la Discussion Générale
1. Se connecter à l'application
2. Cliquer sur **"Discussion Générale"** dans le menu latéral
3. Taper un message et cliquer sur "Envoyer"

### Supprimer un Message
1. Survoler son propre message
2. Cliquer sur le bouton ❌ en haut à droite du message
3. Confirmer la suppression

## 🔧 Configuration

### Fréquence d'Actualisation
Par défaut, les nouveaux messages sont vérifiés toutes les **3 secondes**.

Pour modifier cette fréquence, éditer le fichier `index.blade.php` :
```javascript
setInterval(function() {
    // ...
}, 3000); // Modifier cette valeur (en millisecondes)
```

### Nombre de Messages Affichés
Par défaut, les **100 derniers messages** sont affichés.

Pour modifier, éditer `GroupChatController.php` :
```php
$messages = GroupMessage::with('user')
    ->latest()
    ->take(100) // Modifier cette valeur
    ->get()
    // ...
```

## 🎨 Personnalisation

### Couleurs
- **Messages de l'utilisateur** : Vert Bootstrap (`bg-success`)
- **Messages des autres** : Blanc (`bg-white`)
- **Arrière-plan** : Motif WhatsApp beige (#e5ddd5)

Pour modifier les couleurs, éditer le CSS dans `index.blade.php`.

## 📝 Améliorations Futures Possibles

1. **Notifications Push** (Pusher/WebSockets)
2. **Pièces jointes** (images, documents)
3. **Émojis** (picker d'émojis)
4. **Mentions** (@utilisateur)
5. **Édition de messages**
6. **Réactions** (👍❤️😂)
7. **Messages épinglés**
8. **Recherche dans les messages**
9. **Indicateur "En train d'écrire..."**
10. **Statut en ligne des utilisateurs**

## 🔒 Sécurité

- **Authentification requise** : Seuls les utilisateurs connectés peuvent accéder
- **Validation des données** : Messages validés côté serveur
- **CSRF Protection** : Tokens CSRF sur toutes les requêtes POST/DELETE
- **Limitation** : 5000 caractères max par message
- **Suppression sécurisée** : Un utilisateur ne peut supprimer que ses propres messages (sauf admin)

## 🐛 Dépannage

### Les messages ne s'affichent pas
- Vérifier que la migration a été exécutée : `php artisan migrate`
- Vérifier la console JavaScript pour les erreurs

### Les nouveaux messages n'apparaissent pas automatiquement
- Vérifier la console réseau (Network) pour les requêtes AJAX
- Vérifier que le polling fonctionne (requête toutes les 3s)

### Erreur 403 ou 419
- Vérifier que le token CSRF est présent dans le HTML
- Vider le cache : `php artisan cache:clear`

## 📊 Base de Données

### Structure de la table `group_messages`

| Colonne     | Type      | Description                    |
|-------------|-----------|--------------------------------|
| id          | bigint    | Clé primaire                   |
| user_id     | bigint    | ID de l'utilisateur (FK)       |
| message     | text      | Contenu du message             |
| fichier     | varchar   | Chemin fichier joint (nullable)|
| created_at  | timestamp | Date de création               |
| updated_at  | timestamp | Date de modification           |

## 🎯 Conclusion

Le système de discussion générale est maintenant opérationnel ! Tous les utilisateurs peuvent :
- ✅ Envoyer des messages
- ✅ Voir les messages des autres en temps quasi-réel
- ✅ Supprimer leurs propres messages
- ✅ Profiter d'une interface moderne et intuitive

Pour toute question ou amélioration, n'hésitez pas ! 🚀

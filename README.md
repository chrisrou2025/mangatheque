# mangatheque
# 📚 Mangathèque

Une application web de gestion de collection de mangas développée en PHP, permettant aux utilisateurs de cataloguer, noter et organiser leurs mangas préférés.

## 🎯 Fonctionnalités

### Gestion des Mangas
- ✅ Ajout de nouveaux mangas avec informations complètes
- ✅ Consultation détaillée des fiches manga
- ✅ Modification et suppression des mangas
- ✅ Upload d'images de couverture
- ✅ Classification par type (Shônen, Shôjo, Seinen, Kodomo, Josei)

### Système d'Utilisateurs
- ✅ Inscription et connexion sécurisées
- ✅ Gestion des profils utilisateur
- ✅ Système de sessions

### Fonctionnalités Sociales
- ✅ Système de favoris personnalisés
- ✅ Top des mangas les plus appréciés
- ✅ Système de notation et commentaires (1-5 étoiles)
- ✅ Calcul automatique des notes moyennes

### Interface Utilisateur
- ✅ Interface responsive et moderne
- ✅ Navigation intuitive
- ✅ Messages de notification (toast)
- ✅ Affichage en grille et en liste

## 🛠️ Technologies Utilisées

- **Backend:** PHP 8.1+
- **Base de données:** MySQL 9.1
- **Routage:** AltoRouter
- **Frontend:** HTML5, CSS3, JavaScript vanilla
- **Architecture:** MVC (Model-View-Controller)
- **Sécurité:** Sessions PHP, hashage des mots de passe

## 📋 Prérequis

- PHP 8.1 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)
- Composer (pour la gestion des dépendances)

## 🚀 Installation

### 1. Cloner le projet
```bash
git clone [URL_DU_REPO]
cd mangatheque
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configuration de la base de données

Créez une base de données MySQL nommée `mangatheque` et importez le fichier SQL fourni :

```bash
mysql -u root -p
CREATE DATABASE mangatheque;
USE mangatheque;
SOURCE mangatheque.sql;
```

### 4. Configuration du serveur web

**Option A: Serveur de développement PHP**
```bash
php -S localhost:8000
```
Accédez à l'application via : `http://localhost:8000/mangatheque`

**Option B: Apache/Nginx**
- Configurez votre serveur pour pointer vers le dossier racine du projet
- Configurez le fichier `.htaccess` si nécessaire pour la réécriture d'URL

### 5. Configuration de la base de données

Modifiez les paramètres de connexion dans `model/Model.php` :
```php
self::$db = new PDO('mysql:host=localhost;dbname=mangatheque', 'your_username', 'your_password');
```

## 🏗️ Architecture du Projet

Le projet suit une architecture **MVC (Model-View-Controller)** :

```
mangatheque/
├── index.php                 # Point d'entrée et routeur principal
├── composer.json             # Gestion des dépendances
├── mangatheque.sql          # Structure de la base de données
├── controller/              # Contrôleurs (logique métier)
│   ├── ControllerAuth.php   # Gestion authentification
│   ├── ControllerManga.php  # Gestion des mangas
│   ├── ControllerPage.php   # Pages statiques
│   └── ControllerUser.php   # Gestion des utilisateurs
├── model/                   # Modèles (accès aux données)
│   ├── Model.php           # Classe de base (connexion DB)
│   ├── MangaModel.php      # Modèle des mangas
│   └── ModelUser.php       # Modèle des utilisateurs
├── entity/                  # Entités (objets métier)
│   ├── Manga.php           # Classe Manga
│   ├── User.php            # Classe User
│   └── Review.php          # Classe Review (avis)
├── view/                   # Vues (interface utilisateur)
│   ├── base-html.php       # Template HTML principal
│   ├── auth/               # Pages d'authentification
│   ├── manga/              # Pages des mangas
│   ├── page/               # Pages générales
│   └── user/               # Pages utilisateur
└── public/                 # Fichiers statiques
    ├── css/               # Feuilles de style
    ├── js/                # Scripts JavaScript
    └── covers/            # Images des couvertures
```

## 📊 Base de Données

La base de données contient 4 tables principales :

### `mangas`
- Stockage des informations des mangas
- Champs : id, title, author, volume, description, cover_image, publisher, type

### `user` 
- Gestion des utilisateurs
- Champs : id, pseudo, email, password (hashé), created_at

### `favorites`
- Système de favoris utilisateur-manga
- Champs : id, user_id, manga_id, created_at

### `reviews`
- Système de notation et commentaires
- Champs : id, manga_id, user_id, rating (1-5), comment, created_at

## 🔧 Fonctionnalités Détaillées

### Authentification
- **Inscription** : Validation email/pseudo, hashage sécurisé des mots de passe
- **Connexion** : Vérification des credentials, gestion de session
- **Déconnexion** : Destruction sécurisée de session

### Gestion des Mangas
- **CRUD complet** : Create, Read, Update, Delete
- **Upload d'images** : Validation des formats, génération de noms uniques
- **Système de types** : Classification par genre (Shônen, Shôjo, etc.)

### Fonctionnalités Sociales
- **Favoris** : Ajout/suppression avec vérification d'unicité
- **Top des favoris** : Classement par popularité
- **Système de notes** : Notation 1-5 étoiles avec moyenne automatique
- **Commentaires** : Avis textuels associés aux notes

## 🎨 Interface Utilisateur

- Design responsive adaptatif
- Système de notifications toast
- Navigation intuitive avec menu contextuel
- Affichage en grille pour les listes
- Formulaires avec validation côté client

## 🔒 Sécurité

- **Mots de passe** : Hashage avec `password_hash()` PHP
- **Sessions** : Gestion sécurisée des sessions utilisateur
- **Validation** : Nettoyage et validation des données d'entrée
- **Upload** : Vérification des types de fichiers images
- **SQL** : Utilisation de requêtes préparées (protection contre injections SQL)

## 🚀 Fonctionnalités Avancées

### Système de Routage
Utilisation d'AltoRouter pour une gestion propre des URLs :
- Routes RESTful pour les mangas
- Paramètres dynamiques dans les URLs
- Gestion des méthodes HTTP (GET, POST)

### Gestion des Fichiers
- Upload sécurisé des images de couverture
- Génération automatique de noms de fichiers uniques
- Suppression automatique des anciennes images lors des mises à jour

### Base de Données Avancée
- Jointures complexes pour les statistiques
- Calculs automatiques des moyennes de notes
- Contraintes d'unicité pour éviter les doublons

## 🛠️ Utilisation

### Pour les Utilisateurs

1. **S'inscrire** : Créer un compte avec email et pseudo uniques
2. **Se connecter** : Accéder à l'application avec ses identifiants
3. **Ajouter des mangas** : Remplir le formulaire avec les détails du manga
4. **Gérer sa collection** : Modifier, supprimer ou consulter ses mangas
5. **Interagir** : Ajouter aux favoris, noter et commenter

### Pour les Développeurs

1. **Ajouter de nouveaux contrôleurs** : Étendre les fonctionnalités
2. **Modifier les modèles** : Adapter la logique métier
3. **Personnaliser les vues** : Modifier l'interface utilisateur
4. **Étendre la base de données** : Ajouter de nouvelles tables/champs

## 🔍 Exemples d'Utilisation

### Ajouter un Manga
```php
// Dans ControllerManga.php
$manga = new Manga($title, $author, $volume, $description, $coverImage, $publisher, $type);
$this->mangaModel->add($manga);
```

### Système de Favoris
```php
// Ajouter aux favoris
$this->mangaModel->addFavorite($userId, $mangaId);

// Vérifier si c'est un favori
$isFavorite = $this->mangaModel->isFavorite($userId, $mangaId);
```

### Système de Notes
```php
// Ajouter une note
$this->mangaModel->addReview($mangaId, $userId, $rating, $comment);

// Calculer la moyenne
$average = $this->mangaModel->getAverageRatingForManga($mangaId);
```

## 📱 Responsive Design

L'application s'adapte automatiquement aux différents appareils :
- **Desktop** : Interface complète avec toutes les fonctionnalités
- **Tablette** : Adaptation des grilles et menus
- **Mobile** : Navigation simplifiée, masquage d'éléments secondaires

## 🎯 Points d'Amélioration Possibles

1. **API REST** : Créer une API pour une utilisation mobile
2. **Recherche avancée** : Filtres par auteur, genre, note
3. **Pagination** : Pour les grandes collections
4. **Import/Export** : Sauvegarde des collections
5. **Notifications** : Système de notification en temps réel
6. **Thèmes** : Mode sombre/clair
7. **Multilangue** : Support de plusieurs langues

## 📝 Notes Techniques

- **PHP 8.1+** requis pour les nouvelles fonctionnalités
- **MySQL 9.1** pour les performances optimales
- **AltoRouter** pour le routage moderne
- **PDO** pour l'accès base de données sécurisé
- **Sessions PHP** pour la gestion d'état

## 🐛 Debugging

Pour activer le mode debug, ajoutez dans `Model.php` :
```php
self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

Les logs d'erreur sont disponibles via `error_log()` dans les contrôleurs.

## 📞 Support

Pour toute question ou problème :
1. Vérifiez les logs d'erreur PHP
2. Consultez la documentation des dépendances
3. Testez les requêtes SQL directement dans phpMyAdmin

---

**Projet créé dans le cadre d'un apprentissage du développement web en PHP** 

*Version 1.0 - Janvier 2025*
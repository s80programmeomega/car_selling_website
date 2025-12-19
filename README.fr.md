# 🚗 Marketplace Automobile - Plateforme Moderne de Commerce de Véhicules

**[English](README.md)** | **[Français](README.fr.md)**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=flat&logo=livewire)](https://livewire.laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Une plateforme complète et moderne de marketplace automobile construite avec Laravel 12, Livewire et Flux UI. Cette application offre une expérience fluide pour l'achat et la vente de véhicules avec des capacités de recherche avancées, des notifications en temps réel et une gestion complète des utilisateurs.

## 📋 Table des Matières

- [Fonctionnalités](#-fonctionnalités)
- [Stack Technique](#-stack-technique)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Utilisation](#-utilisation)
- [Architecture](#-architecture)
- [Documentation API](#-documentation-api)
- [Tests](#-tests)
- [Déploiement](#-déploiement)
- [Contribution](#-contribution)
- [Licence](#-licence)

## ✨ Fonctionnalités

### Fonctionnalités Principales
- 🚘 **Gestion des Annonces de Véhicules** - Créer, modifier et gérer les annonces de voitures avec des spécifications détaillées
- 🔍 **Recherche Avancée** - Propulsée par Typesense pour une recherche ultra-rapide et tolérante aux fautes de frappe
- ⭐ **Système de Favoris** - Sauvegarder et suivre les véhicules favoris
- 💬 **Système de Demandes** - Communication directe entre acheteurs et vendeurs
- ⭐ **Avis & Évaluations** - Système de réputation utilisateur avec avis
- 📸 **Gestion d'Images** - Téléchargement multiple d'images avec réorganisation par glisser-déposer

### Fonctionnalités Utilisateur
- 🔐 **Authentification** - Connexion sécurisée avec Laravel Fortify
- 🔒 **Authentification à Deux Facteurs** - Sécurité renforcée avec 2FA
- 👤 **Profils Utilisateur** - Profils complets pour utilisateurs et concessionnaires
- 🎨 **Paramètres d'Apparence** - Préférences d'interface personnalisables
- 📊 **Tableau de Bord** - Tableau de bord personnel pour gérer les annonces et activités

### Système de Notifications
- 🔔 **Notifications en Temps Réel** - Mises à jour instantanées via Laravel Reverb
- 📧 **Notifications par Email** - Alertes email personnalisables
- 🔕 **Préférences de Notification** - Contrôle granulaire des types de notifications
- 📬 **Notifications In-App** - Icône de cloche avec compteur de non-lus
- 📨 **Abonnements Newsletter** - Emails récapitulatifs hebdomadaires

### Fonctionnalités d'Abonnement
- 📮 **Abonnements Email** - S'abonner aux alertes de nouvelles voitures
- 🎯 **Abonnements Filtrés** - Filtres personnalisés (marque, prix, localisation)
- ⏰ **Contrôle de Fréquence** - Notifications instantanées, quotidiennes ou hebdomadaires
- 🔗 **Désabonnement en Un Clic** - Gestion facile des abonnements

### Fonctionnalités Admin
- 🛠️ **Panneau d'Administration** - Interface de gestion complète
- 📊 **Gestion des Données** - Gérer les marques, modèles, types, caractéristiques
- 📍 **Gestion des Localisations** - Administration des états et villes
- 💼 **Gestion des Demandes** - Voir et gérer toutes les demandes
- 📝 **Modération des Avis** - Surveiller et gérer les avis
- 📧 **Messages de Contact** - Gérer les demandes de support client

### Fonctionnalités Avancées
- 🔄 **Mises à Jour en Temps Réel** - Mises à jour en direct avec Laravel Reverb
- 📱 **Design Responsive** - Interface mobile-first, entièrement responsive
- 🎨 **Interface Moderne** - Construite avec les composants Flux UI
- 🚀 **Performance** - Optimisée avec mise en cache et jobs de file d'attente
- 📈 **Analytiques** - Suivi des vues et engagement utilisateur
- 🔍 **Optimisé SEO** - URLs et balises meta optimisées pour les moteurs de recherche
- 🌐 **Prêt Multi-langue** - Support d'internationalisation

## 🛠 Stack Technique

### Backend
- **Framework:** Laravel 12.x
- **PHP:** 8.2+
- **Base de Données:** SQLite (développement) / MySQL/PostgreSQL (production)
- **File d'Attente:** Laravel Horizon (basé sur Redis)
- **Recherche:** Typesense
- **Temps Réel:** Laravel Reverb (WebSockets)
- **Authentification:** Laravel Fortify
- **Audit:** Yajra Laravel Auditable

### Frontend
- **Framework UI:** Livewire 3.x
- **Bibliothèque de Composants:** Flux UI 2.x
- **Stylisation:** Tailwind CSS 4.x
- **Outil de Build:** Vite 7.x
- **JavaScript:** Alpine.js (via Livewire)

### Outils de Développement
- **Débogage:** Laravel Telescope, Laravel Debugbar
- **Tests:** Pest PHP
- **Qualité du Code:** Laravel Pint
- **Logs:** Laravel Pail
- **Développement:** Laravel Sail (Docker)

## 📦 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** ou **Yarn**
- **SQLite** (pour le développement) ou **MySQL/PostgreSQL** (pour la production)
- **Redis** (pour les files d'attente et la mise en cache)
- **Typesense** (pour la fonctionnalité de recherche)

## 🚀 Installation

### 1. Cloner le Dépôt

```bash
git clone https://github.com/s80programmeomega/car_selling_website.git
cd car_selling_website
```

### 2. Installer les Dépendances

```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances Node
npm install
```

### 3. Configuration de l'Environnement

```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configuration de Redis (Développement Local)

[Redis](https://redis.io/) est requis pour les files d'attente, la mise en cache et les sessions.

**Option 1 : Utiliser Docker (Recommandé)**
```bash
# Télécharger et exécuter le conteneur Redis
docker run -d --name redis-car-marketplace \
  -p 6379:6379 \
  redis:alpine

# Vérifier que Redis fonctionne
docker ps | grep redis
```

**Option 2 : Installer Redis Localement**

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install redis-server
sudo systemctl start redis-server
sudo systemctl enable redis-server

# Tester la connexion
redis-cli ping  # Devrait retourner PONG
```

**macOS:**
```bash
brew install redis
brew services start redis

# Tester la connexion
redis-cli ping  # Devrait retourner PONG
```

**Windows:**
- Télécharger depuis [Redis Windows releases](https://github.com/microsoftarchive/redis/releases)
- Ou utiliser WSL2 avec les instructions Ubuntu ci-dessus
- Alternative : [Memurai](https://www.memurai.com/) (compatible Redis pour Windows)

**Ressources:**
- [Documentation Redis](https://redis.io/docs/)
- [Documentation Laravel Redis](https://laravel.com/docs/12.x/redis)

### 5. Configuration de Typesense (Développement Local)

[Typesense](https://typesense.org/) alimente la fonctionnalité de recherche rapide et tolérante aux fautes.

**Option 1 : Utiliser Docker (Recommandé)**
```bash
# Télécharger et exécuter le conteneur Typesense
docker run -d --name typesense-car-marketplace \
  -p 8108:8108 \
  -v $(pwd)/typesense-data:/data \
  typesense/typesense:latest \
  --data-dir /data \
  --api-key=xyz123 \
  --enable-cors

# Vérifier que Typesense fonctionne
curl http://localhost:8108/health
```

**Option 2 : Utiliser un Gestionnaire de Paquets**

**Ubuntu/Debian (APT):**
```bash
# Ajouter le dépôt Typesense
curl -O https://dl.typesense.org/releases/typesense-server-latest-amd64.deb
sudo apt install ./typesense-server-latest-amd64.deb

# Démarrer le service Typesense
sudo systemctl start typesense-server
sudo systemctl enable typesense-server

# Configurer dans /etc/typesense/typesense-server.ini
```

**macOS (Homebrew):**
```bash
# Installer via Homebrew
brew install typesense/tap/typesense-server

# Démarrer Typesense
typesense-server --data-dir=/tmp/typesense-data --api-key=xyz123 --enable-cors

# Ou exécuter comme service
brew services start typesense-server
```

**Mettre à jour .env pour Typesense:**
```env
SCOUT_DRIVER=typesense
TYPESENSE_API_KEY=xyz123
TYPESENSE_HOST=localhost
TYPESENSE_PORT=8108
TYPESENSE_PROTOCOL=http
```

**Ressources:**
- [Documentation Typesense](https://typesense.org/docs/)
- [Documentation Laravel Scout](https://laravel.com/docs/12.x/scout)
- [Intégration Typesense Laravel](https://typesense.org/docs/guide/laravel.html)

### 6. Configuration de Mailpit (Test d'Emails)

[Mailpit](https://github.com/axllent/mailpit) est un outil léger de test d'emails pour le développement local.

**Option 1 : Utiliser Docker (Recommandé)**
```bash
# Télécharger et exécuter le conteneur Mailpit
docker run -d --name mailpit \
  -p 8025:8025 \
  -p 1025:1025 \
  axllent/mailpit

# Accéder à l'interface Mailpit sur http://localhost:8025
```

**Option 2 : Utiliser un Gestionnaire de Paquets**

**Linux (Binaire):**
```bash
# Télécharger la dernière version
sudo wget https://github.com/axllent/mailpit/releases/latest/download/mailpit-linux-amd64 -O /usr/local/bin/mailpit
sudo chmod +x /usr/local/bin/mailpit

# Exécuter Mailpit
mailpit
```

**macOS (Homebrew):**
```bash
# Installer via Homebrew
brew install mailpit

# Exécuter Mailpit
mailpit

# Ou exécuter comme service
brew services start mailpit
```

**Mettre à jour .env pour Mailpit:**
```env
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

**Ressources:**
- [Documentation Mailpit](https://github.com/axllent/mailpit)
- [Documentation Laravel Mail](https://laravel.com/docs/12.x/mail)

### 7. Configuration de la Base de Données

```bash
# Créer la base de données SQLite (développement)
touch database/database.sqlite

# Exécuter les migrations
php artisan migrate

# Remplir la base de données avec des données d'exemple (optionnel)
php artisan db:seed

# Indexer les voitures dans Typesense
php artisan scout:import "App\Models\Car"
```

### 8. Compiler les Assets

```bash
# Développement
npm run dev

# Production
npm run build
```

### 9. Démarrer les Workers de File d'Attente

**Terminal 1 : Démarrer Horizon (Worker de File d'Attente)**
```bash
php artisan horizon
```

**Terminal 2 : Démarrer le Planificateur (Optionnel pour le développement)**
```bash
php artisan schedule:work
```

### 10. Démarrer l'Application

**Terminal 3 : Démarrer le Serveur Laravel**
```bash
composer run dev
```

Visitez `http://localhost:8000` dans votre navigateur.

### 11. Vérifier la Configuration

```bash
# Vérifier la connexion Redis pour l'installation locale
redis-cli ping  # Devrait retourner "PONG"

# Vérifier la connexion Typesense
curl http://localhost:8108/health  # Devrait retourner {"ok":true}

# Vérifier que la file d'attente fonctionne
php artisan queue:work --once
```

## ⚙️ Configuration

### Variables d'Environnement

Configurez votre fichier `.env` avec les paramètres suivants :

#### Application
```env
APP_NAME="Car Marketplace"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

#### Base de Données
```env
DB_CONNECTION=sqlite
# Pour MySQL/PostgreSQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=car_marketplace
# DB_USERNAME=root
# DB_PASSWORD=
```

#### Configuration Mail
```env
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@carmarketplace.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note:** Mailpit doit être en cours d'exécution (voir étape d'installation 6)

**Ressources:**
- [Documentation Mailpit](https://github.com/axllent/mailpit)
- [Documentation Laravel Mail](https://laravel.com/docs/12.x/mail)

#### Configuration File d'Attente
```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

**Ressources:**
- [Documentation Laravel Queue](https://laravel.com/docs/12.x/queues)
- [Documentation Laravel Horizon](https://laravel.com/docs/12.x/horizon)

#### Configuration Typesense
```env
SCOUT_DRIVER=typesense
TYPESENSE_API_KEY=xyz123
TYPESENSE_HOST=localhost
TYPESENSE_PORT=8108
TYPESENSE_PROTOCOL=http
```

**Ressources:**
- [Documentation Laravel Scout](https://laravel.com/docs/12.x/scout)
- [Documentation Typesense](https://typesense.org/docs/)

#### Configuration Reverb (Temps Réel)
```env
REVERB_APP_ID=your_app_id
REVERB_APP_KEY=your_app_key
REVERB_APP_SECRET=your_app_secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

### Gestion Redis & Typesense

**Démarrer/Arrêter les Services (Docker):**
```bash
# Démarrer les services
docker start redis-car-marketplace typesense-car-marketplace mailpit

# Arrêter les services
docker stop redis-car-marketplace typesense-car-marketplace mailpit

# Voir les logs
docker logs redis-car-marketplace
docker logs typesense-car-marketplace
docker logs mailpit

# Supprimer les conteneurs (si nécessaire)
docker rm redis-car-marketplace typesense-car-marketplace mailpit
```

**Ré-indexer Typesense:**
```bash
# Vider et ré-importer toutes les voitures
php artisan scout:flush "App\Models\Car"
php artisan scout:import "App\Models\Car"
```

**Ressources:**
- [Documentation Docker](https://docs.docker.com/)
- [Typesense Cloud](https://cloud.typesense.org/) - Hébergement Typesense géré

### Workers de File d'Attente

Démarrer le worker de file d'attente pour les tâches en arrière-plan :

```bash
# Utiliser Horizon (recommandé)
php artisan horizon

# Ou utiliser queue:work
php artisan queue:work
```

**Accéder au Tableau de Bord Horizon:**
- Visitez `http://localhost:8000/horizon` pour surveiller les files d'attente
- [Documentation Horizon](https://laravel.com/docs/12.x/horizon)

### Planificateur

Ajouter à votre crontab pour les tâches planifiées :

```bash
* * * * * cd /chemin-vers-votre-projet && php artisan schedule:run >> /dev/null 2>&1
```

Ou exécuter manuellement en développement :

```bash
php artisan schedule:work
```

**Tâches Planifiées:**
- Notifications quotidiennes de voitures à 8h00
- Notifications hebdomadaires de voitures le lundi à 9h00
- Emails récapitulatifs hebdomadaires le dimanche à 10h00

**Ressources:**
- [Planification de Tâches Laravel](https://laravel.com/docs/12.x/scheduling)

## 📖 Utilisation

### Rôles Utilisateur

L'application supporte trois rôles utilisateur :

1. **Invité** - Parcourir les annonces, voir les détails
2. **Utilisateur** - Créer des annonces, ajouter des favoris, envoyer des demandes, laisser des avis
3. **Concessionnaire** - Profil amélioré, annonces multiples, informations commerciales

### Créer une Annonce de Voiture

1. S'inscrire/Se connecter à votre compte
2. Cliquer sur le bouton "Ajouter une Nouvelle Voiture"
3. Remplir les détails du véhicule :
   - Informations de base (marque, modèle, année, prix)
   - Spécifications (kilométrage, transmission, type de carburant)
   - Localisation (état, ville)
   - Description et caractéristiques
4. Télécharger des images (glisser pour réorganiser)
5. Publier l'annonce

### Gérer les Notifications

1. Naviguer vers **Paramètres → Notifications**
2. Configurer les préférences :
   - Notifications par email (demandes, avis, favoris)
   - Notifications in-app
   - Récapitulatif hebdomadaire
3. Sauvegarder les préférences

### Gérer les Abonnements

1. Naviguer vers **Paramètres → Abonnements**
2. Créer un nouvel abonnement :
   - Choisir le type (nouvelles voitures, baisses de prix, newsletter)
   - Définir la fréquence (instantané, quotidien, hebdomadaire)
   - Appliquer des filtres (marque, fourchette de prix, localisation)
3. Gérer les abonnements existants (pause/suppression)

### Abonnement Newsletter

**Pour les utilisateurs non authentifiés:**
- Entrer l'email dans le formulaire du pied de page

**Pour les utilisateurs authentifiés:**
- Bouton d'abonnement/désabonnement en un clic dans le pied de page

## 🏗 Architecture

### Structure des Répertoires

```
car_selling_website/
├── app/
│   ├── Events/              # Classes d'événements
│   ├── Http/
│   │   ├── Controllers/     # Contrôleurs HTTP
│   │   └── Requests/        # Requêtes de formulaire
│   ├── Jobs/                # Jobs de file d'attente
│   ├── Listeners/           # Écouteurs d'événements
│   ├── Livewire/            # Composants Livewire
│   │   ├── Admin/           # Composants admin
│   │   ├── Car/             # Composants liés aux voitures
│   │   └── Settings/        # Composants de paramètres
│   ├── Mail/                # Classes Mailable
│   ├── Models/              # Modèles Eloquent
│   ├── Notifications/       # Classes de notification
│   ├── Observers/           # Observateurs de modèles
│   └── Policies/            # Politiques d'autorisation
├── database/
│   ├── factories/           # Factories de modèles
│   ├── migrations/          # Migrations de base de données
│   └── seeders/             # Seeders de base de données
├── resources/
│   ├── css/                 # Feuilles de style
│   ├── js/                  # Fichiers JavaScript
│   └── views/               # Templates Blade
│       ├── car_template/    # Vues d'annonces de voitures
│       ├── components/      # Composants Blade
│       ├── emails/          # Templates d'email
│       └── livewire/        # Vues Livewire
├── routes/
│   ├── channels.php         # Canaux de diffusion
│   ├── console.php          # Routes console & planifications
│   └── web.php              # Routes web
└── tests/                   # Fichiers de test
```

### Patterns de Conception Clés

- **Pattern Observer** - Observateurs de modèles pour les notifications
- **Événementiel** - Événements et écouteurs pour une logique découplée
- **Pattern Repository** - Abstraction d'accès aux données
- **Autorisation Basée sur les Politiques** - Politiques Laravel pour le contrôle d'accès
- **Jobs de File d'Attente** - Traitement en arrière-plan pour emails et notifications
- **Couche Service** - Séparation de la logique métier

### Schéma de Base de Données

**Tables Principales:**
- `users` - Comptes et profils utilisateurs
- `cars` - Annonces de véhicules
- `car_images` - Photos de véhicules
- `makers` - Constructeurs automobiles
- `car_models` - Modèles de voitures
- `car_types` - Types de véhicules (SUV, Berline, etc.)
- `fuel_types` - Types de carburant
- `states` - États géographiques
- `cities` - Villes géographiques
- `features` - Caractéristiques de véhicules

**Tables d'Interaction:**
- `user_favorites` - Voitures favorites
- `car_inquiries` - Demandes d'acheteurs
- `reviews` - Avis utilisateurs
- `contact_messages` - Soumissions de formulaire de contact

**Tables de Notification:**
- `notifications` - Notifications in-app
- `subscriptions` - Abonnements email
- `newsletter_subscribers` - Emails newsletter

## 🧪 Tests

### Exécuter les Tests

```bash
# Exécuter tous les tests
php artisan test

# Exécuter une suite de tests spécifique
php artisan test --testsuite=Feature

# Exécuter avec couverture
php artisan test --coverage
```

### Structure des Tests

```
tests/
├── Feature/
│   ├── Auth/              # Tests d'authentification
│   ├── Settings/          # Tests de paramètres
│   └── DashboardTest.php  # Tests de tableau de bord
└── Unit/                  # Tests unitaires
```

## 🚢 Déploiement

### Liste de Vérification Production

- [ ] Définir `APP_ENV=production`
- [ ] Définir `APP_DEBUG=false`
- [ ] Configurer la base de données de production
- [ ] Configurer Redis pour la mise en cache et les files d'attente
- [ ] Configurer le serveur mail (SMTP/SES/Mailgun)
- [ ] Configurer le serveur Typesense
- [ ] Configurer Laravel Reverb pour les WebSockets
- [ ] Configurer le certificat SSL
- [ ] Configurer les workers de file d'attente (Supervisor)
- [ ] Configurer le cron pour le planificateur
- [ ] Optimiser l'application :
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan optimize
  ```

### Commandes de Déploiement

```bash
# Récupérer le dernier code
git pull origin main

# Installer les dépendances
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Exécuter les migrations
php artisan migrate --force

# Vider et mettre en cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Redémarrer les workers de file d'attente
php artisan horizon:terminate
```

### Exigences Serveur

- **PHP** >= 8.2 avec extensions : BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Serveur Web** - Nginx ou Apache
- **Base de Données** - MySQL 8.0+ ou PostgreSQL 13+
- **Redis** - Pour la mise en cache et les files d'attente
- **Supervisor** - Pour les workers de file d'attente
- **Node.js** - Pour la compilation des assets

## 🤝 Contribution

Les contributions sont les bienvenues ! Veuillez suivre ces étapes :

1. Forker le dépôt
2. Créer une branche de fonctionnalité (`git checkout -b feature/fonctionnalite-incroyable`)
3. Commiter vos changements (`git commit -m 'Ajouter une fonctionnalité incroyable'`)
4. Pousser vers la branche (`git push origin feature/fonctionnalite-incroyable`)
5. Ouvrir une Pull Request

### Standards de Codage

- Suivre les standards de codage PSR-12
- Utiliser Laravel Pint pour le formatage du code : `./vendor/bin/pint`
- Écrire des tests pour les nouvelles fonctionnalités
- Mettre à jour la documentation si nécessaire

## 📄 Licence

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 👥 Auteurs

- **Votre Nom** - *Travail initial* - [VotreGitHub](https://github.com/yourusername)

## 🙏 Remerciements

- [Laravel Framework](https://laravel.com)
- [Livewire](https://livewire.laravel.com) & [Flux UI](https://fluxui.dev)
- [Typesense Search](https://typesense.org)
- [Laravel Fortify](https://laravel.com/docs/12.x/fortify)
- [Laravel Horizon](https://laravel.com/docs/12.x/horizon)
- [Laravel Reverb](https://laravel.com/docs/12.x/reverb)
- [Tailwind CSS](https://tailwindcss.com)
- Tous les contributeurs et packages open-source utilisés

## 📞 Support

Pour le support, ouvrez une issue sur GitHub.

## 🔗 Liens Utiles

### Documentation
- [Documentation Laravel 12](https://laravel.com/docs/12.x)
- [Documentation Livewire 3](https://livewire.laravel.com/docs)
- [Documentation Flux UI](https://fluxui.dev/docs)
- [Documentation Typesense](https://typesense.org/docs/)
- [Documentation Laravel Scout](https://laravel.com/docs/12.x/scout)
- [Documentation Laravel Horizon](https://laravel.com/docs/12.x/horizon)
- [Documentation Laravel Fortify](https://laravel.com/docs/12.x/fortify)
- [Documentation Tailwind CSS](https://tailwindcss.com/docs)

### Outils & Services
- [Mailpit](https://github.com/axllent/mailpit) - Test d'emails
- [Typesense Cloud](https://cloud.typesense.org/) - Typesense géré
- [Redis Cloud](https://redis.com/try-free/) - Redis géré
- [Laravel Forge](https://forge.laravel.com/) - Gestion de serveur
- [Laravel Vapor](https://vapor.laravel.com/) - Déploiement serverless

---

**Construit avec ❤️ en utilisant Laravel & Livewire**

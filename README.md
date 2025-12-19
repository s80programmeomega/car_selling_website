# 🚗 Car Marketplace - Modern Vehicle Trading Platform

**[English](README.md)** | **[Français](README.fr.md)**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=flat&logo=livewire)](https://livewire.laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A full-featured, modern car marketplace platform built with Laravel 12, Livewire, and Flux UI. This application provides a seamless experience for buying and selling vehicles with advanced search capabilities, real-time notifications, and comprehensive user management.

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Architecture](#-architecture)
- [API Documentation](#-api-documentation)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### Core Functionality
- 🚘 **Vehicle Listings Management** - Create, edit, and manage car listings with detailed specifications
- 🔍 **Advanced Search** - Powered by Typesense for lightning-fast, typo-tolerant search
- ⭐ **Favorites System** - Save and track favorite vehicles
- 💬 **Inquiry System** - Direct communication between buyers and sellers
- ⭐ **Review & Rating** - User reputation system with reviews
- 📸 **Image Management** - Multiple image uploads with drag-and-drop reordering

### User Features
- 🔐 **Authentication** - Secure login with Laravel Fortify
- 🔒 **Two-Factor Authentication** - Enhanced security with 2FA
- 👤 **User Profiles** - Comprehensive user and dealer profiles
- 🎨 **Appearance Settings** - Customizable UI preferences
- 📊 **Dashboard** - Personal dashboard for managing listings and activities

### Notification System
- 🔔 **Real-time Notifications** - Instant updates via Laravel Reverb
- 📧 **Email Notifications** - Customizable email alerts
- 🔕 **Notification Preferences** - Granular control over notification types
- 📬 **In-app Notifications** - Bell icon with unread count
- 📨 **Newsletter Subscriptions** - Weekly digest emails

### Subscription Features
- 📮 **Email Subscriptions** - Subscribe to new car alerts
- 🎯 **Filtered Subscriptions** - Custom filters (maker, price, location)
- ⏰ **Frequency Control** - Instant, daily, or weekly notifications
- 🔗 **One-click Unsubscribe** - Easy subscription management

### Admin Features
- 🛠️ **Admin Panel** - Comprehensive management interface
- 📊 **Data Management** - Manage makers, models, types, features
- 📍 **Location Management** - States and cities administration
- 💼 **Inquiry Management** - View and manage all inquiries
- 📝 **Review Moderation** - Monitor and manage reviews
- 📧 **Contact Messages** - Handle customer support requests

### Advanced Features
- 🔄 **Real-time Updates** - Live updates using Laravel Reverb
- 📱 **Responsive Design** - Mobile-first, fully responsive UI
- 🎨 **Modern UI** - Built with Flux UI components
- 🚀 **Performance** - Optimized with caching and queue jobs
- 📈 **Analytics** - Track views and user engagement
- 🔍 **SEO Optimized** - Search engine friendly URLs and meta tags
- 🌐 **Multi-language Ready** - Internationalization support

## 🛠 Tech Stack

### Backend
- **Framework:** Laravel 12.x
- **PHP:** 8.2+
- **Database:** SQLite (development) / MySQL/PostgreSQL (production)
- **Queue:** Laravel Horizon (Redis-based)
- **Search:** Typesense
- **Real-time:** Laravel Reverb (WebSockets)
- **Authentication:** Laravel Fortify
- **Auditing:** Yajra Laravel Auditable

### Frontend
- **UI Framework:** Livewire 3.x
- **Component Library:** Flux UI 2.x
- **Styling:** Tailwind CSS 4.x
- **Build Tool:** Vite 7.x
- **JavaScript:** Alpine.js (via Livewire)

### Development Tools
- **Debugging:** Laravel Telescope, Laravel Debugbar
- **Testing:** Pest PHP
- **Code Quality:** Laravel Pint
- **Logs:** Laravel Pail
- **Development:** Laravel Sail (Docker)

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** or **Yarn**
- **SQLite** (for development) or **MySQL/PostgreSQL** (for production)
- **Redis** (for queues and caching)
- **Typesense** (for search functionality)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/s80programmeomega/car_selling_website.git
cd car_selling_website
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Setup Redis (Local Development)

[Redis](https://redis.io/) is required for queues, caching, and sessions.

**Option 1: Using Docker (Recommended)**
```bash
# Pull and run Redis container
docker run -d --name redis-car-marketplace \
  -p 6379:6379 \
  redis:alpine

# Verify Redis is running
docker ps | grep redis
```

**Option 2: Install Redis Locally**

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install redis-server
sudo systemctl start redis-server
sudo systemctl enable redis-server

# Test connection
redis-cli ping  # Should return PONG
```

**macOS:**
```bash
brew install redis
brew services start redis

# Test connection
redis-cli ping  # Should return PONG
```

**Windows:**
- Download from [Redis Windows releases](https://github.com/microsoftarchive/redis/releases)
- Or use WSL2 with Ubuntu instructions above
- Alternative: [Memurai](https://www.memurai.com/) (Redis-compatible for Windows)

**Resources:**
- [Redis Documentation](https://redis.io/docs/)
- [Laravel Redis Documentation](https://laravel.com/docs/12.x/redis)

### 5. Setup Typesense (Local Development)

[Typesense](https://typesense.org/) powers the fast, typo-tolerant search functionality.

**Option 1: Using Docker (Recommended)**
```bash
# Pull and run Typesense container
docker run -d --name typesense-car-marketplace \
  -p 8108:8108 \
  -v $(pwd)/typesense-data:/data \
  typesense/typesense:latest \
  --data-dir /data \
  --api-key=xyz123 \
  --enable-cors

# Verify Typesense is running
curl http://localhost:8108/health
```

**Option 2: Using Package Manager**

**Ubuntu/Debian (APT):**
```bash
# Add Typesense repository
curl -O https://dl.typesense.org/releases/typesense-server-latest-amd64.deb
sudo apt install ./typesense-server-latest-amd64.deb

# Start Typesense service
sudo systemctl start typesense-server
sudo systemctl enable typesense-server

# Configure in /etc/typesense/typesense-server.ini
```

**macOS (Homebrew):**
```bash
# Install via Homebrew
brew install typesense/tap/typesense-server

# Start Typesense
typesense-server --data-dir=/tmp/typesense-data --api-key=xyz123 --enable-cors

# Or run as service
brew services start typesense-server
```

**Option 3: Manual Installation**

**Linux:**
```bash
# Download Typesense
wget https://dl.typesense.org/releases/0.25.2/typesense-server-0.25.2-linux-amd64.tar.gz
tar -xzf typesense-server-0.25.2-linux-amd64.tar.gz

# Run Typesense
./typesense-server \
  --data-dir=/tmp/typesense-data \
  --api-key=xyz123 \
  --enable-cors
```

**macOS:**
```bash
# Download Typesense
wget https://dl.typesense.org/releases/0.25.2/typesense-server-0.25.2-darwin-amd64.tar.gz
tar -xzf typesense-server-0.25.2-darwin-amd64.tar.gz

# Run Typesense
./typesense-server \
  --data-dir=/tmp/typesense-data \
  --api-key=xyz123 \
  --enable-cors
```

**Windows:**
- Download from [Typesense releases](https://github.com/typesense/typesense/releases)
- Or use Docker Desktop with Option 1

**Update .env for Typesense:**
```env
SCOUT_DRIVER=typesense
TYPESENSE_API_KEY=xyz123
TYPESENSE_HOST=localhost
TYPESENSE_PORT=8108
TYPESENSE_PROTOCOL=http
```

**Resources:**
- [Typesense Documentation](https://typesense.org/docs/)
- [Laravel Scout Documentation](https://laravel.com/docs/12.x/scout)
- [Typesense Laravel Integration](https://typesense.org/docs/guide/laravel.html)

### 6. Setup Mailpit (Email Testing)

[Mailpit](https://github.com/axllent/mailpit) is a lightweight email testing tool for local development.

**Option 1: Using Docker (Recommended)**
```bash
# Pull and run Mailpit container
docker run -d --name mailpit \
  -p 8025:8025 \
  -p 1025:1025 \
  axllent/mailpit

# Access Mailpit UI at http://localhost:8025
```

**Option 2: Using Package Manager**

**Linux (Binary):**
```bash
# Download latest release
sudo wget https://github.com/axllent/mailpit/releases/latest/download/mailpit-linux-amd64 -O /usr/local/bin/mailpit
sudo chmod +x /usr/local/bin/mailpit

# Run Mailpit
mailpit
```

**macOS (Homebrew):**
```bash
# Install via Homebrew
brew install mailpit

# Run Mailpit
mailpit

# Or run as service
brew services start mailpit
```

**Windows:**
- Download from [releases](https://github.com/axllent/mailpit/releases) page
- Run mailpit.exe

**Update .env for Mailpit:**
```env
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

**Resources:**
- [Mailpit Documentation](https://github.com/axllent/mailpit)
- [Laravel Mail Documentation](https://laravel.com/docs/12.x/mail)

### 7. Database Setup

```bash
# Create SQLite database (development)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database with sample data (optional)
php artisan db:seed

# Index cars in Typesense
php artisan scout:import "App\Models\Car"
```

### 8. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 9. Start Queue Workers

**Terminal 1: Start Horizon (Queue Worker)**
```bash
php artisan horizon
```

**Terminal 2: Start Scheduler (Optional for development)**
```bash
php artisan schedule:work
```

### 10. Start the Application

**Terminal 3: Start Laravel Server**
```bash
composer run dev
```

Visit `http://localhost:8000` in your browser.

### 11. Verify Setup

```bash
# Check Redis connection for local installation
redis-cli ping  # Should return "PONG"

# Check Typesense connection
curl http://localhost:8108/health  # Should return {"ok":true}

# Check queue is working
php artisan queue:work --once
```

## ⚙️ Configuration

### Environment Variables

Configure your `.env` file with the following settings:

#### Application
```env
APP_NAME="Car Marketplace"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

#### Database
```env
DB_CONNECTION=sqlite
# For MySQL/PostgreSQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=car_marketplace
# DB_USERNAME=root
# DB_PASSWORD=
```

#### Mail Configuration
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

**Note:** Mailpit should be running (see installation step 6)

**Resources:**
- [Mailpit Documentation](https://github.com/axllent/mailpit)
- [Laravel Mail Documentation](https://laravel.com/docs/12.x/mail)

#### Queue Configuration
```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

**Resources:**
- [Laravel Queue Documentation](https://laravel.com/docs/12.x/queues)
- [Laravel Horizon Documentation](https://laravel.com/docs/12.x/horizon)

#### Typesense Configuration
```env
SCOUT_DRIVER=typesense
TYPESENSE_API_KEY=xyz123
TYPESENSE_HOST=localhost
TYPESENSE_PORT=8108
TYPESENSE_PROTOCOL=http
```

**Resources:**
- [Laravel Scout Documentation](https://laravel.com/docs/12.x/scout)
- [Typesense Documentation](https://typesense.org/docs/)

#### Reverb Configuration (Real-time)
```env
REVERB_APP_ID=your_app_id
REVERB_APP_KEY=your_app_key
REVERB_APP_SECRET=your_app_secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

### Redis & Typesense Management

**Start/Stop Services (Docker):**
```bash
# Start services
docker start redis-car-marketplace typesense-car-marketplace mailpit

# Stop services
docker stop redis-car-marketplace typesense-car-marketplace mailpit

# View logs
docker logs redis-car-marketplace
docker logs typesense-car-marketplace
docker logs mailpit

# Remove containers (if needed)
docker rm redis-car-marketplace typesense-car-marketplace mailpit
```

**Re-index Typesense:**
```bash
# Clear and re-import all cars
php artisan scout:flush "App\Models\Car"
php artisan scout:import "App\Models\Car"
```

**Resources:**
- [Docker Documentation](https://docs.docker.com/)
- [Typesense Cloud](https://cloud.typesense.org/) - Managed Typesense hosting

### Queue Workers

Start the queue worker for background jobs:

```bash
# Using Horizon (recommended)
php artisan horizon

# Or using queue:work
php artisan queue:work
```

**Access Horizon Dashboard:**
- Visit `http://localhost:8000/horizon` to monitor queues
- [Horizon Documentation](https://laravel.com/docs/12.x/horizon)

### Scheduler

Add to your crontab for scheduled tasks:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Or run manually in development:

```bash
php artisan schedule:work
```

**Scheduled Jobs:**
- Daily car notifications at 8:00 AM
- Weekly car notifications on Monday at 9:00 AM
- Weekly digest emails on Sunday at 10:00 AM

**Resources:**
- [Laravel Task Scheduling](https://laravel.com/docs/12.x/scheduling)

## 📖 Usage

### User Roles

The application supports three user roles:

1. **Guest** - Browse listings, view details
2. **User** - Create listings, favorite cars, send inquiries, leave reviews
3. **Dealer** - Enhanced profile, multiple listings, business information

### Creating a Car Listing

1. Register/Login to your account
2. Click "Add New Car" button
3. Fill in vehicle details:
   - Basic info (maker, model, year, price)
   - Specifications (mileage, transmission, fuel type)
   - Location (state, city)
   - Description and features
4. Upload images (drag to reorder)
5. Publish listing

### Managing Notifications

1. Navigate to **Settings → Notifications**
2. Configure preferences:
   - Email notifications (inquiries, reviews, favorites)
   - In-app notifications
   - Weekly digest
3. Save preferences

### Managing Subscriptions

1. Navigate to **Settings → Subscriptions**
2. Create new subscription:
   - Choose type (new cars, price drops, newsletter)
   - Set frequency (instant, daily, weekly)
   - Apply filters (maker, price range, location)
3. Manage existing subscriptions (pause/delete)

### Newsletter Subscription

**For Unauthenticated users:**
- Enter email in footer form

**For Authenticated Users:**
- One-click subscribe/unsubscribe button in footer

## 🏗 Architecture

### Directory Structure

```
car_selling_website/
├── app/
│   ├── Events/              # Event classes
│   ├── Http/
│   │   ├── Controllers/     # HTTP controllers
│   │   └── Requests/        # Form requests
│   ├── Jobs/                # Queue jobs
│   ├── Listeners/           # Event listeners
│   ├── Livewire/            # Livewire components
│   │   ├── Admin/           # Admin components
│   │   ├── Car/             # Car-related components
│   │   └── Settings/        # Settings components
│   ├── Mail/                # Mailable classes
│   ├── Models/              # Eloquent models
│   ├── Notifications/       # Notification classes
│   ├── Observers/           # Model observers
│   └── Policies/            # Authorization policies
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   └── views/               # Blade templates
│       ├── car_template/    # Car listing views
│       ├── components/      # Blade components
│       ├── emails/          # Email templates
│       └── livewire/        # Livewire views
├── routes/
│   ├── channels.php         # Broadcast channels
│   ├── console.php          # Console routes & schedules
│   └── web.php              # Web routes
└── tests/                   # Test files
```

### Key Design Patterns

- **Observer Pattern** - Model observers for notifications
- **Event-Driven** - Events and listeners for decoupled logic
- **Repository Pattern** - Data access abstraction
- **Policy-Based Authorization** - Laravel policies for access control
- **Queue Jobs** - Background processing for emails and notifications
- **Service Layer** - Business logic separation

### Database Schema

**Core Tables:**
- `users` - User accounts and profiles
- `cars` - Vehicle listings
- `car_images` - Vehicle photos
- `makers` - Car manufacturers
- `car_models` - Car models
- `car_types` - Vehicle types (SUV, Sedan, etc.)
- `fuel_types` - Fuel types
- `states` - Geographic states
- `cities` - Geographic cities
- `features` - Vehicle features

**Interaction Tables:**
- `user_favorites` - Favorited cars
- `car_inquiries` - Buyer inquiries
- `reviews` - User reviews
- `contact_messages` - Contact form submissions

**Notification Tables:**
- `notifications` - In-app notifications
- `subscriptions` - Email subscriptions
- `newsletter_subscribers` - Newsletter emails

## 🧪 Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Test Structure

```
tests/
├── Feature/
│   ├── Auth/              # Authentication tests
│   ├── Settings/          # Settings tests
│   └── DashboardTest.php  # Dashboard tests
└── Unit/                  # Unit tests
```

## 🚢 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up Redis for caching and queues
- [ ] Configure mail server (SMTP/SES/Mailgun)
- [ ] Set up Typesense server
- [ ] Configure Laravel Reverb for WebSockets
- [ ] Set up SSL certificate
- [ ] Configure queue workers (Supervisor)
- [ ] Set up cron for scheduler
- [ ] Optimize application:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan optimize
  ```

### Deployment Commands

```bash
# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
php artisan horizon:terminate
```

### Server Requirements

- **PHP** >= 8.2 with extensions: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Web Server** - Nginx or Apache
- **Database** - MySQL 8.0+ or PostgreSQL 13+
- **Redis** - For caching and queues
- **Supervisor** - For queue workers
- **Node.js** - For asset compilation

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Use Laravel Pint for code formatting: `./vendor/bin/pint`
- Write tests for new features
- Update documentation as needed

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Your Name** - *Initial work* - [YourGitHub](https://github.com/yourusername)

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com)
- [Livewire](https://livewire.laravel.com) & [Flux UI](https://fluxui.dev)
- [Typesense Search](https://typesense.org)
- [Laravel Fortify](https://laravel.com/docs/12.x/fortify)
- [Laravel Horizon](https://laravel.com/docs/12.x/horizon)
- [Laravel Reverb](https://laravel.com/docs/12.x/reverb)
- [Tailwind CSS](https://tailwindcss.com)
- All contributors and open-source packages used

## 📞 Support

For support, open an issue on GitHub.

## 🔗 Useful Links

### Documentation
- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Livewire 3 Documentation](https://livewire.laravel.com/docs)
- [Flux UI Documentation](https://fluxui.dev/docs)
- [Typesense Documentation](https://typesense.org/docs/)
- [Laravel Scout Documentation](https://laravel.com/docs/12.x/scout)
- [Laravel Horizon Documentation](https://laravel.com/docs/12.x/horizon)
- [Laravel Fortify Documentation](https://laravel.com/docs/12.x/fortify)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

### Tools & Services
- [Mailpit](https://github.com/axllent/mailpit) - Email testing
- [Typesense Cloud](https://cloud.typesense.org/) - Managed Typesense
- [Redis Cloud](https://redis.com/try-free/) - Managed Redis
- [Laravel Forge](https://forge.laravel.com/) - Server management
- [Laravel Vapor](https://vapor.laravel.com/) - Serverless deployment

---

**Built with ❤️ using Laravel & Livewire**

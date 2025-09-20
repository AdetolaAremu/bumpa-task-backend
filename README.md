# Bumpa Badges and Achievements

A comprehensive ecommerce API service with achievements and badges system built with Laravel 🏆

## 📖 About

This is an achievement and badges ecommerce system that gamifies the shopping experience by rewarding users with badges and achievements based on their purchase behaviors, order completion, and engagement activities. The system tracks user progress and unlocks rewards to encourage continued participation.

## 🚀 Quick Start

### Prerequisites

-   PHP >= 8.2
-   Composer
-   MySQL
-   Laravel 11.0+

### Installation

1. **Clone the repository**

```bash
git clone https://github.com/AdetolaAremu/bumpa-task-backend
cd bumpa-task-backend
```

2. **Install dependencies**

```bash
composer install
```

3. **Environment setup**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure your database settings in .env file**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bumpa_badges
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Database setup**

```bash
php artisan migrate
```

6. **Setup Laravel Passport**

```bash
php artisan passport:client --personal
```

7. **Seed the database**

```bash
php artisan db:seed
```

8. **Start the development server**

```bash
php artisan serve
```

Your API will be available at `http://localhost:8000`

## 🗂️ API Structure

The API routes are organized into four main categories:

### 🔐 Authentication Routes

**Prefix:** `/api/auth`

### 🛒 Cart Routes

**Prefix:** `/api/cart`

### 📦 Order Routes

**Prefix:** `/api/order`

### 🔧 Util Routes

**Prefix:** `/api/util`

Contains APIs for stats, orders, achievements, badges, cashbacks, and more:

-   `GET /stats` - Get user statistics
-   `GET /achievements` - Get user achievements
-   `GET /badges` - Get available badges
-   `GET /cashbacks` - Get cashback history
-   `GET /leaderboard` - Get user rankings
-   `POST /claim-reward` - Claim achievement rewards

## 🔐 Authentication

### Laravel Passport

-   Provides secure OAuth2 authentication
-   Personal Access Tokens for API access
-   Role-based Access Control with separate permissions for users and administrators

### API Headers

```http
Authorization: Bearer {your-access-token}
Content-Type: application/json
Accept: application/json
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 🙏 Acknowledgments

-   Laravel Framework
-   Laravel Passport
-   All contributors who helped shape this project

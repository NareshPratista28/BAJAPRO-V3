# 🎓 BAJAPRO V3 - Gamification Learning Platform

> **Advanced Learning Management System with AI-Powered Question Generation and Online Java Compiler**

## 🚀 Features

-   **🤖 AI-Powered Question Generation**: Automatic question creation using Large Language Models
-   **💻 Online Java Compiler**: Real-time code compilation and execution
-   **🎮 Gamification Elements**: Points, badges, and leaderboards
-   **📚 Content Management**: Create and manage learning materials
-   **🧪 Automated Testing**: JUnit test generation and validation
-   **📊 Analytics Dashboard**: Student progress tracking
-   **🔐 Secure API Integration**: Environment-based configuration

## 🏗️ Architecture

This project consists of 3 main services:

1. **BAJAPRO-V3** (Laravel): Main web application and admin panel
2. **online-compiler** (Django): Python-based Java compiler service
3. **generative-ai-llm** (FastAPI): AI service for question generation

## ⚡ Quick Start

### 1. Clone Repository

```bash
git clone <repository-url>
cd BAJAPRO-V3
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bajapro_v3
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
php artisan migrate
php artisan db:seed
```

### 6. Start Services

```bash
# Laravel (port 8000)
php artisan serve

# Python Compiler Service (port 8000)
cd ../online-compiler
python manage.py runserver 127.0.0.1:8000

# AI Service (port 8001)
cd ../generative-ai-llm
uvicorn app.main:app --host 0.0.0.0 --port 8001
```

## 🔧 Configuration

### Environment Variables

Key configuration in `.env`:

```env
# Core Application
APP_NAME=BajaPro
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# API Services
LLM_API_URL=http://localhost:8001/api/v1
GENERATE_QUESTION_API=http://localhost:8001/api/v1
BASE_URL=http://127.0.0.1:8000/compiler
GENERATE_GRADE=http://127.0.0.1:8000/compiler/generate/grade

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bajapro_v3
DB_USERNAME=root
DB_PASSWORD=
```

## 📁 Project Structure

```
BAJAPRO-V3/
├── app/
│   ├── Http/Controllers/     # Laravel Controllers
│   ├── Models/              # Eloquent Models
│   ├── Services/            # Business Logic Services
│   └── Repositories/        # Data Access Layer
├── resources/
│   ├── views/               # Blade Templates
│   └── js/                  # Frontend JavaScript
├── config/                  # Laravel Configuration
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
└── public/                  # Public Assets
```

## 🎯 Key Features

### 1. AI Question Generation

-   Automatic question creation based on learning content
-   Code template generation
-   JUnit test creation
-   Multiple question types support

### 2. Online Java Compiler

-   Real-time code compilation
-   Automated test execution
-   Anti-cheating validation
-   Detailed error reporting

### 3. Gamification System

-   Point-based scoring
-   Achievement badges
-   Student leaderboards
-   Progress tracking

### 4. Admin Panel

-   Content management
-   User management
-   Analytics dashboard
-   Question bank management

## 🔐 Security Features

-   **Environment-based configuration**: No hardcoded URLs
-   **Input validation**: Comprehensive request validation
-   **SQL injection protection**: Eloquent ORM usage
-   **XSS protection**: Blade template escaping
-   **CSRF protection**: Laravel built-in protection

## 🚀 Deployment

### Production Setup

1. **Environment Configuration**:

    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://yourdomain.com
    ```

2. **Optimize for Production**:

    ```bash
    composer install --optimize-autoloader --no-dev
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

3. **Set File Permissions**:
    ```bash
    chmod 755 storage/ -R
    chmod 755 bootstrap/cache/ -R
    ```

## 🧪 Testing

```bash
# Run PHP tests
php artisan test

# Run feature tests
php artisan test --testsuite=Feature

# Run unit tests
php artisan test --testsuite=Unit
```

## 📚 Documentation

-   [Setup Guide](SETUP_GUIDE.md) - Detailed setup instructions
-   [Security Deployment](SECURITY_DEPLOYMENT.md) - Production security guide
-   [API Configuration](FRONTEND_API_CONFIG.md) - API configuration guide

## 🤝 Contributing

1. Fork the repository
2. Create feature branch: `git checkout -b feature/amazing-feature`
3. Commit changes: `git commit -m 'Add amazing feature'`
4. Push to branch: `git push origin feature/amazing-feature`
5. Open Pull Request

## 📋 Requirements

-   PHP >= 8.0
-   Composer
-   MySQL/MariaDB
-   Node.js & NPM
-   Python 3.8+ (for compiler service)

## 🆘 Support

If you encounter issues:

1. Check [Setup Guide](SETUP_GUIDE.md)
2. Verify all services are running
3. Clear Laravel cache: `php artisan config:clear`
4. Check logs: `storage/logs/laravel.log`

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Authors

-   **Your Name** - _Initial work_

## 🙏 Acknowledgments

-   Laravel Framework
-   OpenAI API
-   Bootstrap UI Framework
-   Quill.js Rich Text Editor

---

**Built with ❤️ for better education**

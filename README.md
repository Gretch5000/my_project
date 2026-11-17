# My Project

> **Note:** This repository is for a collaborative group project.

---

## 📁 Structured Project File Paths

Below is the directory structure and file path layout for the project:

```text
my_project/
├── bin/                             # Executable binaries and CLI entry points
│   └── console                      # Symfony CLI console application
├── config/                          # Application and bundle configuration
│   ├── packages/                    # Bundle configurations (Doctrine, Security, CORS, etc.)
│   ├── routes/                      # Route configuration definitions
│   ├── bundles.php                  # Enabled Symfony bundles
│   ├── preload.php                  # OPcache preloading script
│   ├── routes.yaml                  # Primary route configuration
│   └── services.yaml                # Dependency injection and service configuration
├── migrations/                      # Doctrine database migration versions
├── public/                          # Web server document root (publicly accessible)
│   ├── css/                         # Static stylesheets (e.g. auth.css)
│   └── index.php                    # Front controller / application entry point
├── src/                             # Core PHP application source code
│   ├── ApiResource/                 # API Platform resource declarations
│   ├── Controller/                  # Web and API controllers (Home, Ride, Security)
│   ├── Entity/                      # Doctrine ORM database entities (e.g. User)
│   ├── Repository/                  # Doctrine entity repositories
│   └── Kernel.php                   # Symfony application kernel
├── templates/                       # Twig view templates
│   ├── auth/                        # Authentication & layout views (login, register)
│   ├── search/                      # Ride & search result templates
│   ├── base.html.twig               # Base HTML skeleton template
│   └── home.html.twig               # Home/landing page view
├── .editorconfig                    # Code editor formatting rules
├── .env.example                     # Environment variables template (committed)
├── .gitignore                       # Git ignore rules protecting environment files & secrets
├── AGENTS.md                        # Project conventions and architecture documentation
├── composer.json                    # Project dependencies and autoload definitions
├── composer.lock                    # Dependency lockfile
├── symfony.lock                     # Symfony Flex recipe lockfile
└── README.md                        # Project documentation
```

---

## ⚙️ Environment Configuration

Environment files containing credentials and secrets (`.env`, `.env.dev`, `.env.local`) are excluded from Git to prevent accidental leakage of sensitive information.

To configure your local development environment:

1. **Create your local `.env` file from the template:**
   ```bash
   cp .env.example .env
   ```

2. **Configure your environment variables in `.env`:**
   - **`APP_SECRET`**: Set a unique 32-character hex secret for cryptographic operations.
   - **`DATABASE_URL`**: Update with your local database connection string (PostgreSQL, MySQL, SQLite, etc.).
   - **`CORS_ALLOW_ORIGIN`**: Adjust allowed origins if connecting from an external frontend.

---

## 🚀 Getting Started

1. **Install Dependencies:**
   ```bash
   composer install
   ```

2. **Run Migrations:**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

3. **Start Development Server:**
   ```bash
   symfony serve
   # Alternatively with PHP's built-in web server:
   php -S 127.0.0.1:8000 -t public
   ```

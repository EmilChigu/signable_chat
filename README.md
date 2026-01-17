# Signable Chat

A Laravel Sail starter kit with Inertia that powers a lightweight real-time-friendly chat room where teammates can claim a username and exchange messages.

## Getting Started

### 1. Prerequisites
* **Docker Desktop**: Required to run the environment via Laravel Sail.
* **Node.js & NPM**: Required for managing Git hooks (Husky) and frontend assets.

### 2. Installation & Setup
```bash
# 1. Clone and enter the project
git clone <your-repo-url>
cd signable_chat

# 2. Install PHP dependencies via Docker
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# 3. Setup environment and Database
cp .env.example .env
touch database/database.sqlite

# 4. Start the application
./vendor/bin/sail up -d

# 5. Initialize App
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

# 6. Install Frontend & Husky Hooks
./vendor/bin/sail npm install

# 7. Start the fontend app
./vendor/bin/sail npm run dev
```

## Documentation
- [Backend reference](documentation/backend/README.md)
- [Client reference](documentation/client/README.md)
# Project Setup Guide

## 1. Clone Repository
Run the following command to clone the repository:
```sh
git clone https://github.com/mohyusfi/kasir.git
cd repository-folder-name
```

## 2. Configure `.env`
Copy `.env.example` to `.env` and set up the following configuration:

### Database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-username
DB_PASSWORD=your-pw
```

### Session Driver
Change the session driver to database:
```
SESSION_DRIVER=database
```

## 3. Install Dependencies
Run the following command to install dependencies:
```sh
npm install
composer install
```

## 4. Migrate Database
Run the following command to create tables in the database:
```sh
php artisan migrate
```

## 5. Generate Application Key
Run the following command to generate an application key:
```sh
php artisan key:generate
```

✅ **Project is now ready to run!** 🚀

# Cara Setup Project

## 1. Clone Repository
Jalankan perintah berikut untuk meng-clone repository:
```sh
git clone https://sample.com
cd nama-folder-repo
```

## 2. Konfigurasi `.env`
Salin file `.env.example` menjadi `.env` dan atur konfigurasi berikut:

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
Ubah session driver menjadi database:
```
SESSION_DRIVER=database
```

## 3. Install Dependensi
Jalankan perintah berikut untuk menginstal dependensi:
```sh
npm install
composer install
```

## 4. Migrasi Database
Jalankan perintah berikut untuk membuat tabel di database:
```sh
php artisan migrate
```

## 5. Generate Application Key
Jalankan perintah berikut untuk menghasilkan application key:
```sh
php artisan key:generate
```

✅ **Project siap dijalankan!** 🚀

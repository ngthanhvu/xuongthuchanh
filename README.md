### Xưởng thực hành 
```bash
composer install
```
### Chuyển .env.example thành .env
```bash
copy .env.example .env
```
### Tạo database
```bash
php artisan migrate
```
### Tạo app_key
```bash
php artisan key:generate
```
### Chạy dự án laravel
```bash
php artisan serve
```
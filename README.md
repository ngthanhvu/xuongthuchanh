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
### Thêm code vào git
```bash
git add .
```
### Ghi commit 
```bash
git commit -m "nội dung commit"
```
### push lên git nhánh manh/dev
```bash
git push origin manh/dev
```
### chuẵ cháy
```bash
php artisan session:table
```
### Cài thư viện tải hình ảnh
```bash
php artisan storage:link
```
<<<<<<< HEAD
### Thư viện socialite
```bash
composer require laravel/socialite
=======
### Cập nhật
```bash
git pull origin dev
>>>>>>> 7a25916b6f3b250cdfa6fb9fc2a854ff01ba8c51
```
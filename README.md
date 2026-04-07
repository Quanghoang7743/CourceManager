Hoàng Minh Quang - 20221289

```bash
composer install
```

! Nếu lỗi hãy pate lệnh này để bỏ qua phiên bản

```bash
composer install --ignore-platform-reqs
```

- Tạo bảng trong mySQL: dky_khoahoc
- Sau đó sửa file .env.example 

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dky_khoahoc
DB_USERNAME=root
DB_PASSWORD=
```
- Sau khi tạo bảng xong sử dụng lệnh 

```bash
php artisan migrate
```

```bash
php artisan storage:link
```

- Sau khi hoàn tất tất cả các bước trên 

```bash
php artisan serve
```


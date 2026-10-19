# Website Bat dong san - De 25

He thong dang tin bat dong san chay bang Docker Compose:
Laravel (PHP-FPM) + MySQL + phpMyAdmin + Nginx reverse proxy (HTTPS tu ky).

## Yeu cau
- Docker + Docker Compose

## Cach chay
1. Tao file moi truong: cp .env.example .env roi doi mat khau.
2. Tao chung chi HTTPS tu ky (thay IP-MAY bang IP cua may):

    mkdir -p docker/nginx/certs
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout docker/nginx/certs/selfsigned.key -out docker/nginx/certs/selfsigned.crt -subj "/CN=IP-MAY" -addext "subjectAltName=IP:IP-MAY"

3. Tao file cau hinh Laravel: cp src/.env.example src/.env
   Sua cac dong: DB_CONNECTION=mysql, DB_HOST=mysql, DB_DATABASE=batdongsan,
   DB_USERNAME=bds_user, DB_PASSWORD (giong file .env).
4. Chay he thong: docker compose up -d
5. Cai thu vien, tao khoa ung dung, tao bang:

    docker compose exec app composer install
    docker compose exec app php artisan key:generate
    docker compose exec app php artisan migrate

## Truy cap
- Website: https://IP-MAY
- phpMyAdmin: https://IP-MAY/pma/

## Cau truc
- docker-compose.yml: cac dich vu
- docker/nginx/: cau hinh Nginx
- docker/php/: Dockerfile PHP
- src/: ma nguon Laravel

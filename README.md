# Website Bất động sản - Đề 25

Hệ thống đăng tin bất động sản (nhà đất, tìm kiếm, liên hệ) triển khai hoàn toàn bằng Docker Compose,
có giám sát (Prometheus + Grafana), log tập trung (Loki + Promtail) và hardening.

## Kiến trúc

    Trình duyệt --HTTPS--> Nginx (reverse proxy) --> Laravel (PHP-FPM) --> MySQL
                                |--> /pma/ --> phpMyAdmin --> MySQL

    Giám sát: node-exporter, cAdvisor, mysqld-exporter, nginx-exporter --> Prometheus --> Grafana
    Log:      container --> Promtail --> Loki --> Grafana (LogQL)

Ba mạng Docker: frontend (Nginx), backend (app, MySQL, phpMyAdmin - internal, không ra internet), monitoring.

## Các dịch vụ

| Dịch vụ | Vai trò | Cổng ngoài |
|---|---|---|
| nginx | Reverse proxy, HTTPS tự ký, security headers | 80, 443 |
| app | Laravel (PHP-FPM, chạy user 1000) | - |
| mysql | Cơ sở dữ liệu | - |
| phpmyadmin | Quản trị DB, truy cập qua /pma/ | - |
| prometheus | Thu thập metrics | 9090 |
| grafana | Dashboard, truy vấn LogQL | 3000 |
| node-exporter, cadvisor, mysqld-exporter, nginx-exporter | Xuất metrics | - |
| loki, promtail | Log tập trung | - |

## Hướng dẫn chạy

Yêu cầu: Docker và Docker Compose. Hệ thống demo dùng IP 192.168.98.129. Nếu chạy trên máy khác, thay IP này trong các lệnh bên dưới (và trong PMA_ABSOLUTE_URI).

1. Tạo file môi trường và đặt mật khẩu mạnh:

        cp .env.example .env
        nano .env

2. Tạo file cấu hình cho mysqld-exporter (đặt mật khẩu cho user exporter):

        cp docker/mysqld-exporter/.my.cnf.example docker/mysqld-exporter/.my.cnf
        nano docker/mysqld-exporter/.my.cnf

3. Tạo chứng chỉ HTTPS tự ký:

        mkdir -p docker/nginx/certs
        openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout docker/nginx/certs/selfsigned.key -out docker/nginx/certs/selfsigned.crt -subj "/CN=192.168.98.129" -addext "subjectAltName=IP:192.168.98.129"
        chmod 644 docker/nginx/certs/selfsigned.key

4. Cấu hình Laravel và cài thư viện:

        cp src/.env.example src/.env
        # sửa trong src/.env: DB_CONNECTION=mysql, DB_HOST=mysql, DB_DATABASE=batdongsan,
        # DB_USERNAME=bds_user, DB_PASSWORD (giống DB_PASSWORD trong .env), APP_URL=https://192.168.98.129
        docker compose build
        docker compose run --rm -e COMPOSER_HOME=/tmp app composer install
        docker compose run --rm app php artisan key:generate

5. Sửa PMA_ABSOLUTE_URI trong docker-compose.yml thành `https://192.168.98.129/pma/` rồi chạy:

        docker compose up -d

6. Tạo user chỉ đọc cho exporter trong MySQL (thay MAT_KHAU_EXPORTER bằng mật khẩu ở bước 2):

        docker compose exec mysql mysql -uroot -p -e "CREATE USER IF NOT EXISTS 'exporter'@'%' IDENTIFIED BY 'MAT_KHAU_EXPORTER' WITH MAX_USER_CONNECTIONS 3; GRANT PROCESS, REPLICATION CLIENT, SELECT ON *.* TO 'exporter'@'%'; FLUSH PRIVILEGES;"
        docker compose restart mysqld-exporter

7. Tạo bảng và dữ liệu mẫu:

        docker compose exec app php artisan migrate --force
        docker compose exec app php artisan db:seed --class=PropertySeeder --force

## Truy cập

- Website: `https://192.168.98.129` (trình duyệt cảnh báo chứng chỉ tự ký, chọn Tiếp tục)
- phpMyAdmin: `https://192.168.98.129/pma/` (user bds_user)
- Prometheus: `http://192.168.98.129:9090/targets`
- Grafana: `http://192.168.98.129:3000` (user admin, mật khẩu GRAFANA_PASSWORD trong .env)

## Giám sát (Prometheus + Grafana)

Prometheus thu metrics của máy chủ (node-exporter), container (cAdvisor), MySQL (mysqld-exporter) và Nginx (nginx-exporter).
Grafana tự thêm nguồn Prometheus và Loki (docker/grafana/provisioning). Import dashboard theo ID:
1860 (máy chủ), 14282 (container), 7362 (MySQL), 12708 (Nginx).

## Log tập trung (Loki + Promtail)

Promtail đọc log mọi container qua Docker, gửi sang Loki. Truy vấn LogQL trong Grafana (Explore, nguồn Loki):

    {service="nginx"}
    {service="nginx"} |= " 404 "
    sum(rate({service="nginx"}[1m]))
    sum by (service) (count_over_time({service=~".+"}[5m]))

## Hardening

1. Non-root container: app chạy user 1000, Nginx dùng nginx-unprivileged (uid 101).
2. Network isolation: 3 mạng riêng; mạng backend là internal, app và MySQL không ra được internet.
3. Mật khẩu mạnh: mật khẩu ngẫu nhiên 24 ký tự cho MySQL và Grafana, lưu trong .env (không đưa lên Git).
4. Hạn chế quyền DB: xóa root@%, bds_user chỉ có quyền trên DB batdongsan, exporter chỉ đọc.
5. Security headers Nginx: X-Frame-Options, X-Content-Type-Options, Referrer-Policy, HSTS, Permissions-Policy; HTTP chuyển sang HTTPS.
6. Giới hạn: no-new-privileges, cap_drop ALL, rate limit Nginx và throttle form, APP_DEBUG=false.

## Cấu trúc thư mục

    docker-compose.yml          các dịch vụ và mạng
    docker/nginx/               cấu hình Nginx và chứng chỉ (certs/ không đưa lên Git)
    docker/php/                 Dockerfile PHP-FPM
    docker/prometheus/          cấu hình Prometheus
    docker/promtail/            cấu hình Promtail
    docker/grafana/provisioning nguồn dữ liệu Grafana
    docker/mysqld-exporter/     cấu hình exporter (.my.cnf không đưa lên Git)
    src/                        mã nguồn Laravel

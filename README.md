## Langkah-Langkah 

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di mesin lokal Anda:

1.  **Clone Repositori:**
    ```bash
    git clone [https://github.com/wangsa19/axon_docker.git](https://github.com/wangsa19/axon_docker.git)
    cd axon_docker
    ```
    *(Ganti URL dengan repositori yang benar.)*

2.  **Buat File Konfigurasi Lingkungan (`.env`):**
    * **Buat `./.env.db`** (di *root* proyek) dengan konten dasar:
        ```
        MYSQL_DATABASE=laravel_db
        MYSQL_USER=laravel_user
        MYSQL_PASSWORD=secret
        MYSQL_ROOT_PASSWORD=verysecret
        ```
    * **Salin `./src/.env.example` ke `./src/.env`:**
        ```bash
        cp src/.env.example src/.env
        ```
        Kemudian, edit `src/.env` dan sesuaikan bagian database:
        ```ini
        DB_HOST=db
        DB_PORT=3306
        DB_DATABASE=laravel_db
        DB_USERNAME=laravel_user
        DB_PASSWORD=secret
        ```

3.  **Bangun dan Jalankan Kontainer Docker:**
    ```bash
    docker-compose up -d --build
    ```

4.  **Instal Dependensi Composer:**
    ```bash
    docker-compose exec app composer install
    ```

5.  **Generate Laravel App Key:**
    ```bash
    docker-compose exec app php artisan key:generate
    ```

6.  **Jalankan Migrasi Database:**
    ```bash
    docker-compose exec app php artisan migrate
    ```

## Akses Aplikasi dan Database

* **Aplikasi Laravel:** Buka browser Anda dan kunjungi [http://localhost:8000](http://localhost:8000).
* **phpMyAdmin:** Buka browser Anda dan kunjungi [http://localhost:8080](http://localhost:8080).
    * **Username:** `root`
    * **Password:** Gunakan `MYSQL_ROOT_PASSWORD` dari `.env.db` Anda (default: `verysecret`).

## Perintah Umum

* **Start/Stop Kontainer:**
    ```bash
    docker-compose up -d   # Start di background
    docker-compose stop    # Stop semua kontainer
    docker-compose down    # Stop dan hapus kontainer (data volume tetap)
    docker-compose down -v # Stop dan hapus kontainer + data volume (HATI-HATI!)
    ```
* **Masuk ke Kontainer Aplikasi:**
    ```bash
    docker-compose exec app sh
    ```

---
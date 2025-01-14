# Books Store

This is a personal project: a Books Store application.

The application is available at the link https://mkvb22.site
> [!NOTE]
> The payment system does not have a webhook connected to confirm payment.
> Therefore, e-books and audiobooks are immediately available even with an order status of "Pending".

## Installation

**Prerequisites:**

*   Docker installed and running on your system

**Steps:**

1.  **Clone repo:**

    ```bash
    git clone https://github.com/MKovblyuk/books_store.git
2.  **In root directory create `db_root_password.txt` and write password for database**
3.  **In root directory create `.env.nginx` (copy `.env.nginx.example`)**
4.  **In backend direcotry create `.env`**
     -  write `DB_PASSWORD` the same as in `db_root_password.txt`
5.  **Run:**
    ```bash
    docker compose build
    docker compose up -d
6.  **Move into container:**
    ```bash
    docker compose exec backend_service sh
7.  **Inside container run:**
    ```bash
    composer install
    php artisan storage:link
    php artisan migrate
    php artisan db:seed
    php artisan key:generate
8. **Grant access permission to directories:**
    - backend/storage/logs
    - backend/storage/framework

## Credentials for admin:
*Use it to login on https://mkvb22.site*
  
**Email:** `m1@gmail.com`

**Password:** `123456`


# Manage Companies and Their Employees - Mini-CRM


## Run Locally

Clone the project

```bash
git clone https://github.com/i-am-Debanjan/assesment_project.git
```

Go to the project directory

```bash
cd assesment_project
```
Create a MySQL database named emp_management (or adjust the .env file with your preferred database configuration)
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=emp_management
DB_USERNAME=root
DB_PASSWORD=
```
Install dependencies

```bash
composer update
Run Database Migrations

```bash
php artisan migrate
```

Seed the database
```bash
php artisan db:seed
```
Seed the database
```bash
php artisan db:seed
```

Start the server

```bash
php artisan serve
```

The application will start running at http://localhost:8000.

## Logging In

Use the following credentials to log in as an administrator:

- **Email:** admin@admin.com
- **Password:** password

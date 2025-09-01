# RouterOS Backup Manager

## Introduction

The RouterOS Backup Manager is a web-based application designed to streamline and automate the backup process for MikroTik RouterOS devices. Built with Laravel and Filament, it provides a user-friendly interface to manage devices, store credentials securely, and schedule both binary and script backups.

## Features

*   **Automated Backups:** Schedule and execute automated backups for your MikroTik RouterOS devices.
*   **Multiple Backup Types:** Supports both binary (`.backup`) and script (`.rsc`) backup formats.
*   **Secure Credential Management:** Safely store and manage device access credentials, including password-based and private key-based authentication.
*   **Intuitive Admin Panel:** A powerful and easy-to-use administration interface powered by Filament for managing devices, backups, and users.
*   **User Management:** Built-in user authentication and management.

## Technologies Used

*   **PHP:** 8.4
*   **Laravel:** 12
*   **Filament:** 4

## Installation

Follow these steps to get the RouterOS Backup Manager up and running on your local machine.

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/UnAfraid/routeros-backup-manager.git
    cd routeros-backup-manager
    ```

2.  **Install PHP Dependencies:**

    ```bash
    composer install
    ```

3.  **Install JavaScript Dependencies and Build Assets:**

    ```bash
    npm install
    npm run build
    ```

4.  **Environment Configuration:**

    Copy the example environment file and generate an application key:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Edit the `.env` file to configure your database connection and other settings.

5.  **Database Migration:**

    Run the database migrations to set up the necessary tables:

    ```bash
    php artisan migrate
    ```

6.  **Storage Link:**

    Create a symbolic link for public storage:

    ```bash
    php artisan storage:link
    ```

7.  **Create a Filament User:**

    Create your first admin user for the Filament panel:

    ```bash
    php artisan make:filament-user
    ```

    Follow the prompts to set up your user.

## Usage

1.  **Access the Admin Panel:**

    Once the installation is complete and your development server is running (e.g., `php artisan serve`), navigate to `/admin` in your web browser (e.g., `http://localhost:8000/admin`).

2.  **Login:**

    Log in with the user credentials you created during the installation.

3.  **Manage Devices and Credentials:**

    From the Filament dashboard, you can add and manage your MikroTik RouterOS devices, configure their connection details, and securely store their credentials (password or private key).

4.  **Schedule Backups:**

    Set up backup schedules for your devices. The application will use background jobs to perform the backups. Ensure your Laravel queue worker is running for automated backups to function correctly.

    You can manually trigger the backup job for testing purposes:

    ```bash
    php artisan app:create-backup-job <device id> [--sync]
    ```

    For production, you'll want to configure your server's cron job to run the Laravel scheduler:

    ```bash
    * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    ```

## Contributing

Contributions are welcome! Please feel free to fork the repository, make your changes, and submit a pull request.

## License

The RouterOS Backup Manager is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

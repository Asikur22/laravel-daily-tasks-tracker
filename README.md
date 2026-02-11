# Daily Task Tracker

A modern, premium-quality Daily Task Tracker web application built with **Laravel 12**, **Blade**, **SQLite**, and **Vanilla JavaScript**.

![Dashboard Preview](https://via.placeholder.com/800x400?text=Dashboard+Preview)

## 🚀 Features

- **Daily Dashboard**: Track recurring tasks with instant status toggling.
- **Task Management**: Create, edit, and delete tasks with ease.
- **Smart Recurrence**: Tasks appear only on their scheduled days (e.g., Mon, Wed, Fri).
- **History View**: Visualize your productivity with a monthly calendar heatmap.
- **Categories**: Organize tasks by color-coded categories.
- **Optimistic UI**: Instant interactions without page reloads using Vanilla JS.
- **Modern Design**: Clean, minimal interface built with TailwindCSS.

## 🛠️ Tech Stack

- **Framework**: Laravel 12
- **Frontend**: Blade Templates, TailwindCSS v3
- **Scripting**: Vanilla JavaScript (No heavy frameworks like Vue or React)
- **Database**: SQLite
- **Authentication**: Laravel Breeze

## 📦 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/daily-tasks-tracker.git
   cd daily-tasks-tracker
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   Copy the example environment file and configure it:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Ensure your `.env` is configured for **SQLite**:
   ```ini
   DB_CONNECTION=sqlite
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=laravel
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```
   
   Create the database file:
   ```bash
   touch database/database.sqlite
   ```

4. **Run Migrations & Seed**
   ```bash
   php artisan migrate --seed
   ```
   *This will create a demo user: `demo@example.com` / `password`*

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Start the Server**
   ```bash
   php artisan serve
   ```
   Visit [http://localhost:8000](http://localhost:8000) in your browser.

## 🧪 Running Tests

```bash
php artisan test
```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

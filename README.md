# TallcraftUI Admin Panel Template

TallcraftUI Admin Panel Template is a modern, real-time admin dashboard built with Laravel, Livewire, Alpine.js, and Tailwind CSS. It provides a robust foundation for building scalable admin panels with features like role management, user management, activity logs, and real-time notifications.

## Features

- User authentication and registration
- Role and permission management
- Real-time notifications (database, broadcast, browser push)
- Activity log tracking
- User profile management
- Responsive, modern UI with Tailwind CSS
- Livewire-powered dynamic components
- Notification settings (email, app, Telegram, WhatsApp)

## Tech Stack

- **Backend:** Laravel
- **Frontend:** Blade, Livewire, Alpine.js, Tailwind CSS
- **Real-time:** Laravel Echo, Pusher
- **Database:** MySQL (or compatible)

## Getting Started

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/tallcraftui-admin-panel.git
   cd tallcraftui-admin-panel
   ```
2. **Install dependencies:**
   ```bash
   composer install
   npm install && npm run dev
   ```
3. **Copy and configure .env:**
   ```bash
   cp .env.example .env
   # Set your database, mail, and pusher credentials
   ```
4. **Run migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```
5. **Start the development server:**
   ```bash
   php artisan serve
   ```
6. **(Optional) Start queue and websockets:**
   ```bash
   php artisan queue:work
   # If using Laravel Websockets:
   # php artisan websockets:serve
   ```

## Folder Structure

- `app/Livewire/` - Livewire components for admin, user, roles, etc.
- `app/Notifications/` - Custom notification classes
- `resources/views/` - Blade and Livewire views
- `routes/web.php` - Web routes
- `config/` - App configuration

## Customization

- Update branding, colors, and layout in `resources/views/layouts/` and `resources/css/tallcraftui.css`.
- Add or modify Livewire components in `app/Livewire/`.
- Extend notification channels in `app/Notifications/CustomUserNotification.php`.

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

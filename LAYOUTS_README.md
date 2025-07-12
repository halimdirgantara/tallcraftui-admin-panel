# TallCraftUI Admin Panel Layouts

This project includes two main layouts built with TallCraftUI components and Livewire:

## 1. Authentication Layout (`layouts/auth.blade.php`)

A clean, centered layout for authentication pages (login/register).

### Features:
- Centered card design
- Responsive design
- Dark mode support
- Clean typography using TallCraftUI colors
- Form validation styling

### Usage:
```php
// In wrapper view
@extends('layouts.auth')

@section('content')
    @livewire('auth.login')
@endsection
```

### Sections:
- `@section('title')` - Page title
- `@section('subtitle')` - Page subtitle
- `@section('content')` - Main form content
- `@section('footer')` - Footer links

## 2. Admin Dashboard Layout (`layouts/admin.blade.php`)

A full-featured admin dashboard with sidebar navigation.

### Features:
- Sidebar navigation with icons
- User profile section
- Responsive design
- Dark mode support
- Active state indicators
- Logout functionality

### Navigation Items:
- Dashboard
- Users
- Settings

### Sections:
- `@section('header')` - Page header title
- `@section('content')` - Main page content

## Livewire Components

### Authentication Components

#### Login Component (`app/Livewire/Auth/Login.php`)
- Email and password validation
- Remember me functionality
- Error handling
- Redirect to dashboard on success

#### Register Component (`app/Livewire/Auth/Register.php`)
- User registration with validation
- Password confirmation
- Auto-login after registration

### Admin Components

#### Dashboard Component (`app/Livewire/Admin/Dashboard.php`)
- User statistics cards
- Recent users table
- Real-time data display

## File Structure

```
resources/views/
├── layouts/
│   ├── auth.blade.php          # Authentication layout
│   └── admin.blade.php         # Admin dashboard layout
├── auth/                       # Authentication wrapper views
│   ├── login.blade.php         # Login page wrapper
│   └── register.blade.php      # Register page wrapper
├── admin/                      # Admin wrapper views
│   ├── dashboard.blade.php     # Dashboard page wrapper
│   ├── users.blade.php         # Users page
│   └── settings.blade.php      # Settings page
└── livewire/                   # Livewire component views
    ├── auth/
    │   ├── login.blade.php     # Login form component
    │   └── register.blade.php  # Register form component
    └── admin/
        └── dashboard.blade.php  # Dashboard content component

app/Livewire/
├── Auth/
│   ├── Login.php              # Login component logic
│   └── Register.php           # Register component logic
└── Admin/
    └── Dashboard.php          # Dashboard component logic
```

## Routes

### Authentication Routes (Guest Middleware)
- `/login` - Login page
- `/register` - Registration page

### Admin Routes (Auth Middleware)
- `/admin/dashboard` - Main dashboard
- `/admin/users` - Users management
- `/admin/settings` - Application settings

## Styling

All components use TallCraftUI color scheme:
- Primary: `#1b1b18` (light) / `#3E3E3A` (dark)
- Text: `#1b1b18` (light) / `#EDEDEC` (dark)
- Muted: `#706f6c` (light) / `#A1A09A` (dark)
- Error: `#f53003` (light) / `#F61500` (dark)
- Background: `#FDFDFC` (light) / `#0a0a0a` (dark)

## Getting Started

1. Run migrations: `php artisan migrate`
2. Visit `/register` to create an account
3. Login at `/login`
4. Access admin dashboard at `/admin/dashboard`

## Architecture Notes

### Livewire Component Structure
- **Livewire Components**: Handle business logic and data
- **Livewire Views**: Contain only the component HTML (with root `<div>` tag)
- **Wrapper Views**: Use layouts and include Livewire components
- **Layouts**: Provide the overall page structure

### Livewire Component Naming
Livewire uses kebab-case naming convention for components:
- `App\Livewire\Auth\Login` → `auth.login`
- `App\Livewire\Auth\Register` → `auth.register`
- `App\Livewire\Admin\Dashboard` → `admin.dashboard`

This structure ensures:
- Livewire components have proper root HTML tags
- Layouts are reusable across different pages
- Clean separation of concerns
- No "RootTagMissingFromViewException" errors

## Customization

To customize the layouts:
1. Modify the layout files in `resources/views/layouts/`
2. Update Livewire components in `app/Livewire/`
3. Add new routes in `routes/web.php`
4. Create additional wrapper views in `resources/views/`
5. Create Livewire component views in `resources/views/livewire/`

## Troubleshooting

### Common Issues

1. **RootTagMissingFromViewException**: Ensure all Livewire component views have a single root HTML tag (usually `<div>`)

2. **Component Not Found**: Use kebab-case naming convention for Livewire components in `@livewire()` directives

3. **Layout Issues**: Make sure wrapper views extend the correct layout and use `@livewire()` to include components 
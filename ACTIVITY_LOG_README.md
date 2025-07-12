# Activity Log System

This application includes a comprehensive activity logging system using the `spatie/laravel-activitylog` package. The system automatically tracks user activities and provides a dedicated interface for viewing and managing activity logs.

## Features

### Automatic Activity Logging
- **User Management**: All user creation, updates, and deletions are automatically logged
- **Role Management**: All role creation, updates, and deletions are automatically logged
- **Authentication Events**: User login and logout activities are automatically logged with detailed device information
- **Detailed Information**: Each log entry includes:
  - Who performed the action (causer)
  - What was affected (subject)
  - When the action occurred
  - What changed (properties)
  - Event type (created, updated, deleted)
  - **Device Information** (for login/logout):
    - IP Address
    - Browser and version
    - Platform (OS)
    - Device type (mobile, tablet, desktop)
    - User agent string
    - Referer URL
    - Session ID

### Activity Log Interface
- **Responsive Design**: Works on desktop and mobile devices
- **Advanced Filtering**: Filter by log type, event, date, and search terms
- **Detailed View**: Click on any activity to see detailed information
- **Enhanced Login/Logout Display**: Special formatting for authentication events showing device details
- **Bulk Operations**: Clear all logs or delete individual entries
- **Permission-Based Access**: Only users with appropriate permissions can view/manage logs

## Setup

### 1. Package Installation
The required packages have been installed and configured:

```bash
composer require spatie/laravel-activitylog
composer require jenssegers/agent
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"
php artisan migrate
```

### 2. Model Configuration
The `User` model has been configured to automatically log activities:

```php
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'email_verified_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}")
            ->useLogName('user');
    }
}
```

### 3. Authentication Logging
The system includes automatic login/logout logging with device detection:

- **Middleware**: `LogUserActivity` middleware logs login activities
- **Event System**: `UserLoggedOut` event and `LogUserLogout` listener handle logout logging
- **Device Detection**: Uses `jenssegers/agent` package for detailed device information

### 4. Permissions
Activity log permissions have been created and assigned:

- `view activity logs` - Can view the activity log interface
- `delete activity logs` - Can delete individual logs or clear all logs

These permissions are automatically assigned to admin and super admin roles.

## Usage

### Accessing the Activity Log
1. Navigate to the admin panel
2. Click on "Activity Log" in the sidebar menu
3. You'll see a comprehensive list of all logged activities

### Filtering Activities
- **Search**: Use the search box to find specific activities
- **Log Type**: Filter by activity type (user, role, etc.)
- **Event**: Filter by event type (created, updated, deleted, login, logout)
- **Date**: Filter by specific date
- **Clear Filters**: Reset all filters to show all activities

### Viewing Activity Details
1. Click the eye icon next to any activity
2. A modal will open showing detailed information including:
   - Activity description
   - User who performed the action
   - Date and time
   - Subject information
   - Properties (what changed)
   - Changes (before/after values)
   - **For Login/Logout Events**:
     - IP Address
     - Browser and version
     - Platform (OS)
     - Device type
     - Referer URL
     - Session ID

### Managing Logs
- **Delete Individual Log**: Click the trash icon next to any activity
- **Clear All Logs**: Use the "Clear All Logs" button (requires confirmation)
- **Export**: Logs can be exported for external analysis

## Authentication Logging Details

### Login Activity
- **Triggered**: When user successfully logs in
- **Logged Information**:
  - IP Address
  - Browser and version
  - Operating system
  - Device type (mobile/tablet/desktop)
  - User agent string
  - Referer URL
  - Session ID
  - Timestamp

### Logout Activity
- **Triggered**: When user logs out
- **Logged Information**:
  - Same device information as login
  - Session ID for tracking
  - Timestamp

### Device Detection
The system uses the `jenssegers/agent` package to detect:
- **Browser**: Chrome, Firefox, Safari, Edge, etc.
- **Platform**: Windows, macOS, Linux, iOS, Android
- **Device**: iPhone, iPad, Android phone, etc.
- **Device Type**: Mobile, tablet, desktop
- **Robot Detection**: Identifies bots and crawlers

## Manual Activity Logging

You can manually log activities in your code:

```php
use Illuminate\Support\Facades\Auth;

// Basic logging
activity()
    ->causedBy(Auth::user())
    ->performedOn($model)
    ->log('Custom activity description');

// Logging with properties
activity()
    ->causedBy(Auth::user())
    ->performedOn($model)
    ->withProperties([
        'old_value' => $oldValue,
        'new_value' => $newValue,
        'additional_info' => 'Extra context'
    ])
    ->log('Model updated');

// Logging authentication events with device info
$agent = new \Jenssegers\Agent\Agent();
activity()
    ->causedBy(Auth::user())
    ->withProperties([
        'ip_address' => request()->ip(),
        'browser' => $agent->browser(),
        'platform' => $agent->platform(),
        'device' => $agent->device(),
        'is_mobile' => $agent->isMobile(),
    ])
    ->log('Custom authentication event');
```

## Database Structure

The activity log system uses the following tables:

- `activity_log` - Main activity log table
- `activity_log_subject` - Polymorphic relationships for subjects
- `activity_log_causer` - Polymorphic relationships for causers

## Configuration

The activity log configuration is located in `config/activitylog.php`. Key settings include:

- **Enabled**: Enable/disable activity logging
- **Log Name**: Default log name for activities
- **Subject Types**: Which model types to log
- **Causer Types**: Which model types can cause activities
- **Database Connection**: Which database to use for logs

## Security Considerations

1. **Permission-Based Access**: Only users with appropriate permissions can access logs
2. **Sensitive Data**: Be careful not to log sensitive information like passwords
3. **Data Retention**: Consider implementing log rotation for large applications
4. **Audit Trail**: Activity logs provide a complete audit trail for compliance
5. **Privacy**: IP addresses and device information are logged for security purposes

## Troubleshooting

### Common Issues

1. **Activities Not Logging**
   - Check if the model uses the `LogsActivity` trait
   - Verify the `getActivitylogOptions()` method is implemented
   - Ensure the activity log is enabled in config
   - Check if middleware is properly registered

2. **Login/Logout Not Logging**
   - Verify the `LogUserActivity` middleware is applied to routes
   - Check if the `UserLoggedOut` event is being dispatched
   - Ensure the `LogUserLogout` listener is registered

3. **Permission Errors**
   - Run the activity log permission seeder: `php artisan db:seed --class=ActivityLogPermissionSeeder`
   - Check if the user has the required permissions

4. **Performance Issues**
   - Consider implementing log rotation
   - Use database indexing on frequently queried columns
   - Implement caching for frequently accessed logs

### Commands

```bash
# Clear all activity logs
php artisan activitylog:clean

# Clear logs older than X days
php artisan activitylog:clean --days=30

# Clear specific log names
php artisan activitylog:clean --log=user

# Clear application cache
php artisan optimize:clear
```

## Integration with Existing Features

The activity log system is integrated with:

- **User Management**: All user CRUD operations are logged
- **Role Management**: All role CRUD operations are logged
- **Authentication**: Login and logout activities are logged with device details
- **Settings**: Configuration changes can be logged
- **Admin Panel**: Seamless integration with existing admin interface

## Future Enhancements

Potential improvements for the activity log system:

1. **Export Functionality**: Add CSV/Excel export capabilities
2. **Real-time Notifications**: Notify admins of important activities
3. **Advanced Analytics**: Dashboard with activity statistics
4. **API Integration**: REST API for external log access
5. **Custom Log Types**: Support for custom activity types
6. **Retention Policies**: Automatic log cleanup based on policies
7. **Geolocation**: Add IP-based geolocation for login events
8. **Suspicious Activity Detection**: Alert on unusual login patterns 
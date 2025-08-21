# E-Ticket System

A comprehensive Laravel-based event ticketing system with VIP access controls, capacity management, and booking cancellation features.

## Features

### 🎫 Core Ticketing
- Event creation and management
- Ticket booking with real-time availability
- Capacity management and overbooking prevention
- Ticket cancellation with inventory return

### 👑 VIP Access System
- 24-hour exclusive booking window for VIP customers
- Automatic access control based on user VIP status
- Time-based validation for VIP periods

### 🛡️ Security & Validation
- Comprehensive input validation
- CSRF protection
- User authentication and authorization
- Admin-only event management

### ⏰ Time Management
- Prevents booking for past events
- Enforces VIP time windows
- Event status tracking

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or PostgreSQL database

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd e-ticket2
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=e_ticket
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Start development server**
   ```bash
   php artisan serve
   ```

   The application will be available at `http://localhost:8000`

## Usage

### User Roles

#### Regular Users
- Browse events
- Book tickets (outside VIP periods)
- View their tickets
- Cancel their bookings

#### VIP Users
- All regular user features
- Exclusive 24-hour early booking access
- Priority booking during VIP periods

#### Administrators
- All user features
- Create and manage events
- View all tickets
- Cancel any bookings
- Delete tickets permanently

### Creating Events

1. Login as an administrator
2. Navigate to "Manage Events"
3. Click "Create New Event"
4. Fill in event details:
   - **Name**: Event title
   - **Description**: Event details
   - **Location**: Venue information
   - **VIP Access Period**: Set `special_start_date` and `special_end_date` for VIP-only booking
   - **Event Period**: Set `start_date` and `end_date` for the actual event
   - **Capacity**: Maximum number of tickets
   - **Price**: Ticket price

### Booking Tickets

1. Browse available events
2. Click on an event to view details
3. Click "Book Tickets"
4. Fill in booking information:
   - Full name
   - Email address
   - Number of tickets (1-10)
5. Submit booking

**Note**: During VIP access periods, only VIP users can book tickets.

### Managing Bookings

1. Navigate to "My Tickets"
2. View all your bookings
3. Cancel tickets if needed (before event starts)
4. Edit booking details (admin only)

## Database Schema

### Users Table
- Standard Laravel user fields
- `is_vip`: Boolean flag for VIP status
- `is_admin`: Boolean flag for admin privileges

### Events Table
- Event information (name, description, location)
- `special_start_date`/`special_end_date`: VIP access window
- `start_date`/`end_date`: Actual event timing
- `capacity`: Maximum tickets
- `ticket_price`: Price per ticket

### Tickets Table
- Links to events and users
- Buyer information
- Quantity and status tracking
- Status: 'pending', 'confirmed', 'cancelled'

## Key Features Implementation

### VIP Access Control

```php
// In Event model
public function isVipAccessPeriod(): bool
{
    $now = now();
    return $this->special_start_date && $this->special_end_date &&
           $now->between($this->special_start_date, $this->special_end_date);
}

public function canUserBook($user): bool
{
    if (!$this->isVipAccessPeriod()) {
        return true; // Anyone can book outside VIP period
    }
    
    return $user && $user->isVip(); // Only VIP during VIP period
}
```

### Capacity Management

```php
// In Event model
public function getAvailableTicketsAttribute(): int
{
    $soldTickets = $this->tickets()->where('status', 'confirmed')->sum('quantity');
    return max(0, $this->capacity - $soldTickets);
}
```

### Ticket Cancellation

```php
// In TicketController
public function cancel(Ticket $ticket)
{
    // Validation: user owns ticket, event hasn't passed
    if ($ticket->event->hasPassed()) {
        return back()->withErrors(['error' => 'Cannot cancel tickets for past events.']);
    }
    
    $ticket->update(['status' => 'cancelled']);
    // Tickets automatically return to available pool
}
```

## API Documentation

For detailed API documentation, see [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

## Testing

### Manual Testing Scenarios

1. **VIP Access Testing**
   - Create event with VIP period
   - Test VIP user can book during VIP period
   - Test regular user cannot book during VIP period
   - Test both can book after VIP period ends

2. **Capacity Testing**
   - Create event with small capacity (e.g., 5 tickets)
   - Book tickets up to capacity
   - Verify overbooking prevention
   - Cancel some tickets and verify availability returns

3. **Time Validation**
   - Create past event
   - Verify booking is prevented
   - Verify cancellation is prevented for past events

### Running Tests

```bash
# Run PHP tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## Troubleshooting

### Common Issues

1. **"Class not found" errors**
   ```bash
   composer dump-autoload
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Database connection errors**
   - Verify database credentials in `.env`
   - Ensure database server is running
   - Check database exists

3. **Permission errors**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

4. **Frontend assets not loading**
   ```bash
   npm run build
   php artisan config:clear
   ```

## Security

### Security Features
- CSRF protection on all forms
- Input validation and sanitization
- SQL injection prevention via Eloquent ORM
- Authentication required for sensitive operations
- Authorization checks for admin functions

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Built with Laravel 11 and modern web technologies.**

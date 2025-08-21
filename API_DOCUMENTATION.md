# E-Ticket System API Documentation

## Overview

This Laravel-based e-ticket system provides comprehensive event management and ticket booking functionality with VIP access controls, capacity management, and booking cancellation features.

## Database Schema

### Users Table
- `id` (Primary Key)
- `name` (String)
- `email` (String, Unique)
- `email_verified_at` (Timestamp, Nullable)
- `password` (String)
- `is_vip` (Boolean, Default: false)
- `is_admin` (Boolean, Default: false)
- `remember_token`
- `created_at`, `updated_at`

### Events Table
- `id` (Primary Key)
- `name` (String)
- `description` (Text, Nullable)
- `location` (String, Nullable)
- `special_start_date` (DateTime, Nullable) - VIP access start
- `special_end_date` (DateTime, Nullable) - VIP access end
- `start_date` (DateTime, Nullable) - Event start
- `end_date` (DateTime, Nullable) - Event end
- `capacity` (Integer, Nullable)
- `ticket_price` (Decimal 10,2, Nullable)
- `user_id` (Foreign Key to users)
- `created_at`, `updated_at`

### Tickets Table
- `id` (Primary Key)
- `event_id` (Foreign Key to events)
- `user_id` (Foreign Key to users, Nullable)
- `buyer_name` (String)
- `buyer_email` (String, Nullable)
- `quantity` (Integer, Default: 1)
- `status` (Enum: 'pending', 'confirmed', 'cancelled')
- `created_at`, `updated_at`

## Key Features

### 1. VIP Access System
- VIP users get 24-hour exclusive booking window
- Controlled by `special_start_date` and `special_end_date` in events
- Non-VIP users blocked during VIP period

### 2. Capacity Management
- Real-time ticket availability tracking
- Prevents overbooking
- Only counts 'confirmed' tickets against capacity

### 3. Booking Cancellation
- Users can cancel their own tickets
- Cancelled tickets return to available pool
- Prevents cancellation of past events

### 4. Time-based Validation
- Prevents booking tickets for past events
- Enforces VIP time windows
- Event status tracking

## API Endpoints

### Events

#### GET /events
**Description:** List all events with availability information

**Response:**
```json
{
  "events": [
    {
      "id": 1,
      "name": "Concert Event",
      "description": "Amazing concert",
      "location": "City Hall",
      "start_date": "2024-12-25 19:00:00",
      "end_date": "2024-12-25 23:00:00",
      "capacity": 100,
      "ticket_price": "50.00",
      "available_tickets": 75,
      "is_vip_access_period": false
    }
  ]
}
```

#### GET /events/{id}
**Description:** Get specific event details

#### POST /events (Admin only)
**Description:** Create new event

**Request Body:**
```json
{
  "name": "Event Name",
  "description": "Event description",
  "location": "Event location",
  "special_start_date": "2024-12-20 00:00:00",
  "special_end_date": "2024-12-21 00:00:00",
  "start_date": "2024-12-25 19:00:00",
  "end_date": "2024-12-25 23:00:00",
  "capacity": 100,
  "ticket_price": 50.00
}
```

### Tickets

#### GET /tickets
**Description:** List user's tickets

**Response:**
```json
{
  "tickets": [
    {
      "id": 1,
      "event": {
        "name": "Concert Event",
        "start_date": "2024-12-25 19:00:00"
      },
      "buyer_name": "John Doe",
      "buyer_email": "john@example.com",
      "quantity": 2,
      "status": "confirmed"
    }
  ]
}
```

#### POST /tickets
**Description:** Book tickets for an event

**Request Body:**
```json
{
  "event_id": 1,
  "buyer_name": "John Doe",
  "buyer_email": "john@example.com",
  "quantity": 2
}
```

**Validation Rules:**
- User must be VIP during VIP access period
- Event must not have passed
- Sufficient tickets must be available
- Quantity must be positive integer

#### PATCH /tickets/{id}/cancel
**Description:** Cancel a ticket booking

**Requirements:**
- User must own the ticket or be admin
- Event must not have passed
- Ticket must be in 'confirmed' status

**Response:**
```json
{
  "message": "Ticket cancelled successfully",
  "ticket": {
    "id": 1,
    "status": "cancelled"
  }
}
```

## Model Methods

### User Model
- `isVip()`: Check if user has VIP status
- `tickets()`: Get user's tickets relationship

### Event Model
- `isVipAccessPeriod()`: Check if currently in VIP access window
- `canUserBook($user)`: Check if user can book tickets
- `getAvailableTicketsAttribute()`: Get count of available tickets
- `hasAvailableTickets()`: Check if tickets are available
- `hasPassed()`: Check if event has ended

### Ticket Model
- `user()`: Get ticket owner relationship
- `event()`: Get associated event relationship

## Error Handling

### Common Error Responses

#### 403 Forbidden - VIP Access Required
```json
{
  "error": "This event is currently in VIP access period. Only VIP members can book tickets."
}
```

#### 400 Bad Request - Event Passed
```json
{
  "error": "Cannot book tickets for past events."
}
```

#### 400 Bad Request - Sold Out
```json
{
  "error": "Not enough tickets available. Requested: 5, Available: 2"
}
```

#### 403 Forbidden - Cancellation Not Allowed
```json
{
  "error": "Cannot cancel tickets for past events."
}
```

## Authentication

The system uses Laravel's built-in authentication with session-based auth for web routes. Users must be logged in to:
- Book tickets
- View their tickets
- Cancel bookings

Admin users have additional privileges:
- Create/edit/delete events
- View all tickets
- Delete tickets permanently

## Setup Instructions

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd e-ticket2
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed # Optional: seed with sample data
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   npm run dev
   ```

## Testing

### Key Test Scenarios

1. **VIP Access Testing**
   - Create VIP and regular users
   - Set event with VIP access period
   - Verify VIP users can book, regular users cannot

2. **Capacity Management**
   - Create event with limited capacity
   - Book tickets up to capacity
   - Verify overbooking prevention

3. **Cancellation Testing**
   - Book tickets
   - Cancel tickets
   - Verify tickets return to available pool

4. **Time Validation**
   - Create past events
   - Verify booking prevention
   - Test VIP window enforcement

## Security Considerations

- All user inputs are validated and sanitized
- CSRF protection enabled for all forms
- Foreign key constraints prevent orphaned records
- Soft deletes could be implemented for audit trails
- Rate limiting should be considered for booking endpoints

## Performance Optimizations

- Database indexes on frequently queried columns
- Eager loading for relationships
- Caching for event availability calculations
- Queue jobs for email notifications (future enhancement)

## Future Enhancements

- Payment integration
- Email notifications
- QR code generation for tickets
- Event categories and filtering
- Bulk ticket operations
- Reporting and analytics dashboard
# RAMS Region III - Regional Agency Monitoring System

A multi-tenant Laravel application for monitoring government projects across Region 3 (Central Luzon) agencies.

## System Overview

**RAMS Region III** is a secure, agency-restricted monitoring system where:
- Each agency (DICT, DOH, DPWH, DOST, DepEd) can only see and manage their own projects
- Users must select their agency during login/registration
- All data is filtered by `agency_id` to ensure strict privacy
- Professional White and Royal Blue UI with responsive design

## Features

### 1. **Landing Page** (`landing.blade.php`)
- Modern hero section with "Region 3 Monitoring" branding
- "Sign In" and "Get Started" buttons
- Key features showcase
- Professional footer

### 2. **Authentication System**
- **Login** (`pages/auth/login.blade.php`)
  - Agency dropdown selection
  - Email and password fields
  - Agency-specific authentication
  
- **Registration** (`pages/auth/register.blade.php`)
  - Full name, email, password
  - Agency selection from predefined list
  - Password confirmation

### 3. **Dashboard** (`pages/dashboard.blade.php`)
- Blue gradient welcome banner with agency name
- 7 horizontal scrolling metric cards
- Dual-line wavy chart (Chart.js)
- Glassmorphism VISA card
- Doughnut chart for earnings
- Stacked bar chart for conversions
- Recent projects table
- System alerts section

### 4. **Project Management CRUD**
- **Index** (`pages/projects/index.blade.php`)
  - Agency-restricted project list
  - Progress bars
  - Status badges
  - Edit/Delete actions
  
- **Create** (`pages/projects/create.blade.php`)
  - Project form with validation
  - Budget, status, dates, progress
  
- **Edit** (`pages/projects/edit.blade.php`)
  - Update project details
  - Agency-restricted access

## Database Structure

### Migrations
1. `2026_03_09_121428_create_agencies_table.php` - Agencies table
2. `2026_03_09_130000_add_agency_id_to_users.php` - Add agency_id to users
3. `2026_03_09_130100_create_projects_table.php` - Projects table

### Models
- **Agency** - Has many users and projects
- **User** - Belongs to agency
- **Project** - Belongs to agency

## Setup Instructions

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup
```bash
# Create the database first (XAMPP / MySQL):
# - Database name must match `DB_DATABASE` in your `.env` (default: `monitoring_system`)
# - Example (MySQL CLI): CREATE DATABASE monitoring_system;
#
# Run migrations
php artisan migrate

# Seed agencies and test users
php artisan db:seed
```

### 4. Build Assets
```bash
npm run build
# or for development
npm run dev
```

### 5. Start Server
```bash
php artisan serve
```

Visit `http://localhost:8000`

## Test Credentials

After seeding, use these credentials:

| Agency | Email | Password |
|--------|-------|----------|
| DICT Region III | dict@example.com | password |
| DOH Region III | doh@example.com | password |
| DPWH Region III | dpwh@example.com | password |

## Routes

### Public Routes
- `/` - Landing page
- `/login` - Login page
- `/register` - Registration page

### Protected Routes (Requires Authentication)
- `/dashboard` - Dashboard
- `/projects` - Projects list (agency-restricted)
- `/projects/create` - Create project
- `/projects/{id}/edit` - Edit project
- `/projects/{id}` - Delete project
- `/settings` - Settings
- `/reports` - Reports

## Security Features

### Agency Isolation
- All queries filtered by `Auth::user()->agency_id`
- ProjectPolicy ensures users can only access their agency's projects
- Middleware protects authenticated routes

### Authentication
- Password hashing with Laravel's built-in encryption
- Session-based authentication
- CSRF protection on all forms

## Design System

### Colors
- **Primary**: Royal Blue (#2563eb)
- **Secondary**: Cyan (#22d3ee)
- **Background**: White (#FFFFFF)
- **Text**: Slate (#64748b)

### Typography
- Font: Inter (Google Fonts)
- Weights: 300, 400, 600, 700, 800

### Components
- Rounded corners: `rounded-[2rem]` for cards
- Shadows: Soft shadows with blue tint
- Spacing: Tailwind CSS utilities
- Responsive: Mobile-first design

## File Structure

```
resources/views/
├── pages/
│   ├── landing.blade.php
│   ├── dashboard.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   └── projects/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
├── layouts/
│   └── app.blade.php
└── components/
    ├── navbar.blade.php
    └── sidebar.blade.php

app/
├── Models/
│   ├── Agency.php
│   ├── User.php
│   └── Project.php
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   └── ProjectController.php
│   └── Policies/
│       └── ProjectPolicy.php
└── Providers/

database/
├── migrations/
└── seeders/
    ├── AgencySeeder.php
    └── DatabaseSeeder.php
```

## Key Implementation Details

### Agency-Restricted CRUD
```php
// ProjectController@index
public function index()
{
    $projects = Project::where('agency_id', Auth::user()->agency_id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
    return view('pages.projects.index', compact('projects'));
}
```

### Policy Authorization
```php
// ProjectPolicy
public function update(User $user, Project $project): bool
{
    return $user->agency_id === $project->agency_id;
}
```

### Dashboard Agency Name
```blade
<h1>Hello, {{ Auth::user()->agency->agency_name }} 👋</h1>
```

## Responsive Design

- **Mobile** (320px+): Single column, stacked layout
- **Tablet** (768px+): Two-column grid
- **Desktop** (1024px+): Full three-column layout

All components use Tailwind's responsive prefixes:
- `md:` for tablet breakpoints
- `lg:` for desktop breakpoints

## Charts

All charts use Chart.js with custom styling:
- **Wavy Chart**: Dual-line with blue and cyan colors
- **Doughnut Chart**: Budget breakdown
- **Stacked Bar Chart**: Weekly conversions

## Future Enhancements

- [ ] Email notifications
- [ ] Advanced reporting
- [ ] Budget analytics
- [ ] Project timeline view
- [ ] Team collaboration features
- [ ] File uploads
- [ ] Audit logs

## Support

For issues or questions, contact the development team.

---

**Version**: 1.0.0  
**Last Updated**: 2026-03-09  
**License**: MIT

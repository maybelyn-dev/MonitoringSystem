# RAMS Region III - Quick Reference Guide

## 🚀 Quick Start

### 1. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 2. Start Development Server
```bash
php artisan serve
```

### 3. Access the Application
- **Landing Page**: http://localhost:8000
- **Login**: http://localhost:8000/login
- **Register**: http://localhost:8000/register

## 👤 Test Accounts

All test accounts use password: `password`

```
DICT Region III
├─ Email: dict@example.com
├─ Agency: DICT Region III (Bulacan)
└─ Projects: Only DICT projects visible

DOH Region III
├─ Email: doh@example.com
├─ Agency: DOH Region III (Nueva Ecija)
└─ Projects: Only DOH projects visible

DPWH Region III
├─ Email: dpwh@example.com
├─ Agency: DPWH Region III (Pampanga)
└─ Projects: Only DPWH projects visible
```

## 📋 System Architecture

### Multi-Tenant Model
```
┌─────────────────────────────────────┐
│         RAMS Region III             │
├─────────────────────────────────────��
│  Agency 1 (DICT)                    │
│  ├─ User 1 (dict@example.com)       │
│  └─ Projects (only DICT projects)   │
│                                     │
│  Agency 2 (DOH)                     │
│  ├─ User 2 (doh@example.com)        │
│  └─ Projects (only DOH projects)    │
│                                     │
│  Agency 3 (DPWH)                    │
│  ├─ User 3 (dpwh@example.com)       │
│  └─ Projects (only DPWH projects)   │
└─────────────────────────────────────┘
```

### Data Flow
```
User Login
    ↓
Select Agency
    ↓
Authenticate with agency_id
    ↓
Dashboard (filtered by agency_id)
    ↓
Projects (only agency's projects)
```

## 🔐 Security Implementation

### Agency Isolation
```php
// All queries automatically filtered
$projects = Project::where('agency_id', Auth::user()->agency_id)->get();

// Policy checks ownership
public function update(User $user, Project $project): bool
{
    return $user->agency_id === $project->agency_id;
}
```

### Authentication Flow
```
1. User selects agency
2. System checks email + password + agency_id
3. User logged in with agency context
4. All subsequent queries filtered by agency_id
5. Policies enforce agency ownership
```

## 📊 Dashboard Components

### 1. Welcome Banner
- Shows agency name: "Hello, [Agency Name] 👋"
- Blue gradient background
- Responsive text sizing

### 2. Metrics Cards (7 total)
- Sales, Profit, Users, Orders, Revenue, Growth, Conversion
- Horizontal scrolling on mobile
- Blue accent icons
- Trend indicators

### 3. Charts
- **Wavy Chart**: Dual-line performance chart
- **Doughnut Chart**: Earnings breakdown
- **Stacked Bar Chart**: Weekly conversions

### 4. Recent Projects Table
- Shows agency's projects only
- Progress bars
- Status badges
- Edit/Delete actions

### 5. System Alerts
- Checkboxes for task management
- Time indicators
- Blue-themed cards

## 🛠️ Project Management

### Create Project
```
1. Click "New Project" button
2. Fill in project details:
   - Name (required)
   - Description (optional)
   - Budget (required)
   - Status (required)
   - Start/End dates (optional)
   - Progress % (0-100)
3. Submit form
4. Redirected to projects list
```

### Edit Project
```
1. Click "Edit" on project row
2. Update any field
3. Submit form
4. Changes saved
```

### Delete Project
```
1. Click "Delete" on project row
2. Confirm deletion
3. Project removed
```

## 🎨 Design System

### Colors
```
Primary Blue:     #2563eb (Royal Blue)
Secondary Cyan:   #22d3ee (Cyan)
Background:       #FFFFFF (White)
Text Primary:     #1e293b (Slate 900)
Text Secondary:   #64748b (Slate 500)
Border:           #e2e8f0 (Slate 200)
```

### Typography
```
Font Family: Inter
Weights: 300, 400, 600, 700, 800

Headings:
- H1: text-4xl font-black
- H2: text-2xl font-black
- H3: text-lg font-black

Body:
- Regular: text-sm font-normal
- Bold: text-sm font-bold
```

### Spacing
```
Cards:     rounded-[2rem] (32px)
Buttons:   rounded-xl (12px)
Inputs:    rounded-xl (12px)
Padding:   p-4 md:p-6 lg:p-8
Gap:       gap-4 md:gap-6 lg:gap-8
```

## 📱 Responsive Breakpoints

```
Mobile:   320px - 767px   (single column)
Tablet:   768px - 1023px  (two columns)
Desktop:  1024px+         (three columns)

Tailwind Prefixes:
- md:  768px and up
- lg:  1024px and up
```

## 🔄 User Flow

### First Time User
```
Landing Page
    ↓
Click "Get Started"
    ↓
Registration Page
    ↓
Select Agency
    ↓
Enter Details
    ↓
Create Account
    ↓
Auto-login
    ↓
Dashboard
```

### Returning User
```
Landing Page
    ↓
Click "Sign In"
    ↓
Login Page
    ↓
Select Agency
    ↓
Enter Credentials
    ↓
Dashboard
```

## 📁 Key Files Reference

### Views
| File | Purpose |
|------|---------|
| `landing.blade.php` | Landing page |
| `dashboard.blade.php` | Main dashboard |
| `auth/login.blade.php` | Login form |
| `auth/register.blade.php` | Registration form |
| `projects/index.blade.php` | Projects list |
| `projects/create.blade.php` | Create project |
| `projects/edit.blade.php` | Edit project |

### Controllers
| File | Methods |
|------|---------|
| `AuthController.php` | showLogin, login, showRegister, register, logout |
| `ProjectController.php` | index, create, store, edit, update, destroy |

### Models
| File | Relationships |
|------|---------------|
| `Agency.php` | hasMany(User), hasMany(Project) |
| `User.php` | belongsTo(Agency) |
| `Project.php` | belongsTo(Agency) |

## 🧪 Testing Scenarios

### Scenario 1: Agency Isolation
```
1. Login as DICT user
2. Create a project
3. Logout
4. Login as DOH user
5. Verify DICT project NOT visible
✓ Only DOH projects shown
```

### Scenario 2: Project CRUD
```
1. Login as any user
2. Create project
3. Edit project
4. Verify changes
5. Delete project
✓ All operations work correctly
```

### Scenario 3: Responsive Design
```
1. Open dashboard on mobile (320px)
2. Verify single column layout
3. Resize to tablet (768px)
4. Verify two column layout
5. Resize to desktop (1024px)
6. Verify three column layout
✓ All breakpoints work
```

## 🐛 Troubleshooting

### Issue: "Agency not found" error
**Solution**: Ensure agencies are seeded
```bash
php artisan db:seed --class=AgencySeeder
```

### Issue: Login fails
**Solution**: Check credentials and agency selection
- Email must match
- Password must be correct
- Agency must be selected

### Issue: Projects not showing
**Solution**: Verify agency_id is set
```bash
php artisan tinker
>>> User::find(1)->agency_id
```

### Issue: Charts not rendering
**Solution**: Ensure Chart.js is loaded
- Check browser console for errors
- Verify canvas elements exist
- Check Chart.js CDN link

## 📞 Support

For issues or questions:
1. Check SETUP.md for detailed setup
2. Check IMPLEMENTATION.md for architecture
3. Review code comments
4. Check Laravel documentation

## 📝 Notes

- All times are in server timezone
- Budgets are stored as decimal(15,2)
- Progress is 0-100 percentage
- Status options: Planning, In Progress, Completed, On Hold, Cancelled
- Soft deletes not implemented (hard delete)

---

**Last Updated**: 2026-03-09  
**Version**: 1.0.0  
**Status**: Production Ready

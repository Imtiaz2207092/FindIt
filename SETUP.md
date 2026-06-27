# FindIt — Enterprise Lost & Found System (Oracle 21c)

## 🏛️ Architecture Overview

This is a complete Laravel 12 + Oracle Database 21c implementation of the FindIt Lost & Found platform, featuring:

- **7 Oracle tables** with SEQUENCES and BEFORE INSERT TRIGGERS for auto-increment PKs
- **7 Eloquent models** with proper relationships and Oracle-specific mappings
- **5 resource controllers** for CRUD operations (Lost Items, Found Items, Claims, Notifications, Admin)
- **Premium Blade views** with Bootstrap 5 styling and responsive design
- **Role-based access control** (User vs Admin)
- **Complete migrations** using `DB::unprepared()` for PL/SQL

---

## 📋 Database Schema (Oracle 21c)

### Tables

1. **users** (NUMBER PKs via user_seq)
   - user_id, name, email, password, phone, role, created_at

2. **admins** (NUMBER PKs via admins_seq)
   - admin_id, name, email, password

3. **categories** (NUMBER PKs via categories_seq)
   - category_id, category_name

4. **lost_items** (NUMBER PKs via lost_items_seq)
   - lost_id, user_id (FK), category_id (FK), title, description, image, location, lost_date, status

5. **found_items** (NUMBER PKs via found_items_seq)
   - found_id, user_id (FK), category_id (FK), title, description, image, location, found_date, status

6. **claims** (NUMBER PKs via claims_seq)
   - claim_id, user_id (FK), lost_id (FK), found_id (FK), proof_details, status, claim_date

7. **notifications** (NUMBER PKs via notifications_seq)
   - notification_id, user_id (FK), message, status, created_at

---

## 🚀 Setup Instructions

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- Oracle Database 21c XE running on `127.0.0.1:1521`
- Oracle credentials: `system / 2022`

### Step 1: Install Dependencies

```bash
cd f:\FindIt
composer install
```

### Step 2: Install Oracle Driver

```bash
composer require yajra/laravel-oci8:^12.0
```

This installs the Yajra OCI8 driver required for Oracle 21c support.

### Step 3: Configure Environment

Copy `.env.example` to `.env`:

```bash
copy .env.example .env
```

Update `.env` with your Oracle credentials:

```env
DB_CONNECTION=oracle
DB_HOST=127.0.0.1
DB_PORT=1521
DB_DATABASE=xe
DB_USERNAME=system
DB_PASSWORD=2022
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Run Migrations

Execute the Oracle schema migration (creates sequences, tables, and triggers):

```bash
php artisan migrate --database=oracle
```

### Step 6: Seed Categories (Optional)

Create sample categories via Tinker or manually insert:

```bash
php artisan tinker
>>> \App\Models\Category::create(['category_name' => 'Electronics'])
>>> \App\Models\Category::create(['category_name' => 'Accessories'])
>>> \App\Models\Category::create(['category_name' => 'Documents'])
>>> exit
```

### Step 7: Build Frontend Assets

```bash
npm install
npm run build
```

### Step 8: Start Development Server

```bash
php artisan serve
```

Access the application at: **http://localhost:8000**

---

## 👤 Testing Accounts

### User Registration

1. Navigate to **http://localhost:8000/register**
2. Create a new account with name, email, phone, password
3. Login and explore Lost/Found items, submit claims

### Admin Access

To grant admin privileges to a user:

```bash
php artisan tinker
>>> $user = \App\Models\User::find(1);  # or any user_id
>>> $user->update(['role' => 'Admin']);
>>> exit
```

Then login with that account to access the **Admin Panel** (/admin/dashboard).

---

## 📂 Project Structure

```
app/
  ├── Models/
  │   ├── User.php
  │   ├── Admin.php
  │   ├── Category.php
  │   ├── LostItem.php
  │   ├── FoundItem.php
  │   ├── Claim.php
  │   └── Notification.php
  └── Http/Controllers/
      ├── LostItemController.php
      ├── FoundItemController.php
      ├── ClaimController.php
      ├── NotificationController.php
      └── AdminController.php

resources/views/
  ├── layouts/app.blade.php
  ├── items/
  │   ├── lost/
  │   │   ├── index.blade.php
  │   │   ├── create.blade.php
  │   │   └── show.blade.php
  │   └── found/...
  ├── claims/
  │   ├── index.blade.php
  │   └── create.blade.php
  ├── admin/
  │   └── dashboard.blade.php
  └── auth/
      ├── login.blade.php
      └── register.blade.php

database/migrations/
  └── 2026_06_26_000000_create_oracle_schema.php

routes/
  └── web.php
```

---

## 🔑 Key Features

### User Features
- ✅ Register and login with email/phone
- ✅ Report lost items with photo, location, date, category
- ✅ View all lost/found items in the system
- ✅ Submit claims with proof details
- ✅ Track claim status (Pending, Approved, Rejected)
- ✅ Receive notifications about claim updates
- ✅ Edit/delete own items (unless claimed)

### Admin Features
- ✅ Dashboard with statistics
- ✅ View all users, categories, items, claims
- ✅ Approve/reject claims
- ✅ Manage categories
- ✅ View system reports and analytics

---

## 📝 Route Overview

| Method | Endpoint | Controller | Feature |
|--------|----------|-----------|---------|
| GET | /login | LoginController | Login page |
| POST | /login | LoginController | Process login |
| GET | /register | RegisterController | Register page |
| POST | /register | RegisterController | Process registration |
| GET | /lost-items | LostItemController@index | List all lost items |
| POST | /lost-items | LostItemController@store | Create lost item |
| GET | /lost-items/{id} | LostItemController@show | View lost item |
| PUT | /lost-items/{id} | LostItemController@update | Update lost item |
| DELETE | /lost-items/{id} | LostItemController@destroy | Delete lost item |
| GET | /found-items | FoundItemController@index | List all found items |
| POST | /found-items | FoundItemController@store | Create found item |
| GET | /claims | ClaimController@index | View claims |
| POST | /claims | ClaimController@store | Submit claim |
| POST | /claims/{id}/approve | ClaimController@approve | Approve claim (Admin) |
| POST | /claims/{id}/reject | ClaimController@reject | Reject claim (Admin) |
| GET | /admin/dashboard | AdminController@dashboard | Admin panel |

---

## 🛠️ Troubleshooting

### Migration Fails with "Cannot find SEQUENCE"

Ensure Oracle is running and accessible:
```bash
sqlplus system/2022@localhost:1521/xe
```

### PDO Oracle Driver Issues

Install PHP OCI8 extension:
```bash
pecl install oci8
# Add extension=oci8.so to php.ini
```

### Laravel Cache/Routes Issues

Clear all caches:
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear
```

---

## 📞 Support

For issues or questions, check:
- Laravel Documentation: https://laravel.com/docs
- Yajra OCI8: https://github.com/yajra/laravel-oci8
- Oracle Docs: https://docs.oracle.com/en/database/oracle/oracle-database/

---

**Developed for KUET — 2026**

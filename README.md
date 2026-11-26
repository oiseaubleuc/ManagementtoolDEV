<h1 align="center">Workflow Management Tool</h1>
<p align="center">
  <b>Project and time-tracking platform with role-based access control</b><br/>
  Track time per project and task, separate billable hours, and control who sees what with roles, permissions and policies.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Blade-templates-F05340?style=flat-square" />
  <img src="https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/Vite-assets-646CFF?style=flat-square&logo=vite&logoColor=white" />
  <img src="https://img.shields.io/badge/PHPUnit-12-366488?style=flat-square" />
</p>

---

## Features

- **Projects** — full CRUD, each project with its own tasks.
- **Time tracking** — log time against a project and task with start, end, description and a *billable* flag; stop a running timer in one click.
- **Dashboard** — number of projects and total time logged this week.
- **Authentication** — registration, login, email verification and profile management (Laravel Breeze).
- **Role-based access control** — roles, granular permissions, custom middleware and model policies.
- **Localization** — French translation included (`lang/fr.json`).

## Roles and permissions

| Role | Access |
|---|---|
| **admin** | Everything |
| **manager** | Manage projects and all time entries (view, edit, delete) |
| **member** | View projects, create and view own time entries |

New users are assigned the **member** role on registration.

Access is enforced on three levels:

| Layer | Implementation |
|---|---|
| Routes | `role` and `permission` middleware (`EnsureUserHasRole`, `EnsureUserHasPermission`) |
| Models | `ProjectPolicy`, `TimeEntryPolicy` |
| Data | `roles`, `permissions` and `role_user` tables, seeded by `RolePermissionSeeder` |

## Data model

```
User ──< role_user >── Role ──< Permission
  │
  ├──< Project ──< Task
  │        │
  └──< TimeEntry >──┘   (project, task, started_at, ended_at, duration, billable)
```

## Tech stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13, PHP 8.3 |
| Frontend | Blade, Tailwind CSS, Vite |
| Auth | Laravel Breeze |
| Database | SQLite by default (MySQL / PostgreSQL supported) |
| Testing | PHPUnit 12 |

## Getting started

Requirements: PHP 8.3+, Composer, Node.js and npm.

```bash
git clone https://github.com/oiseaubleuc/ManagementtoolDEV.git
cd ManagementtoolDEV

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate --seed

npm run build
```

Run the app:

```bash
php artisan serve      # http://localhost:8000
npm run dev            # in a second terminal, for hot reload
```

**Demo account** (created by the seeder): `admin@example.com` / `password`

## Routes

| Route | Description |
|---|---|
| `/dashboard` | Overview and weekly time |
| `/projects` | Project management |
| `/time-entries` | Time tracking: list, create, edit, stop, delete |
| `/profile` | Account settings |

## Tests

```bash
php artisan test
```

---

<p align="center">Built by <a href="https://github.com/oiseaubleuc">Hoho</a> · Belgium</p>

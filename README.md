# Laravel Workflow Management Tool

Workflow- en tijdregistratie-applicatie met Laravel, Tailwind CSS en Blade.

## Functionaliteit

- **Database**: Rollen, rechten, projecten, taken, tijdregistraties
- **Tijdregistratie**: Koppeling aan project/taak, start/einde, beschrijving, factureerbaar
- **Front-end**: Blade-templates met Tailwind CSS (Breeze)
- **Autorisatie**: Middleware (`role`, `permission`) en Policies (Project, TimeEntry)
- **Gebruikersrechten**: Rollen (admin, manager, member) met permissions

## Vereisten

- PHP 8.2+
- Composer
- Node.js & npm (voor assets)
- SQLite (standaard) of MySQL/PostgreSQL

## Installatie

```bash
# Dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database (SQLite standaard)
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# Assets
npm run build
```

## Development

```bash
php artisan serve
# In een tweede terminal:
npm run dev
```

Bezoek http://localhost:8000. Registreer een account; nieuwe gebruikers krijgen automatisch de rol **Lid** (member).

## Rollen en rechten (na seeding)

| Rol      | Rechten |
|----------|---------|
| **admin** | Alle rechten |
| **manager** | Projecten en tijdregistraties beheren, alle entries bekijken/bewerken/verwijderen |
| **member** | Projecten bekijken, eigen tijdregistraties aanmaken en bekijken |

Rollen wijzen: na registratie handmatig in de database (bijv. `role_user` tabel) of via een admin-interface.

## Structuur

- **Migraties**: `database/migrations/2025_03_18_*` (roles, permissions, projects, tasks, time_entries)
- **Modellen**: `App\Models\{User, Role, Permission, Project, Task, TimeEntry}`
- **Middleware**: `EnsureUserHasRole`, `EnsureUserHasPermission` (alias: `role`, `permission`)
- **Policies**: `ProjectPolicy`, `TimeEntryPolicy`
- **Controllers**: `ProjectController`, `TimeEntryController`

## Routes (na inloggen)

- `/dashboard` – overzicht en snelkoppelingen
- `/projects` – projecten (CRUD)
- `/time-entries` – tijdregistratie (index, create, edit, stop, destroy)

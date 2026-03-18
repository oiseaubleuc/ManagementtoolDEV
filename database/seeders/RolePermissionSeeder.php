<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Voir les projets', 'slug' => 'view_projects', 'group' => 'projects'],
            ['name' => 'Créer des projets', 'slug' => 'create_projects', 'group' => 'projects'],
            ['name' => 'Gérer tous les projets', 'slug' => 'manage_all_projects', 'group' => 'projects'],
            ['name' => 'Voir les saisies de temps', 'slug' => 'view_time_entries', 'group' => 'time'],
            ['name' => 'Voir toutes les saisies de temps', 'slug' => 'view_all_time_entries', 'group' => 'time'],
            ['name' => 'Créer des saisies de temps', 'slug' => 'create_time_entries', 'group' => 'time'],
            ['name' => 'Modifier toutes les saisies de temps', 'slug' => 'edit_all_time_entries', 'group' => 'time'],
            ['name' => 'Supprimer toutes les saisies de temps', 'slug' => 'delete_all_time_entries', 'group' => 'time'],
            ['name' => 'Gérer les utilisateurs', 'slug' => 'manage_users', 'group' => 'admin'],
            ['name' => 'Gérer les rôles', 'slug' => 'manage_roles', 'group' => 'admin'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        $admin = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrateur', 'description' => 'Accès complet au système']
        );
        $admin->permissions()->sync(Permission::pluck('id'));

        $manager = Role::firstOrCreate(
            ['slug' => 'manager'],
            ['name' => 'Manager', 'description' => 'Gestion des projets et des saisies de temps']
        );
        $manager->permissions()->sync(
            Permission::whereIn('slug', [
                'view_projects', 'create_projects', 'manage_all_projects',
                'view_time_entries', 'view_all_time_entries', 'create_time_entries',
                'edit_all_time_entries', 'delete_all_time_entries',
            ])->pluck('id')
        );

        $member = Role::firstOrCreate(
            ['slug' => 'member'],
            ['name' => 'Membre', 'description' => 'Droits utilisateur par défaut']
        );
        $member->permissions()->sync(
            Permission::whereIn('slug', ['view_projects', 'view_time_entries', 'create_time_entries'])->pluck('id')
        );
    }
}

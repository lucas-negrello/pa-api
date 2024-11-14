<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $readerRole = Role::firstOrCreate(['name' => 'reader']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $destructorRole = Role::firstOrCreate(['name' => 'destructor']);
        $creatorRole = Role::firstOrCreate(['name' => 'creator']);
        $restorerRole = Role::firstOrCreate(['name' => 'restorer']);
        $forceDeletorRole = Role::firstOrCreate(['name' => 'force-deletor']);


        $permissions = [
            'view-any-appointment',
            'view-appointment',
            'create-appointment',
            'update-appointment',
            'delete-appointment',
            'restore-appointment',
            'force-delete-appointment',
            'view-any-goal',
            'view-goal',
            'create-goal',
            'update-goal',
            'delete-goal',
            'restore-goal',
            'force-delete-goal',
            'view-any-shopping-list',
            'view-shopping-list',
            'create-shopping-list',
            'update-shopping-list',
            'delete-shopping-list',
            'restore-shopping-list',
            'force-delete-shopping-list',
            'view-any-task',
            'view-task',
            'create-task',
            'update-task',
            'delete-task',
            'restore-task',
            'force-delete-task'
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            $adminRole->permissions()->syncWithoutDetaching($permission);

            if (in_array($permissionName,
                [
                    'view-any-appointment',
                    'view-appointment',
                    'view-any-goal',
                    'view-goal',
                    'view-any-shopping-list',
                    'view-shopping-list',
                    'view-any-task',
                    'view-task'
                ]))
            {
                $readerRole->permissions()->syncWithoutDetaching($permission);
            }
            if (in_array($permissionName,
                [
                    'update-appointment',
                    'update-goal',
                    'update-shopping-list',
                    'update-task',
                ]))
            {
                $editorRole->permissions()->syncWithoutDetaching($permission);
            }
            if (in_array($permissionName,
                [
                    'delete-appointment',
                    'delete-goal',
                    'delete-shopping-list',
                    'delete-task',
                ]))
            {
                $destructorRole->permissions()->syncWithoutDetaching($permission);
            }
            if (in_array($permissionName,
                [
                    'create-appointment',
                    'create-goal',
                    'create-shopping-list',
                    'create-task',
                ]))
            {
                $creatorRole->permissions()->syncWithoutDetaching($permission);
            }
            if (in_array($permissionName,
                [
                    'restore-appointment',
                    'restore-goal',
                    'restore-shopping-list',
                    'restore-task',
                ]))
            {
                $restorerRole->permissions()->syncWithoutDetaching($permission);
            }
            if (in_array($permissionName,
                [
                    'force-delete-appointment',
                    'force-delete-goal',
                    'force-delete-shopping-list',
                    'force-delete-task',
                ]))
            {
                $forceDeletorRole->permissions()->syncWithoutDetaching($permission);
            }
            $adminUser = User::find(10);
            if ($adminUser){ $adminUser->roles()->syncWithoutDetaching($adminRole); }
        }
    }
}

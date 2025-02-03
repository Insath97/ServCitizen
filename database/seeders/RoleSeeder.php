<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['guard_name' => 'admin', 'name' => 'Super Admin']);

        $allPermissions = Permission::all();
        $role->syncPermissions($allPermissions);

        $admin = new Admin();
        $admin->image = '/test';
        $admin->name = 'Super Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = static::$password ??= Hash::make('password');
        $admin->status = 1;
        $admin->save();

        // Assign the Super Admin role to the newly created user
        $admin->assignRole('Super Admin');
    }
}

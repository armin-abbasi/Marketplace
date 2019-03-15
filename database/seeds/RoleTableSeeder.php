<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_employee = new Role();
        $role_employee->name = 'admin';
        $role_employee->description = 'An Administrator User';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = 'provider';
        $role_manager->description = 'A Provider User';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'customer';
        $role_manager->description = 'Regular Customer';
        $role_manager->save();
    }
}

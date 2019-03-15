<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role_admin = Role::where('name', 'admin')->first();
        $role_provider = Role::where('name', 'provider')->first();
        $role_customer = Role::where('name', 'customer')->first();

        $admin = new User();
        $admin->name = 'Admin Name';
        $admin->email = 'admin@local.com';
        $admin->password = '123';
        $admin->latitude = '35.733747';
        $admin->longitude = '51.399748';
        $admin->city = 'Tehran';
        $admin->save();
        $admin->roles()->attach($role_admin);

        $provider = new User();
        $provider->name = 'Provider Name';
        $provider->email = 'provider@local.com';
        $provider->password = '123';
        $provider->latitude = '35.736166';
        $provider->longitude = '51.401341';
        $provider->city = 'Tehran';
        $provider->save();
        $provider->roles()->attach($role_provider);

        $customer = new User();
        $customer->name = 'Customer Name';
        $customer->email = 'customer@local.com';
        $customer->password = '123';
        $customer->latitude = '35.736166';
        $customer->longitude = '51.401341';
        $customer->city = 'Tehran';
        $customer->save();
        $customer->roles()->attach($role_customer);
    }
}

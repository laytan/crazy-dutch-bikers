<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'member']);

        $super = new User;
        $super->name = 'beheer';
        $super->email = 'beheer@crazydutchbikers.nl';
        $super->email_verified_at = now();
        $super->remember_token = Str::random(10);
        $super->password = '$2y$12$X1HU74UzvASfEqZkBHYqc.ZRnvNnyILcOFA2EDqLsEDcfAOjb/jPi';
        $super->assignRole('super-admin');
        $super->save();
    }
}

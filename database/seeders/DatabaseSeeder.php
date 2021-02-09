<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $super = new User;
        $super->name = 'beheer';
        $super->email = 'founder@crazydutchbikers.nl';
        $super->email_verified_at = now();
        $super->remember_token = \Str::random(10);
        $super->password = env('SUPER_ADMIN_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
        $super->role = 'super-admin';
        $super->api_token = \Str::random(60);
        $super->save();
    }
}

<?php
namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create(
            [
                'role' => UserRole::VENDOR
            ]
        );

         User::factory(5)->create(
            [
                'role' => UserRole::CUSTOMER
            ]
        );

         User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example1.com',
            'password' => bcrypt('password'), // password
            'role' => UserRole::CUSTOMER
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // password
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // password
            'role' => UserRole::ADMIN->value,
        ]);


        $this->call([
            CategorySeeder::class,
            VendorSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class
        ]);
    }
}

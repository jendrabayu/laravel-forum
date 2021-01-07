<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $avatar = 'images/avatar/' . time() . uniqid() . '.png';
        Storage::copy('avatar/avatar-' . rand(1, 5) . '.png', 'public/' . $avatar);

        User::create([
            'first_name' => 'Admin',
            'last_name' => '',
            'username' => 'admin123',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'avatar' => $avatar,
            'role' => User::ROLE_ADMIN,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'remember_token' => Str::random(10),
        ]);

        factory(User::class, 50)->create();
    }
}

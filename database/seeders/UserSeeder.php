<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user = new User();
        $user->name = $faker->name();
        $user->email = env('ADMIN_EMAIL');
        $user->phone = $faker->numerify('+380#########');
        $user->position_id = Position::get()->random()->id;
        $user->email_verified_at = now();
        $user->password = Hash::make(env('ADMIN_PASSWORD'));
        $user->remember_token = Str::random(10);
        $user->save();
        User::factory(45)->create();
    }
}

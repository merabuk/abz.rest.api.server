<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arr = [1, 2, 3, 4, 5, 6];
        $r = Arr::random($arr);
        $contents = Storage::get('./img/avatar'.$r.'.jpg');
        $fileName = Str::random(60);
        $path = 'photo/'.$fileName.'.jpg';
        Storage::disk('public')->put($path, $contents);
        $fullUserPhotoPath = env('APP_URL').'/storage/'.$path;
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('+380#########'),//e164PhoneNumber(),
            'position_id' => Position::get()->random()->id,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'photo' => $fullUserPhotoPath,
        ];
    }
}

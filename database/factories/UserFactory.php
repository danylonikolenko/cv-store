<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $role = Role::where('name', 'admin')->first();
        $roleId = null;
        if($role){
            $roleId = $role->id;
        }
        return [
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'), // password
            'deleted' => false,
            'role_id' => $roleId,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [

            ];
        });
    }
}

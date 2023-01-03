<?php


namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_ids = Permission::all()->pluck('id');
        if ($permission_ids->isNotEmpty()) {
            $permission_ids = $permission_ids->toArray();
        } else {
            $permission_ids = [];
        }

        $data = [
            [
                'name' => 'admin',
                'description' => 'role for admin',
                'permission_ids' => json_encode($permission_ids),
            ],
            [
                'name' => 'guest',
                'description' => 'role for guests',
                'permission_ids' => null,
            ]
        ];

        Role::insert($data);
    }

}

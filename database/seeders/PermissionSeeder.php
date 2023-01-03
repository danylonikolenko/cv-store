<?php


namespace Database\Seeders;


use App\Services\Permission\PermissionService;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->permissionService->generate();
    }
}

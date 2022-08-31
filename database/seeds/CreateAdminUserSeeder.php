<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
   public function run()
    {
        $admin = Admin::create([
            'name' => 'CareCover', 
            'email' => 'projectlead@carecover.com',
            'password' => bcrypt('123456')
        ]);
    
        $role = Role::create(['name' => 'projectlead' , 'guard_name' => 'admin']);
        
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $admin->assignRole($role);
    }
}

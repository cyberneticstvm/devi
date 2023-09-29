<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\ConsultationType;
use App\Models\Department;
use App\Models\User;
use App\Models\UserBranch;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DumpData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'branch-list', 'branch-create', 'branch-edit', 'branch-delete',
            'doctor-list', 'doctor-create', 'doctor-edit', 'doctor-delete',
            'patient-list', 'patient-create', 'patient-edit', 'patient-delete',
            'consultation-list', 'consultation-create', 'consultation-edit', 'consultation-delete',
            'medical-record-list', 'medical-record-create', 'medical-record-edit', 'medical-record-delete',
            'appointment-list', 'appointment-todays-list', 'appointment-create', 'appointment-edit', 'appointment-delete',
         ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $user = User::create([
            'name' => 'Vijoy Sasidharan',
            'username' => 'admin', 
            'email' => 'mail@cybernetics.me',
            'mobile' => '9188848860',
            'password' => bcrypt('admin')
        ]);

        $branch = Branch::create([
            'name' => 'Attingal',
            'code' => 'ATL',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $role = Role::create(['name' => 'Administrator']);         
        $permissions = Permission::pluck('id','id')->all();       
        $role->syncPermissions($permissions);         
        $user->assignRole([$role->id]);
        UserBranch::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id
        ]);

        ConsultationType::insert([
            'name' => 'Consultation',
        ]);

        Department::insert([
            'name' => 'Ophthalmology',
        ]);

    }
}

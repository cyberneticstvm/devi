<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\CampType;
use App\Models\ConsultationType;
use App\Models\Department;
use App\Models\Setting;
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
            'export-today-appointments-excel', 'export-today-appointments-pdf',
            'camp-list', 'camp-create', 'camp-edit', 'camp-delete',
            'camp-patient-list', 'camp-patient-create', 'camp-patient-edit', 'camp-patient-delete',
            'document-list', 'document-create', 'document-delete',
            'supplier-list', 'supplier-create', 'supplier-edit', 'supplier-delete',
            'manufacturer-list', 'manufacturer-create', 'manufacturer-edit', 'manufacturer-delete',
         ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $user = User::create([
            'name' => 'eHMS',
            'username' => 'admin', 
            'email' => 'mail@ehms.care',
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

        Setting::insert([
            'company_name' => 'EYE HOSPITAL MANAGEMENT SYSTEM',
            'qr_code_text' => 'https://ehms.care',
            'consultaton_fee_waived_days' => 0,
            'appointment_starts_at' => '9:00:00',
            'appointment_ends_at' => '19:00:00',
            'per_appointment_minutes' => 15,
            'drug_license_number' => NULL,
            'branch_limit' => 0,
            'allow_sales_at_zero_qty' => 0,
            'tax_type' => 'GST',
            'currency' => '₹',
        ]);

        ConsultationType::insert([
            'name' => 'Consultation',
            'fee' => 1,
        ]);

        Department::insert([
            'name' => 'Ophthalmology',
        ]);

        $ctypes = [
            'Club', 'School', 'Residence Association', 'Other',
        ];
        foreach($ctypes as $ctype):
            CampType::insert([
                'name' => $ctype,
            ]);
        endforeach;

    }
}

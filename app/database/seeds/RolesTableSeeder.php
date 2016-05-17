<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/03/15
 * Time: 3:58 PM
 */
use Carbon\Carbon;

class RolesTableSeeder extends Seeder{
    public function run()
    {
        $role = new Role;
        $role->role = 'Administrator';
        $role->created_at = Carbon::now();
        $role->updated_at = Carbon::now();
        $role->save();

        $role = new Role;
        $role->role = 'Teacher';
        $role->created_at = Carbon::now();
        $role->updated_at = Carbon::now();
        $role->save();

        $role = new Role;
        $role->role = 'Accountant';
        $role->created_at = Carbon::now();
        $role->updated_at = Carbon::now();
        $role->save();

        $role = new Role;
        $role->role = 'Student';
        $role->created_at = Carbon::now();
        $role->updated_at = Carbon::now();
        $role->save();
    }
}

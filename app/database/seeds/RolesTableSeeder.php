<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/03/15
 * Time: 3:58 PM
 */

class RolesTableSeeder extends Seeder{
    public function run()
    {
        $role = new Role;
        $role->role = 'Administrator';
        $role->save();

        $role = new Role;
        $role->role = 'Teacher';
        $role->save();

        $role = new Role;
        $role->role = 'Accountant';
        $role->save();

        $role = new Role;
        $role->role = 'Student';
        $role->save();
    }
} 
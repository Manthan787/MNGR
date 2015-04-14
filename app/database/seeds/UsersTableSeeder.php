<?php

class UsersTableSeeder extends Seeder
{
	public function run()
	{
		
		//Creating three default roles
		$user=new User;
		$user->firstname="Ajay";
		$user->lastname="Shah";
		$user->email="ajayshah@gmail.com";
        $user->password = admin;
        $user->role_id = 1;
		$user->save();
		

	}
}
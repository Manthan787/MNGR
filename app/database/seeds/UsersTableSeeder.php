<?php
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
	public function run()
	{

		//Creating three default roles
		$user = new User;
		$user->id = 1;
		$user->firstname="Ajay";
		$user->lastname="Shah";
		$user->email="ajayshah8@yahoo.com";
    $user->password = "admin";
    $user->role_id = 1;
		$user->created_at = Carbon::now();
		$user->updated_at = Carbon::now();
		$user->temp_password = "nslbnslbn";
		$user->student_id = 0;
		$user->remember_token = "vnslbnlsbn";
		$user->save();


	}
}

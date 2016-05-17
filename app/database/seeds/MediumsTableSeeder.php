<?php
use Carbon\Carbon;

class MediumsTableSeeder extends Seeder
{
	public function run()
	{
		$medium = new Medium;
		$medium->medium = 'Gujarati';
		$medium->created_at = Carbon::now();
		$medium->updated_at = Carbon::now();
		$medium->save();

		$medium = new Medium;
		$medium->medium = 'English';
		$medium->created_at = Carbon::now();
		$medium->updated_at = Carbon::now();
		$medium->save();

	}
}

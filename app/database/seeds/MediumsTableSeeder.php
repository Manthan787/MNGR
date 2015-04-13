<?php


class MediumsTableSeeder extends Seeder
{
	public function run()
	{
		$medium = new Medium;
		$medium->medium = 'Gujarati';
		$medium->save();

		$medium = new Medium;
		$medium->medium = 'English';
		$medium->save();

	}
}
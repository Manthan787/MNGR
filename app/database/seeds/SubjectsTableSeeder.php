<?php


class SubjectsTableSeeder extends Seeder
{
	public function run()
	{
		$subject=new Subject;
		$subject->name="Physics";
		$subject->save();

		$subject=new Subject;
		$subject->name="Chemistry";
		$subject->save();

		$subject=new Subject;
		$subject->name="Maths";
		$subject->save();

		$subject=new Subject;
		$subject->name="Computer";
		$subject->save();

		
	}
}
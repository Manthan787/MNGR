<?php namespace mngr\Repositories\Questions;

interface QuestionsRepository{


	public function getAll();
	public function getById($id);
	public function add(array $input);
	/*
	public function edit(array $input);
	public function delete($id);
	*/

}
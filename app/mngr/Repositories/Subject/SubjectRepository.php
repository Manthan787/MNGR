<?php namespace mngr\Repositories\Subject;

interface SubjectRepository{


	public function create(array $input);
	public function update(array $input);
	public function delete($id);

	
}
<?php 
namespace mngr\Repositories\User;

interface UserRepository{
    
    public function create(array $input);
    public function update(array $input);
    public function delete($id);

    /**
     * Get all the users.
     * 
     * @return User
     */
	//public function getAll();
	/**
	 * Get Administrators.
	 * 
	 * @return User
	 */
	//public function getAdmins();
	/**
	 * Get Teachers
	 * 
	 * @return User
	 */
	//public function getTeachers();
	/**
	 * Find User By Id.
	 * @param  Int
	 * @return User
	 * 
	 */
	//public function find($id);


	
    
    
}

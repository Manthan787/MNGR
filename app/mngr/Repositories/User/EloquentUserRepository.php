<?php namespace mngr\Repositories\User;
use User;
use mngr\Exceptions\FireInTheHoleException;

class EloquentUserRepository implements UserRepository{
    
   protected $user;
    
    
    public function __construct(User $user)
    {
        $this->user=$user;
    }
    public function create(array $input){

        try
        {     
                    $user = $this->user->create([
                    'firstname' => $input['firstname'],
                    'lastname'  => $input['lastname'],
                    'email'     => $input['email'],
                    'password'  => $input['password']
                    ]);
                if($user && isset($input['role_id']))
                {
                    $u=User::findorFail($user->id);
                    $u->roles()->attach($input['role_id']);
                }

                if(! $user)
                {
                    return false;
                }

                return true;
        }
        catch(\Exception $e)
        {
            \Log::error('Something went wrong in UserRepository - create():'.$e->getMessage());
            throw new FireInTheHoleException("Looks like there was an error while adding the user. Please Try Again.");
        }
    }
    
    public function update(array $input){
        
        echo "Updating the user";
    }
    
    public function delete($id){
        echo "deleting user";
        
    }
    
}
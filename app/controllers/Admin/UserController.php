<?php
namespace Admin;
use BaseController;
use Response;
use Exception;
use Input;
use mngr\Repositories\User\UserRepository;
use mngr\Services\Forms\User\AddUserForm;
use mngr\Exceptions\FireInTheHoleException;

class UserController extends BaseController{

    protected $user;
    protected $form;

    public function __construct(UserRepository $user,AddUserForm $form )
    {

        $this->user = $user;
        $this->form = $form;
    }

    public function index()
    {
        //What to do?!
    }

    public function store()
    {
    	if($this->form->valid(Input::all()))
        {
            //If valid then create user

            try
            {
                if($this->user->create(Input::all()))
                {
                    return Response::json(['message' => 'User Successfully Created!'],200);
                }
                else
                {
                    //Redirect
                }
            }
            catch(FireInTheHoleException $e)
            {
                Log::error("Fire In The Hole:".$e->getMessage());
                //Redirect Somewhere!
            }

        }
        else
        {
            return Redirect::to('/')->withErrors($this->form->errors());
        }
    }

}

<?php
namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;


class UserController {
    protected $db;

    public function __construct(){
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }
    /**
     * Show login page
     * 
     * return void
     */
    public function login(){
        viewPartials('users/login');
    }
    /**
     * Show create page
     * 
     * return void
     */
    public function create(){
        viewPartials('users/create');
    }
    /**
     * Store user to db 
     * 
     * return void
     */
    public function store(){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];

        $errors = [];
        //Validation
        if(!Validation::email($email)){
            $errors['email'] = 'Please enter a valid email address';
        }
        if(!Validation::string($name,2,50)){
            $errors['name'] = 'Name must be 2 and 50 characters';
        }
        if(!Validation::string($password,6,50)){
            $errors['name'] = 'Password must be at least characters';
        }
        if(!Validation::match($password,$passwordConf)){
            $errors['password_confirmation'] = 'Password do not match';
        }

        if(!empty($errors)){
            viewPartials('users/create',[
                'errors'=>$errors,
                'user'=>[
                    'name'=>$name,
                    'email'=>$email,
                    'city'=>$city,
                    'state'=>$state
                ]
            ]);
            exit;
        }
        //check if email exist
        $params = [
            'email'=>$email,
        ];
        $user = $this->db->query('SELECT * FROM users WHERE email = :email',$params)->fetch();
        if($user){
            $errors['email']='That email already exist';
            viewPartials('users/create', [
                'errors'=>$errors
            ]);
            exit;
        }
        //create user account
        $params = [
            'name'=>$name,
            'email'=>$email,
            'city'=>$city,
            'state'=>$state,
            'password'=>password_hash($password,PASSWORD_DEFAULT)
        ];
        $this->db->query('INSERT INTO users (name,email,city,state,password) VALUES(:name,:email,:city,:state,:password)',$params);
        //Get new User ID
        $userid = $this->db->conn->lastInsertId();
        //Set user session
        Session::set('user',[
            'id'=>$userid,
            'name'=>$name,
            'email'=>$email,
            'city'=>$city,
            'state'=>$state
        ]);
        // inspectAndDie(Session::get('user'));
        redirect('/');

    }

    /**
     * Logout a user and kill session
     * return void
     */
    public function logout(){
        Session::clearAll('user');
        $params = session_get_cookie_params();
        setcookie('PHPSESSID','',time()-86400,$params['path'],$params['domain']);
        redirect('/');
    }
    /**
     * authenticate a user with email and password
     * return void
     */
    public function authenticate(){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = [];

            if(!Validation::email($email)){
                $errors['email'] = 'Please enter a valid email';
            }
            if(!Validation::string($password,6,50)){
                $errors['password'] = 'Password must be at least 6 characters';
            }
            if(!empty($errors)){
                viewPartials('users/login',[
                    'errors'=>$errors
                ]);
                exit;
            }
        //check for email 
        $params = [
            'email'=>$email,
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email',$params)->fetch();

            if(!$user){
                $errors['email'] = 'Incorrect credentials email';
                viewPartials('users/login',[
                    'errors'=>$errors
                ]);
                exit;
            }
        //check if password is correct
            if(!password_verify($password,$user->password)){
                if(!$password){
                $errors['password'] = 'Incorrect credentialsss';
                viewPartials('users/login',[
                    'errors'=>$errors
                ]);
                exit;
            }
        }
        //set user session
        Session::set('user',[
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'city'=>$user->city,
            'state'=>$user->state
        ]);
        // inspectAndDie(Session::get('user'));
        redirect('/');
        // inspectAndDie('login');
    }
    


}

?>
<?php 
require_once "../models/User.php";
require_once "../helpers/Session.php";
class UserController{
    private User $user;
    public function __construct(User $user){
        $this->user = $user;
    }
    public function register(){
        $data = [
            "username" => trim($_POST["username"]),
            "email" => trim($_POST["email"]),
            "password" => trim($_POST["password"]),
            "confirmed" => trim($_POST["confirmed"]),
        ];

        foreach($data as $item){
            if(empty($item)){
                Session::flash("error", "you need to fill all inputs");
                Session::redirect("../register.php");
                break;
            }
        }
        if(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
            Session::flash("error", "you need to enter right email format");
            Session::redirect("../register.php");
        }
        
        if(strlen($data['password']) < 6){
            Session::flash("error", "password must be more than 6 characters");
            Session::redirect("../register.php");
        }elseif($data['password'] != $data['confirmed']){
            Session::flash("error", "passwords don't match");
            Session::redirect("../register.php");
        }
        
        if($this->user->email_exist($data['email'])){
            Session::flash("error", "email already exist");
            Session::redirect("../register.php");
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        ($this->user->create($data)) ? Session::redirect("../login.php") : die("something went wrong");
    }


    public function login(){
        $data = [
            "email" => trim($_POST["email"]),
            "password" => trim($_POST["password"]),
        ];

        foreach($data as $item){
            if(empty($item)){
                Session::flash("error", "you must fill all inputs");
                Session::redirect("../login.php");
            }
        }
        $data['password'] = password_verify($data['password'], $this->user->hashed_password($data['email']));
        if($this->user->available_user($data['email']) and $data['password']):
            $logged_in_user =  $this->user->available_user($data['email'], $data['password']);
            if($logged_in_user){
                Session::put("id", $logged_in_user->id);
                Session::put("name", $logged_in_user->username);
            }
            Session::redirect("../index.php");
        else:
            Session::flash("error", "data is wrong");
            Session::redirect("../login.php");
        endif; 
    }

    public function logout(){
        unset($_SESSION["id"]);
        unset($_SESSION["name"]);
        session_destroy();
        Session::redirect("../login.php");
    }


}

$user = new UserController(new User);

if($_SERVER["REQUEST_METHOD"] == "POST"):
    if($_POST["type"] == "register"):
        $user->register();
    elseif($_POST["type"] == "login"):
        $user->login();
    endif;
elseif($_SERVER["REQUEST_METHOD"] == "GET"):
    if($_GET["type"] == "logout"):
        $user->logout();
    endif;
endif;


?>
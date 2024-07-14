<?php
require_once "../helpers/Session.php";
require_once "../models/ResetPassword.php";
require_once "../models/User.php";
require_once "../controllers/EmailController.php";
require_once "../interfaces/NotificationInterface.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/SMTP.php";
use PHPMailer\PHPMailer\PHPMailer;

class ResetPasswordController{
    private $user;
    private $rest_password;
    private $email;
    private $mail;

    public function __construct(User $user, ResetPassword $ResetPassword, NotificationInterface $email){
        $this->user = $user;
        $this->rest_password = $ResetPassword;
        $this->email = $email;
    }

    public function send_email(){
        $this->email->send();
    }

    public function change_password(){
        $selector = $_POST["selector"];
        $validator = $_POST["validator"];
        $data = [
            "password" => htmlspecialchars(trim($_POST["password"])),
            "confirmed" => htmlspecialchars(trim($_POST["confirmed"])),
        ];
        if(empty($_POST["password"]) or empty($_POST["confirmed"])){
            Session::flash("error", "you must enter the password");
            Session::redirect("../create_new_password.php?selector=$selector&validator=$validator");
        }elseif($data['password'] != $data['confirmed']){
            Session::flash("error", "the password does not match");
            Session::redirect("../create_new_password.php?selector=$selector&validator=$validator");
        }elseif(strlen($data['password']) < 6){
            Session::flash("error", "the password must be 6 characters at least");
            Session::redirect("../create_new_password.php?selector=$selector&validator=$validator");
        }
        
        $current = date("U");
        $row = $this->rest_password->reset_password_row($selector, $current);
        if(!$row){
            Session::flash("error", "the link is no longer valid");
            Session::redirect("../create_new_password.php?selector=$selector&validator=$validator");
        }
        
        $token = hex2bin($validator);
        if(!password_verify($token, $row->password_reset_token)){
            Session::flash("error", "you need to resubmit your request");
            Session::redirect("../create_new_password.php?selector=$selector&validator=$validator");
        }
        
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $updated =$this->user->update($password);
        if(!$updated){
            Session::flash("error", "you need to resubmit your request");
            Session::redirect("../create_new_password.php?selector=$selector&validator=$validator");
        }

        Session::flash("success", "password updated");
        Session::redirect("../login.php");
        
    }

    

}

$reset_password =  new ResetPasswordController(new User, new ResetPassword, new EmailController(new ResetPassword()));
if($_POST["type"] == "reset_password"){
    $reset_password->send_email();
}elseif($_POST["type"] == "change_password"){
    $reset_password->change_password();
}



?>
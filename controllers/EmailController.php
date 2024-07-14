<?php 
require_once "../helpers/Session.php";
require_once "../interfaces/NotificationInterface.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/SMTP.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController implements NotificationInterface{
    private $reset_password;
    private $mail;
    public function __construct(ResetPassword $ResetPassword){ 
        $this->reset_password = $ResetPassword;
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'sandbox.smtp.mailtrap.io';
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 587;
        $this->mail->Username = '9a926a28072261';
        $this->mail->Password = '41d82929928c20';
        $this->mail->SMTPSecure = 'tls';
    }
    public function send(){
        $email = trim($_POST["email"]);
        if(empty($email)){
            Session::flash("error", "you must enter an email");
            Session::redirect("../reset_password.php");
        }

        if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
            Session::flash("error", "enter valid email format");
            Session::redirect("../reset_password.php");
        }

        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $hashed_token = password_hash($token, PASSWORD_DEFAULT);
        $url = "http://localhost/login-system/create_new_password.php?selector=$selector&validator=" . bin2hex($token);
        $expires = date("U") + 1800;

        if(!$this->reset_password->delete($email)){
            die("There is an error");
        }
        if(!$this->reset_password->insert($email, $selector, $hashed_token, $expires)){
            die("There is an error");
        }        

        $subject = "Reset your password";
        $message = "<p>we recieved a password reset request.</p>";
        $message .= "<p>here is your password reset link: </p>";
        $message .= "<a href='".$url."'>" . "click here" . "</a>";
        try{
            $this->mail->setFrom('TheBoss@gmail.com');
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->addAddress($email);
            $this->mail->send();
        }catch(Exception $e){
            echo "something is wrong";
        }
        Session::flash("success", "check your email");
        Session::redirect("../reset_password.php");
    }
}
?>
<?php
require_once "../db/Database.php"; 
class ResetPassword{
    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }

    public function delete($email){
        $this->conn->prepare("DELETE FROM `password_reset` WHERE `password_reset_email` = :email");
        $this->conn->bind_value(":email", $email);
        return $this->conn->execute() ? true : false;
    }

    public function insert($email, $selector, $hashed_token, $expires){
        $sql = "SELECT * FROM `users` where `email` = :email";
        $this->conn->prepare($sql);
        $this->conn->bind_value("email", $email);
        $this->conn->execute();
        if($this->conn->row_count() == 1){
            $this->conn->prepare("INSERT INTO `password_reset`(`password_reset_email`, `password_reset_selector`, `password_reset_token`, `password_reset_expires`) VALUES(:email, :selector, :token, :expires)");
            $this->conn->bind_value(":email", $email);
            $this->conn->bind_value(":selector", $selector);
            $this->conn->bind_value(":token", $hashed_token);
            $this->conn->bind_value(":expires", $expires);
            return $this->conn->execute() ? true : false;
        }else{
            echo "this email does not exist";
        }
    }

    public function reset_password_row($selector, $current){
        $sql = "SELECT * FROM `password_reset` where `password_reset_selector` = :selector and `password_reset_expires` >= :current";
        $this->conn->prepare($sql);
        $this->conn->bind_value("selector", $selector);
        $this->conn->bind_value("current", $current);
        $this->conn->execute();
        $row = $this->conn->fetch_one();
        return ($this->conn->row_count() > 0) ? $row : false;
    }


    

    
    
}

?>
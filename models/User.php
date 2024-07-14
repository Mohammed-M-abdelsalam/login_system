<?php
require_once "../db/Database.php";  
require_once "../helpers/Session.php";  
class User{
    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }

    public function create($data){
        $query = "INSERT INTO `users`(`username`, `email`, `user_password`) VALUES(:name, :email, :password)";
        $this->conn->prepare($query);
        $this->conn->bind_value("name", $data['username']);
        $this->conn->bind_value("email", $data['email']);
        $this->conn->bind_value("password", $data['password']);
        return ($this->conn->execute()) ? true : false;
    }

    public function email_exist($email){
        $query = "SELECT * FROM `users` WHERE `email` = :email";
        $this->conn->prepare($query);
        $this->conn->bind_value("email", $email);
        $this->conn->execute();
        $user = $this->conn->fetch_one();
        return ($this->conn->row_count() > 0) ? $user : null;
    }

    // public function hashed_password($email, $password){
    //     $query = "SELECT * FROM `users` WHERE `email` = :email";
    //     $this->conn->prepare($query);
    //     $this->conn->bind_value("email", $email);
    //     $this->conn->execute();
    //     $user = $this->conn->fetch_one(); 
    //     return password_verify($password, $user->password);   
    // }
    public function hashed_password($email){
        $query = "SELECT * FROM `users` WHERE `email` = :email";
        $this->conn->prepare($query);
        $this->conn->bind_value("email", $email);
        $this->conn->execute();
        $user = $this->conn->fetch_one(); 
        return $user->user_password;
    }
    
    public function available_user($email){
        $query = "SELECT * FROM `users` WHERE `email` = :email";
        $this->conn->prepare($query);
        $this->conn->bind_value("email", $email); 
        $this->conn->execute();
        $user = $this->conn->fetch_one();
        return ($this->conn->row_count() > 0) ? $user : null;
    }


    public function update($password){
        $sql = "UPDATE `users` SET user_password = :pwd";
        $this->conn->prepare($sql);
        $this->conn->bind_value("pwd", $password);
        return ($this->conn->execute()) ? true : false;
    }
}
?>
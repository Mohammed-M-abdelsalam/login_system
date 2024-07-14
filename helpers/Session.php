<?php 
if(!isset($_SESSION)){
    session_start();
}
class Session{
    public static function flash($name="", $value=""){
        if(!empty($name)):
            if(!empty($value) and empty($_SESSION[$name])){
                $_SESSION[$name] = $value;
            }elseif(empty($value) and !empty($_SESSION[$name])){
                echo $_SESSION[$name];
                unset($_SESSION[$name]);
            }  
        endif;
    }

    public static function put($name="", $value=""){
        if(!empty($name)):
            if(!empty($value) and empty($_SESSION[$name])){
                $_SESSION[$name] = $value;
            }elseif(empty($value) and !empty($_SESSION[$name])){
                return $_SESSION[$name];
            }  
        endif;
    }

    public static function redirect($location){
        header("location:$location");
        exit();
    }
}
?>
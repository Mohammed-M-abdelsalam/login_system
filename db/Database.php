<?php 


class Database{
    private $pdo;
    private $stmt;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'login_system';

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
         $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
         ];

         try{
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
         }catch(PDOException $e){
            echo "not connected to database:" . $e->getMessage();
         }
    }

   public function prepare($query){
      $this->stmt = $this->pdo->prepare($query);
   }

   public function bind_value($placeholder, $value, $datatype = PDO::PARAM_STR){
      if(is_int($value)):
         $datatype = PDO::PARAM_INT;
      elseif(is_null($value)):
         $datatype = PDO::PARAM_NULL;
      elseif(is_bool($value)):
         $datatype = PDO::PARAM_BOOL;
      else:
         $datatype = PDO::PARAM_STR;
      endif;

      $this->stmt->bindValue($placeholder, $value, $datatype);
   }

   public function execute(){
      return $this->stmt->execute();
   }

   public function fetch_one(){
      return $this->stmt->fetch(PDO::FETCH_OBJ);
   }
   
   public function fetch_all(){
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
   }

   public function row_count(){
      return $this->stmt->rowCount();
   }

}




?>
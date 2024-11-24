<?php

class gbook
{
    public $conn;

    public function __construct()
    {
        include "db.php";   //vloží skript do skriptu
        // připojení k MariaDB / MySQL pomocí PDO
        $dsn = "mysql:host=localhost;dbname=$dbname;port=3336";
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try
        {
            $this->conn = new PDO($dsn, $user, $pass, $options);
        }
        catch(PDOException $e)
        {
            echo "Nelze se připojit k MySQL: ";
            echo $e->getMessage();  //smazat
        }
    }

     public function zapisPrispevek($jmeno,$email,$text)
     {
         $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
         $datum = date("Y-m-d"); //2024-09-17
         try {
             $stmt = $this->conn->prepare("INSERT INTO `gbook` (`id`, `jmeno`, `predmet`, `email`, `text`, `datum`, `IP`) VALUES (NULL, :jmeno, NULL, :email, :text , :datum, :IP);");  //SQL INSERT
             $stmt->bindParam(':jmeno', $jmeno);
             $stmt->bindParam(':email', $email);
             $stmt->bindParam(':text', $text);
             $stmt->bindParam(':IP', $IP);
             $stmt->bindParam(':datum', $datum);
             $stmt->execute();
             // možnost řešit zpětnou vazbu
             return true;
         } catch (PDOException $e) {
             echo "Chyba zápisu do tabulky pocitadlo: ";  //spíše zakomentovat
             echo $e->getMessage();  exit;//zakomentovat
             return false;
         }
     }
     public function vratPrispevky()
 {
     try {
         $stmt = $this->conn->prepare("SELECT `jmeno`,`text`,`datum` FROM `gbook` ORDER BY `gbook`.`id` DESC;");  //SQL INSERT
        // $stmt->bindParam(':jmeno', $jmeno);

         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_OBJ);
         // možnost řešit zpětnou vazbu
         return true;
     } catch (PDOException $e) {
         echo "Chyba zápisu do tabulky pocitadlo: ";  //spíše zakomentovat
         //echo $e->getMessage();  //zakomentovat

     }
 }

}
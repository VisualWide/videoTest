<?php
/**
 * Created by PhpStorm.
 * User: WoodenWang
 * Date: 2017/11/12
 * Time: 9:25
 */
class MysqlDb{
    private $servername=MYSQL_SERVERNAME;
    private $username=MYSQL_USERNAME;
    private $password=MYSQL_PASSWORD;
    private $dbName=MYSQL_DBNAME;
    private $conn;
    /*单例*/
    private static $instance;
    public static function getInstance(){
        if(!self::$instance){
            self::$instance=new Db();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $params=array(
            PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8",
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        );
        $this->conn=new PDO("mysql:host=$this->servername;dbname=".$this->dbName,$this->username,$this->password,$params);

    }
    public function add($sql){
        $results=$this->conn->prepare($sql);
        $results->execute();
        return $results->rowCount();
    }
    public function delete($sql){
        $results=$this->conn->prepare($sql);
        $results->execute();
        return $results->rowCount();
    }
    public function update($sql){
        $results=$this->conn->prepare($sql);
        $results->execute();
        return $results->rowCount();
    }
    public function select($sql){
        $results=$this->conn->prepare($sql);
        $results->execute();
        $arr=$results->fetchAll(PDO::FETCH_ASSOC);

        return $arr;
    }
    public function getCount($sql){
        $results=$this->conn->prepare($sql);
        $results->execute();
        $rowsNumber = $results->fetchColumn();
        return $rowsNumber;
    }



}

<?php
include_once 'DBparams.php';
/**
 * Created by PhpStorm.
 * User: AIR
 * Date: 04.08.2016
 * Time: 19:27
 */
class Category
{
    private $id;
    private $name;
    private $parent_id;
    static private $last_id;//число записей в таблице

    public function __construct($db,$name, $parent_id=0)
    {
        try {
            $this->setName($name);
            $this->setParentID($parent_id);
            $this->setId($db);

            $this->AddToDB($db);//insert created object to the database
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
    /*
 * read number of rows in the table and set as $last_id counter
 */
    public static function setLastID($db)
    {
        try {

            self::$last_id=$db->getCount(get_class());
        }

        catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /*
     * method setting ID as autoincrement
     * @param $db - database to retrieve last ID from
     */
    public function setId($db)
    {
        self::setLastID($db);//retrieve last ID from the database
        $this->id = self::$last_id + 1;//and set the next number as object's ID
        self::$last_id = $this->id;
    }

    public function setName($name)
    {
        if (is_string($name) && !empty($name)){
            $this->name = $name;
        }
        else{
            throw new Exception ('Перевірте правильність значення назви категорії!');
        }
    }

    public function setParentID($parent_id)
    {
        if (is_int($parent_id) and ($parent_id<=self::$last_id)) {

            $this->parent_id = $parent_id;
        }
        else{
            throw new Exception('Перевірте правильність значення загальної категорії!');
        }

    }

    public function getID(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getParentID(){
        return $this->parent_id;
    }

    public static function getLastID(){
        return self::$last_id;
    }

    public function PrintInfo(){
        echo "Category name: ".$this->getName().'<br>';
        echo "Category ID: ".$this->getID().'<br>';
        echo "Parent ID: ".$this->getParentID().'<br>';
        echo "Category ID generator: ". self::getLastID().'<br><br>';
    }

/*
 * add category created to the database
 * @param $db database to insert the object to
 */
    protected function AddToDB($db)
    {
        try
        {
            $query = "INSERT INTO `category`(`ID`, `Name`, `ParentID`) VALUES ('{$this->id}','{$this->name}','{$this->parent_id}')";
            $result = $db->query($query);
            //return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            echo "Please check parameters!";
        }
    }

/*
    public function AddCategory($name, $id=null, $parent_id=0){

        $this->name=$name;
        $this->id=$id;
        $this->parent_id=$parent_id;

        if (!($params=GetDBParams()))
        {
            die('Could not load DB parameters');
        }

        $connect=mysqli_connect($params[0],$params[1],$params[2],'mydb2');

        $query="INSERT INTO `category`(`ID`, `Name`, `ParentID`) VALUES ($id,$name,$parent_id)";

        $result=mysqli_query($connect,$query);

        if (!$result)
        {
            die('Not valid SQL query');

        }
        mysqli_free_result($result);
    }*/

    public static function FindCategory($id,$db){

        try {
            $query = "SELECT * from `category` where `ID`=$id";
            $result = $db->query($query);
            //return $result;
        }

        catch (Exception $e){
        echo $e->getMessage();
        }
    }



}
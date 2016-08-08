<?php

/**
 * Created by PhpStorm.
 * User: AIR
 * Date: 04.08.2016
 * Time: 20:33
 */
class Item
{
    private $id;
    private $categoryID;
    private $name;
    private $price;
    static private $last_id;

    public function __construct($db,$categoryID, $name, $price)
    {
        try {
            $this->setCategoryID($db,$categoryID);
            $this->setName($name);
            $this->setPrice($price);

            $this->setId($db);

            $this->AddToDB($db);//insert created object to the database

        }
        catch (Exception $e)
        {
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

    public function getId()
    {
        return $this->id;
    }

    public static function getLastId()
    {
        return self::$last_id;
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

    public function getCategoryID()
    {
        return $this->categoryID;
    }

    public function setCategoryID($db,$categoryID)
    {
        if (is_int($categoryID) && ($this->categoryID)<=($db->getCount('category')) && (!empty($db->getCount('category'))))
        {
            $this->categoryID = $categoryID;
            }
        else
        {
            throw new Exception ('Перевірте правильність значення категорії!');
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (is_string($name)&& !empty($name)) {
                $this->name = $name;
        }
        else{
            throw new Exception("Перевірте правильність значення назви товару!");
        }
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        if (is_float($price) && !empty($price))
        {
            $this->price = $price;
        }
        else
        {
            throw new Exception("Перевірте правильність значення ціни товару!");
        }
    }

    public function PrintInfo(){

        echo "Item ID: ".$this->getId().'<br>';
        echo "Category ID: ".$this->getCategoryID().'<br>';
        echo "Item name: ".$this->getName().'<br>';
        echo "Price: ".$this->getPrice().'<br>';
        echo "Item ID generator: ". self::getLastId().'<br><br>';
    }

    /*
     * add item created to the database
     * @param $db database to insert the object to
     */
    public function AddToDB($db)
    {
        try {
            $query = "INSERT INTO `item`(`ID`, `CategoryID`, `Name`, `Price`) VALUES ('{$this->getId()}','{$this->getCategoryID()}','{$this->getName()}','{$this->getPrice()}')";
            $result = $db->query($query);
            //return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            echo "Please check parameters!";
        }

    }

    public static function FindItem($id,$db)
    {

        try
        {
            $query = "SELECT * from `item` where `ID`=$id";
            $result = $db->query($query);
            //return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

}
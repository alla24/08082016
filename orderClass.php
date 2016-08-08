<?php

/**
 * Created by PhpStorm.
 * User: AIR
 * Date: 06.08.2016
 * Time: 13:14
 */
class order
{
    private $id;

    private $date;
    private $customerID;
    private $itemID;
    private $numberOfItems;
    static private $last_id=5;

    public function __construct($db,$customerID, $itemID, $numberOfItems)
    {
        try
        {
            $this->setDate();
            $this->setCustomerID($db,$customerID);
            $this->setItemID($db,$itemID);
            $this->setNumberOfItems ($numberOfItems);
            $this->setId($db);

            $this->AddToDB($db);//insert created object to the database
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function getId()
    {
        return $this->id;
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

    public function getDate()
    {
        return $this->date;
    }

    public function setDate()
    {
        $this->date = date('Y-m-d H:i:s');//current timestamp
    }

    public function getCustomerID()
    {
        return $this->customerID;
    }

    public function setCustomerID($db,$customerID)
    {
        if (is_int($customerID) && $customerID<=($db->getCount('customer')) && !empty($customerID))
        {
            $this->customerID = $customerID;
        }

        else
        {
            throw new Exception("Перевірте правильність даних замовника!");
        }
    }

    public function getItemID()
    {
        return $this->itemID;
    }

    public function setItemID($db,$itemID)
    {
        if (is_int($itemID) && $itemID<=($db->getCount('item')) && !empty($itemID))
        {
            $this->itemID = $itemID;
        }

        else
        {
            throw new Exception("Перевірте правильність даних товару!");
        }
    }

    public function getNumberOfItems()
    {
        return $this->numberOfItems;
    }

    public function setNumberOfItems($numberOfItems)
    {
        if (is_int($numberOfItems)&& !empty($numberOfItems))
        {
            $this->numberOfItems = $numberOfItems;
        }
        else
        {
            throw new Exception("Перевірте правильність кількості замовлених товарів!");
        }
    }

    public function PrintInfo(){

        echo "Order ID: ".$this->getId().'<br>';
        echo "Date: ".$this->getDate().'<br>';
        echo "Customer ID: ".$this->getCustomerID().'<br>';
        echo "Item ID: ".$this->getItemID().'<br>';
        echo "Number of items ordered: ".$this->getNumberOfItems().'<br>';
        echo "Order ID generator: ". self::getLastId().'<br><br>';
    }

    public function AddToDB( $db)
    {
        try
        {
            $query = "INSERT INTO `order`(`ID`, `Date`, `CustomerID`, `ItemID`, `NumberOfItems`) VALUES
                      ('{$this->getID()}','{$this->getDate()}','{$this->getCustomerID()}','{$this->getItemID()}','{$this->getNumberOfItems()}')";
            $result = $db->query($query);
            //return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            echo "Please check parameters!";
        }
    }

    public static function FindOrder($id,$db)
    {
        try
        {
            $query = "SELECT * from `order` where `ID`=$id";
            $result = $db->query($query);
            //return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

}
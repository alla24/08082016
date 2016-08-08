<?php

/**
 * Created by PhpStorm.
 * User: AIR
 * Date: 04.08.2016
 * Time: 20:54
 */
class customer
{
    private $id;
    private $name;
    private $surname;
    private $phone;
    private $email;
    private $address;
    static private $last_id=5;

    public function __construct($db,$name, $surname, $phone,$email,$address)
    {
        try
        {
            $this->setName($name);
            $this->setSurname($surname);
            $this->setPhone($phone);
            $this->setEmail($email);
            $this->setAddress($address);
            $this->setId($db);

            $this->AddToDB($db);//insert created object to the database
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            echo "Please check parameters!";
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (is_string($name) && !empty($name))
        {
            $this->name = $name;
        }
        else
        {
            throw new Exception("Перевірте правильність імені замовника!");
        }
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {


        if (is_string($surname) && !empty($surname))
        {
            $this->surname = $surname;
        }
        else
        {
            throw new Exception("Перевірте правильність прізвища замовника!");
        }

    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        if (is_string($phone)&& !empty($phone))
        {
            $this->phone = $phone;
        }
        else
        {
            throw new Exception("Перевірте правильність назви міста!");
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (is_string($email) && !empty($email))
        {
            $this->email = $email;
        }
        else
        {
            throw new Exception("Перевірте правильність назви вулиці!");
        }
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        if (is_string($address) && !empty($address))
        {
            $this->address = $address;
        }
        else
        {
            throw new Exception("Перевірте правильність вказаного номеру будинку!");
        }
    }

    public function PrintInfo(){

        echo "Customer ID: ".$this->getId().'<br>';
        echo "Full name: ".$this->getName().' '.$this->getSurname().'<br>';
        echo "Phone: ".$this->getPhone().'<br>';
        echo "Email: ".$this->getEmail().'<br>';
        echo "Address: ".$this->getAddress().'<br>';
        echo "Item ID generator: ". self::getLastId().'<br><br>';
    }

    public function AddToDB( $db)
    {
        try
        {
            $query = "INSERT INTO `customer`(`ID`, `Name`, `Phone`, `Email`, `Address`) VALUES
            ('{$this->getID()}',CONCAT('{$this->getName()}',' ','{$this->getSurname()}'),'{$this->getPhone()}','{$this->getEmail()}','{$this->getAddress()}')";


            $result = $db->query($query);
            //return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            echo "Please check parameters!";
        }
    }

    public static function FindCustomer($id,$db)
    {
        try
        {
            $query = "SELECT * from `customer` where `ID`=$id";
            $result = $db->query($query);
            //return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public static function FindCustomerByCity($city,$db)
    {
        try
        {
            $query = "SELECT * from `customer` where `Address` like '%$city%'";
            $result = $db->query($query);
            //return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
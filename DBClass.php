<?php

/**
 * Created by PhpStorm.
 * User: AIR
 * Date: 06.08.2016
 * Time: 11:44
 */
class DB
{

    protected $connection;//field with established connection to the database

    /*
     * create new database connection according to the provided parameters
     */
    public function __construct($host,$user,$password,$db){

        $this->connection=mysqli_connect($host,$user,$password,$db);

        $this->query("SET NAMES UTF8");//set encoding

        if (!$this->connection){
            throw new Exception('Could not connect to database!');
        }

    }

    /*
     * execute query to the database
     * @param $sql string with SQL query
     */
    public function query($sql){

        //return false if no connection established yet
        if (!$this->connection){
            return false;
        }

        $result= mysqli_query($this->connection,$sql);

       //if there was an error return a string description of the last error
        if (mysqli_error($this->connection)){
            throw new Exception(mysqli_error($this->connection));
        }

        //if query returns bool value return this value, no data
        if (is_bool($result)){
            //echo $result;
            return $result;
        }

        //extract result into an array and return the result
        $data=array();
        while ($row=mysqli_fetch_assoc($result)){
           $data[]=$row;//add new element to the array end
        }

        mysqli_free_result($result);
        $this->printQuery($data);//!!!!!
        return $data;
    }

    /*
     * escape query symbols to protect database from SQL injection
     * @param $sql string with sql query
     * @return escape string
     */
    public function escape($sql){

        mysqli_escape_string($this->connection,$sql);

    }

    /*
 * print result of query to the database as table
 * @param $result array returned from function query($sql)
 */
    private function printQuery($result){

        if (!$result) {
            die('Not valid SQL query');

        }

        $keys=array_keys($result[0]);//extract column names as keys from the resulting associative array

        echo "<table style=\"text-align:center;\">";
        echo "<tr style='background-color:#2980B9;color:#ffffff;'>";
        foreach ($keys as $key){
            echo "<th style='padding:10px';> " . $key . " </th>";
        }
        echo "</tr>";

        $arrColors = ['#E0E6F8', '#F7F8E0', '#A9BCF5'];
        $i = 0;

        foreach ($result as $row) {
            $color = $arrColors[$i % (Count($arrColors))];


            echo "<tr style='background-color: $color'>";
            foreach ($keys as $key){
            echo "<td style='padding:10px';><em> " . $row[$key] . " </em></td>";
            }
          "</tr>";
            $i++;

        }
        echo "</table>";
    }

    public function getCount($table)
    {
        try {
            $query = "SELECT count(ID) FROM `$table`";
            $result = $this->query($query);
            if (!empty($result)){
                return $result[0]['count(ID)'];
            }
            else{
                throw new Exception("Не вдалося підрахувати кількість записів в таблиці. Перевірте параметри запиту!");
            }
        }

        catch (Exception $e){
            echo $e->getMessage();
        }
    }


}
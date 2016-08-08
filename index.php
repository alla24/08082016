<!DOCTYPE html>
<html>
<head>
    <title>Робота з класами та БД</title>
    <meta charset='utf-8'>
</head>
<body style="background-color: #ECF0F1;font-family:verdana;">

<?php
/**
 * Created by PhpStorm.
 * User: AIR
 * Date: 04.08.2016
 * Time: 19:46
 */
include_once 'DBparams.php';
include_once 'DBClass.php';
include_once 'categoryClass.php';
include_once 'customerClass.php';
include_once 'itemClass.php';
include_once 'orderClass.php';

//create connection to database

if (!($params=GetDBParams()))
{
    die('Could not load DB parameters');
}

//try establishing connection
try{

    $db=new DB($params[0],$params[1],$params[2],'myDB2');
}

catch (Exception $e){//catch exception thrown by constructor if unsuccessful and print the message

    echo $e->getMessage();
    return;
}

/*
try{
    $item=new Item($db,6,'new item',199.5);
    $item->PrintInfo();

    $order=new Order($db,4,5,2);
    $order->PrintInfo();

    $customer=new customer($db,'Ольга','Мельник','0506423625','o.mekn@gmail.com','м. Київ, вул. Гарматна, 2/32');
    $customer->PrintInfo();
}
catch (Exception $e){
    echo $e->getMessage();
}*/



echo Category::FindCategory(1,$db);
echo '<br>';
echo Item::FindItem(23,$db);
echo '<br>';
echo Order::FindOrder(4,$db);
echo '<br>';

//show Customers from Kyiv
echo "<h1>Всі замовники з м. Києва</h1>";
echo Customer::FindCustomerByCity('Київ',$db);


?>

</body>
</html>


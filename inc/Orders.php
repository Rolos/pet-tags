<?php
/*
 * This file generate the orders when submited from tagBuilder
 * saving them in the orders database
 * 
 */
require_once 'Conn.php';

if(isset($_POST['vtagType']) && isset($_POST['vuser']) && isset($_POST['vemail']) && isset($_POST['vTotal']) ){
            
    
    $first = mysqli_query($con, 'SELECT Product FROM products WHERE id= ' . $_POST['vtagType'] ) or die('error getting the product');
    $sec = mysqli_fetch_array($first);
    $type = $sec['Product'] ;
    $user = mysqli_real_escape_string($con, $_POST['vuser']);
    $email = mysqli_real_escape_string($con, $_POST['vemail']);
    $total = mysqli_real_escape_string($con, $_POST['vTotal']);
    $datev = date('D j \, M Y h:i:s A'); 
    
    $query = "INSERT INTO orders(EbayUser, Email, Date, Product, Total_Quantity, Order_Status) values('$user', '$email', '$datev', '$type', '$total', '0')"; 
    
    mysqli_query($con, $query) or die('error creating the order' . mysqli_error($con));
    
    $query2 = "SELECT id from orders where EbayUser = '$user' And Date = '$datev'" ;
    $result = mysqli_query($con, $query2) or die('error getting the id ' . mysqli_error($con));
    
    while($ids = mysqli_fetch_array($result)    ){
        echo $ids['id'];
    }
        
    
    
}else{
    echo '<h1 class="adminError">You are not athorized to see this page</h1>';
}
?>

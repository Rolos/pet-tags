<?php

/*
 * This script generate the orders and reload them after the update
 * 
 */
require_once '../inc/Conn.php';

if(!isset($_POST['control']) || $_POST['control'] != 1){
        $home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
        header('Location: '.$home_url);
        
}else{      
    if($_POST['vid'] == '/' ){        
        $query = "SELECT * FROM orders";                           
    }else{        
        $id = $_POST['vid'];
        $value = $_POST['vValue'];
        $query = "SELECT * FROM orders WHERE $id LIKE '$value%'";        
    }              
        $result = mysqli_query($con, $query) or die('error getting the orders '. mysqli_error($con));
        
        if(mysqli_num_rows($result) < 1){
            echo 'No result was found';
        }  else {
            $i = 1; ///to see if the row is pair or not

             echo '<table class="head"><tr><th>Id</th><th>Ebay User</th><th>Email</th><th>Total</th><th>Order type</th><th>Date</th>'.
                     '<th>Report</th><th>EbayId</th><th>Status</th><th>Notes</th></tr>';

            while($orders = mysqli_fetch_array($result)){    
                $isRead = $orders['is_read' ] == 0? '; font-weight: bold; font-style: oblique"' : '"';
                $style = $i%2 == 0? 'style="background-color: #fff'. $isRead : 'style= "background-color: #eee' . $isRead ; 
                $status = $orders['Order_Status'] == 0 ? 'Not Done' : 'Done';            

                echo '<tr '. $style  .'  ><td><span id="'.$orders['id']. '" class="OrderId" title="'.   $orders['Product']. '">'.$orders['id']. '</span></td><td>'.$orders['EbayUser']. 
                    '</td><td>'.$orders['Email']. '</td><td>'.$orders['Total_Quantity']. '</td>'.
                        '<td>'.$orders['Product']. '</td><td>'.$orders['Date']. '</td><td>'.   $orders['Report']. '</td><td>'   .$orders['EbayId'].    '</td>'.
                        '<td>'.$status. '</td><td>'.$orders['Notes']. '</td></tr>';

                $i++;

            }
            echo '</table>';
        }
        
}
?>

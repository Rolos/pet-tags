<html>
    <head>
        <meta charset="utf-8"/> 
      <link rel="icon" href="img/favicon.ico"/>
      <link rel="apple-touch-icon" href="img/apple-touch-icon.png"/>
      <link rel="stylesheet" href="../css/style.css"/>  
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>     
      <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
      <script src="Admin.js"></script>
      <title>Real Engraving | Admin</title>

    </head>

    <body>
<?php
/*this file will receive the Order id and select from the database all the orders details with this id
 * 
 * 
 */
require_once '../inc/Conn.php';

if(isset($_POST['Oid']) && isset($_POST['Type'])){
    $OrderId = $_POST['Oid'];
    $type = $_POST['Type'];
    
    if($type == 'Medical'){        
        $query = "SELECT Od.Order_id OId, Od.frontEngraving Front, Od.backEngraving Back, Od.image_id ImgId, Od.pet_type pet, ".
            "Sh.Name Shape, S.Name Size, C.Color Color, C2.Color scolor  FROM order_details Od INNER JOIN  shapes Sh ON Sh.id = Od.Shapes_id ".
            "JOIN sizes S ON S.id = Od.Sizes_id JOIN colors C ON C.id = Od.Colors_id JOIN colors C2 ON   C2.id = Od.Silencer_color_id WHERE Order_id = $OrderId ";          
        
    }else{
      $query = "SELECT Od.Order_id OId, Od.frontEngraving Front, Od.backEngraving Back, Od.image_id ImgId, Od.pet_type pet, ".
            "Sh.Name Shape, S.Name Size, C.Color Color  FROM order_details Od INNER JOIN  shapes Sh ON Sh.id = Od.Shapes_id ".
            "JOIN sizes S ON S.id = Od.Sizes_id JOIN colors C ON C.id = Od.Colors_id  WHERE Order_id = $OrderId ";  
        
    }    
    
    $result = mysqli_query($con, $query) or die('error gettin the details '. mysqli_error($con) );
    
    $i = 1;    
    
    echo '<table id="ODetails" class="head"><tr><th>Order</th><th>Shapes</th><th>Sizes</th><th>Colors</th><th>Front</th>' ;
    
    if($type == 'Medical'){
        echo '<th>Silencer</th>';
    }else if($type ==   'DoubleSided'){
        echo '<th>Back</th><th>Img</th>';
    }else if($type == 'Random' || $type == '100Random' || $type == '50Random' || $type == '25Random' || $type == '10Random' || $type == '100Random'){
        echo '<th>Pet type</th>';
    }
    
    while($Details = mysqli_fetch_array($result)){
        $style = $i%2 == 0? 'style="background-color: #ccc"' : 'style= "background-color: #eee"' ; 
        
            echo '<tr '. $style. '><td>' .  $Details['OId'] .    '</td><td>' .  
                    $Details['Shape'] .    '</td><td>' .  $Details['Size'] .    '</td><td>' .  $Details['Color'] .    '</td><td>' .  $Details['Front'] .    '</td>' ;
    
            if($type == 'Medical'){
                echo    "<td>" .  $Details['scolor'] .    "</td>";
            }else if($type ==   'DoubleSided'){
                echo "<td>" .  $Details['Back'] .    "</td><td>" .  $Details['ImgId'] .    "</td>";
            }else if($type == 'Random' || $type == '100Random' || $type == '50Random' || $type == '25Random' || $type == '10Random' || $type == '100Random'){
                echo "<td>" .  $Details['pet'] .    "</td>";
            }
            
            $i++;
        
    }
    echo '</table>';
    
    //generate the form
    $query2 = "SELECT * FROM orders WHERE  id = $OrderId";
    $result2 = mysqli_query($con, $query2) or die('error getting the orders '. mysqli_error($con));
    
    $orders = mysqli_fetch_array($result2); 
          
        echo '<div id="Edit"><fieldset>';
        echo '<div><label for="ReportId">Report</label><input type="text" name="ReportId" id="ReportId" value="'.    $orders['Report']   .'"/></div>';
        echo '<div><label for="EbayId">Ebay id</label><input type="text" name="EbayId" id="EbayId" value="'. $orders['EbayId']    .'"/></div>';
        echo '<div><input type="Radio" name="Status" id="Status1" value="1"';
        if($orders['Order_Status'] == 1){ echo 'checked="checked"'; }
        echo '/> Done';
        echo '<input type="Radio" name="Status" id="Status2" value="0"';
        if($orders['Order_Status'] == 0){ echo 'checked="checked"'; }
        echo '/> Not done</div>';
        echo '<div><label for="Notes">Notes</label><input type="text" name="Notes" id="Notes" value="'.  $orders['Notes']    .'"/></div>';
        echo '<input type="hidden" value="'.$OrderId.'" id="Oid"/>';        
        echo '<input type="submit" name="submit" value="Update" id="Submit"/>';
        echo '<fieldset></div>';      
        
        $query3 = "UPDATE orders SET is_read = 1 WHERE id = $OrderId";
        $result = mysqli_query($con, $query3) or die('Error setting is read '. mysqli_error($con));
                
}else{    
    echo '<h1 class="adminError">You are not athorized to see this page</h1>';
}

?>
        </body>
</html>
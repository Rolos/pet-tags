<?php
require_once '../inc/Conn.php';

   if(isset($_POST['itable']) &&   isset($_POST['TheId']) && isset($_POST['TheState'])){                                             
            $id = $_POST['TheId'];  
            $state = $_POST['TheState'];
            
            //get the table we are going to update
            switch ($_POST['itable']){
                case 'shapes':
                    $query1 = 'UPDATE shapes SET is_available = ' . $state .' WHERE id = ' . $id;
                    mysqli_query($con, $query1) or die('Error Updating the database '. mysqli_error($con) );   
                    $query2 = 'UPDATE shapes_has_sizes SET is_available = ' . $state . ' WHERE Shapes_id = '. $id; 
                    mysqli_query($con, $query2) or die('Error Updating the database '. mysqli_error($con) );  
                    $query4 = 'SELECT id FROM shapes_has_sizes WHERE Shapes_id = ' . $id;
                    $res = mysqli_query($con, $query4) or die('Error Updating the database '. mysqli_error($con) );  
                    
                    while($colors = mysqli_fetch_array($res)){
                        $query3 = 'UPDATE shapes_has_sizes_and_colors SET is_available = ' . $state . ' WHERE shapes_has_sizes_id = '. $colors['id']; 
                        mysqli_query($con, $query3) or die('Error Updating the database '. mysqli_error($con) );   
                    }            
                    echo 'Updated';
                    break;
                
                case 'sizes':
                    $query1 = 'UPDATE shapes_has_sizes SET is_available = ' . $state .' WHERE id = ' . $id;
                    mysqli_query($con, $query1) or die('Error Updating the database '. mysqli_error($con) );   
                    $query2 = 'UPDATE shapes_has_sizes_and_colors SET is_available = ' . $state .' WHERE shapes_has_sizes_id = ' . $id;
                    mysqli_query($con, $query2) or die('Error Updating the database '. mysqli_error($con) );                       
                    break;
                
                case 'Colors':
                   $query = 'UPDATE shapes_has_sizes_and_colors SET is_available = ' . $state .' WHERE id = ' . $id;
                    mysqli_query($con, $query) or die('Error Updating the database '. mysqli_error($con) );                                           
                    break;
                
            }          
            
        }else{
            $home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
        header('Location: '.$home_url);
        }       
?>

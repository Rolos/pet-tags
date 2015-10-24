<?php
/*
 * This script generates a list of the available colors for an specified group of
 * Shape-size
 * 
 */
require_once 'Conn.php';

if(isset($_GET['shape_id']) && isset($_GET['size_id'])){
    
   $shape_id = $_GET['shape_id'];
   $sizes_id = $_GET['size_id'];
    
    $query = 'SELECT c.Color as color, c.id as id FROM colors c INNER JOIN '.
            'shapes_has_sizes_and_colors ssc ON ssc.color_id = c.id WHERE ssc.shapes_has_sizes_id IN '.
            '(SELECT id FROM shapes_has_sizes WHERE Shapes_id = '. $shape_id.' AND Sizes_id = '.$sizes_id.') and ssc.is_available = 1';
    
    $result = mysqli_query($con, $query) or die('error getting the colors' . mysqli_error($con));
    
    while($colors = mysqli_fetch_array( $result)){
        
      echo ' <div class="color  '. $colors['color'] . '" title="'. $colors['color']  .'" id="'. $colors['id']  .'" ></div>';              
          
    }
}else{
$home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
header('Location: '.$home_url);
}
?>


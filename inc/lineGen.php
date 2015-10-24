<?php

/*
 * This script generates the lines input based on the data selected by the client and
 * with the correct maxlength and maxsize
 */

require_once 'Conn.php';

if(isset($_GET['shape_id']) && isset($_GET['size_id'])){
    
   $shape_id = $_GET['shape_id'];
   $sizes_id = $_GET['size_id'];
   $is_Double = $_GET['is_Double'];
    
    $query = 'SELECT * FROM shapes_has_sizes WHERE Shapes_id = '.$shape_id.' AND Sizes_id = ' . $sizes_id;
    
    $result = mysqli_query($con, $query) or die('error getting the lines');
    
    $lines = mysqli_fetch_array( $result); 
    
    //Grab the data about the lines
    $maxLines = $lines['MaxLines'];         
    $i = 1;    
    while($i < $maxLines +1){                
        echo '<div class="Front"><label for="line'.$i.'">Line '.$i.' front</label>';
        echo '<input class="EngF" type="text" name="line'.$i.'" id="line'.$i.'" maxlength="'.$lines['MaxCharLine'.$i].'" placeholder="'.$lines['MaxCharLine'.$i].' chars" tabindex="'.$i.'" /> </div>';
        
        if($is_Double == 1){
        echo '<div class="Back"><label for="line'.$i.'">Line '.$i.' back</label>';
        echo '<input class="EngB" type="text" name="line'.$i.'" id="line'.$i.'" maxlength="'.$lines['MaxCharLine'.$i].'" placeholder="'.$lines['MaxCharLine'.$i].' chars" /> </div>';        
        }
        $i++;
    }
      
}else{
    $home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
    header('Location: '.$home_url);
}
?>

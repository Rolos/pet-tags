<?php
require_once 'Conn.php';

if(isset($_GET['shape_id'])){
   $shape_id = $_GET['shape_id'];    
    
    
    $query = 'SELECT sh.Name as shapes, s.Name as sizes, s.Width as Value, s.Height as he, s.id as id FROM shapes sh  INNER JOIN shapes_has_sizes '.
            'shs on sh.id = shs.Shapes_id JOIN sizes  s on s.id = shs.Sizes_id WHERE shs.Shapes_id ='   .$shape_id .' and shs.is_available = 1';    
    
    $result = mysqli_query($con, $query) or die('error getting the sizes');
    
    while($sizes = mysqli_fetch_array( $result)){
      
    echo '<div class="divsizes"   >';
    echo    '<div id="' .$sizes['sizes'].    '" class="sizes '.$sizes['sizes'].'" title="'. $shape_id .'" >'.$sizes['sizes'].'</div>';
    echo    '<p class="sizevalue" id="' .   $sizes['id']    .   '">'.
                    'Width = <span class="width">'. $sizes['Value']. '</span>" <br/> Height = <span class="height">'.$sizes['he'].'</span>"'.
                '<input type="hidden" class="inputShape" title="algo"/></p>';        
    echo '</div>';       
  
    }
}else{
    $home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
    header('Location: '.$home_url);
}
?>

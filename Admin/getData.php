<?php

/*
 * This Script gives me the data to be modified
 */
require_once '../inc/Conn.php';

if(isset($_POST['sid']) && isset($_POST['dis']) ){
$id= $_POST['sid'];
$dis=$_POST['dis'];





if($dis == 'Products'){
    $query = 'SELECT id, Product FROM products';
    $res = mysqli_query($con, $query) or die('ERror getting the products');    
    
    while($products = mysqli_fetch_array($res)){
        echo '<input class="Pro" type="radio" id="'.$products['id'].'" value="'.$products['id'].'" name="products"/>';
        echo '<label>'.$products['Product'] .'</label>';
    }
    
    
    
}else if($dis == 'Shapes'){
    $query = 'SELECT s.Name as shape, s.id as id, s.is_available as available FROM shapes s INNER JOIN 
        products_has_shapes ps ON s.id = ps.Shapes_id WHERE Product_id = '. $id;
    
    $res = mysqli_query($con, $query) or die('ERror getting the shapes');    
    
     while($shapes = mysqli_fetch_array($res)){
        echo '<fieldset><input class="shape" type="radio" id="'.$shapes['id'].'" value="'.$shapes['id'].'" name="shapes"/>';
        echo '<label class="iden">'.$shapes['shape'] .'</label>';
        echo '<span class="divAval">';
        echo 'available:'; ?>
        <input class="avail" type="checkbox" id="shapes" value="<?php echo $shapes['id']; ?>" name="shapeList[]" <?php  echo $shapes['available']== 1 ? 'checked' : ' '; ?>/>        
        <?php
         echo '</span></fieldset>';
    }
   
    
    
    
}else if($dis == 'Sizes'){
    
    $query = 'SELECT s.Name as size, ss.id as id, ss.is_available as available FROM sizes s INNER JOIN shapes_has_sizes ss ON s.id = ss.Sizes_id 
            WHERE ss.Shapes_id = ' . $id;
    
    $res = mysqli_query($con, $query) or die('ERror getting the sizes' . mysqli_error($con));    
    
    while($sizes = mysqli_fetch_array($res)){
        echo '<fieldset><input class="size" type="radio" id="'.$sizes['id'].'" value="'.$sizes['id'].'" name="sizes"/>';
        echo '<label class="iden">'.$sizes['size'] .'</label>';
        echo '<span class="divAval">';
        echo 'available:'; ?>        
        <input class="avail" type="checkbox" id="sizes" value="<?php echo $sizes['id']; ?>" name="sizeList[]" <?php  echo $sizes['available']== 1 ? 'checked' : ' '; ?>/>
        <?php
        echo '</span></fieldset>';
}




}else if($dis == 'Colors'){
      $query = 'SELECT c.Color as color, sc.is_available as available, sc.id as id FROM colors c INNER JOIN shapes_has_sizes_and_colors sc ON c.id = sc.color_id 
          WHERE sc.shapes_has_sizes_id = ' . $id;
    
    $res = mysqli_query($con, $query) or die('ERror getting the colors' . mysqli_error($con));    
    
    while($colors = mysqli_fetch_array($res)){        
        echo '<fieldset><label class="iden">'.$colors['color'].'</label>';
        echo '<span class="divAval">';
        echo 'available:'; ?>
        <input class="avail" type="checkbox" id="Colors" value="<?php echo $colors['id']; ?>" name="sizeList[]" <?php  echo $colors['available']== 1 ? 'checked' : ' '; ?>/>
        <?php
        echo '</span></fieldset>';
}  


}


}else{
    $home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
    header('Location: '.$home_url);
}

?>

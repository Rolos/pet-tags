<?php
/*
 * This file insert all the order details for a specified order
 * 
 */
require_once 'Conn.php';

if(isset($_POST['Oid']) && isset($_POST['vShape']) && isset($_POST['vSize']) && isset($_POST['vcolor']) ){
    
    $needle = array('<br>', '&nbsp;');
    $heystack = array('%', ' ');
    $type = $_POST['type'];
    $id = $_POST['Oid'];  
    $shape = $_POST['vShape'];
    $size = $_POST['vSize'];
    $color = $_POST['vcolor'];
    $FrontEngraving = str_replace($needle, $heystack, mysqli_real_escape_string($con, $_POST['vFront']));
    $BackEngraving = str_replace($needle, $heystack, mysqli_real_escape_string($con, $_POST['vBack']));
    $petType = $_POST['vPetType'];
    $imgId = $_POST['vimgId'];
    $SilencerColor = $_POST['vSColor'];
    $is_Double = $_POST['is_D'];
    $is_Random = $_POST['is_R'];
    $petSex = $_POST['sex'];
    
//    if($type == '5'){
//        $query = "INSERT INTO order_details(Order_id, Sizes_id, Shapes_id, Colors_id, frontEngraving, Silencer_color_id) ".
//                "VALUES ('$id', '$size', '$shape', '$color', '$FrontEngraving', '$SilencerColor')";
        
    if($is_Double == '1'){
        $query = "INSERT INTO order_details(Order_id, Sizes_id, Shapes_id, Colors_id, frontEngraving, backEngraving, image_id, Silencer_color_id)".
                " VALUES ('$id', '$size', '$shape', '$color', '$FrontEngraving', '$BackEngraving', '$imgId', '$SilencerColor')";
        
    }else if($is_Random == '1'){
        $query = "INSERT INTO order_details(Order_id, Sizes_id, Shapes_id, Colors_id, frontEngraving, pet_type, petSex) VALUES ('$id', '$size', '$shape', '$color', '$FrontEngraving', '$petType', '$petSex')";
        
    }else{
        $query = "INSERT INTO order_details(Order_id, Sizes_id, Shapes_id, Colors_id, frontEngraving) VALUES ('$id', '$size', '$shape', '$color', '$FrontEngraving')";
        
    }
    
    mysqli_query($con, $query) or die('Error creating the Order Details ' . mysqli_error($con));
    
    
}else{
    $home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
    header('Location: '.$home_url);
}
?>

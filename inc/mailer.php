<?php

/*
 * This script generates the email sent to the boss
 * 
 */

require_once 'Conn.php';

if(isset($_POST['vtagType']) && isset($_POST['vuser']) && isset($_POST['vemail']) && isset($_POST['vTotal']) ){
    
    //first know which is the tag name based on the id
    $first = mysqli_query($con, 'SELECT * FROM products WHERE id= ' . $_POST['vtagType'] ) or die('error getting the product');
    $sec = mysqli_fetch_array($first);
    
    $type = $sec['Product'] ;    
    $takes_img = $sec['takes_Image'];
    $is_Medical = $sec['is_Medical'];
    $user = mysqli_real_escape_string($con, $_POST['vuser']);
    $email = mysqli_real_escape_string($con, $_POST['vemail']);
    $total = mysqli_real_escape_string($con, $_POST['vTotal']);    
    $Notes = mysqli_real_escape_string($con, $_POST['vNotes']);
    $Shapes = json_decode(stripslashes($_POST['vShape']), true);
    $Sizes = json_decode(stripslashes($_POST['vSize']), true);
    $Colors = json_decode(stripslashes($_POST['vcolor']), true);
    $Front = json_decode(stripslashes($_POST['vFront']), true);
    $Back = json_decode(stripslashes($_POST['vBack']), true);
    $Pet = json_decode(stripslashes($_POST['vPetType']), true);
    $ImgId = json_decode(stripslashes($_POST['vimgId']), true);
    $Silencer = json_decode(stripslashes($_POST['vSColor']), true);
    $petSex = json_decode(stripslashes($_POST['sex']), true);
    $is_Double = $_POST['is_D'];
    $is_Random = $_POST['is_R'];
    $font = json_decode(stripslashes($_POST['vFontid']), true);
    $takes_Font = $sec['takes_Font'];
    
    
    //create the message
    $message = '		
        <html>
            <head>
				<meta charset="utf-8"/>
                <title>New order!!</title>
                <style>
                    div.Orders{background-color: #E8E8E8; margin-bottom: 16px; padding: 2px 10px;}
					div.Orders h2{background-color: #82C0FF; padding: 2px 10px;}
					div.Orders p{text-align: center;}
					span{color: #003060; font-style: italic; font-weight: bold; margin-right: 5px;}
					div.Orders span.eng{display: block;}
					div#primary{margin-left: 30px;}	
                </style>
            </head>
            <body>
                <h3><span>Product:</span> '.$type.'</h3>
                <h3><span>User:</span> '.$user.'</h3>
                 <h3><span>Email: </span>'.$email.'</h3>
                  <h3><span>Total orders: </span>'.$total.'</h3>
                   <h3><span>Notes: </span>'.$Notes.'</h3>';

    $i = 0;
    while($i < $total  ){    
        $count = $i + 1;
        $res1 = mysqli_query($con, 'SELECT Name FROM shapes WHERE id= ' . $Shapes[$i]) or die('error getting the shape' . $Shapes);
        $sh = mysqli_fetch_array($res1);
        $shape = $sh['Name'];

        $res2 = mysqli_query($con, 'SELECT Name FROM sizes WHERE id= ' . $Sizes[$i] ) or die('error getting the size');
        $siz = mysqli_fetch_array($res2);
        $size = $siz['Name'];

        $res3 = mysqli_query($con, 'SELECT Color FROM colors WHERE id= ' . $Colors[$i] ) or die('error getting the color');
        $col = mysqli_fetch_array($res3);
        $color = $col['Color'];

        if($is_Medical == 1){
            $res4 = mysqli_query($con, 'SELECT Color FROM colors WHERE id= ' . $Silencer[$i] ) or die('error getting the silencer');
            $sec = mysqli_fetch_array($res4);
            $SilencerColor = $sec['Color'];
        }
        
        $message .= '
        <div class="Orders">
            <h2>Order '. $count .'</h2>    
              <p><span>Shape: </span>'.$shape.'</p>
              <p><span>Size: </span>'.$size.'</p>
               <p><span>Color: </span>'.$color.'</p>';                           
        
        if($takes_img == 1){
            $message .= '<p><span>Image: </span>'.$ImgId[$i].'</p>';
        }
        
        if($takes_Font == 1){
            $message .= '<p><span>Font: </span>'.$font[$i].'</p>';
        }
        
        if($is_Random == 1){
            $message .= '
                <p><span>Pet: </span>'.$Pet[$i].'</p>
                <p><span>sex: </span>'.$petSex[$i].'</p>';
        }
        
        if($is_Medical == 1){
            $message .='
                <p><span>Silencer: </span>'.$SilencerColor.'</p>';
        }
        $message .= '<p><span class="eng">Front: </span>'.$Front[$i].'</p>';
		
        if($is_Double == 1){
                $message .= '<p><span class="eng">Back: </span>'.$Back[$i].'</p>';
        }
        
        $message .= '</div>';
        
        $i++;
    }
    
    $message .= '</body></html>';
	$header =  "Content-type: text/html\r\n"; 
	$subject = 'New order: '. $type . ' From: ' . $user;
    
   // echo $message;
    mail('xp_simplex@hotmail.com',$subject,$message, $header) ;
   mail('rsierramancebo@gmail.com',$subject,$message, $header) ;
	
	//now send the confirmation email to the client
	$confirmation = "<p>Thanks for ordering our tags. We are going to ship ASAP. Here is what you ordered from us: </p>";
	$confirmation .= $message;
    
	mail($email, 'Thanks for buying our tags!!',$confirmation, $header) ;
    
}else{
    echo '<h1 class="adminError">You are not athorized to see this page</h1>';
}
?>

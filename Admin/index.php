
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

<?php
/*
 * The admin page
 */
require_once '../inc/Conn.php';

if(isset ($_POST['User']) && isset($_POST['Pass'])){
    $user = $_POST['User'];
    $pass = $_POST['Pass'];
    
    //get the database username
    
    $query =    "SELECT * from user WHERE User = '$user' AND password= '$pass' ";
    $result = mysqli_query($con, $query) or die('Error validating the user '. mysqli_error($con));
    
    if(mysqli_num_rows($result) == 1 ){
    ?>  
    <body>       
        <div id="main">
            <div id="mainA">   
                <div id="Panel">
                    <h1 class="AdminTitle">Control Panel</h1>                                       
                    
                    <div id="Content">                                                                       
                        <span class="OrderId">Change the availability of the tags</span>                        
                        <div id="Products"></div>
                        <div id="DivContainer">
                            <div id="Shapes" class="divisors"></div>
                            <div id="Sizes" class="divisors"></div>
                            <div id="Colors" class="divisors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
        
    }else{
        echo '<h1 class="adminError">You are not athorized to see this page</h1>';        
}   
}else{
    echo '<h1 class="adminError">You must provide a Valid User Name and Password</h1>';
}
?>
</body>
</html>


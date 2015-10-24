<?php
/*
 * The confirmation page
 */

$user = $_GET['user'];

?>
<html>
    <head>
        <meta charset="utf-8"/> 
      <link rel="icon" href="img/favicon.ico"/>
      <link rel="apple-touch-icon" href="img/apple-touch-icon.png"/>
      <link rel="stylesheet" href="../css/style.css"/>  
      <title>Real Engraving | Confirmation</title>

    </head>
<body>
    <div id="main">
        <div id="main1">            
                <div id="confirmation">
                    <h1>Your order has been submited...</h1>
                    <p>Thanks <strong><?php echo  $user; ?></strong> , we expect you to come back soon because we love our pets like you do</p>

                </div>            
        </div>
    </div>
</body>
</html>


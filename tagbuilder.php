<?php

//variable initialization
require_once 'inc/Conn.php';
if(isset ($_GET['type'] ) &&  isset ($_GET['ebayUserName']    )    &&  isset ($_GET['email']  ) && isset($_GET['Qt'])  && $_GET['Qt'] > 0 )   {
    $type = mysqli_real_escape_string($con, $_GET['type']);
    $user = mysqli_real_escape_string($con, trim($_GET['ebayUserName']));
    $email = mysqli_real_escape_string($con, trim($_GET['email']));
    $Qt = mysqli_real_escape_string($con, trim($_GET['Qt']));
    
    $res = mysqli_query($con, 'SELECT * FROM products WHERE id = '. $type) or die('error getting the lines');
    $res2 = mysqli_fetch_array($res);
    $is_Double = $res2['is_Double'];
    $takes_color = $res2['takes_Color'];
    $takes_size = $res2['takes_Size'];
    $is_Random = $res2['is_Random'];
    $is_Medical = $res2['is_Medical'];
    $is_laser = $res2['is_laser'];
    $takes_Image = $res2['takes_Image'];
    $takes_Font = $res2['takes_Font'];
    
}  else{
    
$home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
header('Location: '.$home_url);
    
}
//if the user access the page directly form the web or doen't have any get information 
//display the tag selector in wich the clien will choose the product he wants to buy

 if(   $type == 'No'   ){  
    $home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/tagSelector.php';
    header('Location: '.$home_url);    
}

$process = 'Tag Builder';
require_once 'inc/header.php';
?>


<body>  <?php if($takes_Image == 1){?>   
        <div id="light" class="white_content"><?php require_once 'inc/pickImage.php'; ?> </div>
        <div id="fade" class="black_overlay"></div>        
		<?php }; ?>
        <?php if($takes_Font == 1){?>   
        <div id="lightf" class="white_content"><?php require_once 'inc/pickFont.php'; ?> </div>
        <div id="fadef" class="black_overlay"></div>        
		<?php }; ?>
        
    <div id="titlebg">
    <div id="container">    
        <input type="hidden" id="Type" value="<?php echo $type; ?>"/>
        <input type="hidden" id="User" value="<?php echo $user; ?>"/>
        <input type="hidden" id="email" value="<?php echo $email; ?>"/>
        <input type="hidden" id="Qt" value="<?php echo $Qt; ?>"/>
        <input type="hidden" id="is_Double" value="<?php echo $is_Double; ?>"/>
        <input type="hidden" id="t_Size" value="<?php echo $takes_size; ?>"/>
        <input type="hidden" id="t_Color" value="<?php echo $takes_color; ?>"/>
        <input type="hidden" id="is_Random" value="<?php echo $is_Random; ?>"/>
        <input type="hidden" id="is_Medical" value="<?php echo $is_Medical; ?>"/>
        <input type="hidden" id="is_laser" value="<?php echo $is_laser; ?>"/>
        <input type="hidden" id="takes_img" value="<?php echo $takes_Image; ?>"/>
        <input type="hidden" id="takes_Font" value="<?php echo $takes_Font; ?>"/>
        
        <?php if($type == 9 || $type == 10){?>
            <h1 class="maintitle">Hi <?php echo $user; ?>, begin customizing your shelter special</h1>
        <?php }else{?>
        
        <h1 class="maintitle">Hi <?php echo $user; ?>, begin customizing your <?php echo  ($Qt >1 ? $Qt . ' tags' : $Qt. ' tag'); ?>
            <noscript>
            You need to have javascript enabled in your browser to be able to use this application!!
            </noscript>
        </h1>                           
        
        <?php }?>
        
                <div id="container2">
                    <div id="right">
                        
            <!--shape selector -->
                            <div id="shapeSelector" class="builder_section">                                              
                                    <div class="titleicon">
                                            <h1 class="title2"><?php echo $is_Random == 1 ?  'Select Your pet!' :  'Shape   Selector'?> <span id="TagNameDisplay"></span></h1>       
                                            <span class="userSelection" id="userSelection"></span>
                                    </div>
                                <div class="shapes_container">
                                    <?php require_once "inc/tagShapes.php" ; ?>                                                                
                                </div>
                            </div>
                        
<!--     SIZE SELECTOR-->
<?php   if($takes_size == '1'){ ?>
                            <div id="sizeSelector" class="builder_section">
                                <div class="titleicon">
                                    <h1 class="title2">Size Selector</h1>
                                    <span class="userSelection" id="sizeSelection"></span>
                                </div>                                
                                <div id="innerSizeSelector">
                                    
                                </div>
                            </div>
<?php }; ?>

<!--COLOR SELECTOR-->
<?php if($takes_color == '1' ){ // restrict the access of some types to the color module?> 
                            <div id="colorSelector" class="builder_section">
                                <div class="titleicon">
                                    <h1 class="title2">Color Selector<span id="colorDisplay"></span></h1>
                                    <span class="userSelection" id="colorSelection"></span>
                                </div>
                                <div id="innerColorSelector">
                                    
                                </div>
                            </div>
<?php }; ?>
<!--LINES INPUT-->
                            <div id="linesInput" class="builder_section">
                                
                                <div class="titleicon">
                                    <h1 class="title2">Engraving</h1>
                                </div>
                                <div id="counter"></div>
                            <div id="Lines">
                                                                  
                            </div>
<!--LINES INPUT END-->
                                                        
                            </div>     
                            
                            <div id="Notes" class="builder_section">
                                <div class="titleicon">
                                    <h1 class="title2">Notes from you to us....</h1>                                   
                                </div>
                                <p>...Anything you want to tell us, this is the time..</p>
                                <textarea id="textNotes" rows="3" cols="20">
                                    
                                </textarea>                                
                            </div>
</div>     

<!--VIEWER                    -->
            <div id="left">       
<!--                Medical-->
                <?php   if($is_Medical == 1){ ?>

                            <div id="silencerSelector" class="builder_section">
                                <div class="titleicon">
                                    <h1 class="title2">Silencer Preview <span id="silencerToTag"></span></h1>
                                </div>
                                <div id="Innersilencer"></div>
                            </div>

                            <?php
                            }
                            ?>
                
                    <div class="builder_section">
                        <div class="titleicon">
                            <h1 class="title2">Customize your tag<span id="ErrorMsg"></span></h1>
                        </div>   
                        
                <div id="accordion">
                    <?php require_once 'inc/prevGen.php'?>
                </div>
                    
                        <div id="down">
                                <span class="downinfo"><strong>Scale 1:1.5</strong></span>
                                <span class="downinfo" id="width"></span>
                                <span class="downinfo" id="Height"></span>                                
                                <span class="messages">
                                        <input type ="checkbox" name="Agreement" id="Agreement"/>
                                        Certifico que la informacion suministrada es correcta y no puede ser cambiada luego
                                </span>
                                <button type="button">Send</button>
                        </div>
                </div>
                
            </div>

<!--VIEWER END                -->

                    
       
    </div>
<?php require_once 'inc/footer.php' ; ?>
<?php

/*
 * This page generates the previews based on the quantity that the client put in the quantity field
 */

if($Qt >0){
    
    $i = 1; //to show the number of tags in an ascendent order
     While($Qt > 0){
         $Qt--;
         ?>
         
<h3 id="Ac-<?php echo $i; ?>"><a href="#"><?php echo 'Tag-'. $i  ;?><span id="SColor"></span><span class="pet"></span><span class="sex"></span></a></h3>
            <div class="PrevOut">                            
                <div class="previewdiv">
                    <?php                                      
                    echo '<span class="messages1">To begin, <br/>please select one of the <br/> available <strong> Tag Shapes</strong></span>';                   
                    ?>
                </div>                                                                                  
            </div>  
         
 <?php    
 $i++;
    }   
    

}

?>

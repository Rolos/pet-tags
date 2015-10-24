<div id="pickerClose" title="Cancel"></div>
<div id="pickerheading">        
</div>

<?php
///this file is going to generate an html table with all the available images to show
if($type == 13){
    $i = 1;
    while($i < 12){    
    echo '<img class="imgPick" src="img/MedicalImg/'   .$i  . '.jpg" width="100px" height="80px" id="' . $i. '"/>';
    $i++;
    }
    
}else{
$i = 1;
while($i < 100){    
    echo '<img class="imgPick" src="img/EngravedImg/'   .$i  . '.jpg" width="100px" height="80px" id="' . $i. '"/>';
    $i++;
}
    
}


?>


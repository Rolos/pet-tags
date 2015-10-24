<?php

/*
 * This file catch the id of the tag the user bought
 * 
 */

if(isset ($_GET['type'])){
    define('TAGTYPE', $_GET['type']);
}else{    
    define('TAGTYPE', 'No');
}

?>

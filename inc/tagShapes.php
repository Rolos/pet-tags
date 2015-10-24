

<?php            
    
$query = "SELECT s.Name as Name, s.id as id, s.is_available as isA FROM shapes s INNER JOIN products_has_shapes p on s.id = p.Shapes_id WHERE p.Product_id = $type";
       
    $result = mysqli_query($con, $query) or die('Error getting the shapes');
      
   
    while($shapes = mysqli_fetch_array($result)) {   
        if($shapes['isA'] == 1){
            echo '<div class= "shapes">';
            echo     '<img alt="'   .$shapes['Name']  . '" src="img/ShapeIcons/' . $shapes['Name'] . '_Normal.png" id="'    . $shapes['id']  .  '" title="'   .$shapes['Name']  . '" class="shapes" />';                 
            echo '</div>';              
        }else{
            echo '<div class= "shapes">';
            echo '<span class="unavail">'.$shapes['Name'].'</span>';
            echo     '<img alt="'   .$shapes['Name']  . '" src="img/ShapeIcons/not_available.png" />';                 
            echo '</div>';   
        }
       if($is_Random == '1'){
           ?>
<div class="PetChoser">
            <fieldset><legend>Select your pet</legend>
                <label for="cat">Cat</label><input id="cat" type="radio" name="pet" value="Cat" class="pet"/>
                <label for="dog">Dog</label><input id="dog" type="radio" name="pet" value="Dog" class="pet" />
                <label for="other">other</label><input type="radio" name="pet" id="other" value="other" class="pet"/>
            </fieldset>

            <fieldset><legend>Chose your pet's sex</legend>
                <label for="male">Male</label><input id="male" type="radio" name="sex" value="Male" class="sex"/>
                <label for="female">Female</label><input id="female" type="radio" name="sex" value="Female" class="sex" />   
            </fieldset>
</div>
           <?php
       }
                 
    }
     
  
?>

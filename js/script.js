/*
*
*Author: Luis Rolando Sierra Mancebo
*Email: rsierramancebo@gmail.com
*project: Realengravedtags
*date: Oct-8-2012
*
*/

var i =4; //this variable counts the quantity of images for the slideshow   
 
 $(document).ready(function(){       
    
       /*================THE ACCORDION==============*/
        AccordionInit();
        
     /*---------------THE SLIDESHOW---------------------*/
         setInterval('slideChange()', 5000);
    
    //change the background image of the button
    $('fieldset#step1 input#SendTagBuilder').hover(
    function(){
        $(this).attr('src', 'img/Next_button_click.png');
    }, 
    function(){
         $(this).attr('src', 'img/Next_button.png');
    })
        
    //clear the notes section
    $('textarea#textNotes').html('');
    
    /*------------------DATA VALIDATION--------------------------*/
    var helper = $('p#helper');
   
    $('input#ebayUserName').blur(function(){
        notEmpty(this, 'You must provide us with your ebay username', helper);
    });
    
    $('input#Qt').blur(function(){        
        validateNumber(this, 'Please introduce the Quantity of tags that you want' , helper);
    });   
    
    $('input#email').blur(function(){ 
        validateEmail(this, 'You must provide us with a valid email address', helper);
    });
        
    $('form#tagbuilder').submit(function(){
       return validateForm(this, 'Please check your data again', helper);
    });
    
        /*----------------------------NAVIGATION CONTROL------------------------*/
    $('span.nav').click(function(){                
        $('div#navigator span').removeClass('selected');
        $(this).addClass('selected');        
        navigationDisplay(this);                
    })
     
     /*---------------------SHAPE SELECTOR--------------------*/
          
     
     $('img.shapes').on('mouseenter', ShapeHover);
     $('img.shapes').on('mouseleave', ShapeOut);
     $('img.shapes').on('click', ShapeClick);              
     
     /*=========== SCROLL PREVIEW=============*/
     
     $(window).scroll(function(){
         var vertical_position = 0;         
          if (pageYOffset){//usual
            vertical_position = pageYOffset;
            
          }else if (document.documentElement.clientHeight){//ie
            vertical_position = document.documentElement.scrollTop;
            
          }else if (document.body){//ie quirks
            vertical_position = document.body.scrollTop;
            
          }
          
          if(vertical_position > 0)
              vertical_position += 10
                              
        if( $('div#left').height() < (window.innerHeight -100)){ //if left div is shorter scroll this
                $('div#left').css('top',  vertical_position);
                
        }else{ //if right div is shorter scroll this
            $('div#left').css('top', 0);            
            var scrolling = vertical_position % $('div#right').height(); //how many times right fits in left
            
            if(vertical_position < $('div#right').height()){
                $('div#right').css('top', 0);
                
            }else if(scrolling > 10 && scrolling < 100){                    
                     $('div#right').animate({top: vertical_position});   
                } 
            //tester line
           // $('div.previewdiv span.messages1').html('vertical pos = ' + vertical_position + ' scroll= ' + scrolling + ' div heigt = '+ $('div#right').height());
                
        }
             
      })
      
      /*-------------RANDOM TAGS---------------*/
      ///disable the options to chose the pet and sex for a random
        var is_R = $('input#is_Random').val();
        if(is_R == 1){
            $('div.PetChoser').hide();
        }
        
        $('input.pet').click(function(){            
            petTypeSetter(this.value)
        });
        
        $('input.sex').click(function(){
            petSexSetter(this.value)
        });             
                    
                    
          /*-------------------------------THE ORDER CREATOR CALL--------------------------*/
          $('div#down button').click(orderCreator);
          

 });/*============  END OF THE READY EVENT========*/
 
 
 
 /*---------------------THE FUNCTION TO ENTER THE TEXT IN THE PREVIEW CONTAINER-===============*/
 function Engraver(elem){              
          //this is the function that shows the text in the tags                        
		  
              //display the word count for every line              
              $('div#counter').html('<span class="wordcount">'  +wordCount(elem.maxLength, elem)  +    '</span>');
              
              
              //get what the user is entering and the div that is going to display it on the preview
              var inputString = $(elem).attr('class') == 'EngB activate' ? $('input.EngB') : $('input.EngF');
              //alert($(elem).attr('class'));
              var outString = $(elem).attr('class') == 'EngB activate' ? //if this input element is the front 
                                            nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[3] : //set the output element to the textshowerD
                                            nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[2]; //set the output element to texshower

                //insert the text into the tag's body
              outString.innerHTML = ' ';                                        
              var pre = false;   //control variable to know when to introduce a new line
              inputString.each(function(i){                  
                  if(this.value != ''){                                           
                      if(pre == true){
                          var newLine = document.createElement('br');
                          outString.appendChild(newLine);                          
                      }                                            
                      var inText = document.createTextNode(this.value.replace(/ /g, '\u00A0'));                      
                      outString.appendChild(inText);                                                                      
                      pre = true;
                  }
              })           
 }



//start the accordion
function AccordionInit(){
    
                // Accordion
                $("#accordion").accordion({header: "h3"});

                //hover states on the static widgets
                $('#dialog_link, ul#icons li').hover(
                        function() {$(this).addClass('ui-state-hover');},
                        function() {$(this).removeClass('ui-state-hover');}
                );
                    //set the autoHeight to false
              $( "#accordion" ).accordion( "option", "autoHeight", false );
              
              //get the active element in the accordion
              $( "div#accordion h3" ).click(previewReset)                            
                      
}

/*============SHAPE BUILDER FUNCTIONS===========*/

function ShapeHover(){    
        $(this).attr('src', 'img/ShapeIcons/' + this.alt + '_Hover.png');              
        $('span#TagNameDisplay').html('_' + this.alt);            
        $(this).css('cursor', 'pointer');
}

function ShapeOut(){
        $(this).attr('src', 'img/ShapeIcons/' + this.alt + '_Normal.png');              
        $('span#TagNameDisplay').html('');   
}

  /*function ShapeClick:
   *this function handles all what happen
   *when the user clicks a shape icon
   *like make the request for the available sizes and display the images
   */
function ShapeClick(){                    
        var petType = 0; //this variable is only going to be set when it is a random tag
        var shapeName = this.alt;      
        
        //initialize the variable to indicate if the current tag is or not medical
        var is_medical = $('input#is_Medical').val();      
        var is_Double = $('input#is_Double').val();
        var is_Random = $('input#Type').val() == 4 ? 1 : 0;	
                        
            //$(this).attr('src',  'img/ShapeIcons/' + this.alt + '_Click.png');
        $('div#shapeSelector span#userSelection').html('New Shape Selected!!:<strong> ' + this.alt + '</strong>');
    
        
        $('img.shapes').removeClass('imageSelected');
        $(this).addClass('imageSelected');   //show tha yellow background
                             
        //blank older selections
         $('span#sizeSelection').html('');
         $('div#innerColorSelector').html('');      
        $('span#colorSelection').html('');
        $('span#width').html('');
        $('span#Height').html('');
        $('div#Lines').html('');
        
        //Create the preview
        if(is_medical != 1){ // if it is not medical call the view generator
           viewGen(this, this.id);                
                
        //call via Ajax the sizes
        $.ajax({url: 'inc/sizeSelector.php?shape_id=' + this.id + '&is_medical=' + is_medical, type: "post"})
        .done(function(sizes){

            //inject inside it's div the available sizes'
            $('div#innerSizeSelector').html(sizes);

            //attach the click event to the sizes
            $('div.sizes').click(sizeClick);            

            //put the shape name inside the p element
            $('input.inputShape').attr('title', shapeName); 
			
			//if this one is random i dont display the width and height
			if(is_Random == 1){
				$('span.width').hide();
				$('span.height').hide();
				$('span.randomMsg').html('this sizes are just for illustrative proposes');
				$('div.previewdiv').css('background', 'none');
				$('div.PrevOut').css('background', 'none');
				$('div.coin').hide();
				$('span.downinfo').hide();
			}
            })
        
        }else{ //if it is medical tag
            
            if(this.alt == 'Silencer'){ //if it is the silencer send the image to the innerSilencer div                
                $('div#Innersilencer').html('<img src="img/prev/' + this.alt +'.png" alt="'+this.alt+'" class="silencer"/>' );
                                    
            }else{//if it is not the silencer                
            viewGen(this, this.id);        
             tagResize('Millitary', 0, 34)   ;                                    
            }
                      
                
        //call via Ajax the Colors
        $.ajax({url: 'inc/colorSelector.php?shape_id=' + this.id + '&is_medical=' + is_medical + '&size_id=34', type: "post"})
           
        .done(function(colors){            
                $('div#innerColorSelector').html(colors);                  
             $('div.color').click(displayColor);
                $('div.color').hover(
                function(){                
                    $('span#colorDisplay').html(' _' + this.title);
            }, function(){
                    $('span#colorDisplay').html('');
            });
      })                                   
  
      if(this.id == 16){
          linesGenerator(16, 34, is_Double); 
      }
      
    } //end of the medical tag
}



    
    /*====================Preview Generator=======================*/
    
    function viewGen(img, shapeid){
    var is_Random = $('input#is_Random').val();    
    var takes_color = $('input#t_Color').val();
    var takes_img = $('input#takes_img').val();
    var takes_Font = $('input#takes_Font').val();
    var type = $('input#Type').val();
    
    var divGen = nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1]; //the current tag div.previewdiv
    $('div#accordion h3.ui-state-active span#SColor').html('');//reset the silencer viewer
	$('div#accordion h3.ui-state-active span.pet').html('');
	$('div#accordion h3.ui-state-active span.sex').html('');
        
        //display the view
           divGen.innerHTML =                  
            '<div class="previewContainer">'+
                '<img src="img/prev/' + img.alt  +'.png" alt="'+img.alt+'" class="preview"/>'+             
                '<input type="hidden" value="'  +   shapeid  +   '" class="ShapeId"/>'+
                '<input type="hidden" value="" class="SizeId"/>'+
                '<input type="hidden" value="" class="ColorId"/>'+                
                '<input type="hidden" value="" class="SilencerColorId"/>'+
                 '<input type="hidden" value="" class="petType"/>'+
                 '<input type="hidden" value="" class="petSex"/>'+
            '</div>'+            
            '<div class="coin"></div>' +
             '<div class="textShower"></div>'+
            '<div class="textShowerD"></div>' +
            '<p class="Imgname"><Button class="imgpkr">Pick an image</button>'+
            '<div class="imgShower" id="0"></div>' +
              '<p class="fontname"><Button class="fontpkr">Pick a Font</button>'+
            '<div class="FontShower" id="0"></div>' ;
    
    if(takes_Font == 0){
        $('Button.fontpkr').hide();
    }else{
        
//Font picker
	$('Button.fontpkr').click(function(){
            document.getElementById('lightf').style.display='block';
            document.getElementById('fadef').style.display='block';
            
            document.getElementById('fadef').style.height= document.getElementsByTagName('html')[0].scrollHeight + 'px';               
        })        

        //the image event handler
        $('img.fontPick').click(function(){                       
                nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[7].innerHTML =
                '<img class="picked" src="img/FontImg/'+this.id+'.jpg" width="80px" height="70px"/>';               
            
             nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[7].setAttribute('id', this.id);
            document.getElementById('lightf').style.display ='none';
            document.getElementById('fadef').style.display ='none';    
//End of the Font picker
        })
    }
    
    
    if(takes_img == 0){
        $('Button.imgpkr').hide();
    }else{
                                                                      
        
        //*------------------IMAGE PICKER CONFIGURATION------------------*//
           //the close button
        $('div#pickerClose').click(function(){
            $('div.white_content').hide();
            $('div.black_overlay').hide();
//            document.getElementById('light').style.display ='none';
//            document.getElementById('fade').style.display ='none';
        })
       
        //attach the span to the click event
        $('Button.imgpkr').click(function(){
            document.getElementById('light').style.display='block';
            document.getElementById('fade').style.display='block';
            
            document.getElementById('fade').style.height= document.getElementsByTagName('html')[0].scrollHeight + 'px';               
        })        
            
        
        //the image event handler
        $('img.imgPick').click(function(){
            if(type == 13){ //get the medical images if this is a laser medical
                nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[5].innerHTML =
                '<img class="picked" src="img/MedicalImg/'+this.id+'.jpg" width="80px" height="70px"/>';    
            }else{
                nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[5].innerHTML =
                '<img class="picked" src="img/EngravedImg/'+this.id+'.jpg" width="80px" height="70px"/>';    
            }
            
             nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[5].setAttribute('id', this.id);
            document.getElementById('light').style.display ='none';
            document.getElementById('fade').style.display ='none';                             


            //Now disable all the input except the first  if this is not the laser medical
            if(type != 13){
            var inputs = $('input.EngF').get();
						
            //clear the inputs
            for(var i = 1; i < inputs.length ; i++){
                inputs[i].value = '';                
            }
            $(nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[2]).html(' ');            
            $('input.EngF').attr('disabled', true);
            $('input#line1').attr('disabled', false);  
            			
			//if there is information in the first line engrave it again
            var elem = $('input.EngF').get(0);
                if(elem){
                        Engraver(elem); //engrave again the tag
                }         
            }
        })
    } //end of the image picker
    
      //set the color for the products that don't have the option for taking it'
        var elem = $(nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[0]);     
        if(takes_color == 0){            
            if($('input#Type').val() == '3'){ //if this is a double sided steel
                setColor(elem, '#C4C4C4', 24);        
            }else{//is this is a random
                setColor(elem, '#C4C4C4', 25);        
            }            
        }
           
           //set the options for the random tags to choose the pet type and sex
           if(is_Random == 1){
               $('div.PetChoser').show();
           }
        return divGen;
        
    }
    
    
    
  //this function sets the current pet type and sex  to the corresponding input hidden
    function petSexSetter(sex){        
        var petSex = $(nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[6]) ;        
        $(petSex).attr('value', sex);
		$('div#accordion h3.ui-state-active span.sex').html('Pet\'s sex: ' + sex);
    }
    
    function petTypeSetter(type){
        var Type = $(nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[5]) ;
        $(Type).attr('value', type);
		$('div#accordion h3.ui-state-active span.pet').html('Pet ' + type);
    }
    
    
  
    /*-----------------------------------NAVIGATION DISPLAY--------------------------------*/
    //this function display the floating windows in the index page
    function navigationDisplay(span){
        
        var page ;
        //determine the content to display for the span's id
        switch (span.id){
            case 'why':
                page = 'FrontWhy';
                break;
                
            case 'Fa':
                page = 'FrontFaq';
                break;
                
            case 'Policies':
                page = 'FrontPoli';
                break;
                
            case 'Admin':
                page  = 'FrontLoggin';
                break;
                                
        }   
        
        document.getElementById(page).style.display='block';
        document.getElementById('Back').style.display='block';
        document.getElementById('Back').style.height= document.getElementsByTagName('html')[0].scrollHeight + 'px';   
        
          //the close button
        $('div#pickerClose').click(function(){
            document.getElementById(page).style.display ='none';
            document.getElementById('Back').style.display ='none';
        })
        
        $('div#Back').click(function(){
            document.getElementById(page).style.display ='none';
            document.getElementById('Back').style.display ='none';
        })

    }
    
    
        
/*------------------------------THE ORDER CREATOR FUNCTION---------------------------------------*/

function orderCreator(){    
    //get the variable numbers for checking
    var totalOrders = $('input#Qt').val();
    var totalshapes = 0;    
    var totalsizes = 0; //count the not empty input sizes
    var totalcolors = 0;
    var totalfrontSide = 0;
    var totalsilencer =0 ;
    var totalBack = 0;
	var totalPet = 0;
	var totalSex = 0;
    //get the data holding variables
    var Shapes = new Array();
    var Sizes = new Array();
    var colors = new Array();
    var Front = new Array();  
    var Back = new Array();
    var img = new Array();
    var fonts = new Array();
    var Silencers = new Array();
    var PetType = new Array();
    var PetSex = new Array();
    var tagType = $('input#Type').val();
    var user = $('input#User').val();
    var email = $('input#email').val();
    var is_Double = $('input#is_Double').val();
    var is_Random = $('input#is_Random').val();
    var Notes = $('textarea#textNotes').val();
    var is_Medical = $('input#is_Medical').val();    
    var takes_img = $('input#takes_img').val();
    var takes_Font = $('input#takes_Font').val();
    var agree = $('input#Agreement').attr('checked');
    
    if(!agree){
        alert('please agree with our policy');
        $('span.messages').css('outline', '3px dashed red');
        return false;
    }
                    
      //count all the shapes that the client has selected
      $('input.ShapeId').each(function(){totalshapes++;} )
      $('input.SizeId').each(function(){if(this.value != '' ){totalsizes++;}} )
      $('input.ColorId').each(function(){if(this.value !=''){totalcolors++;}} )
      $('div.textShower').each(function(){if(this.innerHTML != ''){totalfrontSide++;}} )
      $('div.textShowerD').each(function(){if(this.innerHTML != ''){totalBack++;}} )
      $('input.SilencerColorId').each(function(){if(this.value != ''){totalsilencer++;}} )	  
	  $('input.petType').each(function(){if(this.value != ''){totalPet++;}} )
	  $('input.petSex').each(function(){if(this.value != ''){totalSex++;}} )
                  
      if(totalshapes == totalOrders){ 
              //ALL SHAPES SELECTED              
              if(totalsizes == totalOrders){
                  //ALL SHAPES AND SIZES SELECTED
                  $('span#ErrorMsg').html('');                                    
                      
                      if(totalcolors == totalOrders){ 
                          //ALL SHAPES, COLORS, AND SIZES SELECTED
                          $('span#ErrorMsg').html('');                                 
                          
                              if(totalfrontSide == totalOrders){//engraving
                                  //ALL DATA COMPLETED NORMAL
                                  $('span#ErrorMsg').html('');
                                   $('input.ShapeId').each(function(){Shapes.push(this.value)   ;} )
                                  $('input.SizeId').each(function(){Sizes.push(this.value) ;} )
                                  $('input.ColorId').each(function(){colors.push(this.value) ;} )
                                  $('div.textShower').each(function(){Front.push(this.innerHTML) ;} )
                                  $('input.petType').each(function(){PetType.push(this.value)} )
                                  $('input.petSex').each(function(){PetSex.push(this.value)} )
                                  $('input.petType').each(function(){PetType.push(this.value)} )
                                  $('input.petSex').each(function(){PetSex.push(this.value)} )
								
									//when is random check the pet and sex type
                                  if(is_Random == 1){
                                        if(totalPet != totalOrders){
                                                $('span#ErrorMsg').html('You need to specify all your pet\'s types');
                                                return false;
                                        }else if(totalSex != totalOrders){
                                                $('span#ErrorMsg').html('You need to specify all your pet\'s sexs');
                                                return false;
                                        }               
                                  }
								  
                                  if(   is_Double == 1   ){                                                               
                                          //    DATA COMPLETED DOUBLE SIDED
                                        $('div.textShowerD').each(function(){Back.push(this.innerHTML) ;} )                                                                                                                                                 
                                  }//DOUBLE SIDED           
                                  
                                  //takes image
                                  if(takes_img == 1){
                                        $('div.imgShower').each(function(){img.push(this.id)} )
                                  }
                                  
                                  if(takes_Font == 1){
                                      $('div.FontShower').each(function(){fonts.push(this.id)} )
                                  }
                                  
                                  if(   is_Medical == 1    ){
                                      if(totalsilencer == totalOrders){
                                          //ALL DATA COMPLETED FOR MEDICAL                                          
                                          $('span#ErrorMsg').html('');
                                          $('input.SilencerColorId').each(function(){Silencers.push(this.value);} )
                                          
                                      }else{
                                          $('span#ErrorMsg').html('You have to select the silencer color');       
                                          return false;
                                      }
                                  } //when is medical
								  
								  								  								  
                                  
                                  //SEND THE DATA TO THE MAILER SCRIPT
                                  //first encode the arrays
                                  var Shapex = JSON.stringify(Shapes);
                                  var Sisex = JSON.stringify(Sizes);
                                  var Colorx = JSON.stringify(colors);
                                  var Frontx = JSON.stringify(Front);
                                  var Backx = JSON.stringify(Back);
                                  var Pet = JSON.stringify(PetType);
                                  var ImgId = JSON.stringify(img);
                                  var fontid = JSON.stringify(fonts);
                                  var Silen = JSON.stringify(Silencers);
                                  var sexPet = JSON.stringify(PetSex);
                                  
                                  //Ajax all the data to the mailer
                                  var orders = $.ajax({
                                      url: 'inc/mailer.php',
                                      data: {vtagType:  tagType, vuser: user, vemail: email, vTotal: totalOrders, vNotes: Notes, 
                                                vShape: Shapex, vSize: Sisex, is_D: is_Double, is_R: is_Random,
                                                vcolor: Colorx, vFront: Frontx, vBack: Backx, vPetType: Pet, 
                                                vimgId: ImgId, vFontid: fontid, vSColor: Silen, sex: sexPet},
                                     type: "POST"
                                  })
                                  
                                  orders.done(function(id){
                                      //alert(id);
                                      redirect(user);
                                  })
                                  
//                                  var orders = $.ajax({
//                                          url: 'inc/Orders.php',
//                                          data: {vtagType:  tagType, vuser: user, vemail: email, vTotal: totalOrders, vNotes: Notes},
//                                          type: "POST"
//                                      })                                                                                         
//                                      orders.done(function(id){                                                   
//                                                var i = 0;
//                                             while(i < totalOrders){                                      
//                                                    var details = $.ajax({
//                                                                url: 'inc/OrderDetails.php',
//                                                                  data: {type: tagType, is_D: is_Double, is_R: is_Random,  Oid: id, vShape: Shapes[i], vSize: Sizes[i], 
//                                                                      vcolor: colors[i], vFront: Front[i], vBack: Back[i], vPetType: PetType[i], 
//                                                                      vimgId: img[i], vSColor: Silencers[i], sex: PetSex[i]},
//                                                                  type: "POST" 
//                                                                })                                                                   
//                                                        details.done(function(done){                                                                
//                                                            if(i == totalOrders){
//                                                                redirect(user);
//                                                            }                                                                                                                         
//                                                        })
//                                                        i++;
//                                            }                                           
//                                      })                                                                        
                                  
                                  
                              }else{
                                  $('span#ErrorMsg').html('Please introduce your engraving info');                                                    
                              }                          
                      }else{
                          $('span#ErrorMsg').html('You have to select all your tags Colors');
                      }
                                        
              }else{
                  $('span#ErrorMsg').html('You have to select all your tags sizes');
              }          
          
      }else{          
          alert('You have to select ' + (totalOrders - totalshapes) + ' more shapes');
      }
      
}


function redirect(user){
     window.location.replace('inc/Confirmation.php?user=' + user);
}


/*------------------ SIZE SELECTOR-----------------------*/

function sizeClick(){  
    
    //get the current selected shape name
    var shape = this.nextSibling.childNodes[7].title;
    var is_Double = $('input#is_Double').val();	
    var is_Laser = $('input#is_laser').val();
    
    //add the selected clasess
    $('div.sizes').removeClass('sizesSelected');
    $(this).addClass('sizesSelected');     
    $('span#sizeSelection').html('New size Selected!!: <strong>' + this.id + '</strong>');
    
    //get the variables 
    var sizeid = this.nextSibling.id;
    var shapeid = this.title;   
      
      tagResize(shape, this, nextElementSibling(this).id);        
          
    // call via Ajax the available colors
  $.ajax({url: 'inc/colorSelector.php?shape_id=' + shapeid +'&size_id='+ sizeid})
  
  .done(function(colors){
      $('div#innerColorSelector').html(colors);      
      if(is_Laser == 1){
          $('div.LightBlue').hide();
          $('div.Silver').hide();
      }
      //attach the click and  hover events to the colors
      $('div.color').click(displayColor);
      $('div.color').hover(function(){
          $('span#colorDisplay').html(' _' + this.title);
      }, function(){
          $('span#colorDisplay').html('');
      });
  })
  
  linesGenerator(shapeid, sizeid, is_Double);
  
}


//this function generates the lines depending on the selected shape
function linesGenerator(shapeid, sizeid, is_Double){
  //call via Ajax the lineGen Script to generate the inputs for the engraving info
   $.ajax({url: 'inc/lineGen.php?shape_id=' + shapeid +'&size_id='+ sizeid + '&is_Double='+is_Double})  
  .done(function(lines){    
      $('div#Lines').html(lines);      
      $('div#Lines input').keyup(function(){Engraver(this)});
      $('div#Lines input').focus(function(){
          $(this).addClass('activate');
      });
      $('div#Lines input').blur(function(){
          $(this).removeClass('activate');
      });
      
      //disable the other lines when there is an image selected
      var is_DoubleNotSteel = $('input#takes_img').val();
      if(is_DoubleNotSteel == 1){
          var imgid = $(nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[5]).attr('id');
          if(imgid != 0){
            $('input.EngF').attr('disabled', true);
            $('input#line1').attr('disabled', false);
      }
      }
      
  })
}




//this function set the color for the tags that don't have choice for color'
function setColor(elem, color, id){
  $(elem).css('background-color', color);
   var inputColorId =  nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[3] ;//the color id in the normal                        
    $(inputColorId).attr('value', id)
}


function tagResize(shape, elem, sizeId){
	var is_Random = $('input#Type').val() == 4 ? 1 : 0;	
//*-----------set the size id to the input hidden-------------*//              
      ///get the correct input SizeId element
    var inputSizeId =  nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[2] ;        
    //set the value of the current size input hidden element to the current size id   
   $(inputSizeId).attr('value', sizeId);
   
   
   var win = 0;
   var hin = 0;
        //get the original image dimensions from the function
    var originalDimensions = tagInfo(shape);
    var OriginalimageWidth = originalDimensions[4];
    var OriginalimageHeight = originalDimensions[5];    

     if(elem != 0){//if this is not a medical tag i  get the image sizes from the span inside the parragraph elements in inches
          win = elem.nextSibling.childNodes[1].innerHTML;
         hin = elem.nextSibling.childNodes[5].innerHTML;
     }else{ //if this is a medical tag set the sizes to the millitary large
          win = 2;
          hin = 1.15;
     }
        
    //traslate the values of the tags in pixels
    var swidth = (win * 96) * 1.5//the standard dpi by the scale gives me the equivalent pixels;
   var sheight = (hin * 96) * 1.5;   
   var newOutArea = swidth * sheight;
   
   
   //get the variation ratio for the dimensions of the image
   var deltax = swidth/ OriginalimageWidth; //the last value enter the first
   var deltay = sheight/OriginalimageHeight;

   
   //get the margins variables  and multiply them by the variation ratio to get the new proportional margins
    var margins = tagInfo(shape);
    var mleft = margins[3] * deltax;
    var mright = margins[1] * deltax;
    var mtop = margins[0] * deltay;
    var mbottom = margins[2] * deltay;
    
    //get the new size for the inner rectangle
    var yMargin =sheight - (mtop + mbottom);
    var xMargin =swidth - (mleft + mright);
             
   //display the preview image with the size calculated in pixels   
   var imgPrev = $(nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[0]);//img.preview   
   var prevContainer = $(nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0]);//prev containfer   
   imgPrev.animate({height: sheight, width: swidth}, 400);          
   prevContainer.animate({height: sheight, width: swidth}, 400);

   //show the user messages
   if(is_Random != 1){
   $('span#width').html('Width = ' + win + 'In');
   $('span#Height').html('Height = ' + hin + 'In');
   }
   
}

/*------------------ COLOR SELECTOR-----------------------*/                 
//click handler
function displayColor(){
    var is_silencer = $('img.imageSelected').attr('id') == 22 ? 1 : 0 ;       
      //var is_Double = $('input#is_Double').val();

        //tell the user the color he's selected'
          $('span#colorSelection').html('New color Selected!! : <strong>' + this.title + '</strong>');

          //style effects to show the selected color
          $('div.color').css({"height": "30px", "width": "30px", "border": "none"});  
          $(this).animate({height: '+=15', width: '+=15'}, 400);
          $(this).css('border', '2px solid white');

          //get the background color of the clicked div
         var currentColor = $(this).css('background-color');
         
         var imgPrev = is_silencer == 1 ? $('div#Innersilencer img') : $(nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[0]) ;
         
          //set the silencer color to the preview
          if( is_silencer == 1){            
              $('div#accordion h3.ui-state-active span#SColor').html('Silencer: ' + this.title); //show the silencer color in the title of the preview
                //set the silencer color input hidden
                var inputSilenColorId = nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[4] ;                                                                  
                $(inputSilenColorId).attr('value', this.id);   
                $(imgPrev).removeClass();
                imgPrev.addClass(this.title);
                
          }else{ //only set the tag color id if this is not the silencer color      
              //set the color id input hidden
              var inputColorId =  nextElementSibling($('div#accordion h3.ui-state-active').get(0)).childNodes[1].childNodes[0].childNodes[3] ;//the color id in the normal                        
                $(inputColorId).attr('value', this.id);
                $(imgPrev).removeClass();
                imgPrev.css('background-color', currentColor);   
          }   
                             
}



//reset preview 
function previewReset(){
    
    //clean the user notifier
        $('span#sizeSelection').html('');
        $('div#shapeSelector span#userSelection').html('');
        $('span#colorSelection').html('');
        $('span#width').html('');
        $('span#Height').html('');
        
        //clear the color and size shower
         $('div#innerColorSelector').html('');      
         $('div#innerSizeSelector').html('');           
         
         //clear the selected clasess
        $('img.shapes').removeClass('imageSelected');        
        
        //desable the lines input module
        //$('input.engraving ,input.engravingSinle, input.engravingD').attr('disabled', true);
        $('div#Lines').html('');
        //$('input.engraving ,input.engravingSinle, input.engravingD').removeClass('activate');
        
        //clear the items in the random
        $('input[name=pet]').attr('checked',false);
        $('input[name=sex]').attr('checked',false);
}


/*================THE SLIDESHOW CONTROLLER================*/

//this function change the slides
 function slideChange(){
      
      if(i > 1){
          $('div#slideshowimg img#slide'+i).fadeOut(1000);
          $('div#Slider div').removeClass('selectedSlide');
          $('div#Slider div#slide'+(i-1)).addClass('selectedSlide');
          i--;
 
      }else{
          i = 4;
          $('div#slideshowimg img').fadeIn(1000);        
          $('div#Slider div').removeClass('selectedSlide');
          $('div#Slider div#slide'+i).addClass('selectedSlide');
      }
      
     }   
     
     /*============NEXT ELEMENT SIBLING EMULATOR================*/
 function nextElementSibling( el ) {
         do {el = el.nextSibling} while ( el && el.nodeType !== 1 );
        return el;
}

/*=============THE CHARACTER COUNTER================*/     

function wordCount(mx, elem){
    return mx - elem.value.length + " characters left";	
}

/*------------------DATA VALIDATION FUNCTIONS--------------------------*/

function notEmpty(element, description, helper){
      return(validateExpression(element, /.+/, description, helper));
}

 function validateEmail(element, description, helper){
     if(!notEmpty(element, description, helper)){
         return false;
     }
     return validateExpression(element, /^[\w\+-\._]+@[\w-]+(\.\w{2,4})$/, description, helper)
 }
 
 function validateNumber(ele, descr, helper){     
      if(!notEmpty(ele, descr, helper)){
         return false;
     }
     return validateExpression(ele, /^\d+$/, descr, helper);
 }
 
 function validateExpression(element, expression, description, helper){
     if (!expression.test(element.value)){
                    element.style.border = "2px solid red";
                    element.style.backgroundColor = "#FFFDD3";
                    helper.html(description);
                    return false;
    }else{
            helper.html('');
            element.style.border = "";
            element.style.backgroundColor = "";
            return true;
    }
 }
 
 
 function validateForm(element, description, helper){             
     if(notEmpty(element['ebayUserName'],  description, helper) ==true  && 
             validateEmail(element['email'], description, helper ) == true &&
                validateNumber(element['Qt'], description, helper) == true){             
             return true;                              
     }else{
         alert(description);         
         return false;
     }
 }
 
 /*------------------FUNCTION TO GET THE MARGINS & ANOTHER INFO FOR EACH TAG IMAGE--------------------------*/
 
 function tagInfo(shape){
     
     //return the specified margins for each shape
     
     var mright;
     var mleft;
     var mtop;
     var mbottom;
     var width;
     var height;
     
     switch(shape){
         
         case 'Barrel':
             mleft = 18;
             mright =   24;
             mtop = 64;
             mbottom =  47;
             width = 251;
             height =   215;          
             break;
             
         case 'Heart':
             mleft = 23;
             mright =   29;
             mtop = 44;
             mbottom =  73;
             width = 171;
             height =   189;        
             break;
             
         case 'Shamrock':
             mleft = 23;
             mright =   32;
             mtop = 60;
             mbottom =  53;
             width = 178;
             height =   176;
             break;
             
         case 'Doggie':
             mleft = 23;
             mright =   27;
             mtop = 44;
             mbottom =  40;
              width = 174;
             height =   158;     
             break;
             
         case 'Cat':
             mleft = 23;
             mright =   27;
             mtop = 40;
             mbottom =  32;
              width = 160;
             height =   161;         
             break;
             
         case 'Star':
             mleft = 35;
             mright =   40;
             mtop = 56;
             mbottom =  38;
             width = 191;
             height = 189;  
             break;
             
         case 'Bulldog':
             mleft = 59;
             mright =   63;
             mtop = 56;
             mbottom =  66;
             width = 227;
             height =   201;            
             break;
             
         case 'Pawprint':
             mleft = 26;
             mright =   36;
             mtop = 53;
             mbottom =  47;
             width = 176;
             height =   188;   
             break;
             
         case 'Mouse':
             mleft = 47;
             mright =   56;
             mtop = 41;
             mbottom =  39;
             width = 182;
             height =   173;        
             break;
             
         case 'Octagon':
             mleft = 20;
             mright =   27;
             mtop = 38;
             mbottom =  48;
             width = 158;
             height =   157;      
             break;
             
         case 'Skull':
             mleft = 59;
             mright =   63;
             mtop = 56;
             mbottom =  66;
              width = 227;
             height =   201;  
             break;
             
         case 'Circle':
             mleft = 30;
             mright =   33;
             mtop = 62;
             mbottom =  44;
             width = 168;
             height =   192;        
             break;
             
         case 'Shield':
             mleft = 23;
             mright =  30;
             mtop = 41;
             mbottom =  47;
             width = 174;
             height =   187; 
             break;
             
         case 'Tshirt':
             mleft = 47;
             mright =   53;
             mtop = 48;
             mbottom =  36;
             width = 189;
             height =   180;    
             break;
             
         case 'Bone':
             mleft = 38;
             mright =   46;
             mtop = 42;
             mbottom =  43;
             width = 264;
             height =   192;       
             break;
             
         case 'Millitary':
             mleft = 29;
             mright =   51;
             mtop = 21;
             mbottom =  31;
              width = 261;
             height =   158;     
             break;
             
         case 'House':
             mleft = 23;
             mright =   30;
             mtop = 50;
             mbottom =  23;
             width = 154;
             height =   170;      
             break;
             
         case 'Hydrant':
             mleft = 34;
             mright =   37;
             mtop = 48;
             mbottom =  30;
             width = 164;
             height =   173;    
             break;
             
         case 'Cloud':
             mleft = 33;
             mright =   36;
             mtop = 40;
             mbottom =  49;
             width = 171;
             height =   171;   
             break;
             
         case 'Random':
             mleft = 20;
             mright =   20;
             mtop = 20;
             mbottom =  20;
             width = 199;
             height =   127;   
             break;
             
         case 'Glitter':
             mleft = 30;
             mright =   33;
             mtop = 62;
             mbottom =  44;
             width = 168;
             height =   192;        
             break;
             
             
         default:
             mleft = 30;
             mright =   45;
             mtop = 53;
             mbottom =  43;
             width = 251;
             height =   215;         
             break;
                       
             
     }
     
     
     var tagInfo = [mtop, mright, mbottom, mleft, width, height];
     
     return tagInfo;
     
 }
 
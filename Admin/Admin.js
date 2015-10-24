   /*---------------------------THE ADMIN SECTION-----------------------*/
           
$(document).ready(function(){   
    //on click load the products
    $('span.OrderId').click(function(){
        getData(0, 'Products');
        //and clear everything
    $('div#Products').html('');
    $('div#Shapes').html('');
    $('div#Sizes').html('');
    $('div#Colors').html('');
    
})    
    
});//on load event

//Function to make ajax requests and get the options for your selection

function getData(id, displayer){
    $.ajax({url: 'getData.php', data: {sid: id, dis: displayer}, type: "POST"})
    .done(function(res){
        $('div#'+displayer).html(res);
        
        //add the event listeners to the radiobuttons
        $('input.pro').click(function(){
            getData($(this).val(), 'Shapes');
            $('div#Shapes').html('');
            $('div#Sizes').html('');
            $('div#Colors').html('');
        })
        
        $('input.shape').click(function(){
            getData($(this).val(), 'Sizes');
            $('div#Sizes').html('');
            $('div#Colors').html('');
        })
        
        $('input.size').click(function(){
            getData($(this).val(), 'Colors'); 
            $('div#Colors').html('');
        })
        
        //add the event listener to the checkboxes
        $('input.avail').change(function(){
            var state = $(this).attr('checked') ? 1 : 0;     
            //alert(this.id + ' ' + $(this).val() + ' ' + state);
             updater(this.id, $(this).val(), state);             
        })
    })           
}

//function to update the availbility
function updater(table, id, state){
     $.ajax({url: 'Updater.php', data: {itable: table, TheId: id, TheState: state}, type: "POST"})
     .done(function(res){
         //alert(res);
     })
}




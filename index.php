<?php
/*
 * The main page
 * 
 */
$process = 'Step1'; 
require_once 'inc/header.php';
require_once 'inc/tagSelection.php';

?>

<body>
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6. chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  
<!--  generate the links pages with the lightbox funtions-->
 <div id="FrontWhy" class="white_content"><?php require_once 'inc/WhyUs.php';?></div>
 <div id="FrontFaq" class="white_content"><?php require_once 'inc/Faq.php';?></div>
 <div id="FrontPoli" class="white_content"><?php require_once 'inc/Policies.php';?></div>
 <div id="FrontLoggin" class="white_content2"><?php require_once 'inc/Loggin.php';?></div> 
  <div id="Back" class="black_overlay"></div>        
  
  <div id="main"> 
      <div id="main1">
              <div id="main2">                  
              <?php require_once 'inc/navigation.php';?>                                                                       
              
                  
              <div class="content">
                  <div class="contenttitle">
                    <h1 class="steptitle">Step 1</h1>
                    
                  </div> 
                  
                  <form  action="tagbuilder.php" method="get" id="tagbuilder">
                      <fieldset id="step1">
                        <div class="fieldsetdiv">
                            <label for="ebayUserName">Ebay username</label>
                            <input type="text" name="ebayUserName" class="Inputdata" id="ebayUserName" placeholder="ebay username..." />
                        </div>
                        <div class="fieldsetdiv">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="Inputdata"  placeholder="email address..." />
                        </div>
                          
<!--                          dont display this module if the tag is multiple-->
                <?php if(TAGTYPE == 9 || TAGTYPE == 10) {?>
                            <input type="hidden" name="Qt"  class="Inputdata"  value="1" />
                <?php }else{?>
                          <div class="fieldsetdiv">
                            <label for="Qt">How many tags You bought</label>
                            <input type="text" name="Qt" id="Qt" class="Inputdata"  placeholder="Quantity" />
                        </div>
                <?php }?>
                            <input type="image" src="img/Next_button.png" name="SendTagBuilder" id="SendTagBuilder" value="Next"/>
                            <input type="hidden" name="type" value="<?php echo TAGTYPE; ?>"/>
                      </fieldset>
                  </form>
                  <div id="tagimage"></div>
                  
                  <p id="helper"></p>   
                  
                  <div id="Note">
                      <h3>Watch out!!!</h3>
                  <p>                  
                  Check this information twice. If there is any mistake in your information above your tag will not be processed.
                  </p>
                      
                  </div>
                  
              </div>
                  
          
        
          </div>
          </div>
            <?php require_once 'inc/footer.php';?>  
 
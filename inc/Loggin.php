<?php

/*
 * this is the loggin form for the admin section
 * 
 */
?>
                
        <div id="logIn">
            <div id="pickerClose" title="Cancel"></div>
            <h1 class="navigationTitle">Loggin</h1>
            
            <form method="POST" action="Admin/index.php">
                <fieldset>
                    <div>
                        <label for="User">User</label><input type="text" name="User" id="User" class="AdminInput"/>
                    </div>
                    <div>
                        <label for="Pass">Password</label><input type="password" name="Pass" id="Pass" class="AdminInput"/>
                    </div>
                    <input type="submit" name="send" id="send" value="Loggin"/>
                </fieldset>
            </form>
            
        </div>

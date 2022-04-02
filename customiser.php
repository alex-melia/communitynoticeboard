<?php

require_once "header.php";

echo <<<_END
<div class="customiser_form">
    <h3><b><i>Customise Page</i></b></h3>
    Change Background Colour: <input type="color" id="changeBackgroundColour"/><br>
    Change Text Colour: <input type="color" id="changeTextColour"/><br>
    Change Font Size: <input type="number" id="changeFontSize"/> <button id="changeFontSize">Change Font Size</button><br>
    Change Font Type: <input type="text" id="changeFontType" value="e.g 'Verdana' "/> <button id="changeFontType">Change Font Type</button><br>
</div>

<script>
    $(document).ready(function(){
        $("#changeBackgroundColour").change(function(){
            $("body").css("background-color", $(this).val());
        });
        $("#changeTextColour").change(function(){
            $("body").css("color", $(this).val());
        });
        $("#changeFontSize").change(function(){
            $("body").css("font-size", $(this).val()+'px');
        });
        $("#changeFontType").change(function(){
            $("body").css("font-family", $(this).val());
        });
    });

</script>
_END;


?>
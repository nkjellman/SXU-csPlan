<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php include 'nav.php'; ?>



<div class="container" id="main">
<link rel="stylesheet" type="text/css" href="CSS/exform.css"> 





<div class ="center">
<script src="js/f.js"></script>

<form method="post" name=f
enctype="multipart/form-data"
onsubmit="return check();"
action="">
<p>
Please select a Excel (.xlsx) file to be sent:
<br>
<input type="file" name="xls" size="40"
accept="exel/xlsx">
<p>
Text:<br>
<textarea name="expl" rows="7" cols="40"
onfocus="check();">
</textarea>
<p>
<input type="submit" value="Send">

</form>
</div>
</div>
</div>
</div>

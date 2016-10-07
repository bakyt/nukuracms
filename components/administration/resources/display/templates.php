<?php
$table = $Administration->getListFromFile('templates/'.TEMPLATE.'/sources/positions.txt', 'li');
$select = $Administration->getListFromFile('templates/'.TEMPLATE.'/sources/positions.txt', 'option');
?>
<div id="small_window">
<div class="title">Position</div>
<div class="body">
	<input style="width:145px;" type="text"/><input type="button" value="Кош"/>
	<ul class="position_box"><?php echo $table?></ul>
	<select style="width:138px;"><?php echo $select?><input type="button" value="Өчүр"/></select>
</div>
</div>
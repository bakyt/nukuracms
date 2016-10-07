<div id = "content">
<?php
$i=0;
$counter = 0;
for($i=0;$i<count($items);$i++){
if($items[$i]['parent_id']) $list = 12; else if (!$items[$i]['parent_id']){if($counter != 2)$list = 6;$counter+=1;}if($counter == 3) $counter = 0;	
?>
	<a href="/content/<?php echo $items[$i]['link']?>"><div class="list row col-sm-<?php echo $list;?> col-xs-12 col-md-<?php echo $list?> col-lg-<?php echo $list?>">
		<?php if($items[$i]['parent_id']){echo'<img class="img"  src="/templates/'.TEMPLATE.'/images/content/category.png">';}else{echo'<img style="float:left; display:block; height:240px;margin:0 8px 0 0;" src="/templates/'.TEMPLATE.'/images/content/no_img.png">';}?>
		<h4><?php if(!$items[$i]['parent_id']) echo substr(htmlspecialchars($items[$i]['name']), 0, 179).'...';else echo $items[$i]['name'];?></h4>
		<p class="text"><?php if(!$items[$i]['parent_id']) echo substr(htmlspecialchars($items[$i]['text']), 0, 420).'...'?></p>
	</div></a>
<?php } ?>
</div>
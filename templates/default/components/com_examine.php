<div id="examine">
<?php
for($i=0; $i < count($cats); $i++){?>
<a href="/examine/<?php echo $cats[$i]['id']?>">
<div class="cat col-xs-12 col-md-12 col-sm-12 col-lg-12">
<?php echo $cats[$i]['name']?><br />
<small><?php echo $cats[$i]['description']?></small>
</div>
</a>
<?php } ?>
</div>
<div id="examine">
<form action="/examine/do" method="post">
<input type="hidden" name="cat" value="<?php echo $cat['id']?>"/>
<?php
for($i=0; $i < count($questions); $i++){?>
<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
<div class="question"><?php echo ($i+1).') '.$questions[$i]['question'];?></div>
<?php if($questions[$i]['answers'][0]) {?><label for="A_<?php echo $i;?>"><div class="btn btn-default answer col-xs-6 col-md-3 col-sm-6 col-lg-3"><input id="A_<?php echo $i;?>" name="answer_<?php echo $questions[$i]['id'];;?>" type="radio" value="1"><?php echo 'А) '.$questions[$i]['answers'][0]?></div></label><?php } ?>
<?php if($questions[$i]['answers'][1]) {?><label for="B_<?php echo $i;?>"><div class="btn btn-default answer col-xs-6 col-md-3 col-sm-6 col-lg-3"><input id="B_<?php echo $i;?>" name="answer_<?php echo $questions[$i]['id'];;?>" type="radio" value="2"><?php echo 'Б) '.$questions[$i]['answers'][1]?></div></label><?php } ?>
<?php if($questions[$i]['answers'][2]) {?><label for="C_<?php echo $i;?>"><div class="btn btn-default answer col-xs-6 col-md-3 col-sm-6 col-lg-3"><input id="C_<?php echo $i;?>" name="answer_<?php echo $questions[$i]['id'];;?>" type="radio" value="3"><?php echo 'В) '.$questions[$i]['answers'][2]?></div></label><?php } ?>
<?php if($questions[$i]['answers'][3]) {?><label for="D_<?php echo $i;?>"><div class="btn btn-default answer col-xs-6 col-md-3 col-sm-6 col-lg-3"><input id="D_<?php echo $i;?>" name="answer_<?php echo $questions[$i]['id'];;?>" type="radio" value="4"><?php echo 'Г) '.$questions[$i]['answers'][3]?></div></label><?php } ?>
<?php if($questions[$i]['answers'][4]) {?><label for="E_<?php echo $i;?>"><div class="btn btn-default answer col-xs-6 col-md-3 col-sm-6 col-lg-3"><input id="E_<?php echo $i;?>" name="answer_<?php echo $questions[$i]['id'];;?>" type="radio" value="5"><?php echo 'Д) '.$questions[$i]['answers'][4]?></div></label><?php } ?>

</div>
<?php } ?>
<input type="submit" style="float:right" class="btn btn-default" name="finish" value="<?php echo $_LANG['FINISH']?>">
</form>
</div>
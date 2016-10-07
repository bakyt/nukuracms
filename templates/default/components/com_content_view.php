<div id="users_profile" style="padding-top:10px;">
<?php echo $_LANG['CONTENT_AUTHOR'].': <a href="/users/'.$item['author']['id'].'">'.$item['author']['name'].'</a>'.'<br />'.$_LANG['DATE'].': '.System::siteDate($item['date'], "year/month/time")?><br />
<div class="profile col-md-12 col-lg-12 row">
<img style="float:left; display:block; height:240px;margin:0 8px 8px 0; border:2px solid #cdcdcd; box-shadow:0 15px 15px rgba(0,0,0,0.5);" src="/templates/<?php echo TEMPLATE?>/images/content/no_img.png">
<?php echo $item['text']?><br />
</div>
</div>
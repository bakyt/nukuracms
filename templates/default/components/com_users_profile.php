<div id="users_profile">
<?php echo $_LANG['STATUS'].': '.$user['status']?><br />
<div class="col-md-4 col-lg-4 row">
<img class="col-xs-4 col-sm-4 profile_avatar col-md-12 col-lg-12" src="/templates/<?php echo TEMPLATE?>/images/profile/no_avatar_<?php echo $user['jynysy']?>.png">
<div class="col-xs-2 col-sm-8 col-md-12 col-lg-12">
<a href="/users/<?php echo $user['id']?>/message"><?php echo $_LANG['MESSAGE']?></a><br />
<a><?php echo $_LANG['SETTINGS']?></a>
</div>
</div>
<div class="profile col-md-8 col-lg-8">
<?php echo $_LANG['NAME'].': '.$user['name']?><br />
<?php echo $_LANG['USERNAME'].': '.$user['login']?><br />
<?php echo $_LANG['LASTVISIT'].': '.$user['lastvisit']?><br />
<?php echo $_LANG['JYNYSY'].': '.$user['jynysy']?><br />
<?php echo $_LANG['BIRTHDATE'].': '.$user['birthdate']?><br />
</div>

</div>
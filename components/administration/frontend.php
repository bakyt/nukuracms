<?php
function com_administration($config=''){
	if(Page::set()->getUrlPart(0) == "administration" and Configuration::set()->get("ADMIN_LINK") != "administration") Page::error404();
}
?>
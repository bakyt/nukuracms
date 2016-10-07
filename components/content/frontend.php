<?php
function com_content($config=''){
	global $_LANG;
	System::loadComponentLanguage('content');
	$Content = new com_content();
	$logUser = User::set();
	$System = System::set();
	$Page = Page::set();
	$link = $Page->getFromLastUrlPart(1);
	if(!$Page->getUrlPart(1) or System::trim_to_dot($link) != '.html'){
		$items = $Content->getCatItems($link);
		$cat = $Content->getCatInfoName($link);
		if($Page->getRequestUri() != 'content/'.$cat['link']) $Page->error404();
		$System->initTemplate("component")->
		setTitle($cat['name'])->
		assign($items, "items")->
		assign($_LANG, "_LANG")->
		display("com_content_list");
	}
	else if(System::trim_to_dot($link) == '.html'){
		$item = $Content->getItem($link);
		if($Page->getRequestUri() != 'content/'.$item['link']) $Page->error404();
		$item['author'] = User::getAuthor($item['author']);
		$System->initTemplate("component")->
		setTitle($item['name'])->
		assign($item, "item")->
		assign($_LANG, "_LANG")->
		display("com_content_view");
	}
	else Page::error404();
}
?>
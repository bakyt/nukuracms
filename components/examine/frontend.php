<?php
function com_examine($config=''){
	global $_LANG;
	if(!User::set()->id) Page::forbiddenForGuests();
	System::loadComponentLanguage('examine');
	$Examine = new com_examine();
	$logUser = User::set();
	$System = System::set();
	if(Page::set()->getUrlPart(1) == ''){
		$AllCats = $Examine->getAllCategories();
		$System->initTemplate('component')->
		setTitle($_LANG['EXAMINE'])->
		assign($logUser, "logUser")->
		assign($_LANG, "_LANG")->
		assign($AllCats, "cats")->
		display('com_examine');
	}
	else if((int)Page::set()->getUrlPart(1)){
		$ques = $Examine->getCatQuestions(Page::set()->getUrlPart(1));
		$cat = $Examine->getCat(Page::set()->getUrlPart(1));
		if (!$ques or !$cat) Page::error404();
		$System->initTemplate('component')->
		setTitle($_LANG['QUESTIONS']." - ".$cat['name'])->
		assign($logUser, "logUser")->
		assign($_LANG, "_LANG")->
		assign($cat, "cat")->
		assign($ques, "questions")->
		display('com_examine_item');
	}
	else if(Page::set()->getUrlPart(1) == 'do' and isset($_POST['finish'])){
		$ques = $Examine->getCatQuestions($_POST['cat']);
		$cat = $Examine->getCat($_POST['cat']);
		if (!$ques or !$cat) Page::error404();
		$true_ans = 0;
		$false_ans = 0;
		for($i=0;$i < count($ques);$i++){
			//echo $ques[$i]['answer'];
			if($_POST['answer_'.$ques[$i]['id']] == $ques[$i]['true_answer']) $true_ans += 1;
			else $false_ans += 1;
			$jooptor .= $ques[$i]['id'].':'.$_POST['answer_'.$ques[$i]['id']].';';
		}
		if($Examine->checkExisting($logUser->id, $_POST['cat'])) System::sendNotice(3, "Экзаменди бир жолу гана тапшыруу мүмкүн!");
		DB::set()->insert('com_examine_result', "('', '$logUser->id', '$_POST[cat]', 'true:$true_ans;false:$false_ans;', '$jooptor')");
		System::sendNotice(1, "Туура: ".$true_ans."<br />Ката: ".$false_ans);
	}
	else Page::error404();
}
?>
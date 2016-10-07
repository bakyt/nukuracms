<?php
class com_examine{
	private $questions;
	private $cat;
	public function __construct(){
		$sql = "SELECT * FROM `com_examine`";
		$this->questions = DB::set()->query($sql);
		$sql = "SELECT * FROM `com_examine_cat`";
		$this->cat = DB::set()->query($sql);
	}
	public function getAllQuestions(){
		$q=0;
		$questionarr = array();
		while($question = $this->questions->fetch_assoc()){
			$questionarr[$q] = $question;
			$q++;
		}
		return $questionarr;
	}
	public function getAllCategories(){
		$q=0;
		$questionarr = array();
		while($cat = $this->cat->fetch_assoc()){
			if($cat['display'] == 0) continue;
			$questionarr[$q] = $cat;
			$q++;
		}
		return $questionarr;
	}
	public function getCat($id){
		while($cat = $this->cat->fetch_assoc()){
			if($id == $cat['id']) {$result = $cat;break;}
		}
		return $result;
	}
	public function getCatQuestions($id){
		$i=0;
		$result = array();
		while($question = $this->questions->fetch_assoc()){
			if($id != $question['category']) continue;
			$ques['answers'] = explode(';', $question['answers']);
			$question['answers'] = array();
		for ($j = 0; $j < count($ques['answers'])-1; $j++){
			$question['answers'][$j] = $ques['answers'][$j];
		}
			$result[$i] = $question;
			$i++;
		}
		return $result;
	}
	public function checkExisting($user_id, $cat_id){
		$sql = "SELECT `user_id`, `cat_id` FROM `com_examine_result`";
		$results = DB::set()->query($sql);
		while($result = $results->fetch_assoc()){
			if($result['user_id'] == $user_id and $result['cat_id'] == $cat_id) $ans += 1;
		}
		return $ans;
	}
}
?>
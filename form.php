<?php 

class form{

	private $form;
	private $fields;
	

	public function __construct($form,$method){
	
		$this->_form = "<form method='$method' action='$form' /></br> ";
		$this->_fields = array();
	
	}
	
	public function setText($affiche,$name,$value,$back_text = ""){
		$this->_fields[] ="<div style=' display: inline-block; margin-left : 50px;'><p style='float:left; font-size: x-large;'>$affiche : </p> 
							<p><input placeholder='$back_text' style='height: 35px; float:right; width:1200px; ' name='$name' value='$value' type='text' /></p></div></br>";
	}
	

	
	public function setRadio($name,$id,$value,$select = ""){
	$this->_fields[] = "<input style='margin-left : 65px; ' type='radio' id='$id' name='$name' value='$value' $select/>
						<label style='font-size: x-large;' for='$id'> $id </label>";
	}
	
	
	
	public function setInput($affiche,$name,$value,$type){
		$this->_fields[] = "<p style='font-size: x-large; margin-left : 50px;'>$affiche </p> 
							<input style='font-size: large; margin-left : 65px;' name='$name' value='$value' type='$type'/>";
	}
	
	public function setTextarea($affiche,$name,$value,$back_text = ""){
		$this->_fields[] ="<div style=' display: inline-block; margin-left : 50px;'><p style='float:left; font-size: x-large;'>$affiche : </p> 
							<p><textarea rows='10' cols='50' placeholder='$back_text' style='float:right; width:1200px; ' name='$name' >$value</textarea></p></div></br>";
	}
	
	public function addText($text){
		$this->_fields[] = "<p style='font-size: x-large; margin-left : 50px;'>$text </p>";
	}	
	
	public function getform(){
		
		echo $this->_form;
		
		foreach($this->_fields as $field){
			echo $field;
		}
		
		echo "<br /> <input style='font-size: x-large; background-color: #A9AFAF; color:black; margin-bottom:50px; margin-left:50; margin-top:40px; height: 40px; float:left; width:250px;' type='submit' value='valider' /> ";
		echo "</form>";
	}


}



?>

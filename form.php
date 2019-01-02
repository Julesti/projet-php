<?php 

class form{

	private $form;
	private $fields;
	

	public function __construct($action,$method){
	
		$this->_form = "<form method='$action' action='$action' /> <br />";
		$this->_fields = array();

	}
	
	public function setText($text,$name,$value){
		$this->_fields[] = "<p>$text : </p> 
							<br />
							<input name='$name' value='$value' type='text'/>
							<br />
							<br />";
	}
	

	
	public function setRadio($name,$id,$value){
	$this->_fields[] = "<input type='radio' id='$id' name='$name' value='$value' />
						<label for='$id'> $id </label>
						<br />";
	}
	
	
	
	public function setInput($affiche,$name,$value,$type){
		$this->_fields[] = "<p>$affiche : </p> 
							<br />
							<input name='$name' value='$value' type='$type'/>
							<br />
							<br />";
	}
	
	public function addText($text){
		$this->_fields[] = "<p>$text </p>";
	}	
	
	public function getform(){
		
		echo $this->_form;
		
		foreach($this->_fields as $field){
			echo $field;
		}
		
		echo "<br /> <input type='submit' value='valider' /> <br />";
		echo "</form>";
	}


}



?>

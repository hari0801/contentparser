<?php

class Counter{

	public $name;
	public $threshold;
	public $operator;
  public $occurrances;
  
	public function __construct($name, $threshold, $operator){
		$this->name = trim($name);
		$this->threshold = trim($threshold);
		$this->operator = trim($operator);
	}
  
  public function addOccurance() {
    $this->occurances++;
  }
  
  public function getOccurances() {
    return $this->occurances;
  }
  
  public function validateOccurance($extractedValue) {  
    $is_valid = false;
    switch($this->operator){
      case ">":
        $is_valid = $extractedValue > $this->threshold;
        break;
      case ">=":
        $is_valid = $extractedValue >= $this->threshold;
        break;      
      case "<":
        $is_valid = $extractedValue < $this->threshold;
        break;
      case "<=":
        $is_valid = $extractedValue <= $this->threshold;
        break;
      case "=":
        $is_valid = $extractedValue == $this->threshold;
        break;
    }
    if ($is_valid)  {
      $this->occurances++;
      return true;
    } 
    return false; 
  }
  
  
}

?>
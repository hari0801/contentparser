<?php 

class ContentHelper {
  
	private $content;
  
	public function __construct($content) {
		$this->content = $content;
	}
  
	function matchCounters() {

		$pattern = "";	
		foreach($this->content->parserProfiles as $parserProfile) {						
			foreach($parserProfile->object_array as $objects) {
				foreach ($objects->object_strings as $object_string) {
					$pattern .= ":".$object_string->name."|";
				}
			
			}	
		}
		$pattern .= '--- panio'. '|Elapsed time since last sampling';
		//$pattern = rtrim($pattern,"|");
		$extractedPath = $this->content->tsExtractedPath;
		//$command = "find $extractedPath -name '*dp-monitor*' | egrep -wri '$pattern' $extractedPath";
		$command = "egrep -wri '$pattern' $extractedPath/opt/var.dp0/log/pan/dp-monitor.log";
		$objStrings_map = $this->getObjectStringsMap();
  
		print "\n Before Parsing: \n";
		print_r($objStrings_map);
  
		$results = SystemUtil::executeCommand($command);
    
		foreach($results as $match) {
			print "\n$match";
			$matchers = preg_split("/[\s::]+/", $match);
			$objStrings = $objStrings_map[$matchers[1]];
			if(sizeof($objStrings) > 0) {
				foreach($objStrings as $objString) {
					$objString->validateOccurance($matchers[2]);
				}
			} else {
				//print "\n ---- Inside panio ----";
			}          
		}	
  
		//print "\n After Parsing: \n";
		//print_r($objStrings_map);
	}
  
	public function getObjectStringsMap() {
  
		$obj_strings_map=array();
		foreach($this->content->parserProfiles as $parserProfile) {	
			foreach($parserProfile->object_array as $object) {
				foreach($object->object_strings as $objStr) {
					$key = $objStr->name;
					$value = $obj_strings_map[$key];
					if($value == null) {
						$value = array();            
					} 
					array_push($value, $objStr);
					$obj_strings_map[$key] = $value;
				}
			}
		}
		return $obj_strings_map;
	}
}
?>
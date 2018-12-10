<?php
namespace ShowAnnotation;

use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\DebugClassLoader;
use Symfony\Component\Dotenv\Dotenv;

class Annotation{

	private $annotationArray = null;
	private $annontationFormated = null;

	public function __construct($myClass){
		self::learnPropertyAnnotations($myClass);
		self::formatedToLaravel();
	}

	private function learnPropertyAnnotations($myClass){
		$reflect = new \ReflectionClass($myClass);
		$props   = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_STATIC
		 | \ReflectionProperty::IS_PUBLIC);

		$count = 0;
		$comments_array = null;

		foreach ($props as $prop) {
		    $prop = new \ReflectionProperty($myClass, $prop->getName());
			preg_match_all('#@ORM(.*?)\n#s', $prop->getDocComment(), $comments);
			
			if((array_key_exists(2,$comments[0]) && !stristr($comments[0][2], 'IDENTITY')) || !array_key_exists(2,$comments[0])){
				$search = array('Column', '(', ')', ';', '\\', '"');
				$replace = array('', '', '', '', '', '');
				$str = str_replace($search, $replace, (String)$comments[1][0]);

				$explode = explode(',', $str);

				for($i=0; $i<count($explode); $i++){
					$ex = explode('=', $explode[$i]);
					$comments_array[$count][trim($ex[0])] = trim($ex[1], " ");
				}
				$count += 1;
			}
		}

		$this->annotationArray = $comments_array;
	}
	
	private function formatedToLaravel(){
		$search = array('type', 'length');
		$replace = array('', 'max:');

		foreach ($this->annotationArray as $propetyAnotation) {
			$array[$propetyAnotation['name']] = null; 
			
			$required = "nullable|";
			
			if($propetyAnotation['nullable'] == "false"){
				$required = 'required|'; 
			}

			$array[$propetyAnotation['name']] .= $required; 

			if(!empty($propetyAnotation['length'])){
				$array[$propetyAnotation['name']] .= 'max:'.$propetyAnotation['length']."|"; 
			}			
			
			switch ($propetyAnotation['type']) {
				case 'decimal':
					$array[$propetyAnotation['name']] .= 'numeric';
					break;

				case 'datetime':
					$array[$propetyAnotation['name']] .= 'date';
					break;

				default:
					$array[$propetyAnotation['name']] .= $propetyAnotation['type'];
					break;
			}
		}

		$this->annontationFormated = $array;
	}

	public function setRules(Array $array){
		foreach ($array as $key => $value) {
			$this->annontationFormated[$key] .= "|".$value;
		}
	}

	public function getResult(){
		return $this->annontationFormated;
	}
}
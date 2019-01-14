<?php
namespace ShowAnnotation;

use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\DebugClassLoader;
use Symfony\Component\Dotenv\Dotenv;

class Annotation{

	private $annotationArray 			= null;
	private $annontationFormated 		= null;
	private $annontationFormatedForm 	= null;

	public function __construct($myClass, $formated=false){
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

	public function getResultForm(){
		foreach ($this->annotationArray as $key => $item) {

			switch ($item['type']) {
				case 'string':
					$this->annontationFormatedForm[$key]['type'] = 'text';

					if($item['name'] == 'password' || $item['name'] == 'senha'){
						$this->annontationFormatedForm[$key]['type'] = 'password';
					}

					if($item['name'] == 'email' || $item['name'] == 'e-mail'){
						$this->annontationFormatedForm[$key]['type'] = 'email';
					}

					if($item['name'] == 'arquivo' || $item['name'] == 'file'){
						$this->annontationFormatedForm[$key]['type'] = 'file';
					}

					break;

				case 'integer':
					$this->annontationFormatedForm[$key]['type'] = 'number';
					break;
				
				case 'date':
					$this->annontationFormatedForm[$key]['type'] = 'date';
					break;

				case 'datetime':
					$this->annontationFormatedForm[$key]['type'] = 'date';
					break;

				default:
					# code...
					break;
			}
			
			$this->annontationFormatedForm[$key]['name'] = self::changeCamelcase($item['name'], '_');
			$this->annontationFormatedForm[$key]['label'] = self::changeLabel($item['name'], '_');

			//verifica se e required
			$this->annontationFormatedForm[$key]['required'] = $item['nullable'] == false ? '' : 'required';

			//verifica se tem tamanho maximo
			!empty($item['length']) ? $this->annontationFormatedForm[$key]['max'] = $item['length'] : null;
		}

		return $this->annontationFormatedForm;
	}

	private function changeCamelcase($text, $delimiter) {
		$newText = $text;
		$explode = explode($delimiter, $text);

		if(is_array($explode)){
			$newText = array_shift($explode);

			foreach ($explode as $item) {
				$newText .= ucfirst($item);
			}
		}
		
		return $newText;
	}

	private function changeLabel($text, $delimiter) {
		$newText = ucfirst($text);
		$explode = explode($delimiter, $newText);

		if(is_array($explode)){
			$newText = implode(' ', $explode);
		}
		
		return $newText;
	}
}
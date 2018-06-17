<?php
class Annotation{

	public function getPropertyAnnotations($myClass){
		$reflect = new ReflectionClass($myClass);
		$props   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_STATIC
		 | ReflectionProperty::IS_PUBLIC);

		$count = 0;
		$comments_array = null;

		foreach ($props as $prop) {
		    $prop = new ReflectionProperty($myClass, $prop->getName());
			preg_match_all('#@(.*?)\n#s', $prop->getDocComment(), $comments);

			$search = array('column', '(', ')', ';');
			$replace = array('', '', '', '');
			$str = str_replace($search, $replace, (String)$comments[1][0]);

			$explode = explode(',', $str);

			for($i=0; $i<count($explode); $i++){
				$ex = explode('=', $explode[$i]);
				$comments_array[$count][$ex[0]] = $ex[1];
			}
			$count += 1;
		}

		return $comments_array;
	}
}
<?php
include_once '../app/config/Annotation.class.php';
include_once '../app/Controller/MyClass.class.php';
include_once '../app/config/driver.php';

echo( json_encode( Annotation::getPropertyAnnotations(new MyClass) ) );
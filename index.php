<?php
include_once 'Annotation.class.php';
include_once 'MyClass.class.php';

echo( json_encode( Annotation::getPropertyAnnotations(new MyClass) ) );

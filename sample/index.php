<?php
require __DIR__ . '/../vendor/autoload.php';
include_once 'MyClass.class.php';

dump(new ShowAnnotation\Annotation(MyClass::class));
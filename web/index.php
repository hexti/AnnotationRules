<?php
require __DIR__ . '/../vendor/autoload.php';
include_once '../app/config/Annotation.class.php';
include_once '../app/Controller/MyClass.class.php';

dump(Annotation::getPropertyAnnotations(new MyClass));
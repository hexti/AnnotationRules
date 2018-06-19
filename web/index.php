<?php
include_once '../app/config/Annotation.class.php';
include_once '../app/Controller/MyClass.class.php';
include_once '../app/config/driver.php';
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\DebugClassLoader;
use Symfony\Component\Dotenv\Dotenv;
require __DIR__ . '/../vendor/autoload.php';

dump(Annotation::getPropertyAnnotations(new MyClass));

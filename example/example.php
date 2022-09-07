<?php
require '../vendor/autoload.php';
use Dhenfie\TemplateSystem\TemplateSystem;

// create instance 
$template = new TemplateSystem();
$template->setViewPath(__DIR__);
echo $template->render('main.php', ['message' => 'hello world']);
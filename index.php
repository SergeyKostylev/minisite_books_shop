<?php
require 'functions.php';


//$page= !empty($_GET['page'])? $_GET['page'] : 'default' ;
$page=requestGet('page','default');

$file="controller/{$page}.php";


if (!file_exists($file))
{

    $page='error';
  $file="controller/{$page}.php";

}

$view=$page;
$action=requestGet('action');
require $file;

ob_start();
require "views/{$view}.phtml";
$content=ob_get_clean();

require 'layout.phtml';
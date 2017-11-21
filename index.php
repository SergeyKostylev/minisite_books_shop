<?php
require 'functions.php';


function loadSedBar($dbConnection)
{

    $sql = 'SELECT count(b.id), c.name ,c.id
            FROM category c
            JOIN book b
            ON c.id=b.category_id
            GROUP BY c.id
            ORDER BY c.name;
            ';

    $res = mysqli_query($dbConnection, $sql);
    $category_books = mysqli_fetch_all($res, MYSQLI_ASSOC);

    return $category_books;
}




$dbConfig = [
    'username' => 'root',
    'password' => '',
    'dbname' => 'mvc',
    'host' => 'localhost'
];

$dbConnection = @mysqli_connect(
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['password'],
    $dbConfig['dbname']
);


$SedBar=loadSedBar($dbConnection);



if (!$dbConnection) {
    die('Error connecting to DB:' . mysqli_connect_error());
}

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
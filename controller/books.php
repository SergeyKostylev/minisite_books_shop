<?php

function loadBooks($dbConnection)
{

    $sql='SELECT b.id, b.title, b.description, b.price, b.category_id, cat.name  AS category_name,
                  GROUP_CONCAT(au.first_name, (SELECT \' \'), au.last_name SEPARATOR \', \') AS authors 
            FROM book b
            JOIN author_book a_b
            ON b.id=a_b.book_id
            JOIN author au
            ON au.id =a_b.author_id
            JOIN category cat
            ON cat.id=b.category_id
            GROUP BY b.id;';
    $res = mysqli_query($dbConnection, $sql);
    $books = mysqli_fetch_all($res, MYSQLI_ASSOC);



    return $books;
}
function loadBook($dbConnection, $id)
{
    //$preparedSql = 'SELECT * FROM book WHERE id = ?';

    $preparedSql='SELECT b.id, b.title, b.description, b.price, b.category_id, cat.name  AS category_name, 
                  GROUP_CONCAT(au.first_name, (SELECT \' \'), au.last_name SEPARATOR \', \') AS authors 
            FROM book b
            JOIN author_book a_b
            ON b.id=a_b.book_id
            JOIN author au
            ON au.id =a_b.author_id
            JOIN category cat
            ON cat.id=b.category_id
            GROUP BY b.id
            HAVING b.id = ?
            ;';


    $stmt = mysqli_prepare($dbConnection, $preparedSql);

    mysqli_stmt_bind_param($stmt, 'i', $id);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($res);
}

function early_next_button($dbConnection,$id){

    $books = loadBooks($dbConnection);

    foreach ( $books as $key => $book)
    {
        if($book['id'] == $id)
        {
            $early=($key-1 != -1)? $key-1 : 'not';
            $next=($key+1 < count($books))? $key+1 : 'not';
            $buttons=@['earlybutton' => $books[$early]['id'], 'nextbutton' => $books[$next]['id']];


            return $buttons;
        }
    }
}




$early_disabled=null;
$next_disabled=null;

if ($action == 'show' && $id=requestGet('id')) {
    $books = loadBooks($dbConnection);


    if (isset(early_next_button($dbConnection, $id)['earlybutton'])) {
        $early = early_next_button($dbConnection, $id)['earlybutton'];
    } else {
        $early_disabled = 'disabled';
    }


    if (isset(early_next_button($dbConnection,$id)['nextbutton'])) {
        $next = early_next_button($dbConnection, $id)['nextbutton'];
    } else {
        $next_disabled = 'disabled';

    }

    $book=loadBook($dbConnection, $id);
    if(!$book){
    die('Book not found');
    }
    $view = 'book_show';
}else {
    $books = loadBooks($dbConnection);
}
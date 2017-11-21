<?php
function loadAuthors($dbConnection)
{
    $sql = 'SELECT * FROM author;';

    $res = mysqli_query($dbConnection, $sql);
    $books = mysqli_fetch_all($res, MYSQLI_ASSOC);

    return $books;
}
function loadAuthor($dbConnection, $id)
{
    $preparedSql = 'SELECT * FROM author WHERE id = ?';

    $stmt = mysqli_prepare($dbConnection, $preparedSql);

    mysqli_stmt_bind_param($stmt, 'i', $id);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);


    return mysqli_fetch_assoc($res);
}


function authorBooks($dbConnection, $id)
{
    $sql = 'SELECT b.id, b.title FROM author_book a_b
                    JOIN author a
                    ON a.id=a_b.author_id
                    JOIN book b
                    ON b.id=a_b.book_id
                    WHERE a.id= ? ;';

    $stmt = mysqli_prepare($dbConnection, $sql);

    mysqli_stmt_bind_param($stmt, 'i', $id);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    $books = mysqli_fetch_all($res, MYSQLI_ASSOC);


    return $books;

//    $stmt = mysqli_prepare($dbConnection, $preparedSql);
//
//    mysqli_stmt_bind_param($stmt, 'i', $id);
//
//    mysqli_stmt_execute($stmt);
//
//    $res = mysqli_stmt_get_result($stmt);

//    return mysqli_fetch_assoc($res);
}

if ($action == 'show_author' && $id=requestGet('id')) {

    $author=loadAuthor($dbConnection, $id);

    $author_books=authorBooks($dbConnection, $id);


    if(!$author){
        die('author not found');
    }
    $view = 'author_show';
}
else{
    $authors = loadAuthors($dbConnection);

}
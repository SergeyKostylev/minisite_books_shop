<?php

//manage books logic

function loadBooks()
{
    $str=file_get_contents('books.txt');
    $books=unserialize($str);

    return $books;
}
function loadbook($id)
{
    $books=loadBooks();
    foreach ($books as $book){
        if($book['id'] == $id)
            return $book;
    }
    return false;
}


if ($action == 'show' && $id=requestGet('id'))
{
    $book=loadBook($id);
    if(!$book){
    die('Book not found');
    }
    $view = 'book_show';
}else {
    $books = loadBooks();
}
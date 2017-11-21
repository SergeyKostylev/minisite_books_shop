<?php

function loadCard($dbConnection, $arrayIds)
{
//    $str=file_get_contents('books.txt');
//    $books=unserialize($str);
//    $sql = 'SELECT * FROM book';
    $sql='SELECT b.id, b.title, b.description, b.price, b.category_id, 
                  GROUP_CONCAT(au.first_name, (SELECT \' \'), au.last_name SEPARATOR \', \') AS authors 
    FROM book b
    JOIN author_book a_b
    ON b.id=a_b.book_id
    JOIN author au
    ON au.id =a_b.author_id
    GROUP BY b.id;';
    $res = mysqli_query($dbConnection, $sql);
    $books = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $result=[];
    $sum_price=0;
    foreach ($books as $book){
        if (in_array($book['id'],$arrayIds)){
            $result[]=$book;
            $sum_price+=$book['price'];
        }
    }
    return $result;

}
function sumPrice($dbConnection, $arrayIds)
{
//    $str=file_get_contents('books.txt');
//    $books=unserialize($str);
//    $sql = 'SELECT * FROM book';
    $sql='SELECT b.id, b.title, b.description, b.price, b.category_id, 
                  GROUP_CONCAT(au.first_name, (SELECT \' \'), au.last_name SEPARATOR \', \') AS authors 
    FROM book b
    JOIN author_book a_b
    ON b.id=a_b.book_id
    JOIN author au
    ON au.id =a_b.author_id
    GROUP BY b.id;';
    $res = mysqli_query($dbConnection, $sql);
    $books = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $result=[];
    $sum_price=0;
    foreach ($books as $book){
        if (in_array($book['id'],$arrayIds)){
            $result[]=$book;
            $sum_price+=$book['price'];
        }
    }
    return $sum_price;
}
session_start();

if ($action == 'add' && $id=requestGet('id')) {
//    $currentCart=cookieGet('cart',serialize([]));
//    $currentCart=unserialize($currentCart);
//    $currentCart[] = $id;
//    cookieSet('cart',serialize($currentCart));

    $currentCart=getSession('cart',[]);

    $currentCart[] = $id;

    $_SESSION['cart']=$currentCart;

    redirect('/?page=books');



}

if ($action == 'clear_cart'){

    removeSession('cart');

    redirect('/?page=cart');

}


    if ($action == 'delete' && $id=requestGet('id')) {

    $currentCart=getSession('cart',[]);

    foreach ($currentCart as $key => $item)
    {
        if ($item == $id){
            unset ($currentCart[$key]);
        }
    }
    $_SESSION['cart']=$currentCart;

    redirect('/?page=cart');
}
$currentCart=getSession('cart',[]);
//$currentCart=cookieGet('cart',serialize([]));
//$currentCart=unserialize($currentCart);

$sum_price=sumPrice($dbConnection, $currentCart);
$books=loadCard($dbConnection,$currentCart);
<?php

function loadCard($arrayIds)
{
    $str=file_get_contents('books.txt');
    $books=unserialize($str);
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
function sumPrice($arrayIds)
{
    $str=file_get_contents('books.txt');
    $books=unserialize($str);
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

//removeSession('cart');

}

if ($action == 'clear_cart'){

    removeSession('cart');

    redirect('/?page=cart');

}


    if ($action == 'delete' && $id=requestGet('id')) {
//    $currentCart=cookieGet('cart',serialize([]));
//    $currentCart=unserialize($currentCart);
    $currentCart=getSession('cart',[]);
    var_dump($currentCart) ;
    foreach ($currentCart as $key => $item)
    {
        if ($item == $id){
            unset ($currentCart[$key]);
        }
    }
    $_SESSION['cart']=$currentCart;
//    cookieSet('cart', serialize($currentCart));
    redirect('/?page=cart');
}
$currentCart=getSession('cart',[]);
//$currentCart=cookieGet('cart',serialize([]));
//$currentCart=unserialize($currentCart);

$sum_price=sumPrice($currentCart);
$books=loadCard($currentCart);
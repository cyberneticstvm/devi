<?php

use App\Models\Branch;
use App\Models\Category;

function branches(){
    return Branch::all();
}

function productcode($category){
    $cat = Category::find($category);
    $key = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(strtoupper($cat->name), 0, 1).'-'.substr(str_shuffle($key), 0, 6);
}

?>
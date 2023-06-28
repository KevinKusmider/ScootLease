<?php 

namespace App\Models;

use App\Database\Database;
use App\Entity\User;

class Cart {
    public static function getAllProducts()
    {
        $user = new User();

        if($user->isAuthenticated()) {
            $db = new Database();
            $q = "SELECT p.*, p.quantity as pQuantity, i.quantity FROM products AS p INNER JOIN incart AS i ON p.id = i.idProduct WHERE i.idUser = ?";
            $res = $db->queryAll($q, [$user->get("id")]) ?: null;
            if($res != null) {
                foreach($res as $index => $product) {
                    $res[$index]["images"] =  Products::getProductImages($product["id"]);
                }
            }
            return $res;
        } else {
            $products = isset($_COOKIE["cart"]) ? json_decode(stripslashes($_COOKIE['cart']), true) : [];
            $res = [];
            foreach($products as $id => $quantity) {
                $product = Products::get($id);
                $product["pQuantity"] = $product["quantity"];
                $product["quantity"] = $quantity;
                $product["images"] = Products::getProductImages($product["id"]);
                array_push($res, $product);
            }
            return $res ?: null;
        }
    }
}
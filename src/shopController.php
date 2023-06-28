<?php 

namespace App\Controllers;

use App\Entity\InvoiceProductCommand;
use App\Models\Cart;

use App\Models\Commands;
use App\Models\Invoices;
use App\Models\Partners;

use App\Models\Products;
use App\Models\Scooters;
use App\Models\Subscriptions;
use App\Models\Users;

class ShopController extends BaseController 
{
    public function getAll(array $data = []) 
    {
        $page = 0;
        $perPage = 10;

        if(isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = intval($_GET["page"]) < 0 ? 0 : intval($_GET["page"]);
        }

        $products = Products::getAll($page, $perPage);
        $data["content"]["products"] = $products;
        isset($_GET["showCart"]) ? $data["cart"]["show"] = true : false;
        $data["cart"]["products"] = Cart::getAllProducts();


        $this->display("shop/shop.html.twig", $data);
    }
}
<?php

namespace App\Controllers;

use App\Database\Database;
use App\Models\Commands;
use App\Models\Products;
use App\Models\Users;
use App\Models\Roles;
use App\Models\Subscriptions;
use App\Models\Juicers;

class UserController extends BaseController 
{
    /* LOGIN */
    public function getLogin(array $data = []) 
    {
        if($this->user->isAuthenticated()) {
            header("Location:" . $this->router->generate("myaccount", ["lang" => $this->lang]));
            return true;
        }
        
        isset($_GET["r"]) ? $data["r"] = $_GET["r"] : ""; 
        $this->display("site/login.html.twig", $data);
    }

    public function postLogin() 
    {
        if($this->user->isAuthenticated()) {
            header("Location:" . $this->router->generate("myaccount", ["lang" => $this->lang]));
            return true;
        }

        $res = Users::login($_POST);
        $email = $_POST['email'];

        if($res["status"]) {
            $this->verifSubValidity($email);
            $val = isset($res["boxMsgs"][0]) ? implode(";", $res["boxMsgs"][0]) : "Succès;success;Connecté.";
            $redirect = $this->urls["BASEURL"] . (isset($_GET["r"]) ? $_GET["r"] : "?boxMsgs=" . $val);
            header("Location:" . $redirect);
            return;
        }

        if(isset($res["form"]["checkedFields"])) $data["form"]["checkedFields"] = $res["form"]["checkedFields"];
        if(isset($res["boxMsgs"])) $data["boxMsgs"] = $res["boxMsgs"];
        if(isset($res["form"]["error"])) $data["form"]["error"] = $res["form"]["error"];

        $this->getLogin($data);
    }
}

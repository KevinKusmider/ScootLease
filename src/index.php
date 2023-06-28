<?php 

include("../vendor/autoload.php");

use App\Router\Router;

use Symfony\Component\Dotenv\Dotenv;

session_start();

date_default_timezone_set("Europe/Paris");

$dotenv = new Dotenv();
$dotenv->load("../.env");


define('HOST', $_ENV["HOST"]);
define('STYLESHEETS', HOST . "css/");
define('JAVASCRIPTS', HOST . "javascript/");
define('UPLOADS', HOST . "uploads/");
define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR);


$router = new Router();
$route = isset($_REQUEST["route"]) ? "/" . $_REQUEST["route"] : header("Location:" . HOST . "fr/");

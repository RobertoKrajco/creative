<?php
require_once "App.php";

$app = new App();
$products = $app->prepare("./commonData.csv");

$app->import($products);
$new_stock_data = $app->prepare("./stockData.csv");

$app->updateStocks($new_stock_data);

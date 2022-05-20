<?php

// --- general settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//call ecomdash file
require '_BS_DB.php';
require '_BS_API.php';

//instantiate Ecomdash DB
$bsDBConnection = new BS_DB();

//start connection
$connBS = $bsDBConnection->connectToDB();

$bsGetAllSkus = new BS_API($connBS);

$skuResults = $bsGetAllSkus->getAllSkus();

echo"<pre>";
print_r($skuResults);
echo"</pre>";




//eof

 ?>

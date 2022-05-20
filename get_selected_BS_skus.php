
<?php

// --- general settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//call BS files
require '_BS_DB.php';
require '_BS_API.php';

//instantiate Ecomdash DB
$bsDBConnection = new BS_DB();

//start connection
$connBS = $bsDBConnection->connectToDB();

$bsGetSomeSkus = new BS_API($connBS);

if(!empty($skusForQuery)) {
  $someSKUS = $bsGetSomeSkus->getSelectedSkus($skusForQuery);

} else {
  echo "No skus provided";
}






//eof

 ?>

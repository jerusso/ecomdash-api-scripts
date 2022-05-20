<?php
// --- general settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("America/Los_Angeles");//set local timezone

require_once "../top.inc.php";
require_once $xcart_dir."/init.php";

x_load('order');


//get product balances from ecomdash and create array of sku and qty
require $xcart_dir.'/ecomdash/get_product_balances_ecomdash.php';

reset($balanceResults);

foreach($balanceResults as $product) {
  $sku = substr($product['sku'],2); //get sku
  $qty = $product['qty']; //get qty to update

  $updateVariantTable = "UPDATE $sql_tbl[variants] SET avail='$qty' WHERE productcode='$sku'";
  db_query($updateVariantTable);
  $updateProductTable = "UPDATE $sql_tbl[products] SET avail='$qty' WHERE productcode='$sku'";
  db_query($updateProductTable);


}


?>

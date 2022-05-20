<?php
// --- general settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("America/Los_Angeles");//set local timezone
$lastUpdate = time();
$lastUpdateCalDate = date("Y-m-d");

//call ecomdash file
require 'get_total_product_pages_ecomdash.php';

//categories array
$categoriesArr= array("Dad Gifts General", "Halloween Item", "Mindful Toys General", "New Dad Kit", "Slippers", "T-Shirt");

for($i=1;$i <= $totalPages;$i++) {
	try {
		$productPage = $ecomdash->getInventoryList($i);
		echo "<pre>";
		print_r($productPage);
		echo "</pre>";
		foreach($productPage['data'] as $product) {
			$sku = $product['Sku'];
			$name = $product['Name'];
			$qtyOnHand = $product['QuantityOnHand'];
			$ssd = $sku."_".$lastUpdateCalDate;
			if(isset($product['Notes'])) {
				$category = $product['Notes'];
			} else {
				$category = '';
			}
			
			//replace data in inventory table
			$replaceSQL = "REPLACE INTO inventory (ssd, sku,name,category,qty_on_hand,last_update,last_update_cal_date) VALUES (:ssd,:sku,:name,:category,:qty,:lastUpdate,:lastUpdateCalDate)";
			$replaceQuery = $connEcom->prepare($replaceSQL);
			$replaceQuery->bindParam(':ssd', $ssd, PDO::PARAM_STR);
			$replaceQuery->bindParam(':sku', $sku, PDO::PARAM_STR);
			$replaceQuery->bindParam(':name', $name, PDO::PARAM_STR);
			$replaceQuery->bindParam(':category', $category, PDO::PARAM_STR);
			$replaceQuery->bindParam(':qty', $qtyOnHand, PDO::PARAM_INT);
			$replaceQuery->bindParam(':lastUpdate', $lastUpdate, PDO::PARAM_INT);
			$replaceQuery->bindParam(':lastUpdateCalDate', $lastUpdateCalDate, PDO::PARAM_STR);
			$replaceQuery->execute();
			
			//back fill category
			$updateCatSQL = "UPDATE inventory SET category = :category WHERE sku = :sku";
			$updateCatQuery = $connEcom->prepare($updateCatSQL);
			$updateCatQuery->bindParam(':category', $category, PDO::PARAM_STR);
			$updateCatQuery->bindParam(':sku', $sku, PDO::PARAM_STR);
			$updateCatQuery->execute();
			
		}
	} catch (Exception $e) {
		echo PHP_EOL . 'Set Product Pages failed:' . PHP_EOL . $e->getMessage();
		exit();
	}
}

?>

<?php
// --- general settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//call ecomdash file
require  '_Ecomdash_API.php';
require 'get_settings_ecomdash.php';

//call Ecomdash Class
$ecomdash = new Ecomdash_API($developer_key, $account_integration_key);

try {
	$action = "Inventory";
	$totalPages = $ecomdash->getTotalProductPages($action);
} catch (Exception $e) {
	echo PHP_EOL . 'Get Total Product Pages failed:' . PHP_EOL . $e->getMessage();
	exit();
}

?>

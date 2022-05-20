<?php
/**
 * Class for executing calls to EcomDash API
 */

class Ecomdash_API
{
	private $developer_key = ''; // Subscription key from developer account
	private $account_integration_key = ''; // The API integration key for mobile from ecomdash account
	private $url = 'https://ecomdash.azure-api.net/api/';

	/**
	 * Constructor
	 * @param string $developer_key           Subscription key from developer account
	 * @param string $account_integration_key The API integration key for mobile from ecomdash account
	 */
	public function __construct( $developer_key, $account_integration_key )
	{
		if ( !isset($developer_key) || $developer_key == '' || !isset($account_integration_key) || $account_integration_key == '' ) {
			throw new Exception('Invalid developer key or account integration key', 1);
		}

		$this->developer_key = $developer_key;
		$this->account_integration_key = $account_integration_key;


	}

	/**
	 * send GET request to ecomdash API
	 * @param  string $action API action without the first forward flash. E.g. "carriers/"
	 * @param  string $params Query parameters. E.g. "?sku=4613246"
	 * @return mixed
	 */
	public function getTotalProductPages($action)
	{
		$headers = array();
		$headers[] = 'Ocp-Apim-Subscription-Key: ' . $this->developer_key;
		$headers[] = 'ecd-subscription-key: ' . $this->account_integration_key;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $this->url . $action);
		$result = json_decode(curl_exec($curl) , true);
		$totalPages = $result['pagination']['TotalNumberOfPages'];

		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if ( curl_errno($curl)
				|| $httpcode != 200
				|| (!empty($result) && (isset($result['status']) && $result['status'] != 'Success'))
				) {
			$error_message = 'Error Processing Request: HTTP Code: ' . $httpcode . "\n" .
				var_export(curl_error($curl), true) . "\n" .
				var_export($result, 1);
			curl_close($curl);
			throw new Exception($error_message, 1);
		}
		curl_close($curl);

		return $totalPages;
	}

	public function getInventoryList($pageNumber)
	{
		$headers = array();
		$headers[] = 'Ocp-Apim-Subscription-Key: ' . $this->developer_key;
		$headers[] = 'ecd-subscription-key: ' . $this->account_integration_key;

		$page = "?pageNumber=".$pageNumber;
		$connect = $this->url . "Inventory" . $page;

		echo $connect;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $connect);
		$result = json_decode(curl_exec($curl) , true);

		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if ( curl_errno($curl)
				|| $httpcode != 200
				|| (!empty($result) && (isset($result['status']) && $result['status'] != 'Success'))
				) {
			$error_message = 'Error Processing Request: HTTP Code: ' . $httpcode . "\n" .
				var_export(curl_error($curl), true) . "\n" .
				var_export($result, 1);
			curl_close($curl);
			throw new Exception($error_message, 1);
		}
		curl_close($curl);

		return $result;
	}

	public function getProductBalances($skus) {
		//build header info. keys are added here
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Ocp-Apim-Subscription-Key: ' . $this->developer_key;
		$headers[] = 'ecd-subscription-key: ' . $this->account_integration_key;
		$headers[] = 'Content-Length: ' . strlen($skus);

		$action = 'product/getProductBalances';//default action for this function

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $skus);
		curl_setopt($curl, CURLOPT_URL, $this->url . $action);
		$result = json_decode(curl_exec($curl) , true);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if (curl_errno($curl)
				|| $httpcode != 200
				|| (!empty($result) && (isset($result['status']) && $result['status'] != 'Success'))
				) {
			$error_message = 'Error Processing Request: HTTP Code: ' . $httpcode . "\n" .
				var_export(curl_error($curl), true) . "\n" .
				var_export($result, 1);
			curl_close($curl);
			throw new Exception($error_message, 1);
		}

		curl_close($curl);

		return $result;


	}

	public function updateQtyOnHand ($skus = '[]') {

		//build header info. keys are added here
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Ocp-Apim-Subscription-Key: ' . $this->developer_key;
		$headers[] = 'ecd-subscription-key: ' . $this->account_integration_key;
		$headers[] = 'Content-Length: ' . strlen($skus);

		$action = 'inventory/updateQuantityOnHand';//default action for this function

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $skus);
		curl_setopt($curl, CURLOPT_URL, $this->url . $action);
		$result = json_decode(curl_exec($curl) , true);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if (curl_errno($curl)
				|| $httpcode != 200
				|| (!empty($result) && (isset($result['status']) && $result['status'] != 'Success'))
				) {
			$error_message = 'Error Processing Request: HTTP Code: ' . $httpcode . "\n" .
				var_export(curl_error($curl), true) . "\n" .
				var_export($result, 1);
			curl_close($curl);
			throw new Exception($error_message, 1);
		}

		curl_close($curl);

		return $result;


	}


}

?>

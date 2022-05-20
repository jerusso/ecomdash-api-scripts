<?php
/**
 * Class for executing calls to EcomDash API
 */

class BS_API
{
	private $db_connection = ''; // database connection used

	/**
	 * Constructor
	 * @param string $dbConnection           database connection object passed to BS object
	 */
	public function __construct( $dbConnection )
	{
		if ( !isset($dbConnection)) {
			throw new Exception('No database connection provided', 1);
		}
		$this->db_connection = $dbConnection;

	}

	/**
	 * query DB for all skus
	 */
	public function getAllSkus()
	{
    $invSQL = "SELECT v.productid, v.productcode, v.variantid, pr.price, v.avail, pl.product FROM xcart_variants as v INNER JOIN xcart_products_lng_en pl ON v.productid = pl.productid INNER JOIN xcart_pricing pr ON v.variantid = pr.variantid and v.productid = pr.productid ORDER BY productcode ASC";
    $invQuery = $this->db_connection->prepare($invSQL);
    $invQuery->execute();

    $skus = array();

    while($skuInfo = $invQuery->fetch(PDO::FETCH_ASSOC)) {
      $skus[] = ['sku'=>"bs".$skuInfo['productcode'],'qty'=>$skuInfo['avail']]; //prepend bs to key to format as ecomdash sku
    }

    return $skus;

	}


  public function getSelectedSkus($skuList = "")

  {

    $invSQL = "SELECT v.productid, v.productcode, v.variantid, pr.price, v.avail, pl.product FROM xcart_variants as v INNER JOIN xcart_products_lng_en pl ON v.productid = pl.productid INNER JOIN xcart_pricing pr ON v.variantid = pr.variantid and v.productid = pr.productid WHERE v.productcode in ($skuList) ORDER BY productcode ASC";
    $invQuery = $this->db_connection->prepare($invSQL);
    $invQuery->execute();

    $skus = array();

    while($skuInfo = $invQuery->fetch(PDO::FETCH_ASSOC)) {
      $skus[] = ['sku'=>"bs".$skuInfo['productcode'],'qty'=>$skuInfo['avail']]; //prepend bs to key to format as ecomdash sku
    }

    return $skus;

  }


}

?>

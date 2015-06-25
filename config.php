<?php 

$config = array(
	'apis' => array(
		'walmart' => array(
			'url' => 'http://api.walmartlabs.com/v1/search?apiKey=^apiKey^&query=^query^',
			'parts' => array(
				'apiKey' => 'qcygz2xdwpgdghweez793wwe',
			),
			'returned_data' => 'items'
		),
		'bestbuy' => array(
			'url' => 'http://api.remix.bestbuy.com/v1/products(^type^=^query^)?format=json&show=upc,name,salePrice,description,longDescription,longDescriptionHtml,thumbnailImage,image,url&apiKey=^apiKey^',
			'parts' => array(
				'type' => array(
					'product' => 'name',
					'upc' => 'upc'
				),
				'apiKey' => 'uqb2fqxmdyp6uv3xxt67gsb8',
			),
			'returned_data' => 'products'
		)
	)
);

return $config;
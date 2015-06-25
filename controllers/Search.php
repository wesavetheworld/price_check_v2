<?php 

class Search {
	
	protected $apis = array(
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
	);

	public function __construct() {
	}

	public function search($type, $query) {
		$data = array();
		foreach($this->apis as $api) {
			print_r($api);
			$data[] = $this->getData($api, $type, $query);
		}
	}

	private function getData($api, $type, $query) {
		$url = $this->buildUrl($api, $query);

		// gets contents of the url (JSON)
		$json = file_get_contents($url);

		// formats the json
		$json = json_decode($json);

		// getting actual items from json returned from API
		if(!empty($json->$api['returned_data'])) {
			$items = $json->$api['returned_data'];
		} else {
			$items = NULL;
		}

		return $items;

	}

	private function buildUrl($api, $type, $query) {
		$url = $api['url'];
		$carrots = array();
		$pattern = '^';
		$start = 0;
		while(($newLine = strpos($url, $pattern, $start)) !== false){
		    $start = $newLine + 1;
		    $carrots[] = $newLine;
		}

		if(count($carrots) % 2 == 0) {
			$change = array();
			for ($i=0; $i < count($carrots) ; $i=$i+2) { 
				// get variable between first two carrots
				$length = $carrots[$i+1]-$carrots[$i];
				$var = substr($url, $carrots[$i]+1, $length-1);
				$var = trim($var, '^');
				if($var == 'type') {
					$api_types = $api['parts']['type'];
					if(count($api_types) > 1) {
						$value = $api['parts']['type'][$type];
					} else {
						$value = $api['parts']['type'];
					}
				} else if($var == 'query') {
					$value = $query;
				} else {
					$value = $api['parts'][$var];
				}
				$change[$var] = $value;
			}

			foreach ($change as $key => $value) {
				$url = str_replace('^'.$key.'^', $value, $url);
			}

		}

		return $url;
	}
}
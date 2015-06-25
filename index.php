<?php
require 'vendor/autoload.php';
require_once 'controllers/Search.php';

$app = new \Slim\Slim();


// Routes
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->get('/search/:apiKey/:type/:query', 'search');

$app->run();

function search($apiKey, $type, $query) {
	// $this->checkApiKey($apiKey);
	$search = new Search;
	$search->search($type, $query);
}


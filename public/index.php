<?php

use ComposerRocks\VersionHelper;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Request;

// composer autoload
require_once(__DIR__ . '/../vendor/autoload.php');

// silex
$app = new Silex\Application();

// debug modu
$app['debug'] = true;

// twig servisini kaydet
$app->register(new TwigServiceProvider(), array(
	'twig.path' => __DIR__ . '/../template', // twig path
	'twig.options' => array(
		'strict_variables' => false,
		'cache'            => false,
		'debug'            => true
	)
));

// url generator serivisini kaydet
$app->register(new UrlGeneratorServiceProvider());

// silex route
$app->get('/hello-world/{forWhat}', function(Request $request) use ($app)
{
	$viewParams = array(
		'forWhat' => $request->get('forWhat'),
		'version' => VersionHelper::VERSION
	);

	return $app['twig']->render('index.html.twig', $viewParams);

})->bind('hello-world-route');

// calistir
$app->run();
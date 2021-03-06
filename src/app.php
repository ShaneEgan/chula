<?php
require_once __DIR__.'/bootstrap.php';


use Symfony\Component\HttpFoundation\Request;

$app->mount(
		'/'.$app['config']['admin_path'],
		new Chula\ControllerProvider\Admin()
	);
$app->mount(
		'/{page}', 
		new Chula\ControllerProvider\Loader()
	);
	

$app->mount(
		'/'.$app['config']['admin_path'].'/new',
		new Chula\ControllerProvider\NewPage()
	);
	

$app->mount(
		'/'.$app['config']['admin_path'].'/delete',
		new Chula\ControllerProvider\DeletePage()
	);

$app->mount(
	'/'.$app['config']['admin_path'].'/edit',
	new Chula\ControllerProvider\EditPage()
);


$app->get('/', function() use ($app)
{
	return 'HELLOOOOO';
});

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

$app->run(); 


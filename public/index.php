<?php
// Start a Session
if( !session_id() ) @session_start();

require '../vendor/autoload.php';
use DI\ContainerBuilder;
use Delight\Auth\Auth;

//$mailer = new SimpleMail();
//var_dump(SimpleMail::make()
//->setTo('mar7995@yandex.ru', 'Marina')
//->setFrom('info@edc.com', 'Admin')
//->setSubject('Тема')
//->setMessage('How are you')
//->send());
$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
    Engine::class => function() {
       return new Engine('../app/views');
    },
    PDO::class => function() {
        return new PDO("mysql:dbname=blog;host=localhost;",
            'root', 
            'mysql');
    },
    Auth::class => function($container) {
        return new Auth($container->get('PDO'));
    },
]);
$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/code/', ['app\controllers\Homepage', 'index']);
    $r->addRoute('GET', '/code/about', ['app\controllers\Homepage', 'about']);
    $r->addRoute('GET', '/code/register', ['app\controllers\Homepage', 'form_registr']);
    $r->addRoute('POST', '/code/register', ['app\controllers\Homepage', 'registration']);
    $r->addRoute('GET', '/code/verificat', ['app\controllers\Homepage', 'email_verification']);
    $r->addRoute('GET', '/code/login', ['app\controllers\Homepage', 'login']);
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/code/about/{amaunt:\d+}', ['app\controllers\Homepage', 'about']);
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $container->call($routeInfo[1], $routeInfo[2]);
        break;
}

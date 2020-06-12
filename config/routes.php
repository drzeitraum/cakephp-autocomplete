<?
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::scope('', function (RouteBuilder $routes) {

    # users
    $routes->connect('/edit/:id', ['controller' => 'Users', 'action' => 'edit'], ['pass' => ['id']]);
    $routes->fallbacks(DashedRoute::class);

});

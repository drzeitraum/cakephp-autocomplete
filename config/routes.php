<?
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::scope('', function (RouteBuilder $routes) {

    # users
    $routes->connect('/users/:url/', ['controller' => 'Users', 'action' => 'edit'], ['pass' => ['url']]);

    # autocomplete
    $routes->connect('/autocomplete/', ['controller' => 'Autocomplete']);

    $routes->fallbacks(DashedRoute::class);

});

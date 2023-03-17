<?php

require dirname(__DIR__) . '/config/routes.php';

$availableRouteNames = array_keys(ROUTES);
// On récupère toutes les clés du tableau ROUTES avec la fonction array_keys()

if (isset($_GET['page']) && in_array($_GET['page'], $availableRouteNames)) {
    // Si tu passe par la méthode GET avec la page && que dans le tableau tu trouve la page alors:
    $route = ROUTES[$_GET['page']];
    $controller = new $route['controller'];
    $controller->{$route['method']}();
}
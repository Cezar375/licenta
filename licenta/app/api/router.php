<?php
require_once('./concept-routes.php');
require_once('../config/Response.php');

header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");

$allHeaders = getallheaders();

$allRoutes = [
    ... $conceptRoutes  #se pune , aici daca am 2 sau mai multe
    #... $campaignRoutes
];

foreach ($allRoutes as $routeConfig) {
    if (parseRequest($routeConfig)) {
        exit;
    }
}

handle404();

function parseRequest($routeConfig)
{
    $url = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method !== $routeConfig['method']) {
        return false;
    }

    $regExpString = routeExpToRegExp($routeConfig['route']);

    if (preg_match("/$regExpString/", $url, $matches)) {

        $params = [];
        $query = [];
        $parts = explode('/', $routeConfig['route']);

        $index = 1;
        foreach ($parts as $p) {
            if (!empty($p) && $p[0] === ':') {
                $params[substr($p, 1)] = $matches[$index];
                $index++;
            }
        }

        if (strpos($url, '?')) {
            $queryString = explode('?', $url)[1];
            $queryParts = explode('&', $queryString);

            foreach ($queryParts as $part) {
                if (strpos($part, '=')) {
                    $query[explode('=', $part)[0]] = explode('=', $part)[1];
                }
            }
        }

        $payload = file_get_contents('php://input');

        if (strlen($payload)) {
            $payload = json_decode($payload, true);
        } else {
            $payload = NULL;
        }

        if (isset($routeConfig['middlewares'])) {
            foreach ($routeConfig['middlewares'] as $middlewareName) {
                $didPass = call_user_func($middlewareName, [
                    "params" => $params,
                    "query" => $query,
                    "payload" => $payload
                ]);

                if (!$didPass) {
                    exit();
                }
            }
        }

        call_user_func($routeConfig['handler'], [
            "params" => $params,
            "query" => $query,
            "payload" => $payload
        ]);

        return true;
    }

    return false;
}

function handle404()
{
    Response::status(404);
}



function routeExpToRegExp($route)
{
    $regExpString = "";
    $parts = explode('/', $route);

    foreach ($parts as $p) {
        $regExpString .= '\/';

        if (!empty($p) && $p[0] === ":") {
            $regExpString .= '([a-zA-Z0-9_]+)';  #am pus _ ca sa trimit cu _ din
        } else {
            $regExpString .= $p;
        }
    }
    $regExpString .= '?';

    return $regExpString;
}
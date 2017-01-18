<?php

$app->post("/login", function ($request, $response) {
    $json   = json_decode($request->getBody(), true);
    $form   = ["username", "password"];
    $error  = checkJson($form, $json);

   $username    = htmlspecialchars($json["username"]);
    $password    = htmlspecialchars($json["password"]);

    if ((!$error) && (!empty($username)) && (!empty($password))) {
        $data = Connection::login($username, $password);
    } else {
        $data   = ["error" => true, "message" => "Something goes wrong. Did you sent all required arguments?"];
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

$app->post("/register", function ($request, $response) {
    $json   = json_decode($request->getBody(), true);
    $form   = ["username", "password"];
    $error  = checkJson($form, $json);
    $username    = htmlspecialchars($json["username"]);
    $password    = htmlspecialchars($json["password"]);

    if ((!$error) && (!empty($username)) && (!empty($password))) {
        $data    = Connection::register($username, $password);
    } else {
        $data   = ["error" => true, "message" => "Something goes wrong. Did you sent all required arguments?"];
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

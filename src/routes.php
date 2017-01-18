<?php
// Routes

/**
 * @desc : We will add all routes needed to make this blog working.
 * @author: Jeremy, Clément, Julien
 * @date: 01/13/2017
 */

$app->get('/', function ($request, $response, $args) {
    return $response->getBody()->write("Hello!");
});

/**
 * @desc : This route will allow you to get a json with all articles.
 * @return : Json with all articles.
 * @param : N/A
 */
$app->get("/articles", function($request, $response) {
    $data = Articles::select();
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

/**
 * @desc : This route will allow you to delete an article by the argument "id".
 * @return : Returns a json with error on 'true/false' and a message.
 * @param : The argument 'id' is required and must be a int in the JSON. (Example : 1)
 */
$app->delete('/article', function($request, $response, $args) {
    if (($user = Connection::getHeader()) == false) {
        $data = ["error" => true, "message" => "Wrong apiKey"];
    } else {
        $json = json_decode($request->getBody(), true);
        if ((!isset($json["id"])) || (!is_numeric($json["id"]))) {
            $data = ["error" => true, "message" => "Argument id is missing or it's not numeric!"];
        } else {
            $id = (int)$json["id"];
            $info = Articles::selectById($id);
            if (!isset($info["id"])) {
                $data = ["error" => true, "message" => "Article not found"];
            } else {
                $data   = $user == $info["author"] ? Articles::deleteById($id) : ["error" => true, "message" => "You are not allowed to delete this article."];
            }
        }
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

/**
 * @desc : This route will allow you to update an article by the argument "id".
 * @return : Returns a json with error on 'true/false' and a message.
 * @param : The argument 'id' is required and must be a int. (Example : 1)
 */
$app->patch('/article', function($request, $response, $args) {
    if (($user = Connection::getHeader()) == false) {
        $data = ["error" => true, "message" => "Wrong apiKey"];
    } else {
        $json   = json_decode($request->getBody(), true);
        if ((!isset($json["id"])) || (!is_numeric($json["id"]))) {
            $data = ["error" => true, "message" => "The id argument must be numeric."];
        } else {
            $id         = (int) $json["id"];
            $info       = Articles::selectById($id);
            if (!isset($info["id"])) {
                $data = ["error" => true, "message" => "Article not found"];
            } else {
                $title      = isset($json["title"]) ? htmlspecialchars($json["title"]) : $info["title"];
                $message    = isset($json["message"]) ? htmlspecialchars($json["message"]) : $info["message"];
                $data       = $user == $info["author"] ? Articles::updateById($id, $title, $message) : ["error" => true, "message" => "You are not allowed to update this article."];
            }
        }
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

$app->post('/search', function ($request, $response, $args) {
    $json   = json_decode($request->getBody(), true);
    if ((!isset($json["id"])) || (!is_numeric($json["id"]))) {
        $data	= ["error" => true, "message" => "ID is missing or it's not numeric.."];
    } else {
        $id     = (int) $json["id"];
        $data   = Articles::selectById($id);
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

/**
 * @desc : This route will allow you to insert an article with a json object ONLY.
 * @return : Returns a json with error on 'true/false' and a message.
 * @param : A json with the argument 'Title', 'Message' and 'Author'.
 */
$app->put('/article', function ($request, $response) { // SAVE A NEW ARTICLE FROM A JSON
    if (($user = Connection::getHeader()) == false) {
        $data = ["error" => true, "message" => "Wrong apiKey"];
    } else {
        $form = ["title", "message"];
        $json = json_decode($request->getBody(), true);
        $error = checkJson($form, $json);

        if ($error == false) {
            $title = htmlspecialchars($json["title"]);
            $message = htmlspecialchars($json["message"]);
            $author = $user;
            $data = Articles::insert($title, $message, $author);
        } else {
            $data = ["error" => true, "message" => "Missing arguments in your JSON."];
        }
    }
	$response->withHeader('Content-type', 'application/json');
	return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

<?php

/**
 * @desc : This route will allow you to get a json with all comments from an article ID.
 * @return : Json with all comments.
 * @param : A json with "id" as argument. (Example : {"id": 1})
 */
$app->post("/comments", function($request, $response) {
    $error  = false;
    $form   = ["id"];
    $json   = json_decode($request->getBody(), true);
    $error  = checkJson($form, $json);

    if (!$error) {
        $fetch = Comments::select(htmlspecialchars($json["id"]));
        $response->withHeader('Content-type', 'application/json');
        $data   = !empty($fetch) ? $fetch : ["error" => true, "message" => "Nothing found in database"];
    } else {
        $data   = ["error" => true, "message" => "Something goes wrong. Did you sent all required arguments?"];
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

/**
 * @desc : This route will allow you to delete a comment from a choosen ID.
 * @return : JSON with a boolean and a success/fail message.
 * @param : A json with "id" as argument. (Example : {"id": 1})
 */
$app->delete("/comment", function($request, $response) {
    if (($user = Connection::getHeader()) == false) {
        $data = ["error" => true, "message" => "Wrong apiKey"];
    } else {
        $form = ["id"];
        $json = json_decode($request->getBody(), true);
        $error = checkJson($form, $json);

        if (!$error) {
            $info = Comments::selectById(htmlspecialchars($json["id"]));
            if (!isset($info["id"])) {
                $data = ["error" => true, "message" => "Comment not found"];
            } else {
                $data = $user == $info["author"] ? Comments::deleteByid(htmlspecialchars($json["id"])) : ["error" => true, "message" => "You are not allowed to delete this comment."];
            }
        } else {
            $data = ["error" => true, "message" => "Something goes wrong. Did you sent all required arguments?"];
        }
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

/**
 * @desc : This route will allow you to update a comment.
 * @return : JSON with boolean and a success/fail message.
 * @param : A json with "comment", "id", "author" as arguments. (Example : {"id": 1, "comment": "hello", "author": "Clément"})
 */
$app->patch("/comment", function($request, $response) {
    if (($user = Connection::getHeader()) == false) {
        $data = ["error" => true, "message" => "Wrong apiKey"];
    } else {
        $form = ["id"];
        $json = json_decode($request->getBody(), true);
        $error = checkJson($form, $json);

        if (!$error) {
            $id = htmlspecialchars($json["id"]);
            $data = Comments::selectById($id);
            if (isset($data["id"])) {
                $comment = isset($json["comment"]) ? htmlspecialchars($json["comment"]) : $data["comment"];
                $author = isset($json["author"]) ? htmlspecialchars($json["author"]) : $data["author"];
                $data = $user == $data["author"] ? Comments::updateById($author, $comment, $id) : ["error" => true, "message" => "You are not allowed to update this comment."];
            } else {
                $data = ["error" => true, "message" => "comment not found"];
            }
        } else {
            $data = ["error" => true, "message" => "Something goes wrong. Did you sent all required arguments?"];
        }
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

/**
 * @desc : This route will allow you to insert a new comment.
 * @return : JSON with boolean and success/fail message.
 * @param : A json with "id", "author", "article_id", "comment" as arguments. (Example : {"article_id":1, "author":"Clément", "comment": "Hello"})
 */
$app->put("/comment", function($request, $response) {
    if (($user = Connection::getHeader()) == false) {
        $data = ["error" => true, "message" => "Wrong apiKey"];
    } else {
        $form = ["article_id", "comment"];
        $json = json_decode($request->getBody(), true);
        $error = checkJson($form, $json);

        if (!$error) {
            $data = Articles::selectById($json["article_id"]);
            if (isset($data["id"])) {
                $article_id = htmlspecialchars($json["article_id"]);
                $comment = htmlspecialchars($json["comment"]);
                $data = Comments::insert($article_id, $user, $comment);
            } else {
                $data = ["error" => true, "message" => "Article not found"];
            }
        } else {
            $data = ["error" => true, "message" => "Something goes wrong. Did you sent all required arguments?"];
        }
    }
	$response->withHeader('Content-type', 'application/json');
	return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

<?php

$app->post("/comments", function($request, $response) { // SHOW  ALL COMMENTS FROM THE ID ARTICLE IN A JSON OBJECT
    $error = false;
    $form = ["id"];
    $json = json_decode($request->getBody(), true);

    $error = checkJson($form, $json);

    if (!$error) {
        $fetch = Comments::select(htmlspecialchars($json["id"]));

        $response->withHeader('Content-type', 'application/json');
        return $response->withJson(!empty($fetch) ? $fetch : ["error" => true, "message" => "Nothing found in database"], 200, JSON_PRETTY_PRINT);
    }
    else {
        return $response->withJson(["error" => true, "message" => "Nothing found in database"], 200, JSON_PRETTY_PRINT);
    }
});

$app->delete("/comment", function($request, $response) { // DELETE THE COMMENT CORRESPONDING TO ID FROM THE JSON OBJECT
    $error = false;
    $form	= ["id"];
    $json	= json_decode($request->getBody(), true);

    $error = checkJson($form, $json);

    if (!$error) {
        $data = Comments::selectById(htmlspecialchars($json["id"]));

        if (isset($data["id"])) {
             $data = Comments::deleteByid(htmlspecialchars($json["id"]));
        }
        else {
            $data = ["error" => true, "comment" => "Comment not found"];
        }
        $response->withHeader('Content-type', 'application/json');
        return $response->withJson($data, 200, JSON_PRETTY_PRINT);
    }
    else {
        return $response->withJson(["error" => true, "message" => "Nothing found in database"], 200, JSON_PRETTY_PRINT);
    }
});

$app->patch("/comment", function($request, $response) { // THIS ROUTE WILL ALLOW YOU TO MODIFY A COMMENT
    $error = false;
    $form	= ["author", "comment", "id"];
    $json	= json_decode($request->getBody(), true);

    $error = checkJson($form, $json);

    if ($error == false) {

      $comment = htmlspecialchars($json["comment"]);
      $author = htmlspecialchars($json["author"]);
      $id = htmlspecialchars($json["id"]);

      if (!$error) {
         $data = Comments::selectById($id);

         if (isset($data["id"])) {
             $data = Comments::updateById($author, $comment, $id);
         }
         else {
             $data = ["error" => true, "comment" => "comment not found"];
         }
      }

      $response->withHeader('Content-type', 'application/json');
      return $response->withJson($data, 200, JSON_PRETTY_PRINT);
    }
    else {
        return $response->withJson(["error" => true, "message" => "something went wrong in arguments"], 200, JSON_PRETTY_PRINT);
    }
});

$app->put("/comment", function($request, $response) { // ADD A COMMENT WITH DATA FROM A JSON OBJECT
  $error	= false;
  $form	= ["author", "article_id", "comment"];
  $json	= json_decode($request->getBody(), true);

  $error = checkJson($form, $json);

  if ($error == false) {

      $author		= htmlspecialchars($json["author"]);
      $article_id	= htmlspecialchars($json["article_id"]);
      $comment 	= htmlspecialchars($json["comment"]);

      $data = Comments::insert($article_id, $author, $comment);

	}
	else {
		$data = ["error" => true, "message" => "Missing arguments in your JSON."];
	}

	$response->withHeader('Content-type', 'application/json');
	return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});
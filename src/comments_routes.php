<?php

$app->post("/comments", function($request, $response, $args) { // SHOW  ALL COMMENTS FROM THE ID ARTICLE IN A JSON OBJECT
  $error = false;
  $form	= ["id"];
  $json	= json_decode($request->getBody(), true);

  $error = jsoncheck($form, $json);

  if ($error == false)
      $comments    = [];
      $article = htmlspecialchars($json["id"]);
      $query	= $this->db->query("SELECT * FROM comments WHERE article_id = '$article' ORDER BY date ASC;");
      $fetch	= $query->fetchAll();
      for ($i = 0; $i < sizeof($fetch); $i++) {
        $comments[] = ["id" => $fetch[$i]["id"], "article_id" => $fetch[$i]["article_id"], "author" => $fetch[$i]["author"], "comment" => $fetch[$i]["comment"], "date" => $fetch[$i]["date"]];
      }
      $response->withHeader('Content-type', 'application/json');
      return $response->withJson(!empty($comments) ? $comments : ["error" => true, "message" => "Nothing found in database"], 200, JSON_PRETTY_PRINT);
    }
});

$app->delete  ("/comments", function($request, $response, $args) { // DELETE THE COMMENT CORRESPONDING TO ID FROM THE JSON OBJECT
    $error = false;
    $form	= ["id"];
    $json	= json_decode($request->getBody(), true);

    $error = jsoncheck($form, $json);

    if ($error == false) {
      $article = htmlspecialchars($json["id"]);
      $query	= $this->db->prepare("DELETE FROM comments WHERE id = $article");
      $query->execute();
      if ($query == false)
        $error = true;
      $response->withHeader('Content-type', 'application/json');
      return $response->withJson(($error == true) ? ["error" => false, "message" => "The deleting was succesfull"] : ["error" => true, "message" => "Error when deleting the comment"], 200, JSON_PRETTY_PRINT);
    }
});

$app->patch("/comments", function($request, $response, $args) { // THIS ROUTE WILL ALLOW YOU TO MODIFY A COMMENT
    $error = false;
    $form	= ["author", "comment", "id"];
    $json	= json_decode($request->getBody(), true);

    $error = jsoncheck($form, $json);

    if ($erreur == false) {
      $comment = htmlspecialchars($json["comment"]);
      $author = htmlspecialchars($json["author"]);
      $id = htmlspecialchars($json["id"]);
      $query	= $this->db->prepare("UPDATE comments SET author=:author, comment=:comment WHERE id = :id;");
      $query->execute(["author" => $author, "comment" => $comment, "id" => $id]);
      if ($query == false)
        $error = true;
      }
      $response->withHeader('Content-type', 'application/json');
      return $response->withJson(($error == false) ? ["error" => false, "message" => "The updating was succesfull"] : ["error" => true, "message" => "Error when updating the comment"], 200, JSON_PRETTY_PRINT);
    }
    else
      return $response->withJson(["error" => true, "message" => "something went wrong in arguments"], 200, JSON_PRETTY_PRINT);
});

$app->put("/comments", function($request, $response) { // ADD A COMMENT WITH DATA FROM A JSON OBJECT
  $erreur	= false;
  $form	= ["author", "article_id", "message"];
  $json	= json_decode($request->getBody(), true);

  $error = jsoncheck($form, $json);

  if ($erreur == false) {
		$author		= htmlspecialchars($json["author"]);
		$article_id	= htmlspecialchars($json["article_id"]);
		$message 	= htmlspecialchars($json["message"]);

		$register 	= $this->db->prepare("INSERT into comments(article_id, author, comment, date) VALUES(:article_id, :author, :comment, :date)");
		$register->execute(["article_id" => $article_id, "author" => $author, "message" => $message, "date" => time()]);

		$data = ["error" => false, "message" => "OK"];
	} else {
		$data = ["error" => true, "message" => "Missing arguments in your JSON."];
	}
	$response->withHeader('Content-type', 'application/json');
	return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

?>

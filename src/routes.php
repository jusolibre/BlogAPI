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
    $article    = [];
    $query	    = $this->db->query("SELECT * FROM miniblog ORDER BY id DESC;");
    $fetch	    = $query->fetchAll();
    for ($i = 0; $i < sizeof($fetch); $i++) {
        $article[] = ["id" => $fetch[$i]["id"], "author" => $fetch[$i]["author"], "title" => $fetch[$i]["title"], "message" => $fetch[$i]["message"], "category" => $fetch[$i]["category"]];
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson(!empty($article) ? $article : ["error" => true, "message" => "Nothing found in database"], 200, JSON_PRETTY_PRINT);
});

/**
 * @desc : This route will allow you to delete an article by the argument "id".
 * @return : Returns a json with error on 'true/false' and a message.
 * @param : The argument 'id' is required and must be a int in the JSON. (Example : 1)
 */
$app->delete('/article', function($request, $response, $args) {
    $json   = json_decode($request->getBody(), true);
    if ((!isset($json["id"])) || (!is_numeric($json["id"]))) {
        $data   = ["error" => true, "message" => "Argument id is missing or it's not numeric!"];
    } else {
        $id     = (int) $json["id"];
        $search = $this->db->query("SELECT id FROM miniblog WHERE id='{$id}'");
        $fetch  = $search->fetch();
        if (isset($fetch["id"])) {
            $this->db->query("DELETE FROM miniblog WHERE id='{$id}'");
            $data   = ["error" => false, "message" => "Article has been deleted!"];
        } else {
            $data   = ["error" => true, "message" => "Article not found"];
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
    $json   = json_decode($request->getBody(), true);
    if ((!isset($json["id"])) || (!is_numeric($json["id"]))) {
        $data = ["error" => true, "message" => "The id argument must be numeric."];
    } else {
        $id         = (int) $json["id"];
        $title      = isset($json["title"]) ? htmlspecialchars($json["title"]) : "";
        $message    = isset($json["message"]) ? htmlspecialchars($json["message"]) : "";
        $query      = $this->db->query("SELECT id FROM miniblog WHERE id='{$id}'");
        $fetch      = $query->fetch();
        if (isset($fetch["id"])) {
            $this->db->query("update miniblog set title='{$title}', message='{$message}' where id='{$id}'");
            $data   = ["error" => false, "message" => "Article has been updated!"];
        } else {
            $data   = ["error" => true, "message" => "Article not found"];
        }
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);

});

/**
 * @desc : This route will allow you to insert an article with a json object ONLY.
 * @return : Returns a json with error on 'true/false' and a message.
 * @param : A json with the argument 'Title', 'Message' and 'Author'.
 */
$app->put('/article', function ($request, $response) {
	$error	= false;
	$form	= ["author", "title", "message"];
	$json	= json_decode($request->getBody(), true);	
	
	foreach ($form as $key) {
		if (!isset($json[$key])) {
			$error	= true;
		}
	}	

	if ($error == false) {
		$title		= htmlspecialchars($json["title"]);
		$message	= htmlspecialchars($json["message"]);
		$author 	= htmlspecialchars($json["author"]);
		
		$register 	= $this->db->prepare("INSERT INTO miniblog(title, message, author, category, date) VALUES(:title, :message, :author, :category, :date)");
		$register->execute(["title" => $title, "message" => $message, "author" => $author, "category" => "Informatic", "date" => time()]);
		
		$data = ["error" => false, "message" => "OK"];
	} else {		
		$data = ["error" => true, "message" => "Missing arguments in your JSON."];
	}
	$response->withHeader('Content-type', 'application/json');
	return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

/**
 * @desc : This route will allow you to search an article informations.
 * @return : Returns a json with error on 'true/false' and article informations.
 * @param : The argument 'id' is required and must be a int. (Example : 1)
 */
$app->post('/search', function ($request, $response, $args) {
    $json   = json_decode($request->getBody(), true);
    if ((!isset($json["id"])) || (!is_numeric($json["id"]))) {
		$data	= ["error" => true, "message" => "ID is missing or it's not numeric.."];
	} else {
        $id     = (int) $json["id"];
		$query	= $this->db->query("SELECT * FROM miniblog WHERE id='{$id}'");
		$fetch	= $query->fetch();
		$data	= isset($fetch["author"]) ? ["error" => false, "id" => (int)$fetch["id"], "author" => $fetch["author"], "title" => $fetch["title"], "message" => $fetch["message"]] : ["error" => true, "message" => "Article not found"];
	}
	$response->withHeader('Content-type', 'application/json');
	return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

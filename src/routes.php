<?php
// Routes

/*
	What can you do on here:
        - Get all articles
        - Delete an article by ID
        - Update an article by ID
        - Insert a new article from a json object. (Example: {"author": "Clément", "title": "Hello!", "message: "Hello world!"}
        - Search an article informations. (title, message, author...)
*/

$app->get('/', function ($request, $response, $args) { // BLOG'S INDEX
    return $response->getBody()->write("Hello!");
});

$app->get("/articles", function($request, $response) { // SHOW  ALL ARTICLES IN A JSON OBJECT
    $article    = [];
    $query	    = $this->db->query("SELECT * FROM miniblog ORDER BY id DESC;");
    $fetch	    = $query->fetchAll();
    for ($i = 0; $i < sizeof($fetch); $i++) {
        $article[] = ["id" => $fetch[$i]["id"], "author" => $fetch[$i]["author"], "title" => $fetch[$i]["title"], "message" => $fetch[$i]["message"], "category" => $fetch[$i]["category"]];
    }
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson(!empty($article) ? $article : ["error" => true, "message" => "Nothing found in database"], 200, JSON_PRETTY_PRINT);
});

$app->delete('/article/[{id}]', function($request, $response, $args) { // DELETE AN ARTICLE BY ID
    if ((!isset($args["id"])) || (!is_numeric($args["id"]))) {
        $data   = ["error" => true, "message" => "Argument id is missing or it's not numeric!"];
    } else {
        $id     = $args["id"];
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

$app->put('/article/[{id}]', function($request, $response, $args) { // UPDATE AN ARTICLE BY ID IF NUMERIC
    $json       = json_decode($request->getBody(), true);
    if (!is_numeric($args["id"])) {
        $data = ["error" => true, "message" => "The id argument must be numeric."];
    } else {
        $id         = $args["id"];
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

$app->post('/article', function ($request, $response) { // SAVE A NEW ARTICLE FROM A JSON
	$erreur	= false;
	$form	= ["author", "title", "message"];
	$json	= json_decode($request->getBody(), true);	
	
	foreach ($form as $key) {
		if (!isset($json[$key])) {
			$erreur	= true;
		}
	}	

	if ($erreur == false) {
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

$app->get('/search/[{id}]', function ($request, $response, $args) { // CHERCHER UN ARTICLE PAR ID
	if ((!isset($args["id"])) || (!is_numeric($args["id"]))) {
		$data	= ["error" => true, "message" => "ID is missing or it's not numeric.."];
	} else {
		$query	= $this->db->query("SELECT * FROM miniblog WHERE id='{$args["id"]}'");
		$fetch	= $query->fetch();
		$data	= isset($fetch["author"]) ? ["error" => false, "id" => (int)$fetch["id"], "author" => $fetch["author"], "title" => $fetch["title"], "message" => $fetch["message"]] : ["error" => true, "message" => "Article not found"];
	}
	$response->withHeader('Content-type', 'application/json');
	return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});

$app->get('/search', function ($request, $response) {
	$data	= ["error" => "id is missing or is not numeric"];
    $response->withHeader('Content-type', 'application/json');
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
});
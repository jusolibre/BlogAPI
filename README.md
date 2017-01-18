<h1>Welcome to our API REST github page.</h1>

This API was created using slim so we will give you <strong>examples using localhost and the port 8080</strong>, but you will be able to use it on the port you have chosen and with your database.
<br>

<h5 style="font-size:140%;">YOU WILL NEED TO UNCOMMENT THE LINE <em>always_populate_raw_post_data = -1</em> IN YOUR PHP.INI FILE </h5>

Our API will allow you to access a blog from your own website.
Using differents routes you will be able to :
  - <a href="#articles">List all articles</a>,
  - <a href="#GETarticle">Get an article</a>,
  - <a href="#PUTarticle">Add an article</a>,
  - <a href="#PATCHarticle">Update an article</a>,
  - <a href="#DELETEarticle">Delete an article (one by one)</a>.
<br>

We also add a comment management so you can use differents routes like for articles :
  - <a href="#GETcomments">List all comments from a specific article</a>,
  - <a href="#PUTcomment">Add a comment</a>,
  - <a href="#PATCHcomment">Edit a comment</a>,
  - <a href="#DELETEcomment">Delete a comment</a>.
<br>

<h2>So here are the differents routes :</h2>

First, you need to be able to send a JSON with required arguments and receive a response in a JSON.

<h3 style="font-size:200%;">ARTICLE :</h3>

<h4 style="font-size=180%;text-decoration: underline;" id="articles">GET all articles :</h4><hr>

```
localhost:8080/articles
```

If we have all required arguments and if everything is good, the JSON response will look like that : 
```
[
  {
    "id": "id",
    "title": "title",
    "message": "article content",
    "author": "author",
    "category": "category",
    "date": "YYYY-MM-DD"
  },
  {
    "id": "id",
    "title": "title",
    "message": "article content2",
    "author": "author",
    "category": "category",
    "date": "YYYY-MM-DD"
  }
]
```

Otherwise, if something is missing or if something is wrong, we will have that kind of JSON : 
```
{
  "error": true,
  "message": "Not article in database"
}
```

Note : This route needs no arguments.
<br>

<h4 style="font-size=180%;text-decoration: underline;" id="GETarticle">GET an article :</h4><hr>

<em style="font-size:80%;">This route allows you to get an article informations. To do it, you will have to send a json with the argument "id" and the article ID you want to get by using a POST request. For example : To get the article "1", I will have to send that JSON: {"id":1}.</em>

```
localhost:8080/search
["id"]
// here is the argument that MUST be present in the Json object of your resquest
```
If you provided a valid JSON and ID, the informations of the article will be returned in a JSON:
```
{
  "id": "id",
  "title": "title",
  "message": "content of the article",
  "author": "author",
  "category": "category",
  "date": "YYYY-MM-DD"
}
```
Otherwise, you will have an error : 
```
{
  "error": true,
  "message": "Error msg"
}
```
This route needs the argument "id" and the article ID. (numeric)
<br>

<h4 style="font-size=180%;text-decoration: underline;" id="DELETEarticle">DELETE an article :</h4><hr>

```
localhost:8080/article
["id"]
// here is the argument that MUST be present in the Json object of your resquest

```


In case of success :
```
{
  "error": false,
  "message": "Article has been deleted!"
}
```
<br>


In case of error :
```
{
  "error": true,
  "message": "Error msg"
}
```
<br>

This route needs the ID of the article you want to delete.
<br><br><br>


<h4 style="font-size=180%;text-decoration: underline;" id="PATCHarticle">PATCH article :</h4><hr>

```
localhost:8080/article
["id", "title", "message"]
// here is the argument that CAN be present in the Json object
// The id must be present

```


In case of success :
```
{
  "error": false,
  "message": "Article has been updated!"
}
```
<br>


In case of error :
```
{
  "error": true,
  "message": "Error msg"
}
```
<br>

With this route you can modify the name of the article (title) and the content of the article (message).
<br><br><br>


<h4 style="font-size=180%;text-decoration: underline;" id="PUTarticle">PUT article :</h4><hr>

```
localhost:8080/article
["title", "message", "author"]
// here is the argument that MUST be present in the Json object of your resquest
```


Json Response :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
<br>

With this route you can add a new article with the name of the article (title) and the content of the article (message).
<br><br><br>

<h3 style="font-size:200%;">COMMENTS :</h3>
<br>
So now we will have a look at the comment section :
<br>

<h4 style="font-size=180%;text-decoration: underline;" id="GETcomments">GET comments :</h4><hr>
So the GET request of our API had to get the argument via Json data so we choose to use a POST request to get the comments and a PUT resquest to add a new comment, So to get all the comments from a specific article you will have to use a POST request :


```
localhost:8080/comments
["id"]
// here is the argument that MUST be present in the Json object of your resquest
```


Json Response :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
<br><br><br>


<h4 style="font-size=180%;text-decoration: underline;" id="PUTcomment">PUT comment :</h4><hr>

```
localhost:8080/comment
["id", "author", "article_id", "comment"]
// here are the argument that MUST be present in you Json object
```


Json Response :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
<br>

So this route will made you able to add a comment using his id.
<br><br><br>


<h4 style="font-size=180%;text-decoration: underline;" id="PATCHcomment">PATCH comment :</h4><hr>

```
localhost:8080/comment
["id", "author", "article_id", "comment"]
// here is the argument that CAN be present in the Json object of your resquest
// The id must be present
```


Json Response :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
<br>

So this route will made you able to update a comment using his id.
<br><br><br>


<h4 style="font-size=180%;text-decoration: underline;" id="DELETEcomment">DELETE comment :</h4><hr>

```
localhost:8080/comment
["id"]
// here is the argument that MUST be present in the Json object of your resquest
// The id must be present
```


Json Response :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
<br>

So this route will made you able to update a comment using his id.

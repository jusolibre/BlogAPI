<h1>Welcome to our API REST github page.</h1>

This API was created using slim so we will give you <strong>examples using localhost and the port 8080</strong>, but you will be able to use it on the port you have chosen and with your database.
<br> <br />

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
<br> <br />

<b>IMPORTANT: </b>You need to register an account before doing that because you need an apiKey! Here are the steps to get your apiKey.
<h2>Get an ApiKey</h2>
<ul>
    <li>You need to send a POST request to the route "/register" with a JSON including       {"username":"YOURUSERNAME","password":"YOURPASSWORD"}</li>
    <li>After that, you need to login by sending a POST request on the route "/login" with a JSON including {"username":"YOURUSERNAME", "password":"YOURPASSWORD"}</li>
    <li>If your account details are corrects, you will get your apiKey.</li>
</ul>

```
{
  "apikey":"APIKEY GOES HERE"
}
```
<h2>How to use my ApiKey?</h2>
Since you have your ApiKey, you will have to set a header named "Authorization" and your ApiKey as value.

<h2>So here are the differents routes for ARTICLES :</h2>

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

<h4 style="font-size=180%;text-decoration: underline;" id="GETarticle">GET an article :</h4><hr>

<em style="font-size:80%;">This route allows you to get an article informations. To do it, you will have to send a json with the argument "id" and the article ID you want to get by using a POST request. For example : To get the article "1", I will have to send that JSON: {"id":1}.</em>

```
localhost:8080/search
["id"]
// here is the argument that MUST be present in the Json object of your resquest
```
If we have all required arguments and if everything is good, the JSON response will look like that :
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
<em style="font-size:80%;">This route allows you to delete an article. To do it, you will have to send a json with the argument "id" and the article ID you want to delete by using a POST request. For example : To delete the article "1", I will have to send that JSON: {"id":1}.</em>
```
localhost:8080/article
["id"]
// here is the argument that MUST be present in the Json object of your request
```
If we have all required arguments and if everything is good, the JSON response will look like that :
```
{
  "error": false,
  "message": "Article has been deleted!"
}
```
Otherwise, you will have an error if the article is not found or if you are not allowed to delete an article:
```
{
  "error": true,
  "message": "Error msg"
}
```
This route needs the argument "id" and the article ID. (numeric)
<br>

<h4 style="font-size=180%;text-decoration: underline;" id="PATCHarticle">PATCH article :</h4><hr>
<em style="font-size:80%;">This route allows you to update an article. To do it, you will have to send a json with the arguments "id" (required), "author" and "message" but they are not required, by using a POST request. <br />

For example : To update the article "1", I will have to send that JSON: {"id":1, "author":"Clement", "message": "Hello world!"}.</em>

```
localhost:8080/article
["id", "title", "message"]
// here is the argument that CAN be present in the Json object
// The id must be present

```
If we have all required arguments and if everything is good, the JSON response will look like that :
```
{
  "error": false,
  "message": "Article has been updated!"
}
```
Otherwise, you will have an error message :
```
{
  "error": true,
  "message": "Error msg"
}
```

<h4 style="font-size=180%;text-decoration: underline;" id="PUTarticle">PUT article :</h4><hr>
<em style="font-size:80%;">This route allows you to update a new article. To do it, you will have to send a json with the arguments "title", "message", "author" by using a PUT request. <br />

For example : To insert a new article, I will have to send that JSON: {"author":"Clement", "message": "Hello world!", "title":"New article!"}.</em>

```
localhost:8080/article
["title", "message", "author"]
// here is the argument that MUST be present in the Json object of your resquest
```
If we have all required arguments and if everything is good, the JSON response will look like that :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
Otherwise, you will have an error message :
```
{
  "error": true,
  "message": "Error msg"
}
```
<h2>So here are the differents routes for COMMENTS:</h2>
So now we will have a look at the comment section :
<br>

<h4 style="font-size=180%;text-decoration: underline;" id="GETcomments">GET all comments from an article :</h4><hr>
<em style="font-size:80%;">This route allows you to get all comments from an article ID. To do it, you will have to send a json with the argument "id" by using a POST request. <br />

For example : To get all comments from the article 1, I will have to send that JSON: {"id":1}.</em>
```
localhost:8080/comments
["id"]
// here is the argument that MUST be present in the Json object of your resquest
```
If we have all required arguments and if everything is good, the JSON response will look like that :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
Otherwise, you will have an error message :
```
{
  "error": true,
  "message": "Error msg"
}
```
<h4 style="font-size=180%;text-decoration: underline;" id="PUTcomment">PUT comment :</h4><hr>
<em style="font-size:80%;">This route allows you to insert a new comment on the article you have chosen. To do it, you will have to send a json with the arguments "article_id", "title", "comment" by using a PUT request. <br />

For example : To insert a new comment on the article ID 1, I will have to send that JSON: {"author":"Julien", "article_id":1, "comment":"Hello!"}.</em>
```
localhost:8080/comment
["author", "article_id", "comment"]
// here are the argument that MUST be present in you Json object
```
If we have all required arguments and if everything is good, the JSON response will look like that :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
Otherwise, you will have an error if the article is not found or if you are not allowed to delete an article:
```
{
  "error": true,
  "message": "Error msg"
}
```
<h4 style="font-size=180%;text-decoration: underline;" id="PATCHcomment">PATCH comment :</h4><hr>
<em style="font-size:80%;">This route allows you to update a comment on the article you have chosen. To do it, you will have to send a json with the arguments "id" (comment_id, required), "title", "comment" (but they are not required) by using a PATCH request. <br />

For example : To update the comment ID 1, I will have to send that JSON: {"id":1, "author":"Clement","comment":"Hello!"}.</em>

```
localhost:8080/comment
["author", "id", "comment"]
// here is the argument that CAN be present in the Json object of your resquest
// The id must be present
```
If we have all required arguments and if everything is good, the JSON response will look like that :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
Otherwise, you will have an error if the article is not found or if you are not allowed to delete an article:
```
{
  "error": true,
  "message": "Error msg"
}
```
<h4 style="font-size=180%;text-decoration: underline;" id="DELETEcomment">DELETE a comment :</h4><hr>
<em style="font-size:80%;">This route allows you to delete a comment. To do it, you will have to send a json with the argument "id" by using a DELETE request. <br />

For example : To delete the comment 1, I will have to send that JSON: {"id":1}.</em>

```
localhost:8080/comment
["id"]
// here is the argument that MUST be present in the Json object of your request
// The id must be present
```
If we have all required arguments and if everything is good, the JSON response will look like that :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
Otherwise, you will have an error if the article is not found or if you are not allowed to delete an article:
```
{
  "error": true,
  "message": "Error msg"
}
```
<h2>Questions? Bugs?</h2>
Feel free to open a new issue.

<h1>Welcome to our API REST github page.</h1>

This API was created using slim so we will give you <strong>examples using localhost and the port 8080</strong>, but you will be able to use it on the port you have chosen and with your database.
<h2>Summary</h2>
<ul>
    <li><a href="#requirement">Requirement</a></li>
    <li><a href="#database">Setup database connection</a></li>
    <li><a href="#whattodo">What to do ?</a></li>
    <li><a href="#getapi">Get an ApiKey</a></li>
    <li><a href="#setupapi">Setup my ApiKey</a></li>
</ul>

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

<h2 id="requirement">Requirement</h2>
<ul>
    <li>PHP 5.6 >=</li>
    <li>Xampp or Wampp (Only if you try this project in local)</li>
    <li><a href="https://getcomposer.org/">Composer</a></li>
</ul>

<h2 id="database">Setup database connection</h2>
Of course, you have to setup your database connection informations. To do that, go on the "src" folder and open the file "settings.php". You will see an array called "db" with all database informations. Feel free to edit them with your database informations! <br />

Don't forget to importing the blog2.sql file in your database.

<h2 id="whattodo">What to do?</h2>
After having everything, you will have to run composer to get the "vendor" folder. Open the windows "cmd", and type :
```
composer install
```
Yes! We have now the vendor folder. Now, we can run the server : 
```
php -S 0.0.0.0:8080 public public/index.php
```
Oh! And I forgot about PHP.INI; You will need to uncomment the line in your PHP folder :
```
always_populate_raw_post_data = -1
```
Don't forget after that to get your ApiKey! For informations you will be able to insert/update/delete an article/comment only if you are logged in and if you are allowed to according to the author.

<h2 id="getapi">Get an ApiKey</h2>
<b>IMPORTANT: </b>You need to register an account before doing that because you need an apiKey! Here are the steps to get your apiKey.
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
<h2 id="setupapi">How to use my ApiKey?</h2>
Since you have your ApiKey, you will have to set a header named "Authorization" and your ApiKey as value.

<h2>So here are the differents routes for ARTICLES :</h2>

First, you need to be able to send a JSON with required arguments and receive a response in a JSON.

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
<em style="font-size:80%;">This route allows you to delete an article. To do it, you will have to send a json with the argument "id" and the article ID you want to delete by using a DELETE request. For example : To delete the article "1", I will have to send that JSON: {"id":1}.</em>
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

<h4 style="font-size=180%;text-decoration: underline;" id="PATCHarticle">UPDATE an article :</h4><hr>
<em style="font-size:80%;">This route allows you to update an article. To do it, you will have to send a json with the arguments "id" (required), "author" and "message" but they are not required, by using a PATCH request. <br />

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

<h4 style="font-size=180%;text-decoration: underline;" id="PUTarticle">Insert an article :</h4><hr>
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
<h4 style="font-size=180%;text-decoration: underline;" id="PUTcomment">Insert a comment :</h4><hr>
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
<h4 style="font-size=180%;text-decoration: underline;" id="PATCHcomment">Update a comment :</h4><hr>
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
Feel free to open a new issue and we'll try to help you!

<h1>Welcome to our API REST github page.</h1>

<p>
This API was created using slim so we will give you <strong>examples using localhost and the port 8080</strong>, but you will be able to use it on the port you choose and with your database.
</p>
<h5 style="font-size:120%;">YOU WILL NEED TO UNCOMMENT THE LINE always_populate_raw_post_data = -1 IN YOUR PHP.INI FILE </h5>

<p>
Our API will allow you to access a blog from your own website.<br>
Using differents routes you will be able to :<br>
  - <a href="#articles">list the differents articles</a>,<br>
  - <a href="#GETarticle">get a specific one</a>,<br>
  - <a href="#PUTarticle">add some article</a>,<br>
  - <a href="#PATCHarticle">update the article</a>,<br>
  - <a href="#DELETEarticle">and finally delete article one by one</a>.<br>
</p>

<p>
We also add a comment management so you can use differents routes like for articles :<br>
  - <a href="#GETcomments">list the comments on a specific article</a>,<br>
  - <a href="#PUTcomment">add a comment</a>,<br>
  - <a href="#PATCHcomment">modify a comment</a>,<br>
  - <a href="#DELETEcomment">and finally delete a comment</a>.<br>
</p>

<h2>So here are the differents routes :</h2>

<p>First you need to be able to send Json data, and receive response in Json.</p>

<h3>ARTICLE :</h3>

<h4 style="font-size=120%" id="articles">GET articles :</h4>
<hr>
```
localhost:8080/articles
```
<hr>

<p>
The Json response will look like (in case of success):<br>
```<br>
[<br>
  {<br>
    "id": "id",<br>
    "title": "title",<br>
    "message": "article content",<br>
    "author": "author",<br>
    "category": "category",<br>
    "date": "YYYY-MM-DD"<br>
  },<br>
  {<br>
    "id": "id",<br>
    "title": "title",<br>
    "message": "article content2",<br>
    "author": "author",<br>
    "category": "category",<br>
    "date": "YYYY-MM-DD"<br>
  }<br>
]<br>
```<br>
</p>

<p>
And in case of fail, or if there is nothing in the database :<br>
```<br>
{<br>
  "error": true,<br>
  "message": "Not article in database"<br>
}<br>
```<br>
</p>

<p>This routes need no arguments.</p>



<h4 style="font-size=120%" id="GETarticle">GET article :</h4>

<em style="font-size:80%;">This route is a special one, you will need to send the id and as we are usiong a full Json communication, you will need to use a POST request, to be able to be able to send data in the body of your request, this request is the reason why you need to uncomment the line in your php.ini.
We could get the argument in the url and use a GET request but, as we had to use a full Json communication, we choose to create this route instead.</em>

<hr>
```
localhost:8080/search
["id"] 
// here is the argument that MUST be present in the Json object of your resquest
```
<hr>

<p>
In case of success :<br>
```<br>
{<br>
  "id": "id",<br>
  "title": "title",<br>
  "message": "content of the article",<br>
  "author": "author",<br>
  "category": "category",<br>
  "date": "YYYY-MM-DD"<br>
}<br>
```<br>
</p>

<p>
In case of error :<br>
```<br>
{<br>
  "error": true,<br>
  "message": "Error msg"<br>
}<br>
```<br>
</p>

<p>This route needs the ID of the article you are looking for.</p>



<h4 style="font-size=120%" id="DELETEarticle">DELETE article :</h4>

<hr>
```
localhost:8080/article
["id"]
// here is the argument that MUST be present in the Json object of your resquest

```
<hr>

<p>
In case of success :<br>
```<br>
{<br>
  "error": false,<br>
  "message": "Article has been deleted!"<br>
}<br>
```<br>
</p>

<p>
In case of error :<br>
```<br>
{<br>
  "error": true,<br>
  "message": "Error msg"<br>
}<br>
```<br>
</p>

<p>This route needs the ID of the article you want to delete.</p>



<h4 style="font-size=120%" id="PATCHarticle">PATCH article :</h4>

<hr>
```
localhost:8080/article
["id", "title", "message"] 
// here is the argument that CAN be present in the Json object
// The id must be present

```
<hr>

<p>
In case of success :<br>
```<br>
{<br>
  "error": false,<br>
  "message": "Article has been updated!"<br>
}<br>
```<br>
</p>

<p>
In case of error :<br>
```<br>
{<br>
  "error": true,<br>
  "message": "Error msg"<br>
}<br>
```<br>
</p>

<p>With this route you can modify the name of the article (title) and the content of the article (message).</p>



<h4 style="font-size=120%" id="PUTarticle">PUT article :</h4>

<hr>
```
localhost:8080/article
["title", "message", "author"] 
// here is the argument that MUST be present in the Json object of your resquest
```
<hr>

<p>
Json Response :<br>
```<br>
  {<br>
    error: false, //will be true if you get an error<br>
    message: "Success" //will contain the message corresponding to you error if you get one.<br>
  }<br>
```<br>
</p>

<p>With this route you can add a new article with the name of the article (title) and the content of the article (message).</p>

<h3>COMMENTS :</h3>

<p>So now we will have a look at the comment section :</p>

<h4 style="font-size=120%" id="GETcomments">GET comments :</h4>

<p>
So the GET request of our API had to get the argument via Json data so we choose to use a POST request to get the comments and a PUT resquest to add a new comment, So to get all the comments from a specific article you will have to use a POST request :
</p>

<hr>
```
localhost:8080/comments
["id"] 
// here is the argument that MUST be present in the Json object of your resquest
```
<hr>

<p>
Json Response :<br>
```<br>
  {<br>
    error: false, //will be true if you get an error<br>
    message: "Success" //will contain the message corresponding to you error if you get one.<br>
  }<br>
```<br>
</p>



<h4 style="font-size=120%" id="PUTcomment">PUT comment :</h4>

<hr>
```
localhost:8080/comment
["id", "author", "article_id", "comment"]
// here are the argument that MUST be present in you Json object
```
<hr>

<p>
Json Response :<br>
```<br>
  {<br>
    error: false, //will be true if you get an error<br>
    message: "Success" //will contain the message corresponding to you error if you get one.<br>
  }<br>
```<br>
</p>

<p>So this route will made you able to add a comment using his id.</p>



<h4 style="font-size=120%" id="PATCHcomment">PATCH comment :</h4>

<hr>
```
localhost:8080/comment
["id", "author", "article_id", "comment"]
// here is the argument that CAN be present in the Json object of your resquest
// The id must be present
```
<hr>

<p>
Json Response :<br>
```<br>
  {<br>
    error: false, //will be true if you get an error<br>
    message: "Success" //will contain the message corresponding to you error if you get one.<br>
  }<br>
```<br>
</p>

<p>So this route will made you able to update a comment using his id.</p>



<h4 style="font-size=120%" id="DELETEcomment">DELETE comment :</h4>

<hr>
```
localhost:8080/comment
["id"]
// here is the argument that MUST be present in the Json object of your resquest
// The id must be present
```
<hr>

<p>
Json Response :<br>
```<br>
  {<br>
    error: false, //will be true if you get an error<br>
    message: "Success" //will contain the message corresponding to you error if you get one.<br>
  }<br>
```<br>
</p>

<p>So this route will made you able to update a comment using his id.</p>

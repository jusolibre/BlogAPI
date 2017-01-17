<h1>Welcome to our API REST github page.</h1>

This API was created using slim so we will give you <strong>examples using localhost and the port 8080</strong>, but you will be able to use it on the port you choose and with your database.
<h5 style="font-size:120%;">YOU WILL NEED TO UNCOMMENT THE LINE always_populate_raw_post_data = -1 IN YOUR PHP.INI FILE </h5>

Our API will allow you to access a blog from your own website.
Using differents routes you will be able to :
  - <a href="#articles">list the differents articles</a>,
  - <a href="#GETarticle">get a specific one</a>,
  - <a href="#PUTarticle">add some article</a>,
  - <a href="#PATCHarticle">update the article</a>,
  - <a href="#DELETEarticle">and finally delete article one by one</a>.

We also add a comment management so you can use differents routes like for articles :
  - <a href="#GETcomments">list the comments on a specific article</a>,
  - <a href="#PUTcomment">add a comment</a>,
  - <a href="#PATCHcomment">modify a comment</a>,
  - <a href="#DELETEcomment">and finally delete a comment</a>.

So here are the differents routes :

First you need to be able to send Json data, and receive response in Json.

<h2>ARTICLE :</h2>

<h3 style="font-size=120%" id="articles">GET articles :</h3>
```
localhost:8080/articles
```
The Json response will look like (in case of success):
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
And in case of fail, or if there is nothing in the database :
```
{
  "error": true,
  "message": "Not article in database"
}
```
This routes need no arguments.



<h3 style="font-size=120%" id="GETarticle">GET article :</h3>

<em style="font-size:80%;">This route is a special one, you will need to send the id and as we are usiong a full Json communication, you will need to use a POST request, to be able to be able to send data in the body of your request, this request is the reason why you need to uncomment the line in your php.ini.
We could get the argument in the url and use a GET request but, as we had to use a full Json communication, we choose to create this route instead.</em>

```
localhost:8080/search
["id"] 
// here is the argument that MUST be present in the Json object of your resquest
```

In case of success :
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

In case of error :
```
{
  "error": true,
  "message": "Error msg"
}
```
This route needs the ID of the article you are looking for.



<h3 style="font-size=120%" id="DELETEarticle">DELETE article :</h3>
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

In case of error :
```
{
  "error": true,
  "message": "Error msg"
}
```
This route needs the ID of the article you want to delete.



<h3 style="font-size=120%" id="PATCHarticle">PATCH article :</h3>
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

In case of error :
```
{
  "error": true,
  "message": "Error msg"
}
```
With this route you can modify the name of the article (title) and the content of the article (message).



<h3 style="font-size=120%" id="PUTarticle">PUT article :</h3>
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
With this route you can add a new article with the name of the article (title) and the content of the article (message).

<h2>COMMENTS :</h2>

So now we will have a look at the comment section :

<h3 style="font-size=120%" id="GETcomments">GET comments :</h3>
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



<h3 style="font-size=120%" id="PUTcomment">PUT comment :</h3>
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
So this route will made you able to update a comment using his id.




<h3 style="font-size=120%" id="DELETEcomment">DELETE comment :</h3>
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
So this route will made you able to update a comment using his id.

<h1>Welcome to our API REST github page.</h1>

This API was created using slim so we will give you <strong>examples using localhost and the port 8080</strong>, but you will be able to use it on the port you choose and with your database.
<h3>YOU WILL NEED TO UNCOMMENT THE LINE always_populate_raw_post_data = -1 IN YOUR PHP.INI FILE </h3>

Our API will allow you to access a blog from your own website.
Using differents routes you will be able to :
  - <a href="#articles">list the differents articles</a>,
  - <a href="#GETarticle">get a specific one</a>,
  - <a href="#PUTarticle">add some article</a>,
  - <a href="#PATCHarticle">update the article</a>,
  - <a href="#DELETEarticle">and finally delete article one by one</a>.

We also add a comment management so you can use differents routes like for articles :
  - list the comments on a specific article,
  - add a comment,
  - modify a comment,
  - and finally delete a comment.

So here are the differents routes :

First you need to be able to send Json data, and receive response in Json.


<h2 id="articles">GET articles :</h2>
```
localhost:8080/articles
```
This routes need no arguments.



<h2 id="GETarticle">GET article :</h2>
```
localhost:8080/article
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
{"error": true,
  "message": "Error msg"
  
}
```
This routes need the ID of the article you are looking for.



<h2 id="DELETEarticle">DELETE article :</h2>
```
localhost:8080/article
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
{"error": true,
  "message": "Error msg"
  
}
```
This routes need the ID of the article you want to delete.



<h2 id="PATCHarticle">PATCH article :</h2>
```
localhost:8080/article

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



<h2 id="PUTarticle">PUT article :</h2>
```
localhost:8080/article

```
Json Response :
```
  {
    error: false, //will be true if you get an error
    message: "Success" //will contain the message corresponding to you error if you get one.
  }
```
With this route you can add a new article with the name of the article (title) and the content of the article (message).

So now we will have a look at the comment section :

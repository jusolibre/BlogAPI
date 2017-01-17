Welcome to our API REST github page.
This API was created using slim so we will give you examples using localhost and the port 8080, but you will be able to use it on the port you choose and with your database.

Our API will allow you to access a blog from your own website.
Using differents routes you will be able to :
  - list the differents articles,
  - find a specific one,
  - add some article,
  - update the article,
  - and finally article one by one.

We also add a comment management so you can use differents routes like for articles :
  - list the comments on a specific article,
  - add a comment,
  - modify a comment,
  - and finally delete a comment.

So here are the differents routes :

First you need to be able to send Json data, and receive response in Json.


Then the first route is articles with a GET verb:
```
localhost:8080/articles
```
This routes need no arguments.



So the next route is article with a GET verb:
```
localhost:8080/article
```
This routes need the ID of the article you are looking for.



So the next route is article with a DELETE verb:
```
localhost:8080/article
```
This routes need the ID of the article you want to delete.



So the next route is article with a PATCH verb:
```
localhost:8080/article
```
With this route you can modify the name of the article (title) and the content of the article (message).



So the next route is article with a PUT verb:
```
localhost:8080/article
```
With this route you can add a new article with the name of the article (title) and the content of the article (message).

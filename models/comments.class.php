<?php
class Comments {

    public static function select ($id) {
        $query  = DataBase::bdd()->query("SELECT * FROM comments WHERE article_id = '$id' ORDER BY date ASC;");
        $fetch  = $query->fetch();
        $row    = $query->rowCount();
        $data   = ($row >= 1) ? $fetch : ["error" => true, "message" => "Not comments in database"];
        return $data;
    }

    public static function selectById ($id) {
        if (!empty($id)) {
            $query  = DataBase::bdd()->query("SELECT * FROM comments WHERE id = $id");
            $fetch  = $query->fetch();
            $data   = $fetch == false ? ["error" => true, "message" => "Comment not found"] : $fetch;
        } else {
            $data = ["error" => true, "message" => "No ID selected"];
        }
        return $data;
    }

    public static function deleteById ($id) {
        $delete = DataBase::bdd()->query("DELETE FROM comments WHERE id = $id");
        $data   = ["error" => false, "message" => "Comment has been deleted!"];
        return $data;
    }

    public static function deleteComments ($article_id) {
        $delete = DataBase::bdd()->query("DELETE FROM comments WHERE article_id = $article_id");
        $data   = ["error" => false, "message" => "Comments had been deleted!"];
        return $data;
    }

    public static function updateById ($author, $comment, $id) {
        $update = DataBase::bdd()->query("UPDATE comments SET author='{$author}', comment='{$comment}' WHERE id='{$id}'");
        $data   = ["error" => false, "message" => "Comment has been updated!"];
        return $data;
    }

    public static function insert ($article_id, $author, $comment) {
        $query = DataBase::bdd()->prepare("INSERT into comments(article_id, author, comment, date) VALUES(:article_id, :author, :comment, NOW())");

        $query->bindParam(':article_id', $article_id);
        $query->bindParam(':author', $author);
        $query->bindParam(':comment', $comment);
        $query->execute();

        $data = ["error" => false, "message" => "Success"];

        return $data;
    }

}

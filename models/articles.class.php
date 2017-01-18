<?php

class Articles {

    public static function select () {
        $query  = DataBase::bdd()->query("SELECT * FROM miniblog");
        $fetch  = $query->fetchAll();
        $row    = $query->rowCount();
        $data   = ($row >= 1) ? $fetch : $fetch = ["error" => true, "message" => "Not article in database"];
        return $data;
    }

    public static function selectById ($id) {
        if (!empty($id)) {
            $query = DataBase::bdd()->query("SELECT * FROM miniblog WHERE id = $id");
            $fetch = $query->fetch();
            $data   = $fetch == false ? ["error" => true, "message" => "Article not found"] : $fetch;
        } else {
            $data = ["error" => true, "message" => "Not id selected"];
        }
        return $data;
    }

    public static function insert ($title, $message, $author, $category = "informatic") {
        $register 	= DataBase::bdd()->prepare("INSERT INTO miniblog(title, message, author, category, date) VALUES(:title, :message, :author, :category, NOW())");

        $register->bindParam(':title', $title);
        $register->bindParam(':message', $message);
        $register->bindParam(':author', $author);
        $register->bindParam(':category', $category);
        $register->execute();

        $data = ["error" => false, "message" => "Success"];

        return $data;
    }

    public static function deleteById ($id) {
        $delete = DataBase::bdd()->query("DELETE FROM miniblog WHERE id = $id");
        if ($delete) {
            $delete = DataBase::bdd()->query("DELETE FROM comments WHERE article_id = $id");
            $data   = ["error" => false, "message" => "Article has been deleted!"];
        }
        return $data;
    }

    public static function updateById ($id, $title, $message) {
        $update = DataBase::bdd()->query("UPDATE miniblog SET title='{$title}', message='{$message}' WHERE id='{$id}'");
        $data   = ["error" => false, "message" => "Article has been updated!"];
        return $data;
    }

}

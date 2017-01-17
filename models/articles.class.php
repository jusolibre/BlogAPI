<?php

class Articles {

    public function select () {
        $query  = $this->db->query("SELECT * FROM miniblog");
        $fetch  = $query->fetchAll();
        $row    = $query->rowCount();
        $data   = ($row >= 1) ? $fetch : $fetch = ["error" => true, "message" => "Not article in database"];
        return $data;
    }

    public function selectById ($id) {
        if (!empty($id)) {
            $query = $this->db->query("SELECT * FROM miniblog WHERE id = $id");
            $fetch = $query->fetch();
            $data   = $fetch == false ? ["error" => true, "message" => "Article not found"] : $fetch;
        } else {
            $data = ["error" => true, "message" => "Not id selected"];
        }
        return $data;
    }

    public function insert ($title, $message, $author, $category = "informatic") {
        $register 	= $this->db->prepare("INSERT INTO miniblog(title, message, author, category, date) VALUES(:title, :message, :author, :category, NOW())");

        $register->bindParam(':title', $title);
        $register->bindParam(':message', $message);
        $register->bindParam(':author', $author);
        $register->bindParam(':category', $category);
        $register->execute();

        $data = ["error" => false, "message" => "Success"];

        return $data;
    }

    public  function  deleteById ($id) {
        $delete = $this->db->query("DELETE FROM miniblog WHERE id = $id");
        $data   = ["error" => false, "message" => "Article has been deleted!"];
        return $data;
    }

    public  function updateById ($id, $title, $message)
    {
        $update = $this->db->query("UPDATE miniblog SET title='{$title}', message='{$message}' WHERE id='{$id}'");
        $data = ["error" => false, "message" => "Article has been updated!"];
        return $data;
    }

}

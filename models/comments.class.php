<?php

    class Comments {

        public function select ($id) {

            $query = $this->db->query("SELECT * FROM comments WHERE article_id = '$id' ORDER BY date ASC;");
            $fetch = $query->fetch();
            $row = $query->rowCount();

            $data = ($row >= 1) ? $fetch : $fetch = ["error" => true, "message" => "Not comments in database"];

            return $data;

        }

        public function selectById ($id) {

            if (!empty($id)) {

                $query = $this->db->query("SELECT * FROM comments WHERE id = $id");
                $fetch = $query->fetch();

                if (!$fetch) {
                    $data = ["error" => true, "message" => "Comment not found"];
                }
                else {
                    $data = $fetch;
                }
            } else {
                $data = ["error" => true, "message" => "Not id selected"];
            }

            return $data;
        }

        public function deleteById ($id) {

            $delete = $this->db->query("DELETE FROM comments WHERE id = $id");
            $data   = ["error" => false, "message" => "Comment has been deleted!"];

            return $data;

        }

        public function updateById ($author, $comment, $id) {

            $update = $this->db->query("UPDATE comments SET author='{$author}', comment='{$comment}' WHERE id='{$id}'");
            $data   = ["error" => false, "message" => "Comment has been updated!"];

            return $data;
        }

        public function insert ($article_id, $author, $comment) {

            $query = $this->db->prepare("INSERT into comments(article_id, author, comment, date) VALUES(:article_id, :author, :comment, NOW())");

            $query->bindParam(':article_id', $article_id);
            $query->bindParam(':author', $author);
            $query->bindParam(':comment', $comment);

            $query->execute();

            $data = ["error" => false, "message" => "Success"];

            return $data;
        }

    }
<?php
class Connection {

    static private function myEncrypt($password) {
        $newPass = password_hash($password, PASSWORD_DEFAULT);
        return $newPass;
    }

    static private function insert($username, $passwordHash, $apiKey) {
        $query  = DataBase::bdd()->query("SELECT * FROM users WHERE username ='{$username}'");
        $query->fetchAll();
        $row    = $query->rowCount();

        if ($row > 0) {
            return ["error" => true, "message" => "An account with this username already exist"];
        } else {
            $register = DataBase::bdd()->prepare("INSERT INTO users(username, password_hash, apiKey) VALUES(:username, :passwordHash, :apiKey)");

            $register->bindParam(':username', $username);
            $register->bindParam(':passwordHash', $passwordHash);
            $register->bindParam(':apiKey', $apiKey);
            $result = $register->execute();
            $data   = $result ? ["error" => false, "message" => "Success"] : ["error" => true, "message" => "Something went wrong adding your account to our database"];
        }
        return $data;
    }

    static private function verifyApiKey($apiKey) {
        $query  = DataBase::bdd()->query("SELECT * FROM users WHERE apiKey ='{$apiKey}'");
        $fetch  = $query->fetchAll();
        $row    = $query->rowCount();
        return ($row > 0) ? false : true;
    }

    static private function getUserAccount($username) {
        $query  = DataBase::bdd()->query("SELECT * FROM users WHERE username ='{$username}'");
        $fetch  = $query->fetch();
        $row    = $query->rowCount();

        return ($row > 0) ? $fetch : false;
    }

    static public function getUsername ($apiKey) {
        $query  = DataBase::bdd()->query("SELECT * FROM users WHERE apiKey ='{$apiKey}");
        $fetch  = $query->fetch();
        $row    = $query->rowCount();

        return ($row > 0) ? $fetch['username'] : false;
    }

    static public function register($username, $password) {
        $newPassword = Connection::myEncrypt($password, $username);
        $apiKey = bin2hex(openssl_random_pseudo_bytes(32));
        while (!Connection::verifyApiKey($apiKey)) {
            $apiKey = bin2hex(openssl_random_pseudo_bytes(32));
        }

        return Connection::insert($username, $newPassword, $apiKey);
    }

    static public function login($username, $password) {
        $user = Connection::getUserAccount($username);

        if ($user) {
            if (password_verify($password, $user["password_hash"])) {
                return (['apiKey' => $user['apiKey']]);
            } else {
                return (["error" => true, "message" => "Wrong password"]);
            }
        } else {
            return (["error" => true, "message" => "Undefined account"]);
        }
    }
}
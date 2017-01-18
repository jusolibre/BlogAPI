<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 18/01/2017
 * Time: 09:29
 */


class Connection {

    private function myEncrypt($password, $username) {

        $newPass = crypt(addslashes($password), "\$_\\\[B\]\[l\]\[o\]\[g\]\[A\]\[P\]\[I\]\[S\]\[A\]\[L\]\[T\]\/_\$" . addslashes($username));
        $newPass = password_hash($newPass, PASSWORD_DEFAULT);

        return ($newPass);
    }

    private function insert($username, $passwordHash, $apiKey) {
        $query  = DataBase::bdd()->query("SELECT * FROM account WHERE username == $username");

        $query->fetchAll();
        $row    = $query->rowCount();

        if ($row > 0) {
            return ["error" => true, "message" => "An account with this username already exist"];
        }

        $register 	= DataBase::bdd()->prepare("INSERT INTO account(username, passwordHash, apiKey) VALUES(:username, :passwordHash, :apiKey)");

        $register->bindParam(':username', $username);
        $register->bindParam(':passwordHash', $passwordHash);
        $register->bindParam(':apiKey', $apiKey);
        $result = $register->execute();

        $data = ($result) ? ["error" => false, "message" => "Success"] : ["error" => true, "message" => "Something went wrong adding you account to our database"];

        return $data;
    }

    private function verifyApiKey($apiKey) {
        $query  = DataBase::bdd()->query("SELECT * FROM account WHERE apiKey == $apiKey");

        $fetch  = $query->fetchAll();
        $row    = $query->rowCount();

        return ($row > 0) ? false : true;
    }

    private function getUserAccount($username) {
        $query  = DataBase::bdd()->query("SELECT * FROM account WHERE username == $username");

        $fetch  = $query->fetch();

        return $fetch;
    }

    static public function getUsername ($apiKey) {
        $query  = DataBase::bdd()->query("SELECT * FROM account WHERE apiKey == $apiKey");

        $fetch  = $query->fetch();

        return $fetch['username'];
    }

    static public function register($username, $password) {

        $newPassword = Connection::myEncrypt($password, $username);
        $apiKey = bin2hex(openssl_random_pseudo_bytes(32));
        while (!Connection::verifyApiKey($apiKey)) {
            $apiKey = bin2hex(openssl_random_pseudo_bytes(32));
        }

        return Connection::insert($username, $newPassword, $apiKey);
    }

    static public function connection($username, $password) {
        $user = Connection::getUserAccount($username);
        $toCheck = Connection::myEncrypt($password, $username);

        if ($toCheck == $user['passwordHash']) {
            return (['apiKey' => $user['apiKey']]);
        } else {
            return (["error" => true, "message" => "Wrong password"]);
        }
    }
}
<?php

class User {
    protected $db;

    public function __construct () {
        global $db;
        $this->db = $db;
    }

    public function register ($username, $email, $password) {
        $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, email, hashed_pwd)
        VALUES (?, ?, ?);";

        $run = $this->db->prepare($sql);
        $run->bind_param("sss", $username, $email, $hashed_pwd);
        $result = $run->execute();

        if ($result) {
            $_SESSION['user_id'] = mysqli_insert_id($this->db);
            return true;

        } else {
            return false;
        }
    }

    public function login ($email, $password) {

        $sql = "SELECT id, hashed_pwd FROM users WHERE email = ?;";

        $run = $this->db->prepare($sql);
        $run->bind_param("s", $email);
        $run->execute();
        $results = $run->get_result();

        $user = $results->fetch_assoc();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['hashed_pwd'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;

        } else {
            return false;
        }
    }
}
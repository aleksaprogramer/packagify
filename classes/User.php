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
}
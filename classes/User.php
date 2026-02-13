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

    public function get_user_data ($id) {

        $sql = "SELECT username, email FROM users WHERE id = ?";
        $run = $this->db->prepare($sql);
        $run->bind_param("s", $id);
        $run->execute();
        $results = $run->get_result();

        $user = $results->fetch_assoc();

        if (!$user) {
            return false;

        } else {
            return $user;
        }
    }

    public function get_all_users () {

        $sql = "SELECT id, username, email, is_admin, created_at FROM users;";
        $run = $this->db->prepare($sql);
        $run->execute();
        $results = $run->get_result();
        $users = $results->fetch_all(MYSQLI_ASSOC);

        if ($users) {
            return $users;

        } else {
            return false;
        }
    }

    public function delete_user ($id) {

        $sql = "DELETE FROM users WHERE id = ?;";
        $run = $this->db->prepare($sql);
        $run->bind_param("s", $id);
        $run->execute();
        $result = $run->get_result();

        if ($result) {
            return true;

        } else {
            return false;
        }
    }
}
<?php

class Package {
    protected $db;

    public function __construct () {
        global $db;
        $this->db = $db;
    }

    public function make_new_package ($user_id, $package_name, $filename, $documentation, $filepath) {
        $sql = "INSERT INTO packages(user_id, filename, documentation, filepath)
        VALUES (?, ?, ?, ?);";
        $run = $this->db->prepare($sql);
        $run->bind_param("ssss", $user_id, $filename, $documentation, $filepath);
        $result = $run->execute();

        if ($result) {
            return true;

        } else {
            return false;
        }
    }
}
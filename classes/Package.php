<?php

class Package {
    protected $db;

    public function __construct () {
        global $db;
        $this->db = $db;
    }

    public function make_new_package ($user_id, $package_name, $filename, $documentation, $filepath) {
        $sql = "INSERT INTO packages(user_id, package_name, filename, documentation, filepath)
        VALUES (?, ?, ?, ?, ?);";
        $run = $this->db->prepare($sql);
        $run->bind_param("sssss", $user_id, $package_name, $filename, $documentation, $filepath);
        $result = $run->execute();

        if ($result) {
            return true;

        } else {
            return false;
        }
    }

    public function get_all_packages () {
        $sql = "SELECT user_id, package_name, documentation, created_at
        FROM packages";
        $run = $this->db->prepare($sql);
        $run->execute();
        $results = $run->get_result();
        $packages = $results->fetch_all(MYSQLI_ASSOC);

        if ($packages) {
            return $packages;

        } else {
            return false;
        }
    }
}
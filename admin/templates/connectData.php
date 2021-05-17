<?php
    class connectData {

        private $host;
        private $username;
        private $password;
        private $database;

        public function __construct($value = '') {
            if ($value != '') {
                include('../data.properties.php');
            }
            else {
                include('../../data.properties.php');
            }
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
        }

        public function selectData($query) {
            if (!$conn = mysqli_connect($this->host,$this->username,$this->password,$this->database)) {
                echo "<script> console.log('Connect failed !')</script>";
            }
            if (!(mysqli_query($conn, "set names 'utf8'"))) {
                echo "<script> console.log('Error : Failed to set names utf-8 !')</script>";
            }
            if (!($res = mysqli_query($conn, $query))) {
                echo "<script> console.log('Error : Failed when executed query !')</script>";
            }
            mysqli_close($conn);
            return $res;
        }

        public function executeQuery($query) {
            if (!$conn = mysqli_connect($this->host,$this->username,$this->password,$this->database)) {
                echo "<script> console.log('Connect failed !')</script>";
            }
            if (!($res = mysqli_query($conn, $query))) {
                echo "<script> console.log('Error : Failed when executed query !')</script>";
                return false;
            }
            return true;
        }
    }

?>
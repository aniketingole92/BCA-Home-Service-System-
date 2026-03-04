<?php
session_start();
include 'db/dbconnect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['order'])) {
                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
                        echo "<script>
                        window.location.href = 'login.php';
                        </script>";
                        exit;
                }else{
                        echo "<script>
                        window.location.href = 'customer/customer_index.php';
                        </script>";
                }
        }
}

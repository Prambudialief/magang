<?php
session_start();
if (!isset($_SESSION['mentor_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

?>
<?php
require_once 'logic.php';
unset($_SESSION['loggedUser']);
header('Location: login.php');
exit;

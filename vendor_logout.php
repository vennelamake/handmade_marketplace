<?php
session_start();
session_destroy();
header('Location: vendor_login.php');
exit;

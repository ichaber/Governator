<?php

require_once "../Database.php";
/**
 *
 * @author    Karl Bergthaler
 * @author    Georg Döhring
 * @copyright Copyright (c) 2013
 * @license   proprietary
 */

$username = $_POST['username'];
$pass = $_POST['pass'];

if (empty($username) OR empty($pass))
{
    returnToSignin();
}

$db = new Database();
$result = $db->getUserInfo($username);

$userId = $result['userId'];
$role = $result['role'];
$hash = $db->getPassHash($pass);

if (!empty($result) AND $result['password'] === $hash)
{
    session_start();
    $_SESSION['userId'] = $userId;
    $_SESSION['userRole'] = $role;
    $_SESSION['hash'] = $hash;
    session_write_close();
    header("Location: /signin.php?success=1");
    die;
    //TODO redirect
}
else
{
    returnToSignin();
}



####Functions
function returnToSignin()
{
    header("Location: /signin.php?error=1");
    die;
}
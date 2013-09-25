<?php

require_once "../Database.php";
require_once '../func/card.php';

const SALT = "\$6\$rounds=5000\$dfjo32498zuiash8kko293n449dfm48ny0ßmrh647ui3h67smv0nbertm2n233qsrweol";

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

$result = getUserInfo($username);
$userId = $result['userId'];
$role = $result['role'];
$hash = getPassHash($pass);

if (!empty($result) AND $result['password'] === $hash)
{
    session_start();
    $_SESSION['userId'] = $userId;
    $_SESSION['userRole'] = $role;
    $_SESSION['hash'] = $hash;
    session_write_close();

    if (userHasRentedCards($userId))
    {
        header("Location: /return.php");
    }
    else
    {
        header("Location: /rental.php");
    }
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

/**
 * @param $username
 *
 * @return array
 */
function getUserInfo($username)
{
    $db = new Database();
    $sql = "
        select * from
            Governator.User
        where username = :username
    ";
    $params = array(
        ":username" => $username
    );
    $result = $db->query($sql, $params);
    return !empty($result) ? $result[0] : array();
}

/**
 * @param $pass
 *
 * @return string
 */
function getPassHash($pass)
{
    return crypt($pass, SALT);
}

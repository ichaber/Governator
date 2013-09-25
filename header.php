<?php
require_once 'php/Database.php';

/**
 * Has the logged in user rented a card
 *
 * @return bool
 */
function userHasRentedCards()
{
    $db = new Database();

    if (empty($_SESSION['userId']))
    {
        die('FAIL');
    }

    $result = $db->query(
        '
                SELECT * FROM `Card`
                INNER JOIN `Transaction` USING (transactionId)
                WHERE userId = :userId
            ', array('userId' => $_SESSION['userId'])
    );

    if (empty($result))
    {
        return false;
    }
    else
    {
        return true;
    }
}

/*
 * Redirection
 */
if (userHasRentedCards())
{
    //TODO: implement
}
?>


<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Governator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./css/font-awesome.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>
    <link href="./css/bootstrap-responsive.css" rel="stylesheet">

</head>

<body style="">

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="/">Governator</a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li><a href="php/controller/logout.php">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container">
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gdoehring
 * Date: 25.09.13
 * Time: 15:10
 * To change this template use File | Settings | File Templates.
 */

session_start();

require_once '../Database.php';

// Validate
if (empty($_POST['cardId']))
{
    // TODO error
}


$Db = new Database();

$_sql = "
    LOCK TABLE `Card`;
";

$_sql = "
    SELECT transactionId
    FROM `Card`
    WHERE cardId = :cardId
";

$_result = $Db->query($_sql, array('cardId' => $_POST['cardId']));

if (empty($_result) OR $_result[0]['transactionId'] != 0)
{
    // TODO ERROR
}

$_sql = "
   INSERT INTO `Transaction`
   SET userId = :userId, cardId = :cardId, fromDate = NOW()
";
$_result = $Db->insertQuery($_sql, array('cardId' => $_POST['cardId'], 'userId' => $_SESSION['userId']));

if (!$_result)
{
    // TODO Error
}

$_insert_id = $Db->getLastInsertID();

$_sql = "
    UPDATE `Card`
    SET transactionId = :transactionId
    WHERE cardId = :cardId
";
$_result = $Db->insertQuery($_sql, array('transactionId' => $_insert_id, 'cardId' => $_POST['cardId']));

echo json_encode(array('success' => false));
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

$json_array = array('success' => false, 'errorId' => null);

// Validate
if (empty($_POST['cardId']))
{
    $json_array['success'] = false;
    $json_array['errorId'] = 1;
    echo json_encode($json_array);
    die();
}


$Db = new Database();

// Lock tables
$_sql = "
    START TRANSACTION
";
$Db->insertQuery($_sql);

// Check what transactionId this card has
$_sql = "
    SELECT transactionId
    FROM `Card`
    WHERE cardId = :cardId
";

$_result = $Db->query($_sql, array('cardId' => $_POST['cardId']));

if (empty($_result) OR $_result[0]['transactionId'] != 0)
{
    $_result['success'] = false;
    $_result['errorId'] = 2;

    // Release lock
    $_sql = "
        COMMIT
    ";
    $Db->insertQuery($_sql);

    echo json_encode($json_array);
    die();
}

// Insert new transaction
$_sql = "
   INSERT INTO `Transaction`
   SET userId = :userId, cardId = :cardId, fromDate = NOW()
";
$_result = $Db->insertQuery($_sql, array('cardId' => $_POST['cardId'], 'userId' => $_SESSION['userId']));

if (!$_result)
{
    // Release lock
    $_sql = "
        COMMIT
    ";
    $Db->insertQuery($_sql);

    echo json_encode($json_array);
    die();
}

$_insert_id = $Db->getLastInsertID();

// Set the information in the card object
$_sql = "
    UPDATE `Card`
    SET transactionId = :transactionId
    WHERE cardId = :cardId
";
$_result = $Db->insertQuery($_sql, array('transactionId' => $_insert_id, 'cardId' => $_POST['cardId']));

$_sql = "
    COMMIT
";
$Db->insertQuery($_sql);

$json_array['success'] = $_result;

echo json_encode($json_array);
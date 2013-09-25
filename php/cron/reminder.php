<?php
require_once 'php/Database.php';
require_once 'php/func/card.php';


$rentals = checkRentals();

foreach ($rentals as $rental)
{

    $fromDate = new DateTime($rental['fromDate']);
    $nowDate = new DateTime();

    $dayDiff = $fromDate->diff($nowDate)->days;

    if($dayDiff >= 3 && $dayDiff % 3 == 0)
    {
        sendReminder($rental['userId'], $rental['username'], $rental['email'], $rental['cardId']);
    }
}



####Functions

/**
 * Fetches all card infos for rented cards
 *
 * @return array An array of information for rented cards
 */
function checkRentals()
{
    $db = new Database();

    $sql= "
        SELECT * FROM `Governator`.`Card`
        INNER JOIN `Governator`.`Transaction` USING (transactionId)
        INNER JOIN `Governator`.`User` USING (userId)
        WHERE untilDate is null;
    ";
    return $db->query($sql);
}

/**
 * Sends a reminder to the user to return the card
 *
 * @param int $userId
 * @param string $username
 * @param string $email
 * @param int $cardNumber
 *
 * @return bool The output of the mail class
 */
function sendReminder($userId, $username, $email, $cardNumber)
{
    $subject = "Please return your card";
    $msg = "Hey " . $username . " Please return your card with number " . $cardNumber . "!";
    $header = null;
    $params = null;
    return mail($email, $subject, $msg, $header, $params);
}

<?php
session_start();
require_once('php/Database.php');
require_once('header.php');

$userId = $_SESSION['userId'];
if (!userHasRentedCards($userId))
{
    header("Location: /rental.php");
    die;
}
?>

<form class="form" action="php/controller/return.php" method="POST">
    <button type="submit" class="btn btn-primary btn-large" style="width: 100%;">Return Card</button>
</form>

<?php
require_once('footer.php');
?>

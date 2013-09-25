<?php
session_start();
require_once('php/Database.php');
require_once('header.php');
?>

<div class="alert alert-block alert-error fade in">
    <h4 class="alert-heading">Oh snap! You got an error returning your card!</h4>
</div>

<?php
require_once('footer.php');

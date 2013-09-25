<?php


/**
 * Redirects to the signin page
 */
function returnToSignin()
{
    header("Location: /signin.php");
}

/**
 * Redirects to the signin page with param error set to true
 */
function returnToSigninError()
{
    header("Location: /signin.php?error=1");
}

//Redirects to the return page
function redirectToReturnPage()
{
    header("Location: /return.php");
}

//Redirects to the rental page
function redirectToRentalPage()
{
    header("Location: /rental.php");
}
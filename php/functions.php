<?php

require_once("connection.php");

/*
 * Login Checkers
 */

function loggedInSuperAdmin() {
    return isset($_SESSION['superAdmin']);
}

function loggedInAdmin() {
    return isset($_SESSION['admin']);
}

function loggedInVoter() {
    return isset($_SESSION['voterID']);
}


function loggedIn() {
    return loggedInSuperAdmin() || loggedInAdmin() || loggedInVoter();
}

function confirmLoggedInSuperAdmin() {
    if (!loggedInSuperAdmin()) {
        redirect("login.html");
    }
}

function confirmLoggedInAdmin() {
    if (!loggedInAdmin()) {
        redirect("login.html");
    }
}

function confirmLoggedInVoter() {
    if (!loggedInVoter()) {
        redirect("login.html");
    }
}

function confirmLoggedIn() {
    if (!loggedIn()) {
        redirect("login.html");
    }
}


/*
 * Election-specific SQL functions
 */
function confirmCredentialsVoter($username, $password) {
    // TODO return if a voter username and password are valid
}

function confirmCredentialsAdmin($username, $password) {
    // TODO return if an admin username and password are valid
}

function confirmCredentialsSuperAdmin($username, $password) {
    // TODO return if a super admin username and password are valid
}

function getOrganizationName() {
    // TODO return the name of the organization as logged in
}

function createAdmin($orgID, $username, $password) {
    // TODO add an admin to an org
}

function createUser($electionID, $username, $password) {
    // TODO add a user to an election
}

function createCandidate($orgID, $candidateID, $firstName, $lastName, $position) {
    // TODO add a candidate to an org
}

function hasVoted($userID) {
    // TODO return if a user has voted
}

/*
 * Utility functions
 */
function prepMySQLString($string) {
    global $connection;
    $magicQuotesExist = get_magic_quotes_gpc(); // always false after PHP 5.4
    if (function_exists("mysqli_real_escape_string")) { // PHP 5 or later
        if ($magicQuotesExist) $string = stripcslashes($string); // get rid of extra slashes from early PHP
        $string = mysqli_real_escape_string($connection, $string);
    } else { // pre-PHP 4.3.0
        if (!$magicQuotesExist) {
            $string = addslashes($string);
        }
    }
    return $string;
}

function redirect($loc) {
    if ($loc != NULL) {
        header("Location:{$loc}");
        exit;
    }
}
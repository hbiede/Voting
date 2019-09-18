<?php

require_once("connection.php");

/*
 * Login Checkers
 */

function loggedInSuperAdmin() {
    return isset($_SESSION['superAdmin']);
}

function loggedInAdmin() {
    return isset($_SESSION['admin']) || isset($_SESSION['orgID']);
}

function loggedInVoter() {
    return isset($_SESSION['voterID']);
}


function loggedIn() {
    return loggedInSuperAdmin() || loggedInAdmin() || loggedInVoter();
}

function confirmLoggedInSuperAdmin() {
    if (!loggedInSuperAdmin() && !loggedIn()) {
        redirect("login.php");
    } elseif (loggedInAdmin()) {
        redirect("admin_dashboard.php");
    } elseif (loggedInVoter()) {
        redirect('voting.php');
    }
}

function confirmLoggedInAdmin() {
    if (!loggedInAdmin() && !loggedIn()) {
        redirect("login.php");
    } elseif (loggedInSuperAdmin()) {
        redirect("organization_picker.php");
    } elseif (loggedInVoter()) {
        redirect('voting.php');
    }
}

function confirmLoggedInVoter() {
    if (!loggedInVoter()) {
        redirect("login.php");
    }
}

function confirmLoggedIn() {
    if (!loggedIn()) {
        redirect("login.php");
    }
}


/*
 * Election-specific SQL functions
 */
function confirmCredentialsVoter($voterID, $password) {
    global $connection;

    // entered a password
    if (!empty($voterID) && !empty($password)) {
        $query = "SELECT voterID,password FROM users WHERE voterID='{$voterID}'";

        // SQL error prevention
        if ($executeQuery = mysqli_query($connection, $query)) {

            // only one such voterID
            if ((mysqli_num_rows($executeQuery) == 1)) {
                while ($row = mysqli_fetch_assoc($executeQuery)) {
                    $dbPassword = $row['password'];

                    // password match detection
                    if ($password == $dbPassword) {
                        $_SESSION['voterID'] = $row['voterID'];
                        redirect("voting.php");
                    } else {
                        $_SESSION['error'] = "Enter correct username and password";
                        redirect("login.php");
                    }
                }
            } else {
                $_SESSION['error'] = "Enter correct username and password";
                redirect("login.php");
            }
        }
    } else {
        $_SESSION['error'] = "Fill all fields";
        redirect("login.php");
    }
}

function confirmCredentialsAdmin($username, $password) {
    global $connection;

    // entered a password
    if (!empty($username) && !empty($password)) {
        $query = "SELECT username,password,isSuperAdmin FROM admins WHERE username='{$username}'";

        // SQL error prevention
        if ($executeQuery = mysqli_query($connection, $query)) {

            // only one such voterID
            if ((mysqli_num_rows($executeQuery) == 1)) {
                while ($row = mysqli_fetch_assoc($executeQuery)) {
                    $dbPassword = $row['password'];

                    // password match detection
                    if ($password == $dbPassword) {
                        $_SESSION['username'] = $row['username'];
                        if ($row['isSuperAdmin'] == 0) {
                            $_SESSION['admin'] = $username;
                            redirect("admin_dashboard.php");
                        } else {
                            $_SESSION['superAdmin'] = $username;
                            redirect("superadmin_dashboard.php");
                        }
                    } else {
                        $_SESSION['error'] = "Enter correct username and password";
                        redirect("login.php");
                    }
                }
            } else {
                $_SESSION['error'] = "Enter correct username and password";
                redirect("login.php");
            }
        }
    } else {
        $_SESSION['error'] = "Fill all fields";
        redirect("login.php");
    }
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
<?php
require('railiac_connector.php');
$con = new railiac_connector();


/**
 * Working example - Login
 * If using previous user, it will work.
 * If user does not exists, throws an exception.
 */
$loginUser = null; // just to globalize it
/**
 * Working example - Register user.
 * If email is already registered, throws an exception.
 */
try {
    $registerUser = $con->register("user5@gmail.com", "1234", "Andrei", "García Cuadra", "mycode");
    var_dump($registerUser);

    /**
     * Working example - validateUser
     * Validates user so it can login
     *
     * NOTE: YOU MUST PASS THE SAME $loginUser THAT YOU'VE GOT ON $con->login...
     * If not set properly, you will get an exception "UNAUTHORIZED"
     */
    try {
        $emailCode = 'nVZ0YIZ'; //note: this should be read from
        $validatedUser = $con->validateUser($emailCode);
        var_dump($validatedUser);
    } catch(Exception $e) {
        print("Error detected: ");
        print($e);
        echo '-------------------------------------------------------';
    }
} catch(Exception $e) {
    /**
     * Working example - Login user.
     * If email is already registered, we connect him.
     */
    try {
        $loginUser = $con->login("user5@gmail.com", "1234", false);
        var_dump($loginUser);
    } catch(Exception $e) {
        print("Error detected: ");
        print($e);
    }
}



/**
 * Working example - GetTicketById
 * If ticket does not exists, it will throw an exception.
 *
 * NOTE: YOU MUST PASS THE SAME $loginUser THAT YOU'VE GOT ON $con->login...
 * If not set properly, you will get an exception "UNAUTHORIZED"
 */
try {
    $ticket = $con->getTicketById(1, $loginUser);
    var_dump($ticket);
} catch(Exception $e) {
    print("Error detected: ");
    print($e);
}



/**
 * Working example - GetUserByRefCode (referrercode)
 * If user does not exists, it will throw an exception.
 *
 * NOTE: YOU MUST PASS THE SAME $loginUser THAT YOU'VE GOT ON $con->login...
 * If not set properly, you will get an exception "UNAUTHORIZED"
 */
try {
    $userByRefCode = $con->getUserByRefCode("mycode", $loginUser);
    var_dump($userByRefCode);
} catch(Exception $e) {
    print("Error detected: ");
    print($e);
}

echo '-------------------------------------------------';
/**
 * Working example - addPointsToUser (referrercode)
 * If user does not exists, it will throw an exception.
 *
 * NOTE: YOU MUST PASS THE SAME $loginUser THAT YOU'VE GOT ON $con->login...
 * If not set properly, you will get an exception "UNAUTHORIZED"
 */
try {
    $userPointTransactions = $con->addPointsToUser(50, $userId, $loginUser);
    var_dump($userPointTransactions);
} catch(Exception $e) {
    print("Error detected: ");
    print($e);
}

/**
 * Working example - getUserPointTransactions (point transactions)
 * If user does not exists, it will throw an exception.
 *
 * NOTE: YOU MUST PASS THE SAME $loginUser THAT YOU'VE GOT ON $con->login...
 * If not set properly, you will get an exception "UNAUTHORIZED"
 */
try {
    $userPointTransactions = $con->getUserPointTransactions($loginUser);
    var_dump($userPointTransactions);
} catch(Exception $e) {
    print("Error detected: ");
    print($e);
}

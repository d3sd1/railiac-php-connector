<?php


class railiac_connector
{
    /*
     * If below attribute is true,
     * set it to false inmediatelly.
     */
    public $url = "https://api.railiac.com"; //
    //public $url = "http://localhost:8080"; //

    public function register($email, $password, $firstname, $surname, $referrercode)
    {
        $ch = curl_init($this->url . "/session/register");
        $payload = json_encode(array(
            "email" => $email,
            "pass" => $password,
            "firstname" => $firstname,
            "surname" => $surname,
            "referrercode" => $referrercode,
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status != 200) {
            throw new Exception($result);
        }
        curl_close($ch);
        return json_decode($result);
    }

    public function login($email, $password, $rememberMe)
    {
        $ch = curl_init($this->url . "/session/login");
        $payload = json_encode(array(
            "email" => $email,
            "password" => $password,
            "rememberMe" => $rememberMe
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status == 400) {
            throw new Exception("Invalid login.");
        }
        if ($http_status != 200) {
            throw new Exception($result);
        }
        curl_close($ch);
        return json_decode($result);
    }

    public function getTicketById($ticketId, $loginUser)
    {
        $ch = curl_init($this->url . "/tickets/fetch/$ticketId");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: ' . $loginUser->jwt));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status == 401) {
            throw new Exception("UNAUTHORIZED");
        }
        if ($http_status != 200) {
            throw new Exception($result);
        }
        curl_close($ch);
        return json_decode($result);
    }

    public function getUserByRefCode($refCode, $loginUser)
    {
        $ch = curl_init($this->url . "/users/fetch/ref_code?ref_code=$refCode");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: ' . $loginUser->jwt));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status == 401) {
            throw new Exception("UNAUTHORIZED");
        }
        if ($http_status != 200) {
            throw new Exception($result);
        }
        curl_close($ch);
        return json_decode($result);
    }
    public function getUserPointTransactions($loginUser)
    {
        $ch = curl_init($this->url . "/point/transactions");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: ' . $loginUser->jwt));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status == 401) {
            throw new Exception("UNAUTHORIZED");
        }
        if ($http_status != 200) {
            throw new Exception($result);
        }
        curl_close($ch);
        return json_decode($result);
    }

    public function addPointsToUser($amount, $userId, $description, $loginUser)
    {
        $ch = curl_init($this->url . "/point/add_points?amount=$amount&user_id=$userId&description=$description");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, null);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: ' . $loginUser->jwt));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status != 200) {
            var_dump($http_status);
            throw new Exception($result);
        }
        curl_close($ch);
        return json_decode($result);
    }

    public function validateUser($emailCode)
    {
        $ch = curl_init($this->url . "/session/validate?confirm_code=$emailCode");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, null);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status == 401) {
            throw new Exception("UNAUTHORIZED");
        }
        if ($http_status != 200) {
            var_dump($http_status);
            throw new Exception($result);
        }
        curl_close($ch);
        return json_decode($result);
    }

    public function storeUser($loginUser)
    {
        setcookie('login_user', json_encode($loginUser), time() + (86400 * 30), "/");
    }

    public function getStoredUser()
    {
        if (!isset($_COOKIE['login_user'])) {
            throw new Exception("User is not logged in");
        } else {
            return json_decode($_COOKIE['login_user']);
        }
    }
}
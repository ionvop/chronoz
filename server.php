<?php

include("common.php");
debug();

if (isset($_POST["method"])) {
    switch ($_POST["method"]) {
        case "login":
            login();
            break;
        default:
            defaultMethod();
            break;
    }
} else {
    defaultMethod();
}

function login() {
    global $BREVO_API_KEY;
    $code = substr(md5(time()), 0, 5);
    session_start();
    $_SESSION["code"] = $code;

    $headers = [
        "Content-Type: application/json",
        "Accept: application/json",
        "Api-Key: {$BREVO_API_KEY}"
    ];

    $body = [
        "sender" => [
            "name" => "ChronoZ",
            "email" => "ionvop@gmail.com"
        ],
        "to" => [
            [
                "email" => $_POST["email"]
            ]
        ],
        "textContent" => "Your login code is: {$code}\n\nIf you did not request this code, please ignore this email.",
        "subject" => "ChronoZ login code"
    ];

    $res = sendCurl("https://api.brevo.com/v3/smtp/email", "POST", $headers, json_encode($body));
    $res = json_decode($res);

    if ($res == false) {
        alert("Failed to send email");
    }

    header("Location: login/verify/");
}

function verify() {
    $db = new SQLite3("database.db");

    session_start();

    if (isset($_SESSION["code"]) == false) {
        http_response_code(401);

        echo json_encode([
            "error" => "Invalid code"
        ]);

        return;
    }

    $code = $_SESSION["code"];
    session_unset();
    session_destroy();

    if ($_POST["code"] != $code) {
        http_response_code(401);

        echo json_encode([
            "error" => "Invalid code"
        ]);

        return;
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_POST["email"]);
    $result = $stmt->execute();

    if ($result == false) {
        http_response_code(500);

        echo json_encode([
            "error" => "Failed to get user"
        ]);

        return;
    }

    $user = $result->fetchArray();
    $session = uniqid("session");

    if ($user == false) {
        if (strlen($_POST["username"]) > 0) {
            if (strlen($_POST["username"]) < 4) {
                http_response_code(400);
        
                echo json_encode([
                    "error" => "Username is too short. Min length is 4"
                ]);
        
                return;
            }

            if (strlen($_POST["username"]) > 20) {
                http_response_code(400);
        
                echo json_encode([
                    "error" => "Username is too long. Max length is 20"
                ]);
        
                return;
            }

            if (preg_match("/[^a-zA-Z0-9-_]/", $_POST["username"])) {
                http_response_code(400);
        
                echo json_encode([
                    "error" => "Username can only contain alphanumeric characters, hyphens, and underscores"
                ]);
        
                return;
            }
    
            $query = <<<SQL
                INSERT INTO `users` (`email`, `username`, `session`) VALUES (:email, :username, :session)
            SQL;
    
            $stmt = $db->prepare($query);
            $stmt->bindValue(":email", $_POST["email"]);
            $stmt->bindValue(":username", $_POST["username"]);
            $stmt->bindValue(":session", uniqid("session"));
            $result = $stmt->execute();
    
            if ($result == false) {
                http_response_code(400);
    
                echo json_encode([
                    "error" => "Failed to create user. Maybe the username is already taken?"
                ]);
    
                return;
            }
    
            setcookie("session", uniqid("session"), time() + 86400 * 30);
            http_response_code(200);
            return;
        }

        http_response_code(404);

        echo json_encode([
            "error" => "Unregistered email"
        ]);

        return;
    }

    $query = <<<SQL
        UPDATE `users` SET `session` = :session WHERE `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_POST["email"]);
    $stmt->bindValue(":session", $session);
    $result = $stmt->execute();

    if ($result == false) {
        http_response_code(500);

        echo json_encode([
            "error" => "Failed to update user"
        ]);

        return;
    }

    setcookie("session", $session, time() + 86400 * 30);
    http_response_code(200);
    return;
}

function defaultMethod() {
    http_response_code(400);

    echo json_encode([
        "error" => "Invalid method"
    ]);
}
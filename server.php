<?php

include("common.php");
Debug();

if (isset($_POST["method"])) {
    switch ($_POST["method"]) {
        case "login":
            Login();
            break;
        case "verify":
            Verify();
            break;
        case "register":
            Register();
            break;
        case "logout":
            Logout();
            break;
        default:
            DefaultMethod();
            break;
    }
} else {
    DefaultMethod();
}

function Login() {
    global $BREVO_API_KEY;

    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
        Alert("Invalid email");
    }

    $code = substr(md5(time()), 0, 5);
    session_start();
    $_SESSION["code"] = $code;
    $_SESSION["email"] = $_POST["email"];

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

    echo <<<HTML
        {$code}<br><br>
        <a href="login/verify/">
            <button>
                Verify
            </button>
        </a>
    HTML;

    exit();

    $res = SendCurl("https://api.brevo.com/v3/smtp/email", "POST", $headers, json_encode($body));
    $res = json_decode($res);

    if ($res == false) {
        Alert("Failed to send email");
    }

    header("Location: login/verify/");
    exit();
}

function Verify() {
    $db = new SQLite3("database.db");
    session_start();

    if ($_POST["code"] != $_SESSION["code"]) {
        Alert("Invalid code");
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_SESSION["email"]);
    $result = $stmt->execute();
    $user = $result->fetchArray();

    if ($user == false) {
        header("Location: register/");
        exit();
    }

    $session = uniqid("session");

    $query = <<<SQL
        UPDATE `users` SET `session` = :session WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":session", $session);
    $stmt->bindValue(":id", $user["id"]);
    $stmt->execute();
    setcookie("session", $session, time() + (86400 * 30));
    header("Location: ./");
    exit();
}

function Register() {
    $db = new SQLite3("database.db");

    if (strlen($_POST["username"]) < 4) {
        Alert("Username must be at least 4 characters long");
    }

    if (strlen($_POST["password"]) > 20) {
        Alert("Password must be at most 20 characters long");
    }

    if (preg_match("/[^a-zA-Z0-9-_]/", $_POST["username"])) {
        Alert("Username can only contain alphanumerics, hyphens, and underscores");
    }

    session_start();

    $query = <<<SQL
        SELECT * FROM `users` WHERE `username` = :username OR `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $_POST["username"]);
    $stmt->bindValue(":email", $_SESSION["email"]);
    $result = $stmt->execute();
    $user = $result->fetchArray();

    if ($user != false) {
        Alert("Username or email already exists");
    }

    $session = uniqid("session");

    $query = <<<SQL
        INSERT INTO `users` (`username`, `email`, `session`)
        VALUES (:username, :email, :session)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $_POST["username"]);
    $stmt->bindValue(":email", $_SESSION["email"]);
    $stmt->bindValue(":session", $session);
    $stmt->execute();
    setcookie("session", $session, time() + (86400 * 30));
    header("Location: ./");
    exit();
}

function Logout() {
    $db = new SQLite3("database.db");
    $user = GetUser();

    if ($user == false) {
        setcookie("session", "", time() - 3600);
        header("Location: ./");
    }

    $query = <<<SQL
        UPDATE `users` SET `session` = NULL WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $user["id"]);
    $stmt->execute();
    setcookie("session", "", time() - 3600);
    header("Location: ./");
    exit();
}

function DefaultMethod() {
    Breakpoint([
        "post" => $_POST,
        "files" => $_FILES
    ]);
}
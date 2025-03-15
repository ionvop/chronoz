<?php

chdir("../");
include("common.php");
include("lib/Parsedown.php");
Debug();
$user = GetUser();

if (isset($_GET["id"]) == false) {
    Alert("User not found");
}

$target = GetTarget($_GET["id"]);

if ($target == false) {
    Alert("User not found");
}

$Parsedown = new Parsedown();

?>

<html>
    <head>
        <title>
            <?=$target["username"]?> | ChronoZ
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .user {
                display: grid;
                grid-template-columns: max-content 1fr;
                border-bottom: 0.1rem solid #fff;
            }

            .user__avatar {
                padding: 1rem;
            }

            .user__avatar > img {
                width: 5rem;
                height: 5rem;
                border-radius: 1rem;
            }

            .user__username {
                display: grid;
                grid-template-rows: 1fr max-content;
            }

            .user__username__text {
                padding: 1rem;
            }

            .user__actions__edit {
                padding: 1rem;
            }

            .user__actions__edit > svg {
                width: 2rem;
                height: 2rem;
            }

            .panels {
                display: grid;
                grid-template-columns: 20rem 1fr;
            }

            .panels__user__details {
                display: grid;
                grid-template-columns: 1fr minmax(0, max-content) 1fr;
                overflow: hidden;
            }

            .panels__user__details__text {
                padding: 1rem;
                line-height: 2rem;
            }

            .panels__user__edit {
                padding: 1rem;
            }

            .panels__user__edit > svg {
                width: 2rem;
                height: 2rem;
            }

            .panels__user__actions {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }

            .panels__user__action {
                padding: 1rem;
            }

            .panels__user__action > svg {
                width: 2rem;
                height: 2rem;
            }

            .panels__user__actions__follow {
                cursor: pointer;
            }

            .panels__description {
                padding: 1rem;
                border-left: 0.1rem solid #555;
            }

            .panels__description img {
                max-width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="main__user">
            <?=SetHeader()?>
            <div class="content">
                <div class="user">
                    <div class="user__avatar">
                        <img src="uploads/avatars/<?=$target["avatar"]?>">
                    </div>
                    <div class="user__username">
                        <div></div>
                        <div class="user__username__text -title">
                            <?=$target["username"]?>
                        </div>
                    </div>
                </div>
                <div class="panels">
                    <div class="panels__user">
                        <div class="panels__user__details">
                            <div></div>
                            <div class="panels__user__details__text">
                                Last seen: <?=TimeAgo($target["last_seen"])?><br>
                                Followers: <br>
                                Following:
                            </div>
                            <div></div>
                        </div>
                        <?php
                            $personAddIcon = Icon("person_add");
                            $flagIcon = Icon("flag");
                            $settingsIcon = Icon("settings");

                            if ($user != false) {
                                if ($target["id"] == $user["id"]) {
                                    echo <<<HTML
                                        <a href="user/edit/" class="-a panels__user__edit -center">
                                            {$settingsIcon}
                                        </a>
                                    HTML;
                                } else {
                                    echo <<<HTML
                                        <div class="panels__user__actions">
                                            <form action="server.php" class="-form panels__user__actions__follow panels__user__action -center" method="post" enctype="multipart/form-data" onclick="this.submit()">
                                                {$personAddIcon}
                                                <input type="hidden" name="username" value="{$target['username']}">
                                                <input type="hidden" name="method" value="follow">
                                            </form>
                                            <a href="user/report/?id={$target['username']}" class="-a panels__user__actions__report panels__user__action -center">
                                                {$flagIcon}
                                            </a>
                                        </div>
                                    HTML;
                                }
                            }
                        ?>
                    </div>
                    <div class="panels__description">
                        <?=$Parsedown->text($target["description"])?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
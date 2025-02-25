<?php

chdir("../");
include("common.php");
Debug();
$user = GetUser();

if (isset($_GET["id"]) == false) {
    Alert("User not found");
}

$target = GetTarget($_GET["id"]);

if ($target == false) {
    Alert("User not found");
}

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
                grid-template-columns: max-content 1fr max-content;
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
                    <div class="user__actions">
                        <a class="-a user__actions__edit" href="user/edit/">
                            <?=Icon("settings")?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
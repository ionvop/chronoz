<?php

chdir("../");
include("common.php");
Debug();

?>

<html>
    <head>
        <title>
            Register | ChronoZ
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .content {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
            }

            .form__title {
                padding: 1rem;
            }

            .form__info {
                padding: 1rem;
            }

            .form__username {
                display: grid;
                grid-template-columns: max-content 1fr;
            }

            .form__username__icon {
                padding: 1rem;
            }

            .form__username__icon > svg {
                width: 2rem;
                height: 2rem;
            }

            .form__username__input {
                padding: 1rem;
                padding-left: 0rem;
            }

            .form__submit {
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="main__register">
            <?=SetHeader()?>
            <div class="content">
                <div></div>
                <form class="-form form" action="server.php" method="post" enctype="multipart/form-data">
                    <div class="form__title -title -center">
                        Register Email
                    </div>
                    <div class="form__info -center">
                        Your email hasn't been registered yet. Please enter your username.
                    </div>
                    <div class="form__username">
                        <div class="form__username__icon -center__flex">
                            <?=icon("person")?>
                        </div>
                        <div class="form__username__input -center__flex">
                            <input class="-input" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="form__submit -center">
                        <button class="-button" name="method" value="register">
                            Submit
                        </button>
                    </div>
                </form>
                <div></div>
            </div>
        </div>
    </body>
</html>
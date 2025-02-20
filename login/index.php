<?php

chdir("../");
include("common.php");
debug();

?>

<html>
    <head>
        <title>

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

            .form__email {
                display: grid;
                grid-template-columns: max-content 1fr;
            }

            .form__email__icon {
                padding: 1rem;
            }

            .form__email__icon > svg {
                width: 2rem;
                height: 2rem;
            }

            .form__email__input {
                padding: 1rem;
                padding-left: 0rem;
            }

            .form__submit {
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="login__main">
            <?=setHeader()?>
            <div class="content">
                <div></div>
                <form class="-form form" action="server.php" method="post" enctype="multipart/form-data">
                    <div class="form__title -title -center">
                        Login / Register
                    </div>
                    <div class="form__info -center">
                        A code will be sent to your email in order to verify your account. Passwords are not required.
                    </div>
                    <div class="form__email">
                        <div class="form__email__icon -center__flex">
                            <?=icon("mail")?>
                        </div>
                        <div class="form__email__input -center__flex">
                            <input type="email" class="-input" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form__submit -center">
                        <button class="-button" name="method" value="login">
                            Submit
                        </button>
                    </div>
                </form>
                <div></div>
            </div>
        </div>
    </body>
    <script src="script.js"></script>
    <script>
        
    </script>
</html>
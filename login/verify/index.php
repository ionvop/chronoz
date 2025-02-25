<?php

chdir("../../");
include("common.php");
Debug();

?>

<html>
    <head>
        <title>
            Verify | ChronoZ
        </title>
        <base href="../../">
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

            .form__code {
                display: grid;
                grid-template-columns: max-content 1fr;
            }

            .form__code__icon {
                padding: 1rem;
            }

            .form__code__icon > svg {
                width: 2rem;
                height: 2rem;
            }

            .form__code__input {
                padding: 1rem;
                padding-left: 0rem;
            }

            .form__submit {
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="main__login__verify">
            <?=SetHeader()?>
            <div class="content">
                <div></div>
                <form class="-form form" action="server.php" method="post" enctype="multipart/form-data">
                    <div class="form__title -title -center">
                        Verify Email
                    </div>
                    <div class="form__info -center">
                        Enter the code that was sent to your email in order to verify your account.
                    </div>
                    <div class="form__code">
                        <div class="form__code__icon -center__flex">
                            <?=Icon("key")?>
                        </div>
                        <div class="form__code__input -center__flex">
                            <input class="-input" name="code" placeholder="Code">
                        </div>
                    </div>
                    <div class="form__submit -center">
                        <button class="-button" name="method" value="verify">
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
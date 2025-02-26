<?php

chdir("../../");
include("common.php");
Debug();
$user = GetUser();

if ($user == false) {
    Alert("Unauthorized");
}

?>

<html>
    <head>
        <title>
            Edit | ChronoZ
        </title>
        <base href="../../">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .content {
                display: grid;
                grid-template-columns: 1fr 2fr 1fr;
            }

            .form__title {
                padding: 1rem;
            }

            .form__info {
                display: grid;
                grid-template-columns: 1fr max-content;
            }

            .form__info__username__label {
                padding: 1rem;
            }

            .form__info__username__input {
                display: grid;
                grid-template-columns: max-content 1fr;
            }

            .form__info__username__input__icon {
                padding: 1rem;
            }

            .form__info__username__input__icon > svg {
                width: 2rem;
                height: 2rem;
            }

            .form__info__username__input__field {
                padding: 1rem;
                padding-left: 0rem;
            }

            .form__info__avatar__preview {
                padding: 1rem;
            }

            .form__info__avatar__preview > img {
                width: 10rem;
                height: 10rem;
                object-fit: cover;
            }

            .form__info__avatar__input {
                padding: 1rem;
            }

            .form__description__label {
                padding: 1rem;
            }

            .form__description__input {
                padding: 1rem;
            }

            .form__description__input > textarea {
                height: 30rem;
            }

            .form__submit {
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="main__user__edit">
            <?=SetHeader()?>
            <div class="content">
                <div></div>
                <form action="server.php" class="-form form" method="post" enctype="multipart/form-data">
                    <div class="form__title -title -center">
                        Edit Profile
                    </div>
                    <div class="form__info">
                        <div class="form__info__username">
                            <div class="form__info__username__label">
                                Username
                            </div>
                            <div class="form__info__username__input">
                                <div class="form__info__username__input__icon -center__flex">
                                    <?=Icon("person")?>
                                </div>
                                <div class="form__info__username__input__field">
                                    <input class="-input" name="username" value="<?=$user["username"]?>" placeholder="Username">
                                </div>
                            </div>
                        </div>
                        <div class="form__info__avatar">
                            <div class="form__info__avatar__preview">
                                <img src="uploads/avatars/<?=$user["avatar"]?>" id="preview">
                            </div>
                            <div class="form__info__avatar__input">
                                <input type="file" name="avatar" id="avatar" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="form__description">
                        <div class="form__description__label">
                            Description
                        </div>
                        <div class="form__description__input">
                            <textarea name="description" class="-textarea"><?=$user["description"]?></textarea>
                        </div>
                    </div>
                    <div class="form__submit -center">
                        <button class="-button" name="method" value="editProfile">
                            Save
                        </button>
                    </div>
                </form>
                <div></div>
            </div>
        </div>
    </body>
    <script src="script.js"></script>
    <script>
        let preview = document.getElementById("preview");
        let avatar = document.getElementById("avatar");

        avatar.addEventListener("change", () => {
            preview.src = URL.createObjectURL(avatar.files[0]);
        })
    </script>
</html>
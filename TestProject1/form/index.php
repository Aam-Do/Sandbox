<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/108cacb930.js" crossorigin="anonymous"></script>
    <script src="Script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Style/Style.css">
    <title>Ivy_Arts Commissions</title>
</head>

<body>

    <?php
    // define variables and set to empty values
    $contactErr = "";
    $type = $contact = $render = $style = $lineart = $size = $description = $contactMedia = $refImages = "";

    $success = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $type = test_input($_POST["type"]);
        $contactMedia = test_input($_POST["contactMedia"]);

        if (empty($_POST["contact"])) {
            $success = false;
            $contactErr = "<div class='alert alert-warning'>Please provide an adress or a username!</div>";
        } else {
            $contact = test_input($_POST["contact"]);
            if ($contactMedia == "email" && !filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                $success = false;
                $contactErr = "<div class='alert alert-warning'>Invalid email format (example@gmail.com)</div>";
            } else if ($contactMedia == "discord" && (!preg_match('/[A-Za-z]/', $contact) || !preg_match('/#[0-9]{4}/', $contact))) {
                $success = false;
                $contactErr = "<div class='alert alert-warning'>Invalid discord username (example#1234)</div>";
            } else if ($contactMedia == "instagram" && $contact[0] != "@") {
                $success = false;
                $contactErr = "<div class='alert alert-warning'>Invalid instagram username (@example)</div>";
            }
        }

        $render = test_input($_POST["render"]);
        $style = test_input($_POST["style"]);
        $lineart = test_input($_POST["lineart"]);
        $size = test_input($_POST["size"]);
        $description = test_input($_POST["description"]);
        $refImages = test_input($_POST["refImages"]);
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    ?>

    <div class="p-3 p-lg-5 text-center bg-primary text-white">
        <h1 class="display-1">Ivy_Arts03</h1>
        <h3 class="display-6">Digital Artist</h1>
    </div>
    <nav class="navbar sticky-top navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="Home.html">
                <img src="Style/Music.png" alt="Ivy Logo" class="rounded-circle img-fluid" style="width: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Commission</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Gallery.html">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="AboutMe.html">About Me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Contact.html">Contact</a>
                    </li>
                </ul>
                <div class="d-flex nav-item">
                    <a class="ps-0 ps-sm-3 navbar-text nav-link" target="_blank" href="https://www.instagram.com/ivy_arts03/?hl=de"><i class="fa-brands fa-instagram"></i></a>
                    <a class="ps-0 ps-sm-3 navbar-text nav-link" target="blank" href="https://aam_do03.artstation.com/"><i class="fa-brands fa-artstation"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-5">

        <?php
        $servername = "db000914.mydbserver.com";
        $username = "p612646";
        $password = "b58tQDVQu7KV9Md!";
        $dbname = "usr_p612646_1";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($success == true && $_SERVER["REQUEST_METHOD"] == "POST") {
            $sql = "SELECT Contact FROM Commissions WHERE Contact='$contactMedia: $contact'&& Type='$type' && Render='$render' && Style='$style' && Lineart='$lineart' && Size='$size' && Description='$description'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $success = false;
                $error = true;
            } else {
                $error = false;
                $sql = "INSERT INTO Commissions (Contact, Type, Render, Style, Lineart, Size, Description)
                VALUES ('$contactMedia: $contact', '$type', '$render', '$style', '$lineart', '$size', '$description')";

                if ($conn->query($sql) === TRUE) {
                    $success = true;
                    // sendMail();

                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
        ?>

        <?php
        if ($success == true && $_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<div class='alert alert-success'><b>Commission placed successfully!</b> I'll get back to you via your provided contact in a few days!</div>";
        } else if ($_SERVER["REQUEST_METHOD"] == "POST" && !$error) {
            echo "<div class='alert alert-danger'><b>Something went wrong!</b> Please check your <a href='#imageUploads' class='alert-link'>image uploads</a> or your <a href='#contact' class='alert-link'>contact info</a> again</div>";
        } else if ($error) {
            echo "<div class='alert alert-danger'><b>Commission has already been submitted.</b> If you think this is an error, please <a target='_blank' class='alert-link' href='https://www.instagram.com/ivy_arts03/?hl=de'>contact me</a>.</div>";
        }
        ?>
        <h1>Commission</h1>
        <p>Turn your ideas into digital drawings by me, Ivy! May it be a gift for someone, an avatar for Twitch, custom
            Discord emotes or a 4k desktop wallpaper, I draw every artwork with lots of love and attention to detail!</p>
        <h2 class="mt-5">Choose your option</h2>

        <form class="mt-4 d-grid" id="commissionForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mt-4">Type</h4>
                    <p>What kind of drawing it should be. Price is calculated by human character. Prices for non-human
                        characters can vary. Note that some types also influence render style and image size!</p>
                    <div class="form-floating mt-3">
                        <select class="form-select" id="type" name="type">
                            <option value="emote" price="5" <?php if (isset($type) && $type == "emote" && !$success) echo "selected"; ?>>Emote</option>
                            <option value="portrait" price="10" <?php if (isset($type) && $type == "portrait" && !$success) echo "selected"; ?>>Portrait</option>
                            <option value="full body" price="13" <?php if (isset($type) && $type == "full body" && !$success) echo "selected"; ?>>Full Body</option>
                            <option value="character sheet" price="15" <?php if (isset($type) && $type == "character sheet" && !$success) echo "selected"; ?>>Character Sheet</option>
                            <option value="scene" price="20" <?php if (isset($type) && $type == "scene" && !$success) echo "selected"; ?>>Scene</option>
                        </select>
                        <label for="type" class="form-label">Select type:</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4 class="mt-4">Render Style</h4>
                    <p>Defines if the image should be a sketch, flat colors or fully rendered. Note that some render
                        styles are not available for certain types.</p>
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="render" name="render">
                            <option value="sketch" price="0.8" <?php if (isset($render) && $render == "sketch" && !$success) echo "selected"; ?>>Sketch</option>
                            <option value="lineart" price="1" <?php if (isset($render) && $render == "lineart" && !$success) echo "selected"; ?>>Lineart</option>
                            <option value="flat" price="1.3" <?php if (isset($render) && $render == "flat" && !$success) echo "selected"; ?>>Flat Colors</option>
                            <option value="rendered" price="1.5" <?php if (isset($render) && $render == "rendered" && !$success) echo "selected"; ?>>Rendered Character (only available for one pose in
                                Character Sheet</option>
                            <option value="full" price="2" <?php if (isset($render) && $render == "full" && !$success) echo "selected"; ?>>Full render (incl. background, not available for Emotes)
                            </option>
                        </select>
                        <label for="render" class="form-label">Select render style:</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mt-4">Artstyle</h4>
                    <p>I draw in various artstyles. For references on the differences of the styles, check out my
                        Gallery!</p>
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="style" name="style">
                            <option value="chibi" price="1.2" <?php if (isset($style) && $style == "chibi" && !$success) echo "selected"; ?>>Chibi</option>
                            <option value="stylized" price="1.4" <?php if (isset($style) && $style == "stylized" && !$success) echo "selected"; ?>>Stylized</option>
                            <option value="semi realistic" price="1.6" <?php if (isset($style) && $style == "semi realistic" && !$success) echo "selected"; ?>>Semi-Realistic</option>
                        </select>
                        <label for="style" class="form-label">Select artstyle:</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4 class="mt-4">Lineart Style</h4>
                    <p>Choose what kind of lineart style you want. Sketches will not have lineart. Sketched Lineart
                        features
                        loose sketched lines while Clean Lineart is smooth and clean.</p>
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="lineart" name="lineart">
                            <option value="none - sketch" price="1" <?php if (isset($lineart) && $lineart == "none - sketch" && !$success) echo "selected"; ?>>- Sketch -</option>
                            <option value="sketched" price="1.4" <?php if (isset($lineart) && $lineart == "sketched" && !$success) echo "selected"; ?>>Sketched Lineart</option>
                            <option value="clean" price="1.6" <?php if (isset($lineart) && $lineart == "clean" && !$success) echo "selected"; ?>>Clean Lineart</option>
                            <option value="none - painting" price="2" <?php if (isset($lineart) && $lineart == "none - painting" && !$success) echo "selected"; ?>>Painting (No Lineart - only available for Rendered
                                Semi-Realistic)
                            </option>
                        </select>
                        <label for="lineart" class="form-label">Select lineart style:</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mt-4">Size</h4>
                    <p>Size of the drawing. Downsizing for free afterwards is possible, upsizing is NOT! Note that some
                        sizes are not available for certain Types. If your desired resolution is not listed, choose the
                        closest to it and remark the desired size in the description! (in px)</p>
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="size" name="size">
                            <option value="32x32" price="0.5" <?php if (isset($size) && $size == "32x32" && !$success) echo "selected"; ?>>32x32 (min Discord Emote)</option>
                            <option value="128x128" price="0.6" <?php if (isset($size) && $size == "128x128" && !$success) echo "selected"; ?>>128x128 (max Discord Emote)</option>
                            <option value="320x240" price="0.8" <?php if (isset($size) && $size == "320x240" && !$success) echo "selected"; ?>>320x240</option>
                            <option value="512x512" price="1" <?php if (isset($size) && $size == "512x512" && !$success) echo "selected"; ?>>512x512</option>
                            <option value="1024x1024" price="1.3" <?php if (isset($size) && $size == "1024x1024" && !$success) echo "selected"; ?>>1024x1024 (recommended min for portraits, character
                                sheets, scenes and full body)</option>
                            <option value="1280x720" price="1.3" <?php if (isset($size) && $size == "1280x720" && !$success) echo "selected"; ?>>1280x720</option>
                            <option value="1920x1080" price="1.5" <?php if (isset($size) && $size == "1920x1080" && !$success) echo "selected"; ?>>1920x1080 (average desktop)</option>
                            <option value="2048x2048" price="1.7" <?php if (isset($size) && $size == "2048x2048" && !$success) echo "selected"; ?>>2048x2048</option>
                            <option value="3840x2160" price="2" <?php if (isset($size) && $size == "3840x2160" && !$success) echo "selected"; ?>>3840x2160 (4k)</option>
                        </select>
                        <label for="size" class="form-label">Select size:</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4 class="mt-4">Estimated Price</h4>
                    <p class="mt-4">Estimated total: <span id="estimatedTotal"></span> €</p>
                    <p class="text-primary">This is an estimated number for rough reference. Actual price can vary
                        depending on complexity, extra wishes and additional afterwards changes.</p>
                </div>
            </div>
            <h4 class="mt-4">Description</h4>
            <p>Describe what you want. What kind of character, what kind of pose, background, clothing, emotion, etc...?
                You can also ask questions or request something that hasn't been listed yet</p>
            <div class="form-floating mb-3 was-validated">
                <textarea class="form-control" id="description" name="description" placeholder="description goes here" rows="10" style="height: 200px;" required><?php if (!$success) {
                                                                                                                                                                        echo $description;
                                                                                                                                                                    } ?></textarea>
                <label for="description">Description</label>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <!-- <h4 class="mt-4">Reference images</h4>
            <p>Attach one or multiple images as references for me. They can be photos, previous commissions or other
                artwork. You can also include color pallettes, moodboards, outfits or anything else you deem helpful.
                (supported formats: .jpg, .png)</p>
            <div>
                <input id="imageUploads" class="form-control mb-3" type="file" id="referenceImages" name="referenceImages" multiple />
            </div> -->
            <?php
            /* $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["referenceImages"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["referenceImages"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image. ";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists. ";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["referenceImages"]["size"] > 500000) {
                    echo "Sorry, your file is too large. ";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (
                    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"
                ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["referenceImages"]["tmp_name"], $target_file)) {
                        echo "The file " . htmlspecialchars(basename($_FILES["referenceImages"]["name"])) . " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            } */
            ?>

            <h4 class="mt-4">Contact</h4>
            <p>After submitting your commission it will take about two-three days for me to review it. Your contact
                information is needed so I can ask questions and update you on the drawing process. The finished product
                will also be sent through the chosen method.</p>
            <div class="input-group mt-3 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="contactMedia" name="contactMedia" required>
                        <option value="email" <?php if (isset($contactMedia) && $contactMedia == "email" && !$success) echo "selected"; ?>>Email</option>
                        <option value="discord" <?php if (isset($contactMedia) && $contactMedia == "discord" && !$success) echo "selected"; ?>>Discord</option>
                        <option value="instagram" <?php if (isset($contactMedia) && $contactMedia == "instagram" && !$success) echo "selected"; ?>>Instagram</option>
                    </select>
                    <label for="contactMedia" class="form-label">Select media:</label>
                </div>
                <div class="form-floating was-validated" style="width: 88%;">
                    <input type="text" class="form-control" name="contact" placeholder="Contact" id="contact" required value="<?php if (!$success) {
                                                                                                                                    echo $contact;
                                                                                                                                } ?>">
                    <label for="contact" class="form-label">Adress or Username</label>
                    <?php echo $contactErr ?>
                    <div class="invalid-feedback">Please provide your contact information.</div>
                </div>
            </div>
            <div class="form-check mt-4 mb-3 was-validated">
                <input class="form-check-input" type="checkbox" id="termsCheck" name="agreed" value="agreed" required>
                <label class="form-check-label" for="termsCheck">I agree to the <a href="#">terms and conditions</a></label>
                <div class="invalid-feedback">In order to proceed, you need to accept the terms and conditions.</div>
            </div>
            <button type="button" class="btn btn-primary mb-5 mt-4" data-bs-toggle="modal" data-bs-target="#orderReview" disabled id="modalButton">Submit Commission</button>
            <div class="modal fade modal-dialog-scrollable" id="orderReview">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm your Commission</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>This is where the order with all details will be shown, so the person who wants to purchase a
                                commission can review and check everything.</p>
                            <p>If they want to go back they can click the button to the top right</p>
                            <p>If they're satisfied they can press the funny button on the bottom</p>
                            <p>That will close the modal and send the commission to me via Email</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="submit" name="submit" value="Submit" id="submit">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="mt-5 p-4 bg-dark text-white text-center">
        <div class="d-flex flex-column-reverse flex-lg-row justify-content-md-between">
            <p class="ms-lg-5 ms-2" style="display: inline;">©2022 Ivy_Arts03 – All Rights Reserved</p>
            <div class="text-lg-end mb-3 mb-lg-0">
                <a class="footer-link ms-2" style="display: inline;" href="Home.html">Home</a>
                <a class="footer-link ms-lg-5 ms-2" style="display: inline;" href="#">Privacy Policy</a>
                <a class="footer-link ms-lg-5 ms-2" style="display: inline;" href="#">Disclaimers</a>
                <a class="footer-link mx-lg-5 mx-2" style="display: inline;" href="#">Terms of Use</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
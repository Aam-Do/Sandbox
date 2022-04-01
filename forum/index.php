<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/108cacb930.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Forum</title>
</head>

<body class="bg-light">
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

    $per_page_record = 5;  // Number of entries to show in a page.   
    // Look for a GET variable page if not found default is 1.        
    if (isset($_GET["page"])) {
        $page  = $_GET["page"];
    } else {
        $page = 1;
    }

    $start_from = ($page - 1) * $per_page_record;


    session_start();

    $errors = [];
    $inputs = [];

    // define variables and set to empty values

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['commentSubmit'])) {
            $inputs['postID'] = test_input($_POST["postID"]);
            $inputs['commentInput'] = test_input($_POST["commentInput"]);

            $sql = "INSERT INTO Comments (Content, PostID)
                VALUES ('$inputs[commentInput]', '$inputs[postID]')";

            if ($conn->query($sql) === TRUE) {
                $errors['commentInsertSucces'] = "comment insert success";
            } else {
                $errors['commentInsertError'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $inputs['name'] = test_input($_POST["name"]);
            $inputs['heading'] = test_input($_POST["heading"]);
            $inputs['content'] = test_input($_POST["content"]);

            $sql = "INSERT INTO Posts (Name, Header, Content)
                VALUES ('$inputs[name]', '$inputs[heading]', '$inputs[content]')";

            if ($conn->query($sql) === TRUE) {
                $errors['postInsertSucces'] = "post insert success";
            } else {
                $errors['postInsertError'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $_SESSION['valid'] = $valid;
        $_SESSION['errors'] = $errors;
        $_SESSION['inputs'] = $inputs;

        header('Location: index.php', true, 303);
        exit;
    } elseif ($request_method === 'GET') {
        if (isset($_SESSION['valid'])) {
            // get the valid state from the session
            $valid = $_SESSION['valid'];
            unset($_SESSION['valid']);
        }

        if (isset($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }

        if (isset($_SESSION['inputs'])) {
            $errors = $_SESSION['inputs'];
            unset($_SESSION['inputs']);
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = addcslashes($data, "'");
        return $data;
    }

    ?>
    <nav class="navbar sticky-top bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="hamster.jpg" alt="MyForum Logo" class="rounded-circle img-fluid" style="width: 50px;">
            </a>
            <a class="navbar-brand mx-auto" style="position: relative; right: 30px" href="#">Scared Hamster Forum</a>
        </div>
    </nav>
    <div class="container mt-3 d-grid">
        <div class="row row-cols-1 g-0">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10 card mx-auto mb-3 shadow">
                <form id="postForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="card-header">
                        <h4>Create a Post</h4>
                    </div>
                    <div class="card-body py-1 px-2">
                        <div class="m-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-sm" name="name" placeholder="Your name" id="name" required>
                        </div>
                        <div class="m-2">
                            <label for="heading" class="form-label">Title</label>
                            <input type="text" class="form-control form-control-sm" name="heading" placeholder="Give your post a suitable title..." id="heading" required>
                        </div>
                        <div class="m-2">
                            <label for="content">Content</label>
                            <textarea class="form-control form-control-sm" id="content" name="content" placeholder="Write a post..." rows="2" style="height: 50px;" required></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit" name="submit" value="submit" id="submit" disabled>Post</button>
                    </div>
                </form>
            </div>
            <hr>
        </div>

        <div class="row row-cols-1 g-0">
            <?php


            $query = "SELECT * FROM Posts ORDER BY PostID DESC LIMIT $start_from, $per_page_record";
            $rs_result = mysqli_query($conn, $query);

            // $sql = "SELECT * FROM Posts ORDER BY PostID DESC";
            // $result = $conn->query($sql);

            if ($rs_result->num_rows > 0) :
                while ($row = mysqli_fetch_array($rs_result)) :
                    $timestamp = strtotime($row['Time']);
                    $time = date("d.m.Y H:i", $timestamp);
            ?>
                    <div class="col-xl-7 col-lg-8 col-md-10 card mx-auto mb-3 shadow">
                        <div class="card-header">
                            <img src="hamster.jpg" alt="MyForum Logo" class="rounded-circle img-fluid me-2" style="width: 50px; display: inline;">
                            <h5 style="display: inline;"><?php echo $row["Name"]; ?></h5>
                            <p class="ms-2 text-muted" style="display: inline;"><small>– <?php echo $time; ?></small></p>
                        </div>
                        <div class="card-body">
                            <h4><?php echo $row["Header"]; ?></h4>
                            <p class="mb-3"><?php echo nl2br($row["Content"]); ?></p>
                            <hr>
                            <?php $sql = "SELECT Time, Content, CommentID FROM Comments WHERE PostID=$row[PostID] ORDER BY CommentID";
                            $commentResult = $conn->query($sql);

                            if ($commentResult->num_rows > 0) :
                            ?>
                                <a href="#comments<?php echo $row['PostID']; ?>" class="text-decoration-none" data-bs-toggle="collapse" style="display: inline;"><small>View comments</small></a>
                                <div id="comments<?php echo $row['PostID']; ?>" class="collapse">
                                    <?php // output data of each row
                                    while ($commentRow = $commentResult->fetch_assoc()) :
                                        $timestamp = strtotime($commentRow['Time']);
                                        $time = date("d.m.Y H:i", $timestamp);
                                    ?>
                                        <hr>
                                        <p class="ms-2 text-muted" style="display: inline;"><small>– <?php echo $time; ?></small></p>
                                        <p class="m-0"><?php echo $commentRow['Content']; ?></p>

                                    <?php endwhile; ?>
                                </div>
                            <?php
                            else : echo "<small style='display: inline;'>No comments yet. Write a comment below!</small>";
                            endif;
                            ?>
                        </div>
                        <div class="card-footer">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "#commentInput" . $row['PostID']; ?>" method="post">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <label for="commentInput<?php echo $row['PostID']; ?>" style="display: none;"></label>
                                        <textarea class="form-control form-control-sm" id="commentInput<?php echo $row['PostID']; ?>" name="commentInput" placeholder="Write a comment..." rows="2" style="height: 40px;" required></textarea>
                                    </div>
                                    <input type="hidden" id="postID" name="postID" value="<?php echo $row['PostID']; ?>">
                                    <button class="btn btn-primary align-self-end" type="submit" name="commentSubmit" id="commentSubmit<?php echo $row['PostID']; ?>">Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                endwhile;
            else : echo "0 results";
            endif;
            ?>
        </div>
        <div class="col mx-auto mt-3 mb-5 shadow">
            <div class="pagination">
                <?php
                $query = "SELECT COUNT(*) FROM Posts";
                $rs_result = mysqli_query($conn, $query);
                $row = mysqli_fetch_row($rs_result);
                $total_records = $row[0];

                echo "</br>";
                // Number of pages required.   
                $total_pages = ceil($total_records / $per_page_record);
                $pagLink = "";

                if ($page >= 2) {
                    echo "<li class='page-item'><a class='page-link' href='index.php?page=" . ($page - 1) . "'>  Prev </a></li>";
                } else {
                    echo "<li class='page-item disabled'><a class='page-link' href='index.php?page=" . ($page - 1) . "'>  Prev </a></li>";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        $pagLink .= "<li class='page-item active'><a class = 'page-link' href='index.php?page="
                            . $i . "'>" . $i . " </a></li>";
                    } else {
                        $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=" . $i . "'>   
                                                " . $i . " </a></li>";
                    }
                };
                echo $pagLink;

                if ($page < $total_pages) {
                    echo "<li class='page-item'><a class='page-link' href='index.php?page=" . ($page + 1) . "'>  Next </a></li>";
                } else {
                    echo "<li class='page-item disabled'><a class='page-link' href='index.php?page=" . ($page + 1) . "'>  Next </a></li>";
                }

                ?>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
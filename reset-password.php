<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$username = $username_err = "";
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Inserimento username
    if(empty(trim($_POST["username"]))){
        $username_err = "Si prega di inserire l'username";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validazione new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Si prega di inserire la nuova password.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La password deve avere almeno 6 caratteri.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Validazione confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Si prega di confermare la password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Le password non corrispondono.";
        }
    }

    // Check input errors before updating the database
    if(empty($username_err) && empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TVGeek - La casa dei cinefili e tv series addicted</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.6/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">

    <!--favicon-img-->
    <link rel="icon" type="image/png" href="images/favicon.jpg">
    <!--favicon-img-->

    <link rel="stylesheet" href="css/index.css">
</head>
<body>


<!-- MAIN CONTENT -->
<main id="blog-one">

    <!-- CUSTOM CURSOR -->
    <div class="cursor scale"></div>
    <div class="cursor-two scale"></div>
    <!-- CUSTOM CURSOR -->


    <!-- PRELOADER -->
    <div id="preloader">
        <div class="p">
            <img src="images/streaming.png" alt="streaming">
            Benvenuto in TV Geek — La casa dei cinefili e tv series addicted
        </div>
    </div>
    <!-- PRELOADER -->



    <div id="blog-one-content">
        <!-- NAVIGATION -->
        <div class="navigation">
            <div class="logo hover ">
                <a href="index.html" class="text">TVGeek</a>
            </div>
            <div class="menu-bar hover ">
                <div class="menu-bar-name text">
                    Menu
                </div>
                <div class="menu-bar-lines text">
                    <div class="menu-bar-line"></div>
                    <div class="menu-bar-line"></div>
                </div>
            </div>
        </div>
        <!-- NAVIGATION -->

        <!-- HEADING -->
        <div class="heading">
               <span class="text">
                RESET PASSWORD
               </span>
        </div>

        <!-- HEADING -->


        <!-- NAVIGATION CONTENT -->
        <div class="navigation-content">
            <div class="navigation-logo hover opacity">
                <a href="#" class="text">TVGeek</a>
            </div>
            <ul class="navigation-ul">
                <li><a href="index.html" data-text="Home" data-img="images/home.jpg">Home</a></li>
                <li><a href="about.html" data-text="About" data-img="images/about-img.jpg">About</a></li>
                <li><a href="account.html" data-text="Account" data-img="images/account.jpg">Account</a></li>
                <li><a href="contact.php" data-text="Contact" data-img="images/contact-us.jpg">Contatti</a></li>
            </ul>
            <div class="navigation-close hover about-close opacity">
                <div class="navigation-close-line"></div>
                <div class="navigation-close-line"></div>
            </div>

            <div class="project-preview"></div>


            <!-- STREAMING IMG -->
            <div class="streaming-navigation opacity">
                <img src="images/streaming.png" title="streaming zone" class="text" alt="streaming">
            </div>
            <!-- STREAMING IMG -->
        </div>
        <!-- NAVIGATION CONTENT -->


        <div class="center">

            <!-- BLOG-CONTAINER -->

            <div id="blogs-container">


                <!-- BLOG -->
                <div class="blog fade-up">
                    <div class="blog-img">
                        <img src="images/forgot-pw.jpg" alt="blog-img">
                    </div>
                    <div class="blog-text">
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="blog-heading">Si prega di compilare questo form per resettare la password</div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" required>
                            </div>
                            <div class="form-group">
                                <label>Nuova<br>Password</label>
                                <input type="password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label>Conferma<br>Password</label>
                                <input type="password" name="confirm_password" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a class="btn btn-link ml-2" href="account.html">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- BLOG-CONTAINER-->

        </div>

        <!-- STREAMING IMG -->
        <div class="streaming img text">
            <img src="images/streaming.png" title="streaming zone" class="text" alt="streaming">
        </div>
        <!-- STREAMING IMG -->

        <!-- progress-bar -->
        <div class="progress-bar-container fade-in">
            <div class="progressbar"></div>
        </div>
        <!-- progress-bar -->
    </div>



    <!-- NAVIGATION CONTENT -->

    <div class="navigation-content">
        <div class="navigation-logo hover opacity">
            <a href="#" class="text">TVGeek</a>
        </div>
        <ul class="navigation-ul">
            <li><a href="index.html" data-text="Home" data-img="images/bg-image-three.jpg">Home</a></li>
            <li><a href="about.html" data-text="About" data-img="images/about-img.jpg">About</a></li>
            <li><a href="account.html" data-text="Account" data-img="images/account.jpg">Account</a></li>
            <li><a href="contact.php" data-text="Contact" data-img="images/contact-us.jpg">Contatti</a></li>
        </ul>
        <div class="navigation-close hover about-close opacity">
            <div class="navigation-close-line"></div>
            <div class="navigation-close-line"></div>
        </div>

        <div class="project-preview"></div>


        <!-- STREAMING IMG -->
        <div class="streaming-navigation opacity">
            <img src="images/streaming.png" title="streaming zone" class="text" alt="streaming">
        </div>
        <!-- STREAMING IMG -->

    </div>

    <!-- NAVIGATION CONTENT -->





</main>
<!-- MAIN CONTENT -->

<script src="js/jquery.min.js"></script>
<script src="js/bez.js"></script>
<script src="js/pace.js"></script>
<script src="js/index.js"></script>
</body>
</html>
<?php
// Inizializzo la sessione
session_start();

// Includo config.php
require_once "config.php";

// Definisco le variabili che mi servono e le inizializzo
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processo i dati una volta che viene premuto il bottone per inviare i dati del form
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Valido l'username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/', trim($_POST["username"]))){
        $username_err = "L'username deve essere una mail valida.";
    } else{
        // Preparo la select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Lego le variabili alla select statement come parametri
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Setto i parametri
            $param_username = trim($_POST["username"]);

            // Tentativo di esecuzione della query preparata
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Username già presente nei nostri database.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Valido la password
    if(empty(trim($_POST["password"]))){
        $password_err = "Si prega di inserire una password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La password deve avere almeno 6 caratteri..";
    } else{
        $password = trim($_POST["password"]);
    }

    // Valido la conferma password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Si prega di confermare la password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Le password non corrispondono.";
        }
    }

    // Controllo errori di input prima di inserire il tutto nel database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Preparo l'insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Lego le variabili per lo statement
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Setto i parameteri
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Tento di eseguire lo statement
            if(mysqli_stmt_execute($stmt)){
                // Reindirizzo al login
                header("location: account.html");
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
                REGISTRAZIONE A TVGEEK
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
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Conferma Password</label>
                                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                            </div>
                            <p>Hai già un account? <a href="login.php">Autenticati</a>.</p>
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
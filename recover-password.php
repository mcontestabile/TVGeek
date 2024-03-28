<?php
// Initialize the session
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once "config.php";
require_once('SMTP.php');
require_once('PHPMailer.php');
require_once('Exception.php');

// Crea una nuova istanza di PHPMailer
$mail = new PHPMailer(true);

// Imposta il protocollo SMTP
$mail->isSMTP();

// Imposta l'host SMTP di Gmail
$mail->Host = 'smtp.gmail.com';

// Imposta il numero di porta SMTP di Gmail
$mail->Port = 465;

// Abilita l'autenticazione SMTP
$mail->SMTPAuth = true;

$mail->SMTPSecure='ssl';

$mail->Mailer = 'smtp';

// Mittente
$mail->setFrom('m.contestabile@studenti.unibs.it', 'Martina Contestabile - TVGeek Team');
$mail->Username = 'm.contestabile@studenti.unibs.it';
$mail->Password = $config['password'];

// Imposta l'oggetto e il corpo dell'email
$mail->Subject = 'Reset della password';

// Define variables and initialize with empty values
$email = $email_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validazione email
    if(empty(trim($_POST["email"]))){
        $email_err = "Si prega di inserire la propria mail.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Controllo possibili errori di input prima di aggiornare il database
    if(empty($email_err)){
        // Esegui la query per recuperare ulteriori informazioni dell'utente
        $query = "SELECT * FROM users WHERE username = '$email'";
        $result = mysqli_query($conn, $query);
        $mail->addAddress($email, 'Utente TVGeek');

        if ($result && mysqli_num_rows($result) > 0) {
            // L'email esiste nel database, procedi con l'invio dell'email di reset.
            $row = mysqli_fetch_assoc($result);
            $username = $row['username'];

            // Genera una password casuale.
            $newPassword = generateRandomPassword();

            // Aggiorna la password nel database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE username = '$email'";
            mysqli_query($conn, $updateQuery);

            $mail->Body = "Ciao $username,\n\nLa tua password è stata resettata. La tua nuova password è: $newPassword\n\nTi consigliamo di cambiarla al successivo accesso.\n\nGrazie, TVGeek Team.";

            $mail->addAddress($username);
            $mail->addReplyTo('m.contestabile@studenti.unibs.it', 'Information');

            // Invia l'email
            $mail->Send();

            if ($mail) {
                header("location: index.html");
                $email_err = "Email di reset inviata correttamente. Controlla la tua casella di posta.";
            } else {
                $email_err = "Si è verificato un errore durante l'invio dell'email. Riprova.";
            }
        } else {
            $email_err = "L'indirizzo email non esiste nel nostro sistema. Inserire una mail valida.";
        }
    }

    // Close connection
    mysqli_close($conn);
}

// Funzione per generare una password casuale
function generateRandomPassword($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
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
                        <form action="recover-password.php" method="POST">
                            <div class="blog-heading">Si prega di inserire la mail per resettare la password</div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" required class="form-control" <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>>
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a class="btn btn-link ml-2" href="index.html">Cancel</a>
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
            <li><a href="index.html" data-text="Home" data-img="images/home.jpg">Home</a></li>
            <li><a href="about.html"  data-text="About"  data-img="images/about-img.jpg">About</a></li>
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
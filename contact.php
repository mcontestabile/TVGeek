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

$mail->Username = 'm.contestabile@studenti.unibs.it';
$mail->Password = $config['password'];

// Define variables and initialize with empty values
$email = $email_err = "";
$subject = $subject_err = "";
$name = $name_err = "";
$body = $body_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

// Validazione email
    if (empty(trim($_POST['email']))) {
        $email_err = "Si prega di inserire la propria mail.";
    } else {
        $email = trim($_POST['email']);
    }

// Validazione subject
    if (empty(trim($_POST['subject']))) {
        $subject_err = "Si prega di inserire l'oggetto della mail.";
    } else {
        $subject = trim($_POST['subject']);
    }

// Validazione subject
    if (empty(trim($_POST['name']))) {
        $name_err = "Si prega di inserire il proprio nome.";
    } else {
        $name = trim($_POST['name']);
    }

// Validazione subject
    if (empty(trim($_POST['body']))) {
        $body_err = "Si prega di inserire il contenuto del messaggio.";
    } else {
        $body = trim($_POST['body']);
    }

    if(empty($email_err) && empty($body_err) && empty($name_err) && empty($subject_err)) {
        $mail->setFrom('requests@tvgeek.com', $name);
        $mail->addAddress('m.contestabile@studenti.unibs.it');

        // Imposta l'oggetto e il corpo dell'email
        $mail->Subject = ("$email ($subject)");
        $mail->Body = $body;

        $mail->addReplyTo($email, $name);

        // Invia l'email
        $mail->Send();

        if ($mail) {
            $email_err = "Email di reset inviata correttamente. Controlla la tua casella di posta.";
            header("location: index.html");
        } else {
            $email_err = "Si è verificato un errore durante l'invio dell'email. Riprova.";
        }
    }
}

// Close connection
mysqli_close($conn);
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
<main id="contact-one">

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


    <div id="contact-one-content">

        <!-- NAVIGATION -->
        <div class="navigation">
            <div class="logo hover ">
                <a href="index.html" class="text-contact">TVGeek</a>
            </div>
            <div class="menu-bar hover ">
                <div class="menu-bar-name text-contact">
                    Menu
                </div>
                <div class="menu-bar-lines">
                    <div class="menu-bar-line-contact"></div>
                    <div class="menu-bar-line-contact"></div>
                </div>
            </div>
        </div>
        <!-- NAVIGATION -->





        <!-- HEADING -->
        <div class="contact-one-heading">
            <div class="textstyle">
                CONTATTI
            </div>
        </div>

        <!-- HEADING -->


        <div id="flex-row">

            <!-- FORM CONTATTI -->

            <div id="contact-form">
                <div id="form" class="opacity-contact">
                    <form  id ="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="input-line">
                            <input name="name" type="text" placeholder="NOME" class="input-same-line" required>
                            <input name="email" type="email" placeholder="EMAIL" class="input-same-line" required>
                        </div>
                        <div class="input-line-column">
                            <input name="subject" type="text" placeholder="OGGETTO" required>
                            <textarea name="body" class="textarea" placeholder="MESSAGGIO" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a class="btn btn-link ml-2" href="index.html">Homepage</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FORM CONTATTI -->



            <!-- ENQUIRY MAIL -->

            <div id="collaboration-mail" class="opacity-contact">

                <div class="circular-text">
                    <span id="rotated">  FOR COLLABORATION * &nbsp;&nbsp;&nbsp;&nbsp; FOR COLLABORATION * &nbsp;&nbsp;&nbsp;&nbsp; FOR COLLABORATION * &nbsp;&nbsp;&nbsp;&nbsp; FOR COLLABORATION * &nbsp;&nbsp;&nbsp;&nbsp; </span>
                </div>
                <div class="mail">
                    <a href="mailto:INFO@GMAIL.COM">martina.contestabile01@gmail.com</a>
                </div>
            </div>

            <!-- ENQUIRY MAIL -->

        </div>







        <!-- STREAMING IMG -->
        <div class="headphone img text">
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
            <li><a href="contact.html"  data-text="Contact" data-img="images/contact-us.jpg">Contatti</a></li>
        </ul>
        <div class="navigation-close hover about-close opacity">
            <div class="navigation-close-line"></div>
            <div class="navigation-close-line"></div>
        </div>

        <div class="project-preview"></div>


        <!-- HEADPHONE IMG -->
        <div class="headphone-navigation opacity">
            <img src="images/headphone.png" title="headphone zone" class="text" alt="headphone">
        </div>
        <!-- HEADPHONE IMG -->


        <!-- SOCIAL MEDIA LINKS -->
        <div class="social-media-links-navigation">
            <ul>
                <li ><a href="#"  class="text hover opacity">YT</a></li>
                <li ><a href="#"  class="text hover opacity">FB</a></li>
                <li ><a href="#"  class="text hover opacity">IG</a></li>
            </ul>
        </div>
        <!-- SOCIAL MEDIA LINKS -->

    </div>

    <!-- NAVIGATION CONTENT -->




</main>

<script src="js/jquery.min.js"></script>
<script src="js/circletype.min.js"></script>
<script src="js/jquery.lettering.js"></script>
<script src="js/bez.js"></script>
<script src="js/pace.js"></script>
<script src="js/index.js"></script>

</body>
</html>
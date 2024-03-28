<?php
require_once 'config.php';
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
<main id="index-one">

    <!-- CUSTOM CURSOR -->
    <div class="cursor scale"></div>
    <div class="cursor-two scale"></div>
    <!-- CUSTOM CURSOR -->

    <!-- PRELOADER -->
    <div id="preloader">
        <div class="p">
            <img src="images/streaming.png" alt="streaming">Benvenuto in TV Geek — La casa dei cinefili e tv series addicted</div>
    </div>
    <!-- PRELOADER -->

    <!-- HEADER -->
    <div id="header">
        <!-- NAVIGATION -->
        <div class="navigation">
            <div class="logo hover ">
                <a href="index.html" class="text-index">TVGeek</a>
            </div>
            <div class="menu-bar hover ">
                <div class="menu-bar-name text">Menu</div>
                <div class="menu-bar-lines text">
                    <div class="menu-bar-line"></div>
                    <div class="menu-bar-line"></div>
                </div>
            </div>
        </div>
        <!-- NAVIGATION -->



        <div class="scrolling-part"></div>

        <div class="left2">
        </div>

        <div class="right2">
            <div class="container">
                <div class="heading">
                    <span class="text">DISCOVER, WATCH, ENJOY</span>
                </div>
                <div id="screen1">
                    <h2>Seleziona i generi che potrebbero piacerti.<br>
                        Se non farai scelte, sceglieremo noi casualmente<br>
                        dei generi che potrebbero interessarti!</h2>
                    <br>
                    <div id="genres-form" style="max-height: 340px; overflow-y: scroll; margin: 2px;">
                        <form action="tvgeek-magic2.php" method="POST">
                            <?php
                            $sql = 'SELECT DISTINCT genres FROM all_movies_details_cleaned WHERE genres IS NOT NULL ORDER BY RAND() LIMIT 50;';
                            $rows = $conn->query($sql);
                            while ($row = $rows->fetch_assoc()) {
                                if (!empty($row['genres'])) {
                                    ?>
                                    <label>
                                        <input type="checkbox" type="submit" name="genres[]" value="<?php echo $row['genres']; ?>" unchecked>
                                        <?php echo $row['genres']; ?>
                                    </label>
                                    <br>
                                    <?php
                                } else continue;
                            }
                            ?>
                            <input type="submit" name="submit" value="Prosegui" class="acc-btn-cuteblue"/>
                        </form>
                    </div>
                </div>


                <div class="container">
                    <!-- STREAMING IMG -->
                    <div class="streaming img text">
                        <img src="images/streaming.png" class = "text" alt="streaming">
                    </div>
                    <!-- STREAMING IMG -->
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

<script src="js/script.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bez.js"></script>
<script src="js/pace.js"></script>
<script src="js/index.js"></script>
</body>
</html>
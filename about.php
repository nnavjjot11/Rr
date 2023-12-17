<?php 
    include 'connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if (!isset($user_id)) {
        header('location:login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("location: login.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!------------------------bootstrap icon link------------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>veggen - home page</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>about us</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor.</p>
            <a href="index.php">home</a><span>/ about us</span>
        </div>
    </div>
    <div class="line"></div>
    <!-----------------------about us------------------------>
    <div class="line2"></div>
    <div class="about-us">
        <div class="row">
            <div class="box">
                <div class="title">
                    <span>ABOUT OUR ONLINE STORE</span>
                    <h1>Hello, With 25 years of experience</h1>
                </div>
                <p>Over 25 years Ecommerce helping companies reach their financial and branding goals.

                    The perfect way to enjoy brewing tea on low hanging fruit to identify. Duis autem vel eum iriure
                    dolor in hendrerit in
                    vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. For me,
                    the most important part of
                    improving at photography.</p>
            </div>
            <div class="img-box">
                <img src="img/about3.jpg">
            </div>
        </div>
    </div>
    <div class="line3"></div>
    <!-----------------------features----------------------->
    <div class="line4"></div>
    <div class="features">
        <div class="title">
            <h1>Complete Customer Ideas</h1>
            <span>best features</span>
        </div>
        <div class="row">
            <div class="box">
                <img src="img/icon2.png">
                <h4>24 X 7</h4>
                <p>Online Support 27/7</p>
            </div>
            <div class="box">
                <img src="img/icon1.png">
                <h4>Money Back Guarantee</h4>
                <p>100% Secure Payment</p>
            </div>
            <div class="box">
                <img src="img/icon0.png">
                <h4>Special Gift Card</h4>
                <p>Give The Perfect Gift</p>
            </div>
            <div class="box">
                <img src="img/icon.png">
                <h4>Worldwide Shipping</h4>
                <p>On Order Over $99</p>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <!-----------------------team section----------------------->
    <div class="line2"></div>
    <div class="team">
        <div class="title">
            <h1>Our Workable Team</h1>
            <span>best team</span>
        </div>
        <div class="row">
            <div class="box">
                <div class="img-box">
                    <img src="img/team.jpg">
                </div>
                <div class="detail">
                    <span>Finace Manager</span>
                    <h4>Miguel Rodrigez</h4>
                    <div class="icons">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-behance"></i>
                        <i class="bi bi-whatsapp"></i>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="img/te.jpg">
                </div>
                <div class="detail">
                    <span>Finace Manager</span>
                    <h4>Miguel Rodrigez</h4>
                    <div class="icons">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-behance"></i>
                        <i class="bi bi-whatsapp"></i>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="img/team1.jpg">
                </div>
                <div class="detail">
                    <span>Finace Manager</span>
                    <h4>Miguel Rodrigez</h4>
                    <div class="icons">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-behance"></i>
                        <i class="bi bi-whatsapp"></i>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="img/team2.jpg">
                </div>
                <div class="detail">
                    <span>Finace Manager</span>
                    <h4>Miguel Rodrigez</h4>
                    <div class="icons">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-behance"></i>
                        <i class="bi bi-whatsapp"></i>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="img/team0.jpg">
                </div>
                <div class="detail">
                    <span>Finace Manager</span>
                    <h4>Miguel Rodrigez</h4>
                    <div class="icons">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-behance"></i>
                        <i class="bi bi-whatsapp"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="line3"></div>
    <div class="line4"></div>
    <div class="project">
        <div class="title">
            <h1>Our Best Project</h1>
            <span>how it works</span>
        </div>
        <div class="row">
            <div class="box">
                <img src="img/about1.jpg">
            </div>
            <div class="box">
                <img src="img/about2.jpg">
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="line2"></div>
    <div class="ideas">
        <div class="title">
            <h1>We And Our Clients Are Happy To Cooperate With Our Company</h1>
            <span>our features</span>
        </div>
        <div class="row">
            <div class="box">
                <i class="bi bi-stack"></i>
                <div class="detail">
                    <h2>What We Really Do</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper
                        mattis, pulvinar dapibus
                        leo.</p>
                </div>
            </div>
            <div class="box">
                <i class="bi bi-grid-1x2-fill"></i>
                <div class="detail">
                    <h2>History of Beginning</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper
                        mattis, pulvinar dapibus
                        leo.</p>
                </div>
            </div>
            <div class="box">
                <i class="bi bi-tropical-storm"></i>
                <div class="detail">
                    <h2>Our Vision</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper
                        mattis, pulvinar dapibus
                        leo.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="line3"></div>
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>
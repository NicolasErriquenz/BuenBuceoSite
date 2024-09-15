<?php  
    
    // require_once ("ssi_seguridad.php");
    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    if( isset($_POST["userid"]) && $_POST["userid"] != "" && isset($_POST["password"]) && $_POST["password"] != "" ){
        $sql = "SELECT * FROM administradores WHERE usuario='".$_POST["userid"]."' AND password='".md5($_POST["password"])."'";
        $rs  = $mysqli->query($sql);
        
        if( mysqli_num_rows($rs) > 0 ){
            $row = $rs->fetch_array(MYSQLI_ASSOC);

            if(!isset($_SESSION))
                @session_start();
            
            $_SESSION["admin"] = $row;

            //$_POST["rememberme"];
            header("location:dashboard.php");
            die();
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="_nK">
    
    <title><?php echo SITE_TITLE; ?></title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="bower_components/nanoscroller/bin/css/nanoscroller.css">
    <link rel="stylesheet" type="text/css" href="bower_components/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/material-design-icons/css/material-design-icons.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/weather-icons/css/weather-icons.min.css">
    <link rel="stylesheet" type="text/css" href="assets/_con/css/con-base.min.css">
    
    <link rel="icon" href="<?=$FAVICON_32?> " sizes="32x32">
    <link rel="icon" href="<?=$FAVICON_196?>" sizes="192x192">
    <link rel="apple-touch-icon" href="<?=$FAVICON_180?>">
</head>
<body>
    <section id="sign-in">
        <canvas id="bubble-canvas"></canvas>
        <form action="index.php" method="post">
            <div class="row links">
                <div class="col s6 logo">
                    <img src="images/logos/LogoBB_01.png" alt="">
                </div>
                <!-- <div class="col s6 right-align">
                    <strong>Sign In</strong> / <a href="page-sign-up.html">Sign Up</a>
                </div>-->
            </div> 
            <div class="card-panel clearfix">
                <!-- <div class="row socials">
                    <div class="col s4">
                        <a class="btn blue darken-2 z-depth-0 z-depth-1-hover" href="#"><i class="fa fa-2x fa-facebook"></i></a>
                    </div>
                    <div class="col s4">
                        <a class="btn blue lighten-2 z-depth-0 z-depth-1-hover" href="#"><i class="fa fa-2x fa-twitter"></i></a>
                    </div>
                    <div class="col s4">
                        <a class="btn red z-depth-0 z-depth-1-hover" href="#"><i class="fa fa-2x fa-google-plus"></i></a>
                    </div>
                </div> -->
                <div class="input-field">
                    <i class="fa fa-user prefix"></i>
                    <input id="userid" name="userid" type="text" class="validate">
                    <label for="userid">Username</label>
                </div>
                <div class="input-field">
                    <i class="fa fa-unlock-alt prefix"></i>
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password">Password</label>
                </div>
                <div class="switch">
                    <label>
                        <input type="checkbox" checked="checked" id="rememberme">
                        <span class="lever"></span>
                        Remember
                    </label>
                </div>
                <button type="submit" class="waves-effect waves-light btn-large z-depth-0 z-depth-1-hover">LogIn</button>
            </div>
            <!-- <div class="links right-align">
                <a href="page-forgot-password.html">Forgot Password?</a>
            </div> -->
        </form>
    </section>

    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/jquery-requestAnimationFrame/dist/jquery.requestAnimationFrame.min.js"></script>
    <script type="text/javascript" src="bower_components/nanoscroller/bin/javascripts/jquery.nanoscroller.min.js"></script>
    <script type="text/javascript" src="bower_components/materialize/bin/materialize.js"></script>
    <script type="text/javascript" src="bower_components/Sortable/Sortable.min.js"></script>
    <script type="text/javascript" src="assets/_con/js/_con.min.js"></script>
    <script type="text/javascript" src="bower_components/code-prettify/src/prettify.js"></script>
</body>
</html>

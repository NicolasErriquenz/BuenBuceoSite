<?php  
require_once ("Connections/config.php");
require_once ("Connections/connect.php");
require_once ("servicios/servicio.php");

// Verificar si existe cookie de remember me
if (!isset($_SESSION['admin']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $sql = "SELECT * FROM usuarios 
            WHERE remember_token = ? AND token_expires > NOW()";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        session_start();
        $_SESSION["admin"] = $row;
        $_SESSION["admin"]["foto"] = $row["imagen"];
        header("location:dashboard.php");
        die();
    }
}

// Login normal
if(isset($_POST["userid"]) && $_POST["userid"] != "" && 
   isset($_POST["password"]) && $_POST["password"] != "") {
    
    $sql = "SELECT * FROM usuarios WHERE usuario=? AND password=?";
    $stmt = $mysqli->prepare($sql);
    $hashedPassword = md5($_POST["password"]);
    $stmt->bind_param("ss", $_POST["userid"], $hashedPassword);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if(!isset($_SESSION)) {
            session_start();
        }
      
        // Si remember me está marcado
        if(isset($_POST['rememberMe'])) {
            $token = bin2hex(random_bytes(32));
            $sql = "UPDATE usuarios 
                   SET remember_token = ?, 
                       token_expires = DATE_ADD(NOW(), INTERVAL 30 DAY) 
                   WHERE usuarioId = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $token, $row['usuarioId']);
            $stmt->execute();
            
            setcookie(
                'remember_token',
                $token,
                [
                    'expires' => time() + (30 * 24 * 60 * 60), // 30 días
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]
            );
        }
              
        $_SESSION["admin"] = $row;
        $_SESSION["admin"]["foto"] = $row["imagen"];
        header("location:dashboard.php");
        die();
    }
}

$frase = obtenerOracionInspiradora();
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
  
  <?php include("includes/head.php"); ?>

<body class="">
  
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">LOGIN</h4>
                  <p class="mb-0">Ingresá nombre de usuario y password</p>
                </div>
                <div class="card-body">
                  <form action="index.php" method="post">
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="username" id="userid" name="userid">
                    </div>
                    <div class="mb-3">
                      <div class="position-relative">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                        <i class="fa fa-eye position-absolute top-50 translate-middle-y text-muted" style="cursor: pointer; right: 15px;" onmousedown="togglePassword(true)" onmouseup="togglePassword(false)"></i>
                      </div>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe" value="1" checked>
                      <label class="form-check-label" for="rememberMe">Recordarme</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" 
                     style="background-image: url('<?php echo $frase["imagen"] ?>');
                            background-size: cover;">
                      <span class="mask bg-gradient-primary opacity-6"></span>
                      
                      <h4 class="mt-5 text-white font-weight-bolder position-relative"><?php echo $frase["titulo"] ?></h4>
                      <p class="text-white position-relative"><?php echo $frase["descripcion"] ?></p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  
  <script>
    function togglePassword(show) {
        document.getElementById("password").type = show ? "text" : "password";
    }
  </script>

  <?php include("includes/scripts.php") ?>
</body>

</html>
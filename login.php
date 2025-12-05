<?php
session_start();

// Se já estiver logado, redireciona para index.php
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = "";

// Verifica login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['uname'];
    $password = $_POST['psw'];

    // Login simples (podes ligar a BD se quiseres)
    if ($username === "admin" && $password === "1234") {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Username ou password incorretos!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* Estilo igual ao do teu formulário */
        form { border: 3px solid #f1f1f1; width: 300px; margin: auto; padding: 20px; }
        input[type=text], input[type=password] {
            width: 100%; padding: 12px; margin: 8px 0;
            border: 1px solid #ccc; box-sizing: border-box;
        }
        button { background-color: #04AA6D; color: white; padding: 14px; border: none; width: 100%; }
        .container { padding: 16px; }
        .error { color: red; text-align:center; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Login</h2>

<?php if ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form action="login.php" method="post">
  <div class="imgcontainer">
    <img src="user.png" alt="Avatar" class="avatar" style="width:100px;">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>
  </div>
</form>

</body>
</html>

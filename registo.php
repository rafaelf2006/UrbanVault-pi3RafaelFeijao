<?php
session_start();
require_once 'db.php';

// Se já estiver logado, redireciona
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";

// Processar registo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registar'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validações
    if (empty($nome) || empty($email) || empty($password) || empty($password_confirm)) {
        $error = "Por favor, preencha todos os campos!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email inválido!";
    } elseif (strlen($password) < 6) {
        $error = "A password deve ter no mínimo 6 caracteres!";
    } elseif ($password !== $password_confirm) {
        $error = "As passwords não coincidem!";
    } else {
        // Verificar se email já existe
        $check_query = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Este email já está registado!";
        } else {
            // Criar hash da password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Inserir novo utilizador
            $insert_query = "INSERT INTO users (nome, email, password, tipo_usuario, ativo) VALUES (?, ?, ?, 'cliente', 1)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sss", $nome, $email, $password_hash);

            if ($stmt->execute()) {
                $success = "Registo bem-sucedido! A redirecionar para login...";
                header("refresh:2;url=login.php");
            } else {
                $error = "Erro ao criar conta. Tenta novamente!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registo - UrbanVault</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0e0e0e 0%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 20px;
        }

        .register-container {
            background: #1b1b1b;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 500px;
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-family: 'Oswald', sans-serif;
            font-size: 2.5rem;
            letter-spacing: 3px;
            color: #fff;
        }

        .logo h1 span {
            color: #D2BBA0;
        }

        .logo p {
            color: #aaa;
            margin-top: 0.5rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .alert-error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ff6b6b;
        }

        .alert-success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid rgba(0, 255, 0, 0.3);
            color: #51cf66;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #ddd;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 1rem;
            background: #0e0e0e;
            border: 2px solid #333;
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            transition: 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #D2BBA0;
        }

        .btn-register {
            width: 100%;
            padding: 1rem;
            background: #D2BBA0;
            border: none;
            border-radius: 8px;
            color: #000;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(210, 187, 160, 0.3);
        }

        .links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .links a {
            color: #D2BBA0;
            text-decoration: none;
            transition: 0.3s;
        }

        .links a:hover {
            color: #fff;
        }

        .password-requirements {
            font-size: 0.85rem;
            color: #888;
            margin-top: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>URBAN<span>VAULT</span></h1>
            <p>Streetwear Exclusivo</p>
        </div>

        <h2>Criar Conta</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" placeholder="O teu nome" required value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="exemplo@email.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                <div class="password-requirements">Mínimo 6 caracteres</div>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmar Password</label>
                <input type="password" id="password_confirm" name="password_confirm" placeholder="••••••••" required>
            </div>

            <button type="submit" name="registar" class="btn-register">Criar Conta</button>
        </form>

        <div class="links">
            <p>Já tens conta? <a href="login.php">Faz login aqui</a></p>
        </div>

        <div class="links" style="margin-top: 1rem;">
            <a href="index.php">← Voltar à loja</a>
        </div>
    </div>
</body>
</html>
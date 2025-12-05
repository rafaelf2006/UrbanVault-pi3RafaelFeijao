<?php
// Aqui poderás futuramente carregar produtos do carrinho através da base de dados ou sessões:
// session_start();
// include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrinho | UrbanVault</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="carrinho.css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="logo">UrbanVault</div>
    <nav>
      <ul>
        <!-- Botão de modo escuro -->
        <button id="theme-toggle">🌙</button>

        <li><a href="index.php">Home</a></li>
        <li><a href="loja.php">Loja</a></li>
        <li><a href="carrinho.php">Carrinho (<span id="cart-count">0</span>)</a></li>
      </ul>
    </nav>
  </header>

  <section class="carrinho-section">
    <h1 class="section-title">O Meu Carrinho</h1>

    <div id="carrinho-container"></div>

    <div id="carrinho-total">
      <p>Total: €<span id="total">0.00</span></p>
      <button id="checkout-btn">Finalizar Compra</button>
    </div>
  </section>

  <footer>
    <p>© 2025 UrbanVault. Todos os direitos reservados.</p>
  </footer>

  <script src="carrinho.js"></script>
</body>
</html>

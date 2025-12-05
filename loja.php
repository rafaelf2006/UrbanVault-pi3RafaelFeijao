<?php
// Aqui poderás futuramente carregar produtos da base de dados:
// include 'config/db.php';
// session_start();

?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja | UrbanVault</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="loja.css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>

  <header>
    <div class="logo">UrbanVault</div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="loja.php">Loja</a></li>
        <li><a href="carrinho.php">Carrinho (<span id="cart-count">0</span>)</a></li>
      </ul>
    </nav>
  </header>

  <section class="loja">
    <h1 class="section-title">A Loja</h1>
    
    <div class="filtros">
      <input type="text" id="search" placeholder="Pesquisar produto...">
      <select id="filtro">
        <option value="todos">Todos</option>
        <option value="Hoddies">Hoddies</option>
        <option value="Sweatshirt">Sweatshirt</option>
        <option value="T-shirt">T-shirt</option>
        <option value="Pants">Pants</option>
        <option value="Shorts">Shorts</option>
      </select>
    </div>

    <div id="produtos-container" class="products"></div>
  </section>

  <footer>
    <p>© 2025 UrbanVault. Todos os direitos reservados.</p>
  </footer>

  <script src="loja.js"></script>
</body>
</html>

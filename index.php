
<?php
session_start();
require_once 'config.php'; // Liga à base de dados

// Vai buscar os 4 produtos mais recentes
$query = "SELECT * FROM products ORDER BY data_adicionado DESC LIMIT 4";
$result = $conn->query($query);
?>


<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UrbanVault</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="logo">UrbanVault</div>

    <div class="search-box">
      <input type="text" placeholder="Pesquisar...">
    </div>

    <div class="right-side">
      <nav>
        <ul>
          <li><a href="#about">Sobre</a></li>
          <li><a href="loja.php">Loja</a></li>
        </ul>
      </nav>

      <div class="user-icon">
        <?php if(isset($_SESSION['username'])): ?>
          <a href="logout.php"><img src="login/user.png" alt="Logout" class="header-avatar"></a>
        <?php else: ?>
          <a href="login.php"><img src="login/user.png" alt="Login" class="header-avatar"></a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1 class="reveal">Desbloqueia o teu estilo</h1>
      <p class="reveal">Streetwear premium — só os melhores drops.</p>
      <a href="loja.php"><button class="reveal">Shop Now</button></a>
    </div>
  </section>

  <section id="novidades">
    <h2 class="section-title">Novidades</h2>
    <div class="products">

      <div class="product reveal">
        <div class="hoodie-images">
          <img id="hoodie-front" src="mockupsUV/hoodie_black_front.png" alt="Hoodie Preto Frente">
          <img id="hoodie-back" src="mockupsUV/hoodie_black_back.png" alt="Hoodie Preto Trás">
        </div>
        <h3>Hoodie UrbanVault</h3>
        <p>€79,99</p>

        <div class="color-options">
          <img class="color-swatch" src="mockupsUV/hoodie_black_front.png" alt="Preto" onclick="changeHoodieColor('black')">
          <img class="color-swatch" src="mockupsUV/hoodie_white_front.png" alt="Branco" onclick="changeHoodieColor('white')">
          <img class="color-swatch" src="mockupsUV/hoodie_green_front.png" alt="Verde" onclick="changeHoodieColor('green')">
          <img class="color-swatch" src="mockupsUV/hoodie_wine_front.png" alt="Wine" onclick="changeHoodieColor('wine')">
        </div>

        <div class="view-options">
          <button onclick="showFront()">Frente</button>
          <button onclick="showBack()">Trás</button>
        </div>
      </div> 
      <div class="product reveal">
        <div class="hoodie-images"> 
          <img id="tshirt-front" src="mockupsUV/tshirt_black_front.png" alt="T-shirt Frente">
          <img id="tshirt-back" src="mockupsUV/tshirt_black_back.png" alt="T-shirt Trás">
        </div>
        <h3>T-Shirt UrbanVault</h3>
        <p>€39,99</p>

        <div class="color-options">
          <img class="color-swatch" src="mockupsUV/tshirt_black_front.png" alt="Preto" onclick="changeTshirtColor('black')">
          <img class="color-swatch" src="mockupsUV/tshirt_white_front.png" alt="Branco" onclick="changeTshirtColor('white')">
        </div>

        <div class="view-options">
          <button onclick="showTshirtFront()">Frente</button>
          <button onclick="showTshirtBack()">Trás</button>
        </div>
      </div>
      </div> </section> <section id="about">
    <h2 class="section-title reveal">Sobre a UrbanVault</h2>
    <p class="about-text reveal">
      A UrbanVault nasceu da cultura de rua e da paixão pelo estilo. Selecionamos apenas os melhores sneakers e roupa streetwear para que possas elevar o teu look todos os dias.  
      Faz parte da comunidade — desbloqueia o teu estilo com a UrbanVault.
    </p>
  </section>

  <footer>
    <p>© 2025 UrbanVault. Todos os direitos reservados.</p>
    <p>Siga-nos em @urbanvault_official</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
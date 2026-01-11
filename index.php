<?php

session_start();

/
if (file_exists('db.php')) {
    require_once 'db.php';
    // Vai buscar os 4 produtos mais recentes
    $query = "SELECT * FROM products ORDER BY data_adicionado DESC LIMIT 4";
    $result = $conn->query($query);
} else {
    // Se o ficheiro não existir, cria um aviso para tu saberes
    die("Erro Crítico: O ficheiro config.php não foi encontrado na pasta atual.");
}
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

      <?php 
      // 3. Verificar se a consulta correu bem e se há produtos
      if(isset($result) && $result->num_rows > 0): 
          while($row = $result->fetch_assoc()): 
      ?>
          <div class="product reveal">
            <div class="hoodie-images">
              <img src="<?php echo $row['imagem_url']; ?>" alt="<?php echo $row['nome']; ?>">
            </div>
            <h3><?php echo $row['nome']; ?></h3>
            <p>€<?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
            
            <a href="produto.php?id=<?php echo $row['id']; ?>">
                <button class="view-btn">Ver Produto</button>
            </a>
          </div>
      <?php 
          endwhile; 
      else:
      ?>
          <p>A carregar coleções...</p>
      <?php endif; ?>

    </div>
  </section>

  <section id="about">
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
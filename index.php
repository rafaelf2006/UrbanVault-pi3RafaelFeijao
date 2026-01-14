<?php
session_start();

if (file_exists('db.php')) {
    require_once 'db.php';
} else {
    die("Erro Crítico: O ficheiro db.php não foi encontrado.");
}

$result = null;

try {
    $query = "SELECT * FROM produtos ORDER BY data_criacao DESC LIMIT 4";
    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception("Erro na query: " . $conn->error);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    $result = null;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrbanVault - Streetwear Exclusivo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Fix para o header */
        header {
            background: rgba(14, 14, 14, 0.98) !important;
            border-bottom: 1px solid #333;
        }

        .search-box input {
            background: #222 !important;
            border: 1px solid #444 !important;
            color: #fff !important;
            font-size: 0.95rem;
        }

        .search-box input::placeholder {
            color: #888;
        }

        nav ul {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        nav ul li {
            list-style: none;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s;
            text-transform: capitalize;
        }

        nav ul li a:hover {
            color: #D2BBA0;
        }

        .right-side a {
            color: #fff !important;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        .right-side a:hover {
            color: #D2BBA0 !important;
        }

        .right-side > div {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .logo {
            cursor: pointer;
        }

        .logo:hover {
            color: #D2BBA0;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="logo" onclick="window.location.href='index.php'">URBANVAULT</div>
        
        <div class="search-box">
            <input type="text" placeholder="Procurar produtos...">
        </div>
        
        <div class="right-side">
            <nav>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="#produtos">Produtos</a></li>
                    <li><a href="#sobre">Sobre</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </nav>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <div>
                    <a href="carrinho.php">🛒 Carrinho</a>
                    <a href="conta.php">👤 <?php echo htmlspecialchars($_SESSION['user_nome']); ?></a>
                    <a href="logout.php" style="color: #D2BBA0 !important; font-weight: 600;">Sair</a>
                </div>
            <?php else: ?>
                <div>
                    <a href="login.php">Login</a>
                    <a href="registo.php" style="color: #D2BBA0 !important; font-weight: 600;">Registar</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="hero" id="home">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Nova Coleção 2026</h1>
            <p>Streetwear exclusivo para quem tem estilo</p>
            <button onclick="document.querySelector('#produtos').scrollIntoView({behavior: 'smooth'})">Ver Produtos</button>
        </div>
    </section>

    <!-- PRODUTOS -->
    <section id="produtos">
        <h2 class="section-title">Produtos em Destaque</h2>
        
        <!-- DEBUG -->
        <?php
        echo "<!-- DEBUG INFO: ";
        echo "Result existe: " . ($result ? 'SIM' : 'NÃO') . " | ";
        if($result) {
            echo "Número de linhas: " . $result->num_rows . " | ";
        }
        echo "Query: " . $query;
        echo " -->";
        ?>
        
        <div class="products">
            
            <!-- PRODUTOS DA DB JÁ TÊM AS IMAGENS, NÃO PRECISAS DESTE CARD -->

            <!-- PRODUTOS DA BASE DE DADOS -->
            <?php
            if ($result && $result->num_rows > 0) {
                while($produto = $result->fetch_assoc()) {
                    // Buscar TODAS as imagens do produto (frente e trás)
                    $img_query = "SELECT caminho_imagem, principal FROM produto_imagens WHERE produto_id = ? ORDER BY ordem ASC";
                    $stmt = $conn->prepare($img_query);
                    $stmt->bind_param("i", $produto['id']);
                    $stmt->execute();
                    $img_result = $stmt->get_result();
                    
                    $imagens = [];
                    while($img = $img_result->fetch_assoc()) {
                        $imagens[] = $img;
                    }
                    
                    if(count($imagens) >= 2) {
                        // Tem frente e trás
                        $img_frente = $imagens[0]['caminho_imagem'];
                        $img_tras = $imagens[1]['caminho_imagem'];
                        ?>
                        <div class="product reveal" onclick="window.location.href='produto.php?id=<?php echo $produto['id']; ?>'" style="cursor: pointer;">
                            <div class="hoodie-images">
                                <img src="<?php echo htmlspecialchars($img_frente); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?> Frente">
                            </div>
                            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <p>€<?php echo number_format($produto['preco'], 2); ?></p>
                        </div>
                        <?php
                    } else {
                        // Tem só uma imagem
                        $caminho_imagem = $imagens[0]['caminho_imagem'] ?? 'images/produtos/placeholder.jpg';
                        ?>
                        <div class="product reveal" onclick="window.location.href='produto.php?id=<?php echo $produto['id']; ?>'" style="cursor: pointer;">
                            <div class="hoodie-images">
                                <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                            </div>
                            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <p>€<?php echo number_format($produto['preco'], 2); ?></p>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="sobre">
        <h2 class="section-title">Sobre a UrbanVault</h2>
        <div class="about-text">
            <p>
                A UrbanVault é uma marca de streetwear que combina estilo urbano com qualidade premium. 
                Cada peça é cuidadosamente desenhada para expressar a tua individualidade e atitude na rua.
            </p>
        </div>
    </section>

    <!-- CONTACTO -->
    <section id="contacto">
        <h2 class="section-title">Contacto</h2>
        <div class="about-text">
            <p>Email: info@urbanvault.pt</p>
            <p>Instagram: @urbanvault</p>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>&copy; 2026 UrbanVault. Todos os direitos reservados.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
<?php
if (isset($conn)) {
    $conn->close();
}
?>
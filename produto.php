<?php
session_start();
require_once 'db.php';

// Verificar se o ID do produto foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$produto_id = (int)$_GET['id'];

// Buscar informações do produto
$query = "SELECT p.*, c.nome as categoria_nome 
          FROM produtos p 
          LEFT JOIN categorias c ON p.categoria_id = c.id 
          WHERE p.id = ? AND p.ativo = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $produto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit;
}

$produto = $result->fetch_assoc();

// Buscar todas as imagens do produto
$img_query = "SELECT * FROM produto_imagens WHERE produto_id = ? ORDER BY ordem ASC";
$stmt = $conn->prepare($img_query);
$stmt->bind_param("i", $produto_id);
$stmt->execute();
$imagens_result = $stmt->get_result();
$imagens = [];
while($img = $imagens_result->fetch_assoc()) {
    $imagens[] = $img;
}

// Buscar tamanhos disponíveis
$stock_query = "SELECT DISTINCT tamanho, cor, quantidade FROM stock WHERE produto_id = ? AND quantidade > 0";
$stmt = $conn->prepare($stock_query);
$stmt->bind_param("i", $produto_id);
$stmt->execute();
$stock_result = $stmt->get_result();
$tamanhos = [];
$cores = [];
while($stock = $stock_result->fetch_assoc()) {
    if (!in_array($stock['tamanho'], $tamanhos)) {
        $tamanhos[] = $stock['tamanho'];
    }
    if (!in_array($stock['cor'], $cores)) {
        $cores[] = $stock['cor'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome']); ?> - UrbanVault</title>
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

        /* Estilos da página de produto */
        .produto-detalhes {
            max-width: 1400px;
            margin: 120px auto 50px;
            padding: 0 5%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .galeria-imagens {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .imagem-principal {
            width: 100%;
            height: 600px;
            background: #1b1b1b;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .imagem-principal img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: zoom-in;
        }

        .thumbnails {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
        }

        .thumbnail {
            min-width: 100px;
            height: 100px;
            background: #1b1b1b;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            border: 3px solid transparent;
            transition: 0.3s;
        }

        .thumbnail.active {
            border-color: #D2BBA0;
        }

        .thumbnail:hover {
            border-color: #fff;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-produto h1 {
            font-family: 'Oswald', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .preco {
            font-size: 2rem;
            color: #D2BBA0;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .preco-antigo {
            text-decoration: line-through;
            color: #777;
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .descricao {
            color: #ccc;
            line-height: 1.8;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #333;
        }

        .opcoes-grupo {
            margin-bottom: 2rem;
        }

        .opcoes-grupo label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .tamanhos, .cores-opcoes {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .tamanho-btn, .cor-btn {
            padding: 0.8rem 1.5rem;
            background: transparent;
            border: 2px solid #555;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .tamanho-btn:hover, .cor-btn:hover {
            border-color: #D2BBA0;
            background: rgba(210, 187, 160, 0.1);
        }

        .tamanho-btn.selected, .cor-btn.selected {
            background: #D2BBA0;
            color: #000;
            border-color: #D2BBA0;
        }

        .btn-adicionar-carrinho {
            width: 100%;
            padding: 1.2rem;
            background: #D2BBA0;
            border: none;
            color: #000;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-adicionar-carrinho:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(210, 187, 160, 0.3);
        }

        .btn-adicionar-carrinho:disabled {
            background: #555;
            color: #888;
            cursor: not-allowed;
            transform: none;
        }

        .info-extra {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #333;
            color: #aaa;
        }

        .info-extra div {
            margin-bottom: 0.8rem;
        }

        @media (max-width: 968px) {
            .produto-detalhes {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .imagem-principal {
                height: 400px;
            }
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
                    <li><a href="index.php#produtos">Produtos</a></li>
                    <li><a href="index.php#sobre">Sobre</a></li>
                    <li><a href="index.php#contacto">Contacto</a></li>
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

    <!-- DETALHES DO PRODUTO -->
    <div class="produto-detalhes">
        <!-- GALERIA DE IMAGENS -->
        <div class="galeria-imagens">
            <div class="imagem-principal" id="imagemPrincipal">
                <?php if (!empty($imagens)): ?>
                    <img src="<?php echo htmlspecialchars($imagens[0]['caminho_imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" id="imgPrincipal">
                <?php else: ?>
                    <img src="images/produtos/placeholder.jpg" alt="Sem imagem">
                <?php endif; ?>
            </div>

            <?php if (count($imagens) > 1): ?>
            <div class="thumbnails">
                <?php foreach($imagens as $index => $img): ?>
                    <div class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" onclick="trocarImagem('<?php echo htmlspecialchars($img['caminho_imagem']); ?>', this)">
                        <img src="<?php echo htmlspecialchars($img['caminho_imagem']); ?>" alt="Thumbnail">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- INFORMAÇÕES DO PRODUTO -->
        <div class="info-produto">
            <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
            
            <div class="preco">
                <?php if($produto['preco_promocional']): ?>
                    <span class="preco-antigo">€<?php echo number_format($produto['preco'], 2); ?></span>
                    <span>€<?php echo number_format($produto['preco_promocional'], 2); ?></span>
                <?php else: ?>
                    €<?php echo number_format($produto['preco'], 2); ?>
                <?php endif; ?>
            </div>

            <?php if($produto['descricao']): ?>
            <div class="descricao">
                <p><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
            </div>
            <?php endif; ?>

            <form id="formAdicionarCarrinho" method="POST" action="adicionar_carrinho.php">
                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">

                <?php if (!empty($tamanhos)): ?>
                <div class="opcoes-grupo">
                    <label>Tamanho:</label>
                    <div class="tamanhos">
                        <?php foreach($tamanhos as $tamanho): ?>
                            <button type="button" class="tamanho-btn" data-tamanho="<?php echo htmlspecialchars($tamanho); ?>" onclick="selecionarTamanho(this)">
                                <?php echo htmlspecialchars($tamanho); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="tamanho" id="tamanhoSelecionado" required>
                </div>
                <?php endif; ?>

                <?php if (!empty($cores)): ?>
                <div class="opcoes-grupo">
                    <label>Cor:</label>
                    <div class="cores-opcoes">
                        <?php foreach($cores as $cor): ?>
                            <button type="button" class="cor-btn" data-cor="<?php echo htmlspecialchars($cor); ?>" onclick="selecionarCor(this)">
                                <?php echo htmlspecialchars($cor); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="cor" id="corSelecionada" required>
                </div>
                <?php endif; ?>

                <button type="submit" class="btn-adicionar-carrinho" id="btnAdicionar" disabled>
                    Adicionar ao Carrinho
                </button>
            </form>

            <div class="info-extra">
                <?php if($produto['material']): ?>
                <div><strong>Material:</strong> <?php echo htmlspecialchars($produto['material']); ?></div>
                <?php endif; ?>
                <?php if($produto['cuidados']): ?>
                <div><strong>Cuidados:</strong> <?php echo htmlspecialchars($produto['cuidados']); ?></div>
                <?php endif; ?>
                <div><strong>Envio:</strong> Grátis para encomendas acima de €50</div>
                <div><strong>Devoluções:</strong> 30 dias para devolução ou troca</div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>&copy; 2026 UrbanVault. Todos os direitos reservados.</p>
    </footer>

    <script>
        // Trocar imagem principal
        function trocarImagem(src, elemento) {
            document.getElementById('imgPrincipal').src = src;
            
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            elemento.classList.add('active');
        }

        // Selecionar tamanho
        function selecionarTamanho(btn) {
            document.querySelectorAll('.tamanho-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            document.getElementById('tamanhoSelecionado').value = btn.dataset.tamanho;
            verificarSelecao();
        }

        // Selecionar cor
        function selecionarCor(btn) {
            document.querySelectorAll('.cor-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            document.getElementById('corSelecionada').value = btn.dataset.cor;
            verificarSelecao();
        }

        // Verificar se tamanho e cor foram selecionados
        function verificarSelecao() {
            const tamanho = document.getElementById('tamanhoSelecionado').value;
            const cor = document.getElementById('corSelecionada').value;
            const btn = document.getElementById('btnAdicionar');
            
            if (tamanho && cor) {
                btn.disabled = false;
            } else {
                btn.disabled = true;
            }
        }
    </script>
</body>
</html>
<?php
$conn->close();
?>
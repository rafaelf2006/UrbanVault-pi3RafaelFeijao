document.addEventListener("DOMContentLoaded", () => {

  const produtos = [
    { id: 1, name: "Hoodie UrbanVault", price: 79.99, img: "https://images.unsplash.com/photo-1520975918318-3e58d7ed3694?auto=format&fit=crop&w=800&q=80", categoria: "Hoddies" },
    { id: 2, name: "T-shirt Signature", price: 30.99, img: "https://images.unsplash.com/photo-1520974735194-56f34a4b1a6f?auto=format&fit=crop&w=800&q=80", categoria: "T-shirt" },
    { id: 3, name: "Pants", price: 39.99, img: "https://images.unsplash.com/photo-1520974735194-56f34a4b1a6f?auto=format&fit=crop&w=800&q=80", categoria: "Pants" },
  ];

  const produtosContainer = document.getElementById("produtos-container");
  const filtroSelect = document.getElementById("filtro");
  const searchInput = document.getElementById("search");
  const cartCountDisplay = document.getElementById("cart-count");

  if (!produtosContainer || !filtroSelect || !searchInput || !cartCountDisplay) {
    console.error("Faltam elementos no HTML ou IDs incorretos.");
    return;
  }

  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  atualizarContador();

  function atualizarContador() {
    cartCountDisplay.textContent = cart.length;
  }

  function guardarCarrinho() {
    localStorage.setItem("cart", JSON.stringify(cart));
    atualizarContador();
  }

  function criarProdutoCard(produto) {
    const card = document.createElement("div");
    card.className = "product";
    card.innerHTML = `
      <img src="${produto.img}" alt="${produto.name}">
      <h3>${produto.name}</h3>
      <p>€${produto.price.toFixed(2)}</p>
      <button type="button">Adicionar ao Carrinho</button>
    `;

    const btn = card.querySelector("button");
    btn.addEventListener("click", () => {
      cart.push(produto);
      guardarCarrinho();

      btn.textContent = "✅ Adicionado!";
      btn.style.background = "#27ae60";
      btn.disabled = true;
      setTimeout(() => {
        btn.textContent = "Adicionar ao Carrinho";
        btn.style.background = "#ff4141";
        btn.disabled = false;
      }, 1000);
    });

    return card;
  }

  function renderizarProdutos(lista) {
    produtosContainer.innerHTML = "";
    if (lista.length === 0) {
      produtosContainer.innerHTML = `<p style="grid-column: 1/-1; text-align:center; color:#aaa;">Nenhum produto encontrado.</p>`;
      return;
    }
    const fragment = document.createDocumentFragment();
    lista.forEach(p => fragment.appendChild(criarProdutoCard(p)));
    produtosContainer.appendChild(fragment);
  }

  function aplicarFiltros() {
    const termo = searchInput.value.toLowerCase();
    const categoria = filtroSelect.value;

    const filtrados = produtos.filter(p => {
      const matchCategoria = categoria === "todos" || p.categoria === categoria;
      const matchTermo = p.name.toLowerCase().includes(termo);
      return matchCategoria && matchTermo;
    });

    renderizarProdutos(filtrados);
  }

  filtroSelect.addEventListener("change", aplicarFiltros);
  searchInput.addEventListener("input", aplicarFiltros);

  aplicarFiltros();
});

function atualizarContador() {
  cartCountDisplay.textContent = cart.length;
  cartCountDisplay.classList.add("bounce");
  setTimeout(() => cartCountDisplay.classList.remove("bounce"), 300);
}
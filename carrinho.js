document.addEventListener("DOMContentLoaded", () => {
  const carrinhoContainer = document.getElementById("carrinho-container");
  const totalDisplay = document.getElementById("total");
  const checkoutBtn = document.getElementById("checkout-btn");
  const cartCountDisplay = document.getElementById("cart-count");

  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  atualizarContador();

  function atualizarContador() {
    cartCountDisplay.textContent = cart.length;
  }

  function guardarCarrinho() {
    localStorage.setItem("cart", JSON.stringify(cart));
    atualizarContador();
  }

  function calcularTotal() {
    const total = cart.reduce((sum, item) => sum + item.price, 0);
    totalDisplay.textContent = total.toFixed(2);
  }

  function renderizarCarrinho() {
    carrinhoContainer.innerHTML = "";
    if (cart.length === 0) {
      carrinhoContainer.innerHTML = `<p style="color:#aaa;">O carrinho está vazio.</p>`;
      totalDisplay.textContent = "0.00";
      return;
    }

    cart.forEach((item, index) => {
      const div = document.createElement("div");
      div.className = "carrinho-item";
      div.innerHTML = `
        <img src="${item.img}" alt="${item.name}">
        <h3>${item.name}</h3>
        <p>€${item.price.toFixed(2)}</p>
        <button>Remover</button>
      `;

      div.querySelector("button").addEventListener("click", () => {
        cart.splice(index, 1);
        guardarCarrinho();
        renderizarCarrinho();
        calcularTotal();
      });

      carrinhoContainer.appendChild(div);
    });

    calcularTotal();
  }

  checkoutBtn.addEventListener("click", () => {
    if(cart.length === 0){
      alert("O carrinho está vazio!");
      return;
    }
    alert("Compra finalizada com sucesso!");
    cart = [];
    guardarCarrinho();
    renderizarCarrinho();
  });

  renderizarCarrinho();
});

function atualizarContador() {
  cartCountDisplay.textContent = cart.length;
  cartCountDisplay.classList.add("bounce");
  setTimeout(() => cartCountDisplay.classList.remove("bounce"), 300);
}
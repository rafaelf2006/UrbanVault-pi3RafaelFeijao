document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.getElementById("theme-toggle");
  if(!toggle) return;

  // Inicializa tema
  if(localStorage.getItem("theme") === "light") {
    document.body.classList.add("light");
  }

  toggle.addEventListener("click", () => {
    document.body.classList.toggle("light");
    localStorage.setItem("theme", document.body.classList.contains("light") ? "light" : "dark");
  });
});

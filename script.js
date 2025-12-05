document.addEventListener('DOMContentLoaded', () => {

  // --- Efeito de scroll suave ---
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      if (targetId.startsWith('#') && targetId.length > 1) {
        e.preventDefault();
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          targetElement.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });

  // --- Scroll Reveal Animation ---
  const reveals = document.querySelectorAll('.reveal');

  window.addEventListener('scroll', () => {
    const triggerBottom = window.innerHeight * 0.8;
    reveals.forEach(r => {
      const top = r.getBoundingClientRect().top;
      if (top < triggerBottom) {
        r.classList.add('active');
      }
    });
  });

  // ==========================================
  // LÓGICA DO HOODIE
  // ==========================================
  const hoodieImages = {
    black: { front: "mockupsUV/hoodie_black_front.png", back: "mockupsUV/hoodie_black_back.png" },
    white: { front: "mockupsUV/hoodie_white_front.png", back: "mockupsUV/hoodie_white_back.png" },
    green: { front: "mockupsUV/hoodie_green_front.png", back: "mockupsUV/hoodie_green_back.png" },
    wine:  { front: "mockupsUV/hoodie_wine_front.png",  back: "mockupsUV/hoodie_wine_back.png" },
  };

  // Variáveis de estado
  let currentHoodieColor = 'black';
  let currentHoodieView = 'front';

  // Função para atualizar as imagens do Hoodie no DOM
  window.updateHoodieImages = function() {
    const frontImg = document.getElementById('hoodie-front');
    const backImg = document.getElementById('hoodie-back');

    if(!frontImg || !backImg) return; // Evita erro se o elemento não existir

    frontImg.src = hoodieImages[currentHoodieColor].front;
    backImg.src = hoodieImages[currentHoodieColor].back;

    if(currentHoodieView === 'front') {
      frontImg.classList.add('active');
      backImg.classList.remove('active');
    } else {
      frontImg.classList.remove('active');
      backImg.classList.add('active');
    }
  };

  // Funções acessíveis pelo onclick do HTML
  window.changeHoodieColor = function(color) {
    currentHoodieColor = color;
    updateHoodieImages();
  };

  window.showFront = function() {
    currentHoodieView = 'front';
    updateHoodieImages();
  };

  window.showBack = function() {
    currentHoodieView = 'back';
    updateHoodieImages();
  };

  // Inicializar Hoodie
  updateHoodieImages();


  // ==========================================
  // LÓGICA DA T-SHIRT (Para recuperar o card)
  // ==========================================
  // Nota: Tens de ter as imagens com estes nomes na pasta mockupsUV ou ajustar aqui
  const tshirtImages = {
    black: { front: "mockupsUV/tshirt_black_front.png", back: "mockupsUV/tshirt_black_back.png" },
    white: { front: "mockupsUV/tshirt_white_front.png", back: "mockupsUV/tshirt_white_back.png" },
  };

  let currentTshirtColor = 'black';
  let currentTshirtView = 'front';

  window.updateTshirtImages = function() {
    const frontImg = document.getElementById('tshirt-front');
    const backImg = document.getElementById('tshirt-back');

    if(!frontImg || !backImg) return; 

    frontImg.src = tshirtImages[currentTshirtColor].front;
    backImg.src = tshirtImages[currentTshirtColor].back;

    if(currentTshirtView === 'front') {
      frontImg.classList.add('active');
      backImg.classList.remove('active');
    } else {
      frontImg.classList.remove('active');
      backImg.classList.add('active');
    }
  };

  window.changeTshirtColor = function(color) {
    currentTshirtColor = color;
    updateTshirtImages();
  };

  window.showTshirtFront = function() {
    currentTshirtView = 'front';
    updateTshirtImages();
  };

  window.showTshirtBack = function() {
    currentTshirtView = 'back';
    updateTshirtImages();
  };

  // Inicializar T-shirt
  updateTshirtImages();

});
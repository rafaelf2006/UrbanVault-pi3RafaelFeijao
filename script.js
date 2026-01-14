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
  // LÓGICA DO HOODIE - CAMINHOS CORRETOS
  // ==========================================
  const hoodieImages = {
    black: { 
      front: "mockupsUV/blackuv/blackfront_uv.png", 
      back: "mockupsUV/blackuv/blackback_uv.png" 
    },
    white: { 
      front: "mockupsUV/whiteuv/whitefront_uv.png", 
      back: "mockupsUV/whiteuv/whiteback_uv.png" 
    },
    green: { 
      front: "mockupsUV/greenuv/greenfront_uv.png", 
      back: "mockupsUV/greenuv/greenback_uv.png" 
    },
    wine: { 
      front: "mockupsUV/wineuv/winefront_uv.png", 
      back: "mockupsUV/wineuv/wineback_uv.png" 
    },
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

  // FUNÇÃO PARA TOGGLE FRONT/BACK - USA INLINE STYLES
  window.toggleView = function(produtoId, view) {
    var frontImg = document.getElementById('produto-' + produtoId + '-front');
    var backImg = document.getElementById('produto-' + produtoId + '-back');
    
    if(!frontImg || !backImg) return;
    
    if(view === 'front') {
      frontImg.style.display = 'block';
      backImg.style.display = 'none';
    } else {
      frontImg.style.display = 'none';
      backImg.style.display = 'block';
    }
  };

});
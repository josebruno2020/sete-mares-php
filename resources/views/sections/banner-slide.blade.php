<section id="inicio"
  class="banner-slider h-[80vh] md:h-[90vh] flex flex-col gap-2 items-center justify-center relative overflow-hidden">
  <!-- Background Images -->
  <div id="image-container">
    <div class="banner-image active absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-50"
      style="background-image: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)), url('/img/alunos_2.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    </div>
    <div class="banner-image absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0"
      style="background-image: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)), url('/img/sala_aula.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    </div>
    <div class="banner-image absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0"
      style="background-image: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)), url('/img/fundo_banner.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    </div>
  </div>

  <!-- Content Overlay -->
  <div class="relative z-10 flex flex-col gap-5 items-center justify-center h-full">
    <div>
      <img class="w-[350px] md:w-[500px]" alt="Sete Mares" src="/img/logo_azul_sem_fundo.webp">
    </div>
    <p class="text-lg md:text-2xl text-center text-gray-800 font-bold max-w-3xl px-6 bg-white/70 p-4 rounded-lg"
      style="color: #3871c1">
      Educação Personalizada em Maringá
    </p>
    <x-button
      text="CONHEÇA NOSSA PROPOSTA"
      href="#sobre"
      class="" />
  </div>

  <!-- Navigation Arrows -->
  <button id="prev-btn"
    class="hidden md:block absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition-all duration-300 backdrop-blur-sm"
    aria-label="Imagem anterior">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
    </svg>
  </button>

  <button id="next-btn"
    class="hidden md:block absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition-all duration-300 backdrop-blur-sm"
    aria-label="Próxima imagem">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
  </button>

  <!-- Dots Indicator -->
  <div id="dots-container" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex space-x-3">
    <button class="dot active w-3 h-3 rounded-full transition-all duration-300 bg-white shadow-lg" data-slide="0"
      aria-label="Ir para imagem 1"></button>
    <button class="dot w-3 h-3 rounded-full transition-all duration-300 bg-white/50 hover:bg-white/70" data-slide="1"
      aria-label="Ir para imagem 2"></button>
    <button class="dot w-3 h-3 rounded-full transition-all duration-300 bg-white/50 hover:bg-white/70" data-slide="2"
      aria-label="Ir para imagem 3"></button>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
  // Banner slider otimizado
  const initBannerSlider = () => {
    const images = document.querySelectorAll('.banner-image');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const bannerSlider = document.querySelector('.banner-slider');

    if (!images.length || !dots.length || !prevBtn || !nextBtn || !bannerSlider) return;

    let currentImage = 0;
    let autoSlideInterval;
    let isTransitioning = false;

    // Cache das classes para melhor performance
    const CLASSES = {
      OPACITY_0: 'opacity-0',
      OPACITY_50: 'opacity-50',
      ACTIVE: 'active',
      BG_WHITE: 'bg-white',
      SHADOW_LG: 'shadow-lg',
      BG_WHITE_50: 'bg-white/50'
    };

    // Função otimizada para mostrar slide
    const showSlide = (index) => {
      if (isTransitioning || index === currentImage) return;

      isTransitioning = true;

      // Batch DOM operations usando requestAnimationFrame
      requestAnimationFrame(() => {
        // Update images
        images.forEach((img, i) => {
          const classList = img.classList;
          if (i === index) {
            classList.remove(CLASSES.OPACITY_0);
            classList.add(CLASSES.OPACITY_50, CLASSES.ACTIVE);
          } else {
            classList.remove(CLASSES.OPACITY_50, CLASSES.ACTIVE);
            classList.add(CLASSES.OPACITY_0);
          }
        });

        // Update dots
        dots.forEach((dot, i) => {
          const classList = dot.classList;
          if (i === index) {
            classList.add(CLASSES.ACTIVE, CLASSES.BG_WHITE, CLASSES.SHADOW_LG);
            classList.remove(CLASSES.BG_WHITE_50);
          } else {
            classList.remove(CLASSES.ACTIVE, CLASSES.BG_WHITE, CLASSES.SHADOW_LG);
            classList.add(CLASSES.BG_WHITE_50);
          }
        });

        currentImage = index;

        // Allow next transition after animation completes
        setTimeout(() => {
          isTransitioning = false;
        }, 300);
      });
    };

    // Navegação otimizada
    const nextSlide = () => showSlide((currentImage + 1) % images.length);
    const prevSlide = () => showSlide((currentImage - 1 + images.length) % images.length);

    // Auto-slide com debounce
    const startAutoSlide = () => {
      if (autoSlideInterval) clearInterval(autoSlideInterval);
      autoSlideInterval = setInterval(nextSlide, 6000);
    };

    const stopAutoSlide = () => {
      if (autoSlideInterval) {
        clearInterval(autoSlideInterval);
        autoSlideInterval = null;
      }
    };

    const restartAutoSlide = () => {
      stopAutoSlide();
      startAutoSlide();
    };

    // Event listeners otimizados
    const addEventListeners = () => {
      nextBtn.addEventListener('click', () => {
        nextSlide();
        restartAutoSlide();
      }, { passive: true });

      prevBtn.addEventListener('click', () => {
        prevSlide();
        restartAutoSlide();
      }, { passive: true });

      // Dots com event delegation
      dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
          showSlide(index);
          restartAutoSlide();
        }, { passive: true });
      });

      // Pause/resume com throttle
      let hoverTimeout;
      bannerSlider.addEventListener('mouseenter', () => {
        clearTimeout(hoverTimeout);
        stopAutoSlide();
      }, { passive: true });

      bannerSlider.addEventListener('mouseleave', () => {
        clearTimeout(hoverTimeout);
        hoverTimeout = setTimeout(startAutoSlide, 100);
      }, { passive: true });

      // Pause em visibility change
      document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
          stopAutoSlide();
        } else {
          startAutoSlide();
        }
      }, { passive: true });
    };

    // Initialize
    addEventListeners();
    startAutoSlide();

    // Cleanup function
    return () => {
      stopAutoSlide();
      // Remove event listeners if needed
    };
  };
  initBannerSlider();
});
</script>
@endpush
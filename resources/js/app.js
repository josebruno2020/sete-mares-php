import './bootstrap';

function contactForm() {
  const form = document.getElementById('contact-form');
  const submitBtn = document.getElementById('submit-btn');
  const btnText = document.getElementById('btn-text');
  const btnLoading = document.getElementById('btn-loading');
  const phoneInput = document.getElementById('phone');
  const feedbackMessage = document.getElementById('feedback-message');
  const feedbackText = document.getElementById('feedback-text');
  const successIcon = document.getElementById('success-icon');
  const errorIcon = document.getElementById('error-icon');

  let turnstileStatus = 'required';
  let turnstileToken = null;

  // Turnstile callbacks
  window.turnstileOnSuccess = function (token) {
    turnstileStatus = 'success';
    turnstileToken = token;
  };

  window.turnstileOnError = function (err) {
    console.error('Turnstile error:', err);
    turnstileStatus = 'error';
    showMessage('A verificação de segurança falhou. Por favor, tente novamente.', 'error');
  };

  window.turnstileOnExpire = function () {
    turnstileStatus = 'expired';
    turnstileToken = null;
    showMessage('A verificação de segurança expirou. Por favor, tente novamente.', 'error');
  };

  window.turnstileOnLoad = function () {
    turnstileStatus = 'required';
    turnstileToken = null;
  };

  // Formatação do telefone
  phoneInput.addEventListener('input', function (e) {
    const digits = e.target.value.replace(/\D/g, '');
    const match = digits.match(/(\d{0,2})(\d{0,5})(\d{0,4})/);

    if (!match || !match[2]) {
      e.target.value = match?.[1] || '';
    } else {
      const [, area, prefix, suffix] = match;
      e.target.value = `(${area}) ${prefix}${suffix ? '-' + suffix : ''}`;
    }
  });

  function showMessage(text, type) {
    feedbackText.textContent = text;
    feedbackMessage.classList.remove('hidden', 'text-gray-600', 'text-red-700', 'border-gray-300');

    if (type === 'success') {
      feedbackMessage.classList.add('text-gray-600', 'border-gray-300');
      successIcon.classList.remove('hidden');
      errorIcon.classList.add('hidden');
    } else {
      feedbackMessage.classList.add('text-red-700', 'border-gray-300');
      errorIcon.classList.remove('hidden');
      successIcon.classList.add('hidden');
    }
  }

  function hideMessage() {
    feedbackMessage.classList.add('hidden');
    successIcon.classList.add('hidden');
    errorIcon.classList.add('hidden');
  }

  function setLoading(loading) {
    submitBtn.disabled = loading;
    if (loading) {
      submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
      submitBtn.classList.remove('default-button');
      btnText.classList.add('hidden');
      btnLoading.classList.remove('hidden');
      btnLoading.classList.add('flex');
    } else {
      submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
      submitBtn.classList.add('default-button');
      btnText.classList.remove('hidden');
      btnLoading.classList.add('hidden');
      btnLoading.classList.remove('flex');
    }
  }

  // Submissão do formulário
  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    hideMessage();
    setLoading(true);

    // Verificar Turnstile
    if (turnstileStatus !== 'success') {
      showMessage('Por favor, complete a verificação de segurança.', 'error');
      setLoading(false);
      return;
    }

    const formData = new FormData(form);
    const data = {
      name: formData.get('name'),
      email: formData.get('email'),
      phone: formData.get('phone'),
      message: formData.get('message'),
      token: turnstileToken,
      _token: formData.get('_token'),
    };

    try {
      const response = await fetch('/contact', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      if (response.ok) {
        showMessage('Mensagem enviada com sucesso! Entraremos em contato em breve.', 'success');
        form.reset();
        // Reset Turnstile
        if (window.turnstile) {
          window.turnstile.reset();
        }
        turnstileStatus = 'required';
        turnstileToken = null;
      } else {
        showMessage(result.message || 'Erro ao enviar mensagem. Tente novamente.', 'error');
      }
    } catch (error) {
      showMessage('Erro de conexão. Verifique sua internet e tente novamente.', 'error');
      console.error('Fetch error:', error);
    } finally {
      setLoading(false);
    }
  });
}

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

document.addEventListener('DOMContentLoaded', function () {
  initBannerSlider();
  contactForm();
});
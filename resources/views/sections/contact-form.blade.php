<?php
// Verificar se há mensagem de feedback
$message = '';
$messageType = '';
if (isset($_SESSION['contact_message'])) {
  $message = $_SESSION['contact_message']['text'];
  $messageType = $_SESSION['contact_message']['type'];
  unset($_SESSION['contact_message']);
}
?>

<section id="contato" class="contact bg-gray-50 py-16">
  <div class="container mx-auto px-6 max-w-6xl">
    <div class="text-center mb-12">
      <h2 class="font-cinzel text-3xl font-bold text-gray-800 mb-4">
        Entre em Contato
      </h2>
      <p class="text-gray-600">
        Estamos aqui para esclarecer suas dúvidas
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-12">
      <!-- Contact Form -->
      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h3 class="font-cinzel text-xl font-semibold mb-6">
          Envie sua mensagem
        </h3>

        <!-- Mensagem de Feedback -->
        <div id="feedback-message" class="mb-4 p-4 rounded-lg hidden">
          <div class="flex items-center gap-3">
            <svg id="success-icon" class="w-5 h-5 mr-2 hidden" fill="green" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd" />
            </svg>
            <svg id="error-icon" class="w-5 h-5 mr-2 hidden" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd" />
            </svg>
            <span id="feedback-text" class="text-sm font-medium"></span>
          </div>
        </div>

        <form class="space-y-4" id="contact-form">
          @csrf
          <div>
            <label for="name" class="font-cinzel block text-sm font-medium text-gray-700 mb-1">
              Nome completo
            </label>
            <input type="text" id="name" name="name"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-primary"
              placeholder="Seu nome completo" required />
          </div>

          <div>
            <label for="email" class="font-cinzel block text-sm font-medium text-gray-700 mb-1">
              E-mail
            </label>
            <input type="email" id="email" name="email"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-primary"
              placeholder="seu@email.com" required />
          </div>

          <div>
            <label for="phone" class="font-cinzel block text-sm font-medium text-gray-700 mb-1">
              Telefone
            </label>
            <input type="tel" id="phone" name="phone" maxlength="15"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-primary"
              placeholder="(44) 99999-9999" required />
          </div>

          <div>
            <label for="message" class="font-cinzel block text-sm font-medium text-gray-700 mb-1">
              Mensagem
            </label>
            <textarea id="message" rows="4" name="message"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-primary"
              placeholder="Como podemos ajudar?" required></textarea>
          </div>

          <!-- Cloudflare Turnstile -->
          <div class="cf-turnstile" 
               data-sitekey="{{ config('services.turnstile.site_key') }}"
               data-theme="light" 
               data-retry="auto" 
               data-refresh-expired="auto" 
               data-callback="turnstileOnSuccess"
               data-error-callback="turnstileOnError" 
               data-expired-callback="turnstileOnExpire"
               data-load-callback="turnstileOnLoad">
          </div>

          <button type="submit"
            class="font-cinzel w-full py-3 px-6 rounded-md font-medium cursor-pointer transition-all default-button text-white"
            id="submit-btn">
            <span id="btn-text">Enviar Mensagem</span>
            <span id="btn-loading" class="hidden items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
              Enviando...
            </span>
          </button>
        </form>
      </div>

      <!-- Contact Info & Map -->
      <div class="space-y-8">
        <div class="bg-white p-8 rounded-lg shadow-lg">
          <h3 class="font-cinzel text-xl font-semibold mb-6">
            Informações de Contato
          </h3>
          <div class="space-y-4">
            <div class="flex items-center border-b border-gray-300 pb-1">
              <a href="{{ htmlspecialchars(config('links.maps')) }}" class="flex items-center" target="_blank">
                <svg class="w-5 h-5 text-blue-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                    clip-rule="evenodd" />
                </svg>
                <span>Maringá, PR</span>
              </a>
            </div>
            <div class="flex items-center border-b border-gray-300 pb-1">
              <a href="tel:+5544998475257" class="flex items-center">
                <svg class="w-5 h-5 text-blue-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>
                <span>(44) 99847-5257</span>
              </a>
            </div>
            <div class="flex items-center border-b border-gray-300 pb-1">
              <a href="mailto:secretaria@colegiosetemares.com.br" class="flex items-center">
                <svg class="w-5 h-5 text-blue-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
                <span>secretaria@colegiosetemares.com.br</span>
              </a>
            </div>
          </div>
          <!-- Social Media -->
          <div class="flex items-center justify-center w-full gap-3">
            <div class="social-icon">
              <a href="{{ htmlspecialchars(config('links.instagram')) }}" target="_blank"
                rel="noopener noreferrer">
                <x-svg icon="instagram" />
              </a>
            </div>
            <div class="social-icon">
              <a href="{{ htmlspecialchars(config('links.facebook')) }}" target="_blank" rel="noopener noreferrer">
                <x-svg icon="facebook" />
              </a>
            </div>
          </div>
        </div>

        <!-- Map -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-80">
          <iframe class="w-full h-full"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3661.2684178965505!2d-51.930933888311664!3d-23.414669056132897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ecd184f54e7ac5%3A0x144c183952dd7ea8!2sCol%C3%A9gio%20Sete%20Mares!5e0!3m2!1sen!2sbr!4v1756949568626!5m2!1sen!2sbr"
            style="border: 0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            title="Localização do Colégio Sete Mares">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
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
});
</script>
@endpush
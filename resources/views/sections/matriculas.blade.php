<section class="py-8 min-h-[80vh] flex items-center">
  <div class="container mx-auto px-6 max-w-10xl w-full">
    <div class="grid md:grid-cols-2 gap-12 md:gap-24 items-center h-full">
      <article class="flex flex-col justify-center items-center h-full">
        <h2 class="cinzelFont uppercase text-2xl md:text-4xl text-center text-blue-primary mb-2">
          Escola Sete Mares
        </h2>
        {{-- <p class="font-cinzel uppercase text-sm md:text-base tracking-wide text-blue-secondary mb-4">Matrículas abertas 2026!</p> --}}
        <div class="matriculas section-p">
          <x-text
            text="Se você busca uma escola que caminha ao lado da sua família, com valores sólidos e um olhar integral para cada aluno, convidamos você a conhecer de perto o Sete Mares."
            align="justify"
            fontSize="text-lg md:text-xl"
          />
          <x-text
            text="Nossa missão é acompanhar cada criança de forma individual e integral, buscando desenvolver suas dimensões fundamentais: intelectual, física, afetivo, social e transcendente."
            align="justify"
            fontSize="text-lg md:text-xl"
          />
          <x-text
            text="Esse propósito só é possível quando existe uma unidade educativa: onde os valores vividos em casa são fortalecidos e cultivados no ambiente escolar."
            align="justify"
            fontSize="text-lg md:text-xl"
          />
          <x-text
            text="No Sete Mares, a família é o centro e o porto seguro de toda a jornada educativa."
            align="justify"
            fontSize="text-lg md:text-xl"
          />
        </div>
        <div class="mt-10">
          <x-button text="AGENDAR UMA VISITA" href="{{ config('links.calendar') }}" target="_blank" />
        </div>
      </article>
      <article class="flex justify-center items-center h-full">
        <img class="w-[100%] max-w-lg rounded-lg shadow-xl" src="/img/aluno.webp" alt="Aluno da Escola Sete Mares"
          loading="lazy" width="520" height="350" />
      </article>
    </div>
  </div>
</section>

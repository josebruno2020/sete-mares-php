<section class="py-8 min-h-[80vh] flex items-center">
  <div class="container mx-auto px-6 max-w-10xl w-full">
    <div class="grid md:grid-cols-2 gap-12 md:gap-24 items-center h-full">
      <article class="flex flex-col justify-center items-center h-full">
        <h2 class="cinzelFont uppercase text-2xl md:text-4xl text-center text-blue-primary mb-4">
          Matrículas abertas 2026!
        </h2>
        <div class="matriculas section-p">
          <x-text
            text="Se você procura uma escola que caminha ao lado da sua família, com valores sólidos e um olhar integral para cada criança, te convidamos a conhecer de perto o Sete Mares."
            align="justify"
            fontSize="text-lg md:text-xl"
          />
          <x-text
            text="Em 2026, além da Educação Infantil, teremos também o"
            :bold-words="['Educação', 'Infantil', '1º', 'ano', 'do', 'Ensino', 'Fundamental.']"
            align="center"
            fontSize="text-lg md:text-xl"
          />
          <x-text
            text="1º ano do Ensino Fundamental."
            :bold-words="['Educação', 'Infantil', '1º', 'ano', 'do', 'Ensino', 'Fundamental.']"
            align="center"
            fontSize="text-lg md:text-xl"
          />
          <x-text
            text="É mais um passo na missão de caminhar ao lado das famílias, oferecendo uma Educação Personalizada em um ambiente seguro e acolhedor!"
            align="justify"
            fontSize="text-lg md:text-xl"
          />
          <x-text
            text="Agende sua visita e venha conhecer"
            align="center"
            fontSize="text-lg md:text-xl"
          />
          <x-text
            text="nosso projeto pedagógico."
            align="center"
            fontSize="text-lg md:text-xl"
          />
        </div>
        <div class="mt-10">
          <x-button text="AGENDAR UMA VISITA" href="{{ config('links.calendar') }}" target="_blank" />
        </div>
      </article>
      <article class="flex justify-center items-center h-full">
        <img class="w-[100%] max-w-lg rounded-lg" src="/img/aluno.webp" alt="Colégio Sete Mares logo"
          loading="lazy" width="520" height="350" />
      </article>
    </div>
  </div>
</section>
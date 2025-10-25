<section id="sobre" class="py-10 bg-gray-50">
  <div class="container mx-auto px-6 max-w-6xl">
    <div class="text-center mb-16">
      <h2 class="cinzelFont uppercase text-xl text-blue-primary mb-4">
        A FAMÍLIA NO CENTRO DA EDUCAÇÃO
      </h2>
      <h2 class="cinzelFont text-3xl md:text-4xl font-bold text-gray-800 mb-6">
        Educação Personalizada
      </h2>
      <x-text
        text="Um lugar fruto da união de pais e educadores que têm uma profunda preocupação com a formação das crianças em todas as suas fases de desenvolvimento."
        align="center"
        fontSize="text-lg md:text-xl"
      />
    </div>

    <!-- Values Cards -->
    <div id="valores" class="section-p grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
      <x-valor-card
        image="/img/alunos.webp"
        title="FORMAÇÃO HUMANA INTEGRAL"
      >
        <x-text
          text="Nossa missão é colaborar com os pais na formação integral de seus filhos. Aqui, cada criança é única e cuidada com intencionalidade, vivendo a educação como uma jornada que abraça todas as dimensões do ser humano."
          align="justify"
        />
        <x-text
          text="Acreditamos que isso é possível por meio de um verdadeiro trabalho em conjunto: aluno, pais e professores."
          align="justify"
        />
      </x-valor-card>
      <x-valor-card
        image="/img/maes_1.webp"
        title="FAMÍLIA NO CENTRO DA EDUCAÇÃO"
      >
        <x-text
          text="Entendemos que a participação ativa dos pais na vida escolar de seus filhos é um pilar fundamental em uma educação de excelência."
          align="justify"
        />
        <x-text
          text="Nosso intuito é ser uma extensão da sua família: um lugar onde o seu filho continuará desenvolvendo os valores aprendidos em casa, inserindo a criança em uma comunidade educativa coesa."
          align="justify"
        />
      </x-valor-card>
      <x-valor-card
        image="/img/cristaos_1.webp"
        title="IDENTIDADE CRISTÃ"
      >
        <x-text
          text="A prática educacional pautada nos valores cristãos visa oferecer às crianças as ferramentas necessárias para uma vida plena e significativa, promovendo o seu desenvolvimento completo."
          align="justify"
        />
        <x-text
          text="Na educação cristã, buscamos a formação integral do ser humano e vamos além dos conhecimentos acadêmicos. Queremos preparar as crianças para uma vida que reflete os valores eternos da bondade, da beleza e da verdade!"
          align="justify"
        />
      </x-valor-card>
    </div>
    <div class="text-center">
      <x-button text="QUERO SABER MAIS" href="#contato" />
    </div>
  </div>
</section>
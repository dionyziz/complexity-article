<?php
    ob_start();
?>
        <h1 id='gentle'>Uma introdução gentil a análise de complexidade de algoritmos</h1>
        Dionysis "dionyziz" Zindros &lt;<a href='mailto:dionyziz@gmail.com'>dionyziz@gmail.com</a>&gt;<br />
        Jefferson Carvalho &lt;<a href='mailto:jeffersonhcarvalho@gmail.com'>jeffersonhcarvalho@gmail.com</a>&gt;

        <?= $translations ?>

        <h2 id='intro'>Introdução</h2>
        <p>Vários dos programadores que fazem alguns dos softwares mais úteis e legais que temos hoje, como muitas coisas que vemos na internet ou usamos no nosso dia a dia, não possuem um conhecimento teórico de ciência da computação. Mesmo assim, eles são programadores excelentes e muito criativos, e agradecemos a eles pelo o que eles construíram.</p>

        <p>Entretanto, a parte teórica da ciência da computação tem os seus usos e aplicações, e pode ser bastante prática. Neste artigo, direcionado para programadores que "conhecem a sua arte" mas não tem um background teórico de ciência da computação, irei apresentar uma das ferramentas mais pragmáticas da ciência da computação: a notação Big O e a análise de complexidade de algoritmos. Como alguém que trabalhou tanto na parte acadêmica de ciência da computação quanto no mercado de desenvolvimento de software para produção, essa é uma daquelas ferramentas que eu descobri ser uma das que são realmente úteis na prática, então eu espero que depois de ler este artigo, você possa aplicá-la no seu próprio código para fazê-lo melhor. Depois de ler este post, você deverá ser capaz de entender todos os termos comuns que cientistas da computação usam, como "big O", "comportamento assintótico" e "análise do pior caso".</p>

        <p>Este texto também é direcionado para estudantes do ensino médio que competem na Olimpíada Internacional de Informática, uma competição de algoritmos para estudantes, ou outras competições similares. Assim sendo, ele não possui pré-requisitos em matemática e vai te dar a base necessária para que você continue estuando algoritmos com um entendimento mais sólido da teoria por trás deles. Como alguém que participava dessas competições, eu aconselho fortemente que você leia todo este material introdutório e o entenda por completo, porque vai ser necessário quando você estudar algoritmos e aprender técnicas mais avançadas.</p>

        <p>Eu acredito que esse texto será útil para programadores da indústria de software que não tem muita experiência com a parte teórica da ciência da computação(é um fato de que alguns dos mais inspiradores engenheiros de software nunca fizeram uma faculdade). Mas pelo fato de que ele também é para estudantes, as vezes ele pode parecer didático demais. Além disso, alguns dos tópicos neste texto podem parecer muito óbvios para você; por exemplo, você deve tê-los visto durante o ensino médio. Se você já conhecer esses assuntos, você pode pulá-los. Outras partes vão ser um pouco mais profundas e se tornar um pouco mais teóricas, pois estudantes que participam dessas competições vão precisar saber mais sobre algorítimos teóricos do que a maioria das pessoas. Mas ainda é interessante saber essas coisas e elas não são muito difíceis de se acompanhar, então é bem provável que valha o seu tempo. Como o texto original foi direcionado para estudantes do ensino médio, nenhum conhecimento prévio de matemática é necessário, então qualquer um com alguma experiência com programação(por exemplo, sabe o que é recursividade) vai ser capaz de acompanhar sem problemas.</p>

        <p>Ao longo deste artigo, você encontrará vários ponteiros que vão ligar a materiais interessantes, muitas vezes fora do escopo do tópico em discussão. Se você é um desenvolvedor no mercado, é provável que você já conheça a maioria desses conceitos. Se você é um estudante júnior participando de competições, seguir esses links vai te dar ideias de outras áreas da ciência da computação ou da engenharia de software que você pode ainda não conhecer, e que você pode dar uma olhada para ampliar seus horizontes.</p>

        <p>A notação big O e análise de complexidade de algoritmos é algo que tanto programadores no mercado quanto estudantes acham difícil de entender, têm medo ou evitam como se fosse algo inútil. Mas não é tão difícil ou teórico como pode parecer em um primeiro momento. A complexidade de um algoritmo é somente uma maneira de se medir formalmente o quão rápido um programa ou algoritmo pode ser executado, então na verdade é algo bem pragmático. Vamos começar com um pouco de motivação sobre o assunto.</p>

        <div class='sidefigure'>
            <img src='images/halflife2.jpg' alt='Um screenshot de um personagem de inteligência artificial em Half-life 2' />
            <label><strong>Figura 1</strong>: Personagens de inteligência artificial em vídeo games usam algoritmos para evitar obstáculos enquanto navegam em um mundo virtual</label>
        </div>

        <h2 id='motivation'>Motivação</h2>

        <p>Nós já sabemos que existem ferramentas para medir o quão rápido um programa é executado. Existem programas conhecidos como <em>profilers</em> que medem o tempo de execução em milissegundos e podem nos ajudar a otimizar o nosso código encontrando gargalos. Apesar de serem ferramentas úteis, não são tão relevantes para a complexidade de algoritmos. Complexidade de algoritmos é algo feito para comparar dois algoritmos no nível das ideias — ignorando detalhes de baixo nível como a linguagem de programação em que foi implementado, o hardware em que o algoritmo é executado, ou o conjunto de instruções da CPU. Nós queremos comparar algoritmos somente em termos do que eles realmente são: Ideias de como algo é computado. Contar milissegundos não vai nos ajudar nisso. É possível que um algoritmo ruim escrito em uma linguagem de programação de baixo nível como <a href='https://pt.wikipedia.org/wiki/Linguagem_assembly'>assembly</a> rode muito mais rápido que um bom algoritmo escrito em uma linguagem de alto nível, como <a href='http://www.python.org/'>Python</a> ou <a href='http://www.ruby-lang.org/pt/'>Ruby</a>. Então, é hora de definir o que realmente é um "algoritmo melhor".</p>

        <p>Como algoritmos são programas que realizam computações, e não outras coisas que computadores normalmente fazem como tarefas na rede ou entrada e saída de dados, a análise de complexidade nos permite analisar o quão rápido um programa é quando ele realiza uma computação. Exemplos de operações que são puramente <em>computacionais</em> incluem <a href='https://pt.wikipedia.org/wiki/Vírgula_flutuante'>operações de ponto flutuante</a> como adição e multiplicação; pesquisa em uma base de dados que cabe na RAM por um determinado valor; determinar o caminho pelo qual um personagem de inteligência artificial vai caminhar em um vídeo game de tal forma que ele tenha que caminhar apenas uma curta distância dentro do mundo virtual (veja a <strong>Figura 1</strong>); ou executar um padrão de <a href='http://www.regular-expressions.info/'>expressão regular</a> que combine com uma string. Claramente, a computação é ubíqua em programas de computador.</p>

        <p>A análise de complexidade também é uma ferramenta que nos permite explicar como um algoritmo se comporta se a entrada aumentar. Se nós precisarmos de um input diferente, como o algoritmo vai se comportar? Se o nosso algoritmo leva 1 segundo para executar para uma entrada de tamanho 1000, como ele vai se comportar se dobrarmos o tamanho da entrada? Ele vai executar tão rápido quanto, vai levar metade do tempo, ou vai ser quatro vezes mais lento? Na prática, isso é importante para nos ajudar a predizer como um algoritmo vai ser comportar se a entrada aumentar. Por exemplo, se fizermos um algoritmo para uma aplicação web que funciona bem com 1000 usuários e medirmos o seu tempo de execução, usando a análise de complexidade nós podemos ter uma boa ideia do que irá acontecer uma vez que tivermos 2000 usuários. Para competições de algoritmos, a análise de complexidade nos dá uma ideia do quão longa será a execução do nosso código para os casos de teste maiores que serão utilizados para testar se o nosso programa está correto. Então, se medirmos o comportamento do nosso programa para uma entrada pequena, nós podemos ter uma boa ideia de como ele vai se comportar com entradas maiores. Vamos começar com um exemplo simples: Encontrar o maior elemento de um array.</p>

        <h2>Contando instruções</h2>

        <p>Neste artigo, vou utilizar várias linguagens de programação para os exemplos. Entretanto, não se desespere se você não conhecer uma linguagem de programação em específico. Como você já sabe programar, você deve ser capaz de ler os exemplos sem problema algum, mesmo se você não for familiar com a linguagem de programação escolhida, pois eles serão simples e não usarão nenhuma feature esotérica das linguagens. Se você for um estudante participando de competições de algoritmos, provavelmente você vai usar <a href='http://www.cplusplus.com/doc/tutorial/'>C++</a>, então você não deverá ter problemas em acompanhar. Nesse caso, eu recomendo trabalhar nos exercícios usando C++ para praticar.</p>

        <p>O maior elemento de um array pode ser encontrado usando com um trecho de código simples como esse, escrito em <a href='http://www.quirksmode.org/js/intro.html'>Javascript</a>. Dado uma array de entrada <var>A</var> de tamanho <var>n</var>:</p>

        <pre name='code' class='brush: js; gutter: false; toolbar: false'>
            var M = A[ 0 ];

            for ( var i = 0; i &lt; n; ++i ) {
                if ( A[ i ] &gt;= M ) {
                    M = A[ i ];
                }
            }
        </pre>

        <p>Agora, a primeira coisa que vamos fazer é contar quantas <em>instruções fundamentais</em> este código executa. Nós vamos fazer isso somente agora e isso não vai ser mais necessário à medida que desenvolvemos nossa teoria, então seja um pouquinho paciente enquanto fazemos isso. Ao analisarmos esse trecho de código, nós queremos quebrá-lo em instruções simples; coisas que podem ser executadas diretamente pela CPU — ou algo próximo disso. Nós vamos assumir que o nosso processador pode executar as seguintes operações precisando de apenas uma única instrução para cada uma:</p>

        <ul>
            <li>Atribuir um valor a uma variável</li>
            <li>Encontrar o valor de um elemento específico de um array</li>
            <li>Comparar dois valores</li>
            <li>Incrementar um valor</li>
            <li>Operações aritméticas básicas, como adição e multiplicação</li>
        </ul>

        <p>Nós iremos assumir que ramificações(escolhas de partes do código entre <code>if</code> e <code>else</code> depois que a condição já tiver sido avaliada) ocorre instantaneamente e não iremos contar essas instruções. No código acima, a primeira linha do código é:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            var M = A[ 0 ];
        </pre>

        <p>Isso requer duas instruções: Uma para acessar <var>A[ 0 ]</var> e uma para atribuir o valor para <var>M</var> (nós estamos assumindo que n é sempre pelo menos 1). Essas duas instruções são sempre requeridas pelo algoritmo, independente do valor de <var>n</var>. O código de inicialização do loop <code>for</code> também tem que ser executado sempre. Isso nos dá mais duas instruções: uma atribuição e uma comparação:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            i = 0;
            i &lt; n;
        </pre>

        <p>Elas vão ser executadas antes da primeira iteração do loop <code>for</code> Depois de cada iteração, nós vamos ter mais duas instruções para executar, um incremento de i e uma comparação para checar se vamos continuar no loop:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            ++i;
            i &lt; n;
        </pre>

        <p>Então, se ignorarmos o corpo do loop, o número de instruções que esse algoritmo precisa é 4 + 2n. Isso é, 4 instruções no começo do loop <code>for</code> e 2 instruções no final de cada iteração que nós temos em <var>n</var>. Nós podemos então definir uma função matemática f(n) que, dado um <var>n</var>, nos dá o número de instruções que o algoritmo precisa. Por exemplo, para um <code>for</code> com corpo vazio, nós temos f(n) = 4 + 2n.</p>

        <h2 id='worst'>Análise do pior caso</h2>

        <p>Agora, olhando para o corpo do <code>for</code> nós temos uma operação de acesso a um array e uma comparação, que sempre acontecem:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            if ( A[ i ] &gt;= M ) { ...
        </pre>

        <p>Aqui são duas instruções. Mas o corpo do <code>if</code> pode ou não pode ou não ser executado, dependendo de quais são os valores do array. Se <code>A[ i ] &gt;= M</code>, então nós vamos executar essas duas instruções adicionais - um acesso ao array e uma atribuição:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            M = A[ i ]
        </pre>

        <p>Mas agora, não podemos definir um f(n) tão facilmente, porque o número de instruções não depende somente de <var>n</var> mas também da entrada. Por exemplo, se <code>A = [ 1, 2, 3, 4 ]</code>, o algoritmo vai precisar de mais instruções do que se <code>A = [ 4, 3, 2, 1 ]</code>. Quando analisamos algoritmos, nós geralmente consideramos o pior caso. Qual a pior coisa que pode acontecer para o nosso algoritmo? Quando o nosso algoritmo precisa do maior número possível de instruções para ser concluído? Nesse caso, é quando nós temos um array em ordem crescente, como <code>A = [ 1, 2, 3, 4 ]</code>. Então, <var>M</var> precisa ser substituído em cada iteração, de forma que teremos o maior número de instruções. Cientistas da computação têm um nome chique pra isso e o chamam de <em>análise do pior caso</em>; E isso não é nada mais do que simplesmente considerar o caso em que temos a pior sorte possível. Então, no pior caso, nós temos 4 instruções para executar dentro do corpo do <code>for</code> , então nós temos que f(n) = 4 + 2n + 4n = 6n + 4. Esta função f, dado um problema de tamanho n, nos dá o número de instruções que precisaríamos executar no pior caso.</p>

        <h2 id='asymptotic'>Comportamento assintótico</h2>

        <p>Dada uma função dessa forma, nós temos uma boa ideia do quão rápido é um algoritmo. Entretanto, como eu prometi, nós não vamos precisar passar pela tarefa tediosa de contar instruções no nosso programa. Além disso, o número real de instruções que a CPU precisa executar para cada linguagem de programação depende do compilador da linguagem e do conjunto de instruções disponível (por exemplo, se o processador é um AMD ou um Intel Pentium no seu PC, ou um processador MIPS no seu Playstation 2) e nós dissemos que vamos ignorar isso. Agora, vamos passar nossa "função f" por um "filtro" que vai nos ajudar a eliminar esses pequenos detalhes que cientistas da computação preferem ignorar.</p>

        <p>Na nossa função, 6n + 4, nós temos dois termos: 6n e 4. Na análise de complexidade nós apenas nos importamos com o que acontece na função de contagem de instruções quando a entrada do programa (<var>n</var>) fica muito grande. Isso combina bem com as ideias anteriores de comportamento no "pior caso": Nós estamos interessados em como o nosso algoritmo se comporta quando é exigido bastante dele; quando ele é desafiado a fazer algo realmente difícil. Note que isso é muito útil quando comparamos algoritmos. Se um algoritmo ganha de outro para uma entrada muito grande, então provavelmente o algoritmo mais rápido vai permanecer mais rápido quando for dado a ele uma entrada menor e mais fácil. <strong>Dos termos que estamos considerando, nós descartamos todos os termos que crescem lentamente e conservamos apenas aqueles que crescem depressa a medida que n se torna maior.</strong> Claramente 4 permanece 4 a medida que <var>n</var> vai crescendo, mas 6n fica cada vez maior e maior, então ele tende a importar mais para problemas maiores. Logo, a primeira coisa que nós vamos fazer é descartar o 4 e manter a função como f( n ) = 6n.</p>

        <p>Isso faz sentido se você pensar um pouco a respeito, pois 4 é simplesmente uma "constante de inicialização". Diferentes linguagens de programação podem precisar de intervalos de tempo diferentes para se prepararem. Por exemplo, Java precisa de algum tempo para inicializar a sua <a href='http://en.wikipedia.org/wiki/Java_virtual_machine'>máquina virtual</a>. Como estamos ignorando as diferenças entre as linguagens de programação, faz todo o sentido ignorarmos esse valor.</p>

        <p>A segunda coisa que vamos ignorar é a constante multiplicativa na frente do <var>n</var>, então nossa função vai se tornar f( n ) = n. Como você pode ver, isso simplifica bastante as coisas. Novamente, faz sentido descartar essa constante multiplicativa se nós pensarmos sobre como diferentes linguagens de programação se compilam. A "instrução" de acesso a um array pode se compilar para diferentes instruções em diferentes linguagens de programação. Por exemplo, em C, fazer <code>A[ i ]</code> não inclui uma verificação que checa se <var>i</var> está dentro do tamanho declarado para o array, enquanto que em <a href='https://pt.wikipedia.org/wiki/Pascal_(linguagem_de_programação)'>Pascal</a> isso está incluído. Então, o seguinte código em Pascal:</p>

        <pre class='brush: delphi; gutter: false; toolbar: false;'>
            M := A[ i ]
        </pre>

        <p>É equivalente ao seguinde código em C:</p>

        <pre class='brush: c; gutter: false; toolbar: false;'>
            if ( i &gt;= 0 &amp;&amp; i &lt; n ) {
                M = A[ i ];
            }
        </pre>

        <p>Então, é razoável esperar que diferentes linguagens de programação vão nos dar diferentes fatores quando contamos suas instruções. No nosso exemplo, em que estamos usando um compilador burro de Pascal em que possíveis otimizações são óbvias, Pascal precisa de 3 instruções para cada acesso de array ao invés de 1 instrução necessária para o C. Descartar esse fator combina com ignorar as diferenças entre linguagens de programação e compiladores e somente analisar a ideia do algoritmo em si.</p>

        <p>Esse filtro de "descartar todos os fatores" e de "manter o termo que mais cresce" como descrito acima é o que chamamos de <em>comportamento assintótico</em>. Então, o comportamento assintótico de f( n ) = 2n + 8 é descrito pela função f( n ) = n. Matematicamente falando, o que estamos falando aqui é que estamos interessados no limite da função f, onde <var>n</var> tende ao infinito; mas se você não entende o que essa frase significa formalmente, não se preocupe, porque isso é tudo o que você precisa saber. (Obs: Tecnicamente, se formos ser rigorosos, nós não podemos descartar as constantes no limite; mas na ciência da computação, nós queremos fazer isso pelas razões descritas acima.) Vamos fazer alguns exemplos para nos familiarizarmos com o conceito.</p>

        <div class='right sidefigure'>
            <img src='images/cubic-vs-linear.png' alt='A função cúbica, em azul, supera a função linear, em vermelhor, a partir de n = 45' />
            <label><strong>Figura 2</strong>: A função n<sup>3</sup>, desenhada em azul, fica maior que a função 1999n, desenhada em vermelho, depois que n = 45. A partir desse ponto, ela será sempre cada vez maior.</label>
        </div>

        <p>Vamos encontrar o comportamento assintótico para as seguintes funções de exemplo descartando fatores constantes e conservando os termos que crescem mais rápido.</p>

        <ol>
            <li><p>f( n ) = 5n + 12 dá f( n ) = n.</p>
                <p>Pelas mesmas razões escritas acima.</p></li>

            <li><p>f( n ) = 109 dá f( n ) = 1.</p>
                <p>Nós estamos descartando o multiplicador 109 * 1, mas ainda temos que colocar o 1 ali para indicar que a função possui um valor diferente de zero.</p></li>

            <li><p>f( n ) = n<sup>2</sup> + 3n + 112 dá f( n ) = n<sup>2</sup></p>
                <p>Aqui, n<sup>2</sup> cresce mais do que 3n se n for grande o suficiente, então vamos mantê-lo.</p></li>

            <li><p>f( n ) = n<sup>3</sup> + 1999n + 1337 dá f( n ) = n<sup>3</sup></p>
                <p>Mesmo que o fator na frente seja muito grande, nós ainda podemos encontrar um <var>n</var> grande o suficiente para que n<sup>3</sup> seja maior que 1999n. Como estamos interessados no comportamento para valores muito grandes de <var>n</var>, nós conservamos apenas o<sup>3</sup> (Veja a <strong>Figura 2</strong>).</p></li>

            <li><p>f( n ) = n + <img alt='sqrt( n )' src='images/sqrtn.png' /> dá f( n ) = n</p>
                <p>Isso acontece porque n aumenta mais rápido que <img alt='sqrt( n )' src='images/sqrtn.png' /> a medida que <var>n</var> aumenta.</p></li>
        </ol>

        <p>Você também pode tentar os seguintes exemplos sozinho(a):</p>
        <div class='exercise'>
            <h3>Exercicio 1</h3>
            <ol>
                <li>f( n ) = n<sup>6</sup> + 3n</li>
                <li>f( n ) = 2<sup>n</sup> + 12</li>
                <li>f( n ) = 3<sup>n</sup> + 2<sup>n</sup></li>
                <li>f( n ) = n<sup>n</sup> + n</li>
            </ol>
            <p>(Anote os seus resultados; a solução será dada abaixo)</p>

            <p>Se você estiver tendo dificuldade com algum desses, coloque algum <var>n</var> muito grande e veja qual termo fica maior. Simples, né?</p>
        </div>

        <h2 id='complexity'>Complexidade</h2>

        <p>Então, o que isso diz pra gente, é que como podemos descartar todas essas constantes decorativas, é bem fácil dizer o comportamento assintótico de uma função de contagem de instruções de um programa. Na verdade, qualquer programa que não tem nenhum loop vai ter f( n ) = 1, uma vez que o número de instruções que ele precisa é uma constante(a não ser que ele use recursividade; veja abaixo). Qualquer programa com um único loop que vai de 1 a n vai ter f( n ) = n, uma vez que ele vai executar um número constante de instruções antes do loop, um número constante de instruções depois do loop, e um número constante de instruções dentro do loop que vão ser executadas todas as <var>n</var> vezes.</p>

        <p>Isso deve ser bem mais fácil e menos chato do que contar instruções individuais, então vamos dar uma olhada em alguns exemplos para nos familiarizarmos com isso. O seguinte programa em <a href='http://php.net/'>PHP</a> checa se um valor específico existe em um array <var>A</var> de tamanho <var>n</var>:</p>

        <pre class='brush: php; gutter: false; toolbar: false;'>
            &lt;?php
                $exists = false;
                for ( $i = 0; $i &lt; n; ++$i ) {
                    if ( $A[ $i ] == $value ) {
                        $exists = true;
                        break;
                    }
                }
            ?&gt;
        </pre>

        <p>Este método de procurar um valor em um array é chamado de busca linear. Este é um nome razoável, porque esse programa é f( n ) = n (nós vamos definir exatamente o que "linear" significa na próxima seção). Você pode notar que tem uma instrução "break" ali que faz com que o programa termine mais cedo, mesmo depois de uma única iteração. Mas lembre-se de que estamos interessados no pior caso, que para esse programa é quando o array A não contém o valor. Então, ainda temos f( n ) = n.</p>

        <div class='exercise'>
            <h3>Exercício 2</h3>

            <p>Analise sistematicamente a quantidade de instruções que o programa PHP acima precisa em respeito de n no pior caso para encontrar f( n ), de maneira similar a como analisamos nosso primeiro programa em Javascript. Então verifique que, assintoticamente, nós temos f( n ) = n.</p>
        </div>

        <p>Vamos olhar um programa em Python que soma dois elementos de um array juntos para produzir uma soma que é armazenada em outra variável:</p>

        <pre class='brush: python; gutter: false; toolbar: false;'>
            v = a[ 0 ] + a[ 1 ]
        </pre>

        <p>Aqui nós temos um número constante de instruções, então temos que f(n) = 1.</p>

        <p>O seguinte programa em C++ checa se um <i>vector</i>(um array mais chique) chamado A de tamanho n contém algum valor duplicado:</p>

        <pre class='brush: cpp; gutter: false; toolbar: false;'>
            bool duplicate = false;
            for ( int i = 0; i &lt; n; ++i ) {
                for ( int j = 0; j &lt; n; ++j ) {
                    if ( i != j &amp;&amp; A[ i ] == A[ j ] ) {
                        duplicate = true;
                        break;
                    }
                }
                if ( duplicate ) {
                    break;
                }
            }
        </pre>

        <p>Como aqui temos um loop aninhado dentro de outro, nós teremos um comportamento assintótico descrito por f( n ) = n<sup>2</sup>.</p>

        <div class='highlight'>
            <p class='thumb'><strong>Regra geral</strong>: Programas simples podem ser analisados contando a quantidade de loops aninhados que eles possuem. Um único loop em n items nos dá f( n ) = n. Um loop dentro de outro loop nos dá f( n ) = n<sup>2</sup>. Um loop dentro de outro loop dentro de outro loop nos dá f( n ) = n<sup>3</sup>.</p>
        </div>

        <p>Se nós temos um programa que chama uma função dentro de um loop e nós sabemos o número de instruções dessa função, é fácil determinar o número de instruções de todo o programa. Vamos dar uma olhada nesse exemplo em C:</p>

        <pre class='brush: c; gutter: false; toolbar: false;'>
            int i;
            for ( i = 0; i &lt; n; ++i ) {
                f( n );
            }
        </pre>

        <p>Se nós sabemos que <code>f( n )</code> é uma função que executa exatamente <var>n</var> instruções, nós então sabemos que o número de instruções de todo o programa é assintoticamente n<sup>2</sup>, porque a função é chamada exatamente <var>n</var> vezes.</p>

        <div class='highlight'>
            <p class='thumb'><strong>Regra geral</strong>: Dada uma série de loops que são sequenciais, o mais lento dentre eles determina o comportamento assintótico do programa. Dois loops aninhados seguidos de um único loop é assintoticamente o mesmo que somente os loops aninhados, porque os loops aninhados "dominam" o loop à parte.</p>
        </div>

        <p>Agora, vamos mudar para a notação chique que os cientistas da computação usam. Quando nós encontramos qual o valor assintótico exato de f, nós dizemos que nosso programa é Θ( f( n ) ). Por exemplo, os programas acima são Θ( 1 ), Θ( n<sup>2</sup> ) e Θ( n<sup>2</sup> ) respectivamente. Θ( n ) é pronunciado como "teta de n". As vezes dizemos que f( n ), a função original de contagem de instruções incluindo as constantes, é Θ( alguma coisa). Por exemplo, podemos dizer que f( n ) = 2n é uma função que é Θ( n ) — nada de novo aqui. Nós também podemos escrever 2n ∈ Θ( n ), que é pronunciado como "dois n pertence a teta de n". Não se confunda com essa notação: tudo o que ela diz é que se nós contarmos o número de instruções que um programa precisa e ele for 2n, então o comportamento assintótico do nosso algoritmo é descrito por n, que encontramos ao eliminar as constantes. Dada essa notação, a seguir temos algumas expressões matemáticas verdadeiras:</p>
        <ol>
            <li>n<sup>6</sup> + 3n ∈ Θ( n<sup>6</sup> )</li>
            <li>2<sup>n</sup> + 12 ∈ Θ( 2<sup>n</sup> )</li>
            <li>3<sup>n</sup> + 2<sup>n</sup> ∈ Θ( 3<sup>n</sup> )</li>
            <li>n<sup>n</sup> + n ∈ Θ( n<sup>n</sup> )</li>
        </ol>

        <p>A propósito, se você resolveu o exercício 1 acima, essas são as respostas que você deveria encontrar.</p>

        <p><strong>Nós chamamos essa função, i.e. o que nós colocamos dentro Θ( daqui ), de <em>complexidade de tempo</em>, ou apenas <em>complexidade</em> do nosso algoritmo.</strong> Então um algoritmo Θ( n ) é de complexidade n. Nós também temos nomes especiais para Θ( 1 ), Θ( n ), Θ( n<sup>2</sup> ) e Θ( log( n ) ) porque eles ocorrem com frequência. Nós dizemos que um algoritmo Θ( 1 ) é um algoritmo de <em>tempo constante</em>, Θ( n ) é <em>linear</em>, Θ( n<sup>2</sup> ) é <em>quadrático</em> e Θ( log( n ) ) é <em>logarítmico</em> (não se preocupe se você ainda não sabe o que são logaritmos — nós vamos chegar lá daqui a pouco).</p>

        <div class='highlight'>
            <p class='thumb'><strong>Regra geral:</strong>: Programas com um Θ maior são mais lentos que programas com um Θ menor.</p>
        </div>

        <div class='right sidefigure'>
            <img src='images/hidden-surface.jpg' alt='Um exemplo de superfícies escondidas em um vídeo game.' />
            <label><strong>Figura 3</strong>: Um jogador que está localizado no ponto amarelo não vê as áreas sombreadas. Dividir o mundo em pequenas partes e ordená-las pela distância ao jogador é uma maneira de resolver o problema da visibilidade.</label>
        </div>

        <h2 id='big-o'>Notação Big-O </h2>

        <p>Algumas vezes vai ser difícil descobrir exatamente qual o comportamento de um algoritmo da maneira que fizemos acima, especialmente para exemplos mais complexos. Entretanto, nós podemos dizer que o comportamento do nosso algoritmo nunca vai exceder um certo limite. Isso torna a nossa vida mais fácil, pois não vamos ter que especificar exatamente o quão rápido o nosso algoritmo roda, mesmo ignorando constantes como fizemos acima. Tudo que precisamos fazer é encontrar um certo limite. Isso é facilmente explicado com um exemplo.</p>

        <p>Um problema bastante usado por cientistas para ensinar algoritmos é o <em>problema de ordenação</em>. No problema de ordenação, um array <var>A</var> de tamanho <var>n</var> é dado (parece familiar?) e temos que escrever um programa que ordena esse array. Esse problema é interessante porque é um problema pragmático em sistemas reais. Por exemplo, um explorador de arquivos precisa ordenar os arquivos que ele exibe por nome para facilitar a navegação do usuário. Ou, como outro exemplo, um video game pode precisar ordenar os objetos 3D exibidos no mundo com base em suas distâncias ao olho do jogador dentro do mundo virtual para determinar o que está visível e o que não está, algo chamado de <a href='http://en.wikipedia.org/wiki/Hidden_surface_determination'>Problema da visibilidade</a> (veja a <strong>Figura 3</strong>). Os objetos mais próximos ao jogador são os visíveis, enquanto que aqueles que estão mais afastados podem estar escondidos atrás de outros objetos na frente deles. O problema de ordenação também é interessante porque existem muitos algoritmos algoritmos que o resolvem, alguns pior do que outros. Também é um problema fácil de se definir e explicar. Então, vamos escrever um trecho de código que ordena um array.</p>

        <p>Eis aqui uma maneira ineficiente de se implementar uma ordenação em um array em Ruby. (Claro, Ruby permite a ordenação de arrays usando funções já inclusas na linguagem, que você deve utilizar, e que certamente serão mais rápidas do que o algoritmo que veremos aqui. Mas vamos criar um mesmo assim para ilustrar.)</p>

        <div class='leftofimage'>
            <pre class='brush: ruby; gutter: false; toolbar: false;'>
                b = []
                n.times do
                    m = a[ 0 ]
                    mi = 0
                    a.each_with_index do |element, i|
                        if element &lt; m
                            m = element
                            mi = i
                        end
                    end
                    a.delete_at( mi )
                    b &lt;&lt; m
                end
            </pre>
        </div>

        <p>Esse método é conhecido como <a href='http://pt.wikipedia.org/wiki/Selection_sort'>selection sort</a>. Ele encontra o menor elemento do nosso array (o array está denotado como <var>a</var> acima, enquanto que o menor valor é denotado como <var>m</var> e <var>mi</var> é o seu índice), o coloca em um novo array (no caso, <var>b</var>), e o remove do array original. Então ele encontra o mínimo entre os valores restantes do array original e o coloca no fim do novo array de modo que agora ele vai conter dois elementos, e o remove do array original. O processo continua até que todos os items tenham sido removidos do array original e inseridos no novo array, o que significa que o novo array estará ordenado. Nesse exemplo, nós podemos ver que temos dois loops aninhados. O loop externo é executado <var>n</var> vezes, e o loop interno é executado uma vez para cada elemento do array <var>a</var>. O array <var>a</var> inicialmente tem <var>n</var> itens, mas nós estamos removendo um item a cada iteração. Então o loop interno se repete <var>n</var> vezes durante a primeira iteração do loop externo, depois <code>n - 1</code> vezes, depois <code>n - 2</code> vezes, e assim por diante, até a última iteração do loop externo, onde vai ser executado somente uma vez.</p>

        <p>É meio difícil avaliar a complexidade desse programa, pois teríamos que dar um jeito de somar 1 + 2 + … + (n - 1) + n. Mas nós podemos encontrar um "limite superior" para ele. Isso é, podemos alterar o nosso programa (você pode fazer isso na sua cabeça, não no código ) para o tornar <strong>pior</strong> do que ele é e então encontrar a complexidade do novo programa criado a partir dele. Se nós encontrarmos a complexidade do programa pior que nós fizemos, então vamos saber que o nosso programa original vai ser no máximo tão ruim quanto, ou talvez será até melhor do que ele. Dessa forma, se encontrarmos uma complexidade muito boa para o programa alterado, que é pior que o original, nós vamos saber que o nosso programa original também vai ter uma complexidade muito boa — tão boa quanto o nosso programa alterado, ou até melhor.</p>

        <p>Vamos agora pensar em uma maneira de modificar esse programa exemplo para o tornar mais fácil de se descobrir sua complexidade. Mas tenha em mente que nós só o podemos torná-lo pior, por exemplo, criando mais instruções, para que a nossa estimativa seja significativa para o programa original. Claramente nós podemos alterar o loop interno do programa para sempre se repetir exatamente <var>n</var> vezes, ao invés de um número variável de vezes. Algumas dessas repetições vão ser inúteis, mas vão nos ajudar a analisar a complexidade do algoritmo resultante. Se nós fizermos essa simples mudança, então o novo algoritmo que construímos é claramente Θ( n<sup>2</sup> ), porque nós temos dois loops aninhados que se repetem exatamente <var>n</var> vezes. Se é assim, podemos dizer que o algoritmo original é O( n<sup>2</sup> ). O( n<sup>2</sup> ) é pronunciado como "O de n ao quadrado". O que isso diz é que o nosso programa não é assintoticamente pior do que n<sup>2</sup>. Pode ser até melhor do que isso, ou talvez seja a mesma coisa. A propósito, se o programa realmente for Θ( n<sup>2</sup> ), nós ainda podemos dizer que ele é O( n<sup>2</sup> ). Para ajudar na compreensão, imagine o programa sendo alterado de uma maneira que não o mude muito, mas o faz um pouquinho pior, como adicionando uma instrução sem importância no começo do programa. Fazer isso vai alterar a função contadora de instruções com uma simples constante, que é ignorada quando analisamos seu comportamento assintótico. Então um programa que é Θ( n<sup>2</sup> ) também é O( n<sup>2</sup> ).</p>

        <p>Mas um programa que é O( n<sup>2</sup> ) pode não ser Θ( n<sup>2</sup> ). Por exemplo, qualquer programa que é Θ( n ) também é O( n<sup>2</sup> ) além de ser O( n ). Se imaginarmos que um programa Θ( n ) é um simples loop <code>for</code> que se repete <var>n</var> vezes, nós podemos torná-lo pior o colocando dentro de outro loop <code>for</code> que também se repete <var>n</var> vezes, produzindo assim um programa f( n ) = n<sup>2</sup>. Para generalizar, qualquer programa que for Θ( <var>a</var> ) também é O( <var>b</var> ) se <var>b</var> for pior que <var>a</var>. Note que a nossa alteração ao programa não precisa gerar um programa que seja significativo ou equivalente ao programa original. Ele só precisa executar mais instruções que o programa original para um dado <var>n</var>. Tudo que estamos usando é para contar instruções, e não para resolver o problema em si.</p>

        <p>Então, dizer o que nosso programa é O( n<sup>2</sup> ) é ficar na zona de conforto: Nós analisamos o nosso algoritmo, e descobrimos que ele nunca vai ser pior que n<sup>2</sup>. Mas pode ser mesmo que ele seja n<sup>2</sup>. Isso nos dá uma boa estimativa do quão rápido nosso programa é executado. Vamos olhar alguns exemplos para ajudar com a familiarização dessa nova notação.</p>

        <div class='exercise'>
            <h3>Exercise 3</h3>

            <p>Descubra quais afirmações são verdadeiras:</p>
            <ol>
                <li>Um algoritmo Θ( n ) é O( n )</li>
                <li>Um algoritmo Θ( n ) é O( n<sup>2</sup> )</li>
                <li>Um algoritmo Θ( n<sup>2</sup> ) é O( n<sup>3</sup> )</li>
                <li>Um algoritmo Θ( n ) é O( 1 )</li>
                <li>Um algoritmo O( 1 ) é Θ( 1 )</li>
                <li>Um algoritmo O( n ) é Θ( 1 )</li>
            </ol>
        </div>

        <div class='exercise solution'>
            <h3>Solução</h3>

            <ol>
                <li>Sabemos que essa é verdadeira porque nosso programa original era Θ( n ). Nós podemos chegar em O( n ) sem alterar absolutamente nada no nosso programa.</li>
                <li>Como n<sup>2</sup> é pior que n, essa é verdadeira.</li>
                <li>Como n<sup>3</sup> é pior que n<sup>2</sup>, essa é verdadeira.</li>
                <li>Como 1 não é pior que n, essa é falsa. Se um programa precisa de <var>n</var> instruções assintoticamente (uma quantidade linear de instruções), nós não podemos torná-lo pior e fazer com que ele tenha apenas 1 instrução assintoticamente (uma quantidade constante de instruções)</li>
                <li>Essa é verdadeira porque as duas complexidades são iguais.</li>
                <li>Essa pode ou não ser verdadeira dependendo do algoritmo. Em um caso geral, é falsa. Se um algoritmo é Θ( 1 ), então ele certamente é O( n ). Mas se ele for O ( n ) então ele pode não ser Θ( 1 ). Por exemplo, um algoritmo Θ( n ) é O ( n ) mas não é Θ( 1 ).</li>
            </ol>
        </div>

        <div class='exercise'>
            <h3>Exercício 4</h3>

            <p>Use uma progressão aritmética para provar que o programa acima não só é O( n<sup>2</sup> ) como também é Θ( n<sup>2</sup> ). Se você não souber o que é uma progressão aritmética, olhe na <a href='http://en.wikipedia.org/wiki/1_%2B_2_%2B_3_%2B_4_%2B_%E2%80%A6'>Wikipedia</a> – é fácil.</p>
        </div>

        <p>Como a complexidade O de um algoritmo nos dá o <em>limite superior</em> para a complexidade real dele enquanto que Θ nos dá a complexidade exata do algoritmo, as vezes dizemos que Θ nos dá um <em>limite estreito</em>. Se sabemos que encontramos um limite de complexidade que não é estreito, nós podemos usar um "o" minúsculo para denotar isso. Por exemplo, se um algoritmo é Θ( n ), então sua complexidade estreita é n. Então esse algoritmo é tanto O( n ) quanto O( n<sup>2</sup> ). Como o algoritmo é Θ( n ), o limite O( n ) é um limite estreito. Mas o limite O( n<sup>2</sup> ) não é estreito, então nós podemos escrever que o algoritmo é o( n<sup>2</sup> ), para ilustrar que nós sabemos que o limite não é estreito. Essa notação também é conhecida como notação "little o". É melhor se nós pudermos encontrar os limites estreitos dos nossos algoritmos, porque eles nos dão mais informação sobre como nosso algoritmo se comporta, mas isso nem sempre é fácil de se fazer.</p>

        <div class='exercise'>
            <h3>Exercício 5</h3>

            <p>Determine quais dos seguintes limites são estreitos e quais não são. Verifique se existe algum limite pode estar errado. Use a notação little o para ilustrar os limites que não são estreitos.</p>

            <ol>
                <li>Um algoritmo Θ( n ) para o qual encontramos um limite superior O( n ).</li>
                <li>Um algoritmo Θ( n<sup>2</sup> ) Para qual encontramos um limite superior O( n<sup>3</sup> ),</li>
                <li>Um algoritmo Θ( 1 ) para qual encontramos um limite superior O( n ).</li>
                <li>Um algoritmo Θ( n ) para qual encontramos um limite superior O( 1 ).</li>
                <li>Um algoritmo Θ( n ) para qual encontramos um limite superior O( 2n ).</li>
            </ol>
        </div>

        <div class='exercise solution'>
            <h3>Solution</h3>

            <ol>
                <li>Nesse caso, a complexidade Θ e a complexidade O são as mesmas, então o limite é estreito.</li>
                <li>Aqui vemos que a complexidade O é de uma escala maior do que a complexidade Θ, então esse limite não é estreito. Para ser estreito, o limite deveria ser de O( n<sup>2</sup> ). Então nós podemos escrever que o algoritmo é o( n<sup>3</sup> ).</li>
                <li>Novamente vemos que a complexidade O é de uma escala maior que a complexidade Θ, então temos um limite que não é estreito. Um limite de O( 1 ) seria estreito. Então podemos indicar que o limite O( n ) não é estreito o escrevendo como o( n ).</li>
                <li>Devemos ter cometido algum erro no cálculo desse limite, porque está errado. É impossível para um algoritmo Θ( n ) ter um limite superior de O( 1 ), pois n é uma complexidade maior do que 1. Lembre-se que O dá o limite superior.</li>
                <li>Esse pode parecer um limite que não é estreito, mas isso não é verdade. Esse limite é de fato estreito. Lembre-se que o comportamento assintótico de 2n é n são os mesmos, e que para as notações O e Θ importam apenas os comportamentos assintóticos. Então nós temos que O( 2n ) = O( n ) e então esse limite é estreito, pois sua complexidade é a mesma de Θ.</li>
            </ol>
        </div>

        <div class='highlight'>
            <p class='thumb'><strong>Rergra geral</strong>: É mais fácil descobrir a complexidade O de um algoritmo do que a sua complexidade Θ.</p>
        </div>

        <p>Você pode estar ficando um pouco confuso com todas essas novas notações, mas vou apresentar só mais dois símbolos antes de irmos para alguns exemplos. Eles vão ser fáceis agora que você já conhece Θ, O e o, e nós não vamos usá-los muito daqui pra frente, mas é bom aproveitar a oportunidade para conhecê-los. No exemplo acima, nós modificamos o programa para torná-lo pior (executando mais instruções, o que aumenta o tempo de execução) e introduzimos a notação O. A notação O é importante porque nos diz informações valiosas para sabermos se o programa é bom o suficiente. Se fizermos o oposto e modificarmos nosso programa para torná-lo <strong>melhor</strong> encontrarmos a complexidade do programa resultante, nós usamos a notação Ω. Ω então nos dá uma complexidade que nós sabemos que o nosso programa não vai ser melhor que ela. Isso é útil se quisermos provar que um programa roda mais lentamente ou que um algoritmo é ruim. Também pode ser usado para argumentar que um algoritmo é muito lento para ser usado em algum caso específico. Por exemplo, dizer que um algoritmo é Ω( n<sup>3</sup> ) significa que o algoritmo não é melhor que n<sup>3</sup>. Ele pode ser Θ( n<sup>3</sup> ), tão ruim quanto Θ( n<sup>4</sup> ) ou até pior, mas sabemos que é pelo menos tão ruim quanto n<sup>3</sup>. Então Ω nos dá um <em>limite inferior</em> para a complexidade do nosso algoritmo. De maneira similar ao "o", nós podemos escrever ω se soubermos que nosso limite não é estreito. Por exemplo, um algoritmo Θ( n<sup>3</sup> ) é ο( n<sup>4</sup> ) e ω( n<sup>2</sup> ). Ω( n ) se pronuncia como "grande omega de n" enquanto que ω( n ) se pronuncia "pequeno omega de n"</p>


        <div class='exercise'>
            <h3>Exercício 6</h3>

            <p>Para as seguintes complexidades Θ, escreva um limite O estreito e um não estreito, além de um limite Ω estreito outro não estreito de sua escolha, desde que eles existam.</p>
            <ol>
                <li>Θ( 1 )</li>
                <li>Θ( <img alt='sqrt( n )' src='images/sqrtn.png' /> )</li>
                <li>Θ( n )</li>
                <li>Θ( n<sup>2</sup> )</li>
                <li>Θ( n<sup>3</sup> )</li>
            </ol>
        </div>

        <div class='exercise solution'>
            <h3>Solução</h3>

            <p>Essa é uma aplicação intuitiva dos concentos que vimos acima.</p>

            <ol>
                <li>Os limites estreitos vão ser O( 1 ) e Ω( 1 ). Um limite O não estreito seria O( n ). Lembre-se que O nos dá um limite superior. Como n é de uma escala maior que 1, esse limite não é estreito, então também podemos escrevê-lo como o( n ). Mas não é possível encontrar um limite não estreito para Ω, pois não podemos usar um valor menor que 1 para essas funções. Então vamos ter que usar somente o limite estreito.</li>
                <li>Os limites estreitos vão ter que ser os mesmos da complexidade Θ, então eles são O( <img alt='sqrt( n )' src='images/sqrtn.png' /> ) e Ω( <img alt='sqrt( n )' src='images/sqrtn.png' /> ) respectivamente. Para limite superior não estreito, nós podemos usar O( n ), porque n é maior que <img alt='sqrt( n )' src='images/sqrtn.png' /> então é um limite superior para <img alt='sqrt( n )' src='images/sqrtn.png' />. Como sabemos que ele é um limite não estreito, também podemos escrevê-lo como o( n ). Para um limite inferior não estreito, podemos simplesmente utilizar Ω( 1 ). Como sabemos que esse limite não é estreito, também podemos escrevê-lo como ω( 1 ).</li>
                <li>Os limites estreitos são O( n ) e Ω( n ). Dois limites não estreitos podem ser ω( 1 ) e o( n<sup>3</sup> ). Esses na verdade são limites bem ruins, porque estão longe das complexidades originais, mas ainda são válidos de acordo com as nossas definições.</li>
                <li>Os limites estreitos são O( n<sup>2</sup> ) e Ω( n<sup>2</sup> ). Para limites não estreitos podemos novamente usar ω( 1 ) e o( n<sup>3</sup> ) assim como no exemplo anterior.</li>
                <li>Os limites estreitos são O( n<sup>3</sup> ) e Ω( n<sup>3</sup> ) respectivamente. Dois limites não estreitos podem ser ω( <img alt='sqrt( n )' src='images/sqrtn.png' /> n<sup>2</sup> ) e o( <img alt='sqrt( n )' src='images/sqrtn.png' /> n<sup>3</sup> ). Mesmo sendo limites não estreitos, eles ainda são melhores que os que demos acima.</li>
            </ol>
        </div>

        <p>A razão de usarmos O e Ω ao invés de Θ mesmo que O e Ω possam dar intervalos estreitos é que pode ser que não sejamos capazes de determinar se um intervalo que encontramos é realmente estreito, ou talvez só não queremos passar pelo processo verificá-lo cuidadosamente.</p>

        <p>Se você não entender muito bem todos os símbolos diferentes e seus usos, não se preocupe muito com isso agora. Você pode sempre voltar e dar outra olhada. Os símbolos mais importantes são O e Θ.</p>

        <p>Note também que mesmo Ω nos dando um limite inferior para a nossa função (ou seja, melhoramos o programa e agora ele executa menos instruções) nós ainda estamos nos referindo a análise do pior caso. Isso acontece porque nós estamos alimentando o nosso programa com a pior entrada possível para um dado n e analisando o seu comportamento a partir desse princípio.</p>

        <p>A tabela seguinte mostra os símbolos que acabamos de apresentar e sua correspondência com os símbolos matemáticos que geralmente usamos com números. A razão para não usarmos os símbolos matemáticos aqui e usarmos letras gregas é para indicar que estamos realizando uma comparação entre comportamentos assintóticos, e não somente simples comparações.</p>

        <div class='figure'>
            <table>
                <thead>
                    <tr>
                        <th>Operador de comparação assintótica</th>
                        <th>Operador de comparação numérica</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nosso algoritmo é <strong>o</strong>( alguma coisa )</td>
                        <td>Um número é <strong>&lt;</strong> alguma coisa</td>
                    </tr>
                    <tr>
                        <td>Nosso algoritmo é <strong>O</strong>( alguma coisa )</td>
                        <td>Um número é <strong>≤</strong> something</td>
                    </tr>
                    <tr>
                        <td>Nosso algoritmo é <strong>Θ</strong>( alguma coisa )</td>
                        <td>Um número é <strong>=</strong> alguma coisa</td>
                    </tr>
                    <tr>
                        <td>Nosso algoritmo é <strong>Ω</strong>( alguma coisa )</td>
                        <td>Um número é <strong>≥</strong> alguma coisa</td>
                    </tr>
                    <tr>
                        <td>Nosso algoritmo é <strong>ω</strong>( alguma coisa )</td>
                        <td>Um número é <strong>></strong> alguma coisa</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class='highlight'>
            <p class='thumb'><strong>Regra geral</strong>: Mesmo que todos os símbolos O, o, Ω, ω e Θ sejam úteis, O é o que é mais utilizado, porque é mais fácil de se determinar do que Θ e tem mais utilidade prática do que Ω.</p>
        </div>

        <div class='right sidefigure'>
            <img src='images/log-vs-linear.png' alt='A função logarítmo é muito menor que a função raiz quadrada, que por sua vez é muito menor que a função linear mesmo para um n pequeno.' />
            <label><strong>Figure 4</strong>: Uma comparação entre as funções n, <img alt='sqrt( n )' src='images/sqrtn.png' />, e log( n ). A função n, a função linear, desenhada em verde no topo, cresce muito mais rápido que a função da raiz quadrada, desenhada em vermelho, no meio, que por sua vez cresce muito mais rápido que a função log( n ) desenhada em azul na base desse gráfico. Mesmo para valores de n pequenos como n = 100, a diferença é bem notável.</label>
        </div>

        <h2 id='logarithms'>Logarítmos</h2>

        <p>Se você já sabe o que são logaritmos, sinta-se livre para pular essa seção. Como muita gente não os conhece, ou simplesmente não o usaram tanto ultimamente e não se lembram bem deles, essa seção é uma introdução. Esse texto também é para estudantes mais jovens que ainda não estudaram logaritmos na escola. Logaritmos são importantes porque eles aparecem bastante quando analisamos complexidade. Um logaritmo é uma operação aplicada a um número que o torna bem menor - como uma raiz quadrada de um número. Então se tem uma coisa que você vai querer lembrar de logaritmos, é que eles pegam um número e o tornam bem menor que o número original (Veja a <strong>Figura 4</strong>). Agora, da mesma maneira que a raiz quadrada é a operação inversa de elevar alguma coisa ao quadrado, o logaritmo é a operação inversa da exponenciação. Não é tão difícil quanto parece. Fica melhor explicado com um exemplo. Considere essa equação:</p>

        <p>2<sup>x</sup> = 1024</p>

        <p>Nós queremos resolver essa equação para <var>x</var>. Então nos perguntamos: Qual é a potência de base 2 que é igual a 1024? Esse número é o 10. Então, nós temos que 2<sup>10</sup> = 1024, o que é fácil de se verificar. Logaritmos nos ajudam a representar esse problema com uma nova notação. Nesse caso, 10 é o logaritmo de 1024 e nós o escrevemos como log ( 1024 ) e o lemos como "o logaritmo de 1024". Como estamos usando o 2 como base, nós o chamamos de logaritmo de base 2. Existem logaritmos e outras bases, mas vamos usar somente logaritmos de base 2 nesse artigo. Se você é um estudante que participa de competições internacionais e não sabe logaritmos, eu recomendo fortemente que você os <a href='http://tutorial.math.lamar.edu/Classes/Alg/LogFunctions.aspx'>pratique</a> depois de terminar de ler esse artigo. Na ciência da computação, logaritmos de base 2 são muito mais comuns que qualquer outro tipo de logaritmo. Isso acontece porque geralmente temos somente duas entidades diferentes: 0 e 1. Nós também tendemos a dividir problemas grandes em metades, que são sempre duas. Então você só precisa saber logaritmos de base 2 para continuar nesse artigo.</p>

        <div class='exercise'>
            <h3>Exercício 7</h3>

            <p>Resolva as equações abaixo. Escreva o logaritmo que você encontrar em cada caso. Use somente logaritmos de base 2.</p>
            <ol>
                <li>2<sup>x</sup> = 64</li>
                <li>(2<sup>2</sup>)<sup>x</sup> = 64</li>
                <li>4<sup>x</sup> = 4</li>
                <li>2<sup>x</sup> = 1</li>
                <li>2<sup>x</sup> + 2<sup>x</sup> = 32</li>
                <li>(2<sup>x</sup>) * (2<sup>x</sup>) = 64</li>
            </ol>
        </div>

        <div class='exercise solution'>
            <h3>Solução</h3>

            <p>Não é preciso fazer mais nada além de aplicar as ideias definidas acima.</p>
            <ol>
                <li>Por tentativa e erro podemos encontrar que x = 6, e então log( 64 ) = 6.</li>
                <li>Aqui podemos notar que (2<sup>2</sup>)<sup>x</sup>, pelas propriedades da exponenciação, pode ser escrito como 2<sup>2x</sup>. Então temos que 2x = 6 porque log( 64 ) = 6 de acordo com o exercício anterior, portanto x = 3.</li>
                <li>Usando o que sabemos da equação anterior, podemos escrever 4 como 2<sup>2</sup> então nossa equação se torna (2<sup>2</sup>)<sup>x</sup> = 4 que é o mesmo que 2<sup>2x</sup> = 4. Então notamos que log( 4 ) = 2 porque 2<sup>2</sup> = 4 então temos que 2x = 2, logo x = 1. Isso é facilmente observado a partir da equação original, uma vez que usar um exponente igual a 1 nos dá a base como resultado.</li>
                <li>Lembre-se que um expoente 0 nos dá 1 como resultado. Então temos que log( 1 ) = 0 pois 2<sup>0</sup> = 1, então x = 0.</li>
                <li>Aqui temos uma soma, então não podemos calcular o logaritmo diretamente. Porém, notamos que 2<sup>x</sup> + 2<sup>x</sup> é o mesmo que 2 * (2<sup>x</sup>). que por sua vez é igual a 2<sup>x + 1</sup>. Agora, tudo que temos que fazer é resolver a equação 2x + 1 = 32. Nós encontramos log( 32 ) = 5, então x + 1 = 5, resultando que x = 4.</li>
                <li>Nós estamos multiplicando duas potências de base 2, então podemos juntá-las notando que (2<sup>x</sup>) * (2<sup>x</sup>) é o mesmo que 2<sup>2x</sup>. Então, tudo que temos que fazer é resolver a equação 2<sup>2x</sup> = 64 que já resolvemos acima, então x = 3.</li>
            </ol>
        </div>

        <div class='highlight'>
            <p class='thumb'><strong>Regra geral</strong>: Para algoritmos de competições implementados em C++, depois que você analisa a complexidade, você pode fazer uma estimativa do quão rápido o seu programa irá executar assumindo que ele realiza cerca de 1.000.000 operações por segundo, onde a quantidade de operações que você contou são dadas pelo comportamento assintótico da função que descreve o seu algoritmo. Por exemplo, um algoritmo Θ( n ) leva cerca de um segundo para processar uma entrada n = 1.000.000.</p>
        </div>

        <div class='right sidefigure'>
            <img src='images/factorial-recursion.png' alt='factorial( 5 ) -&gt; factorial( 4 ) -&gt; factorial( 3 ) -&gt; factorial( 2 ) -&gt; factorial( 1 )' />
            <label><strong>Figura 5</strong>: Chamadas recursivas realizadas pela função fatorial.</label>
        </div>

        <h2 id='recursion'>Complexidade recursiva</h2>

        <p>Vamos agora dar uma olhada em uma função recursiva. Uma <em>função recursiva</em> é uma função que chama a ela mesma. Podemos analisar a complexidade dela? A seguinte função, escrita em Python, calcula o <a href='http://pt.wikipedia.org/wiki/Fatorial'>fatorial</a> de um número. O fatorial é um número inteiro positivo que é encontrado ao se multiplicar esse número com todos os números inteiros positivos anteriores. Por exemplo, o fatorial de 5 é 5 * 4 * 3 * 2 * 1. Nós o denotamos como "5!" e o pronunciamos como "cinco fatorial" (algumas pessoas preferem pronunciar gritando como "CINCO!!!").</p>

        <div class='leftofimage'>
            <pre class='brush: python; gutter: false; toolbar: false;'>
                def factorial( n ):
                    if n == 1:
                        return 1
                    return n * factorial( n - 1 )
            </pre>
        </div>

        <p>Vamos analisar a complexidade dessa função. Essa função não tem nenhum loop, mas sua complexidade não é constante. Para encontrarmos sua complexidade, temos novamente que contar as suas instruções. Claramente, se passarmos algum n para essa função, ele vai ser executada n vezes. Se você não tiver certeza disso, execute agora a função "na mão" para n = 5 para validar se ela realmente funciona. Por exemplo, para n = 5, ela será executada 5 vezes, porque ela vai decrementar n em 1 a cada chamada. Nós podemos então ver que essa função é Θ( n ).</p>

        <p>Se você não tiver certeza disso, lembre-se que você pode sempre encontrar a complexidade exata ao contar as instruções. Se você quiser, pode tentar contar as instruções executadas por essa função e encontrar uma função f( n ) e verificar se ela é realmente linear (lembre-se que linear significa Θ( n )).</p>

        <p>Veja a <strong>Figura 5</strong> com um diagrama para lhe ajudar a entender as chamadas recursivas que são feitas quando a função <code>factorial(5)</code> é chamada.</p>

        <p>Isso deve deixar claro o porquê dessa função ser linear.</p>

        <div class='right sidefigure'>
            <img src='images/binary-search.png' alt='Busca binária em um array' />
            <label><strong>Figura 6</strong>: a recursão feita pela busca binária. O argumento A para cada chamada está destacado em preto. A recursão continua até o array examinado conter apenas um elemento. Cortesia de Like Francl.</label>
        </div>

        <h2 id='logcomplexity'>Complexidade logaritmica</h2>

        <p>Um problema famoso na ciência da computação é o de encontrar um valor em um array. Nós resolvemos esse problema anteriormente para um caso geral. Esse problema se torna interessante se tivermos um array que está ordenado e queremos encontrar um certo valor dentro dele. Um maneira para se fazer isso é conhecida como busca binária. Nós olhamos o elemento do meio no nosso array: Se o encontrarmos ali, então terminamos. Caso contrário, se o valor que encontrarmos for menor que o valor pelo qual estamos procurando, nós sabemos que o elemento estará na parte esquerda do array. Caso contrário, nós sabemos que ele estará na parte direita do array. Nós podemos continuar cortando o array em partes menores até termos um único elemento para olhar. Eis o método usando pseudocódigo:</p>

        <div class='leftofimage'>
            <pre class='brush: python; gutter: false; toolbar: false;'>
                def binarySearch( A, n, value ):
                    if n = 1:
                        if A[ 0 ] = value:
                            return true
                        else:
                            return false
                    if value &lt; A[ n / 2 ]:
                        return binarySearch( A[ 0...( n / 2 - 1 ) ], n / 2 - 1, value )
                    else if value &gt; A[ n / 2 ]:
                        return binarySearch( A[ ( n / 2 + 1 )...n ], n / 2 - 1, value )
                    else:
                        return true
            </pre>
        </div>

        <p>Esse pseudocódigo é uma simplificação da implementação verdadeira. Na prática, esse método é mais fácil descrito do que implementado, porque o(a) programador(a) precisa tomar cuidado com alguns detalhes na implementação. Podem existir erros em expressões booleanas e a divisão por 2 nem sempre vai resultar em um valor inteiro, então será necessário arredondar o valor com floor() ou ceil(). Mas podemos assumir para os nossos propósitos que ela vai sempre ser bem sucedida, e que a nossa implementação está livre desses erros, pois queremos apenas analisar a complexidade desse método. Se você nunca implementou uma busca binária antes, pode ser que você queria fazer isso na sua linguagem de programação favorita. É um esforço realmente esclarecedor.</p>

        <p>Veja a <strong>Figura 6</strong> para ajudar no entendimento de como a busca binária funciona.</p>

        <p>Se você tiver dúvidas se esse método realmente funciona, aproveite agora para rodar ele na mão em um exemplo simples e convença a si mesmo que ele realmente funciona.</p>

        <p>Vamos agora tentar analisar o algoritmo. Novamente, nós temos um algoritmo recursivo. Vamos assumir, para simplificar as coisas, que o array sempre será cortado exatamente no meio, ignorando a parte do +1 e -1 na chamada recursiva. Você já deve estar convencido de que uma pequena mudança como ignorar +1 e -1 não vai afetar o resultado da complexidade. Esse é um fato que normalmente teríamos que provar se quiséssemos ser prudentes de um ponto de vista matemático, mas na prática isso já é intuitivo. Vamos assumir que nosso array tem um tamanho que é uma potência de 2, também para simplificar. Novamente, isso não muda o resultado final da complexidade que vamos encontrar. O pior caso para esse problema é quando o valor pelo qual estamos procurando não existe no array. Nesse caso, começamos com um array de tamanho n na primeira chamada recursiva, então temos um array de tamanho n / 2 na próxima chamada. Então teremos um array de tamanho n / 4 na próxima chamada, seguido por um array de tamanho n / 8, e assim por diante. Em geral, nosso array é dividido pela metade em cada chamada, até encontrarmos um array de tamanho 1. Então, vamos escrever o número de elementos no nosso array para cada chamada:</p>
        <ol class='hide-nums'>
            <li>0-ésima iteração: n</li>
            <li>primeira iteração: n / 2</li>
            <li>segunda iteração: n / 4</li>
            <li>terceira iteração: n / 8</li>
            <li>...</li>
            <li>i-ésima iteração: n / 2<sup>i</sup></li>
            <li>...</li>
            <li>última iteração: 1</li>
        </ol>

        <p>Note que na i-ésima iteração, nosso array tem n / 2<sup>i</sup> elementos. Isso acontece porque a cada iteração nós estamos cortando nosso array pela metade, o que significa que estamos dividindo o seu número de elementos por 2. Isso se traduz em multiplicar o denominador por 2. Se fizermos isso i vezes, temos n / 2<sup>i</sup>. Esse procedimento continua e quanto maior for o i, menor vai ser a quantidade de elementos até chegarmos na última iteração em que teremos apenas um único elemento restante. Se quisermos encontrar o i para vermos em qual iteração isso acontece, temos que resolver a seguinte equação:</p>

        <p>1 = n / 2<sup>i</sup></p>

        <p>Ela somente será verdadeira quando tivermos chegado na última chamada da função binarySearch(), e não em um caso geral. Então resolver a equação para i nos ajuda a encontrar em qual iteração a recursão vai terminar. Multiplicando ambos os lados por 2<sup>i</sup> nos dá:</p>

        <p>2<sup>i</sup> = n</p>

        <p>Esta equação deve parecer familiar se você leu a seção de logaritmos acima. Resolver essa equação para i nos dá:</p>

        <p>i = log( n )</p>

        <p>Isto nos diz que o número de iterações necessárias para realizar uma busca binária é log( n ), onde n é o número de elementos do array original.</p>

        <p>Se você pensar sobre isso, vai ver que faz sentido. Por exemplo, seja n = 32, um array de 32 elementos. Quantas vezes teremos que cortá-lo pela metade para chegar em apenas 1 elemento? Nós temos 32 → 16 → 8 → 4 → 2 → 1. Fizemos isso 5 vezes, que é o logaritmo de 32. Logo, a complexidade da busca binária é Θ( log( n ) ).</p>

        <p>Esse último resultado nos permite comparar a busca binária com a busca linear, nosso método anterior. Claramente, como log( n ) é muito menor que n, é razoável concluir que a busca binária é um método bem mais rápido de busca em um array do que a busca linear, então é recomendado sempre manter nossos arrays ordenados se quisermos fazer muitas buscas neles.</p>

        <div class='highlight'>
            <p class='thumb'><strong>Regra geral</strong>: Melhorar o comportamento assintótico de um programa geralmente aumenta muito a sua performance, muito mais do que qualquer pequena otimização "técnica" como usar uma linguagem de programação mais rápida.</p>
        </div>

        <h2 id='sort'>Ordenação ótima</h2>

        <p><strong>Parabéns.</strong> Você sabe sobre análise de complexidade de algoritmos, comportamento assintótico de funções e a notação big-O. Você também sabe, de forma intuitiva, descobrir se a complexidade de um algoritmo é O( 1 ), O( log( n ) ), O( n ), O( n<sup>2</sup> ) e assim por diante. Você conhece os símbolos o, O, ω, Ω e Θ, e sabe o que significa análise do pior caso. Se você chegou a esse ponto, esse tutorial já serviu o seu propósito.</p>

        <p>Essa última seção é opcional. É um pouco mais aprofundada, então sinta-se livre para pulá-la se você sentir que é demais. Ela vai precisar do seu foco e que você gaste alguns momentos trabalhando nos exercícios. Entretanto, ela vai te dar um método muito útil na análise de complexidade de algoritmos que pode ser muito poderoso, então certamente vale a pena entender.</p>

        <p>Nós vimos uma implementação de ordenação acima chamada selection sort. Nós mencionamos que o selection sort não é ótimo. Um <em>algoritmo ótimo</em> é um algoritmo que resolve um problema da melhor maneira possível, o que significa que não existe um algoritmo melhor pra isso. Isso quer dizer que todos os outros algoritmos para resolver esse problema tem uma complexidade igual ou pior que o algoritmo ótimo. Podem existir muitos algoritmos ótimos para um problema com todos eles compartilhando da mesma complexidade. O problema de ordenação pode ser resolvido de maneira ótima de várias formas. Nós podemos usar a mesma ideia da busca binária para ordenar rapidamente. Esse método de ordenação é chamado de <em>mergesort</em>.</p>

        <p>Para fazer um mergesort, primeiro precisamos criar uma função auxiliar que vamos usar para fazer a ordenação de fato. Nós vamos criar uma função <code>merge</code> que pega dois arrays que já estão ordenados e os junta em um array maior ordenado. Isso é fácil:</p>

        <pre class='brush: python; gutter: false; toolbar: false;'>
            def merge( A, B ):
                if empty( A ):
                    return B
                if empty( B ):
                    return A
                if A[ 0 ] &lt; B[ 0 ]:
                    return concat( A[ 0 ], merge( A[ 1...A_n ], B ) )
                else:
                    return concat( B[ 0 ], merge( A, B[ 1...B_n ] ) )
        </pre>

        <p>A função <code>concat</code> pega um item, a "cabeça", e um array, a "cauda", e constrói e retorna um novo array que contém a "cabeça" como primeiro item no novo array e a "cauda" como o resto dos elementos do array. Por exemplo, <code>concat(3, [4, 5, 6])</code> retorna <code>[3, 4, 5, 6]</code> . Nós usamos <code>A_n</code> e <code>B_n</code> para denotar os tamanhos dos arrays <code>A</code> e <code>B</code>, respectivamente.</p>

        <div class='exercise'>
            <h3>Exercício 8</h3>

            <p>Verifique que a função acima realmente faz uma união de dois arrays. Reescreva-o em sua linguagem de programação favorita em uma forma iterativa (usando loops <code>for</code>) ao invés de recursão.</p>
        </div>

        <p>Analisar esse algoritmo revela que ele tem um tempo de execução de Θ( n ), onde n é o tamanho do array resultante (n = A_n + B_n).</p>

        <div class='exercise'>
            <h3>Exercício 9</h3>

            <p>Verifique que o tempo de execução do <code>merge</code> é de Θ( n ).</p>
        </div>

        <p>Utilizando essa função, podemos construir um algoritmo de ordenação melhor. A ideia é a seguinte: Nós dividimos o array em duas partes. Então, ordenamos cada parte recursivamente, para em seguida unir os dois arrays ordenados em um array maior. Em pseudocódigo:</p>

        <pre class='brush: python; gutter: false; toolbar: false;'>
        def mergeSort( A, n ):
            if n = 1:
                return A # já está ordenado
            middle = floor( n / 2 )
            leftHalf = A[ 1...middle ]
            rightHalf = A[ ( middle + 1 )...n ]
            return merge( mergeSort( leftHalf, middle ), mergeSort( rightHalf, n - middle ) )
        </pre>

        <p>Esta função é mais difícil de se entender do que a que vimos anteriormente, então o próximo exercício pode levar alguns minutos.</p>

        <div class='exercise'>
            <h3>Exercício 10</h3>

            <p>Verifique se o <code>mergeSort</code> está correto. Isso é, cheque se o <code>mergeSort</code> como definido acima ordena corretamente o array que é dado a ele. Se você estiver tendo dificuldades para entender porque ele funciona, tente com um array de exemplo pequeno e rode ele "na mão". Quando executar essa função na mão, certifique-se que <code>leftHalf</code> e <code>rightHalf</code> são o que você consegue se cortar o array aproximadamente no meio; ele não tem que estar exatamente no meio se o array tiver um número ímpar de elementos (foi pra isso que usamos o <code>floor</code> acima).</p>
        </div>

        <p>Como exemplo final, vamos analisar a complexidade do <code>mergeSort</code>. Em cada passo do <code>mergeSort</code>, estamos dividindo o array em duas metades de tamanho igual, de maneira similar a <code>binarySearch</code>. Entretanto, nesse caso, nós vamos manter ambas as metades durante a execução. Então aplicamos o algoritmo recursivamente em cada metade. Depois que a recursão terminar, aplicamos a operação <code>merge</code> no resultado, o que leva um tempo Θ( n ).</p>

        <p>Então, nós dividimos o array original em dois arrays de tamanho n / 2 cada. Em seguida nós unimos os dois arrays, em uma operação que une <code>n</code> elementos e que portanto, leva um tempo Θ( n ).</p>

        <p>Dê uma olhada na <strong>Figura 7</strong> para entender essa recursão.</p>

        <div class='sidefigure'>
            <img src='images/mergesort-recursion.png' alt='N se divide em N / 2 e N / 2. Cada uma delas se divide em N / 4 e N / 4, e o processo continua até termos chamadas de tamanho 1.' />
            <label><strong>Figure 7</strong>: A árvore de recursão do merge sort.</label>
        </div>

        <p>Vamos ver o que está acontecendo aqui. Cada círculo representa uma chamada à função <code>mergeSort</code>. O número escrito dentro do círculo mostra o tamanho do array que está sendo ordenado. O círculo azul no topo é a chamada inicial ao <code>mergeSort</code>, onde temos que ordenar um array de tamanho <code>n</code>. As flechas indicam chamadas recursivas feitas entre funções. A chamada inicial do <code>mergeSort</code> faz duas chamdas para <code>mergeSort</code> em dois arrays, cada um de tamanho n / 2. Isso é indicado pelas duas flechas no topo. Por sua vez, cada uma dessas chamadas faz mais duas outras chamadas para <code>mergeSort</code> em mais dois arrays, cada um de tamanho n / 4, e assim por diante até chegarmos nos arrays de tamanho 1. Esse diagrama é chamado de árvore de recursão, porque ele demonstra como a recursão se comporta e se parece com uma árvore (a raiz está no topo e as folhas na base, então na verdade se parece com uma árvore invertida).</p>

        <p>Note que em cada linha do diagrama acima, o número total de elementos é n. Para ver isso, olhe para cada linha individualmente. A primeira linha contém somente uma chamada para <code>mergeSort</code> comum array de tamanho <var>n</var>, então o número total de elementos é <var>n</var>. A segunda linha tem duas chamadas para <code>mergeSort</code>, cada uma com tamanho n / 2. Mas n / 2 + n / 2 = n, então novamente, o número total de elementos é <var>n</var>. Na terceira linha, temos 4 chamadas para as quais são aplicados arrays de tamanho n / 4 cada uma, dando um número total de elementos igual a n / 4 + n / 4 + n / 4 + n / 4, que é igual a 4n / 4 = n. Então, novamente temos <var>n</var> elementos. Agora note que em cada linha nesse diagrama, quem chama as funções tem que fazer uma operação <code>merge</code> nos elementos retornados pelas funções que são chamadas. Por exemplo, o círculo indicado pela cor vermelha tem que ordenar n / 2 elementos. Para fazer isso, ele divide o array de tamanho n / 2 em dois arrays de tamanho n / 4, chama o <code>mergeSort</code> recursivamente para ordená-los (essas chamadas são os círculos indicados em verde), então os une. Essa operação de união tem que unir n / 2 elementos. A cada linha da nossa árvore, o número total de elementos unidos é n. Na linha que acabamos de olhar, nossa função une n / 2 elementos e a função à sua direita (que está em azul) também tem que unir n / 2 elementos. Isso retorna n elementos no total que precisam ser unidos para a linha que estamos olhando.</p>

        <p>Por esse argumento, a complexidade de cada linha é de Θ( n ). Sabemos que o número de linhas nesse diagrama, também chamado de <em>profundidade</em> da árvore de recursão, vai ser log( n ). A razão para isso é exatamente a mesma que usamos quando analisamos a complexidade da busca binária. Nós temos log( n ) linhas e cada uma delas é Θ( n ), logo, a complexidade do <code>mergeSort</code> é Θ( n * log( n ) ). Isso é bem melhor do que Θ( n<sup>2</sup> ) que tínhamos com o selection sort (lembre-se que log( n ) é bem menor do que n, então n * log( n ) é bem menor do que n * n = n<sup>2</sup>). Se isso parecer complicado para você, não se preocupe: Não é fácil da primeira vez. Volte para essa seção e leia novamente sobre os argumentos depois de implementar o mergesort na sua linguagem de programação favorita e validar que ele funciona.</p>

        <p>Como você viu no último exemplo, análise de complexidade nos permite comparar algoritmos para ver qual é o melhor. Sob essas circunstâncias, nós podemos agora ter certeza de que o merge sort tem uma performance melhor do que o selection sort em arrays grandes. Essa conclusão seria difícil de ser alcançada se não tivéssemos esse background teórico de análise de algoritmos que acabamos de desenvolver. Na prática, os algoritmos que rodam em Θ( n * log( n ) ) são os mais usados. Por exemplo, <a href='https://github.com/torvalds/linux/blob/master/lib/sort.c'>o kernel Linux usa um algoritmo de ordenação chamado heapsort</a>, que tem o mesmo tempo de execução do mergesort que exploramos aqui, que é Θ( n log( n ) ), então ele é ótimo. Note que nós não provamos que esses algoritmos de ordenação são ótimos. Fazer isso necessita de um argumento matemático mais aprofundado, mas fique tranquilo porque eles não podem ficar melhores de um ponto de vista de complexidade.</p>

        <p>Ao terminar de ler esse tutorial, a intuição que você desenvolveu sobre complexidade de algoritmos deve ser capaz de te ajudar a fazer programas melhores e focar os seus esforços de otimização em coisas que realmente importam, no lugar de pequenas coisas que não importam, fazendo o seu trabalho ficar mais produtivo. Além disso, a notação e linguagem matemática que desenvolvemos nesse artigo, como a notação big-O é útil para se comunicar com outros engenheiros de software quando você quiser argumentar sobre o tempo de execução de algoritmos, então você deverá ser capaz de fazer isso com o seu conhecimento recém adquirido.</p>

        <h2 id='about'>Sobre</h2>
        <p>Este artigo está licenciado com uma Licença <a href='http://creativecommons.org/licenses/by/3.0/'>Creative Commons Atribuição 3.0</a>. Isso significa que você pode copiar/colar, compartilhar, postar no seu site, modificar, e de maneira geral, fazer o que você quiser com ele, desde que mencione o meu nome. Mesmo que você não tenha que fazer isso, se você se basear no meu trabalho, eu o encorajo a publicar seus próprios escritos sob o Creative Commons para ser mais fácil para que outros também compartilhem e colaborem. Da mesma forma, tenho que dar créditos aos trabalhos que usei aqui. Os ícones estilosos que você vê nessa página são os <a href='http://p.yusukekamiyamane.com/'>ícones fugue</a>. O lindo padrão listrado que você vê nesse design foi criado por <a href='http://leaverou.me/css3patterns/'>Lea Verou</a>. E, o mais importante, os algoritmos que eu sei, e que me permitiram escrever esse artigo foram ensinados a mim pelos meu professores <a href='http://www.softlab.ntua.gr/~nickie/'>Nikos Papaspyrou</a> e <a href='http://www.softlab.ntua.gr/~fotakis/'>Dimitris Fotakis</a>.</p>

        <p>Atualmente, sou um candidato a PhD na pela <a href='https://en.uoa.gr'>Universidade de Atenas</a>. Quando eu escrevi esse artigo, eu era um estudante de graduação em <a href='https://www.ece.ntua.gr/en'>Engenharia Elétrica e Computacional</a> na <a href='https://www.ntua.gr/en/'>Universidade Nacional Técnica de Atenas</a> aprendendo <a href='http://www.cslab.ntua.gr'>software</a> e era coach na <a href='http://www.pdp.gr/'>Competição Grega de Informática</a>. Na indústria, trabalhei como membro no time de engenharia que fez o <a href='https://www.deviantart.com/'>deviantART</a>, uma rede social para artistas, nos times de segurança do <a href='https://www.google.com'>Google</a> e do <a href='https://twitter.com'>Twitter</a>, e em duas start-ups, Zino e Kamibu onde fizermos redes sociais e video games, respectivamente. <a href='https://www.twitter.com/dionyziz'>Me siga no Twitter</a> ou no <a href='https://github.com/dionyziz'>GitHub</a> se você gostou do artigo, ou <a href='mailto:dionyziz@gmail.com'>mande um e-mail</a> se quiser entrar em contato. Muitos jovens programadores não tem um bom conhecimento em inglês. Mande um e-mail se você quiser traduzir o artigo para a sua língua nativa, para que mais pessoas possam lê-lo.</p>

        <p><strong>Obrigado por ler.</strong> Eu não fui pago para escrever esse artigo, então se você gostou, <a href='mailto:dionyziz@gmail.com'>me mande um e-mail</a> para dizer oi. Eu gosto de receber imagens de lugares ao redor do mundo, então sinta-se livre para anexar uma foto sua na sua cidade!</p>

        <h2 id='references'>Referências</h2>
        <ol>
            <li>Cormen, Leiserson, Rivest, Stein. <a href='http://www.amazon.co.uk/Introduction-Algorithms-T-Cormen/dp/0262533057/ref=sr_1_1?ie=UTF8&amp;qid=1341414466&amp;sr=8-1'>Introduction to Algorithms</a>, MIT Press.</li>
            <li>Dasgupta, Papadimitriou, Vazirani. <a href='http://www.amazon.co.uk/Algorithms-Sanjoy-Dasgupta/dp/0073523402/ref=sr_1_1?s=books&amp;ie=UTF8&amp;qid=1341414505&amp;sr=1-1'>Algorithms</a>, McGraw-Hill Press.</li>
            <li>Fotakis. Course of <a href='http://discrete.gr/'>Discrete Mathematics</a> at the National Technical University of Athens.</li>
            <li>Fotakis. Course of <a href='http://www.corelab.ece.ntua.gr/courses/algorithms/'>Algorithms and Complexity</a> at the National Technical University of Athens.</li>
        </ol>

       <div id="disqus_thread"></div>
<?php
    return array(
        'title' => 'A Gentle Introduction to Algorithm Complexity Analysis',
        'content' => ob_get_clean()
    );
?>

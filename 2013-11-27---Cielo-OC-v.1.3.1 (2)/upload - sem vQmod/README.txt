Módulo Cielo sem gateways de pagamento Brasil (Brazil module)

Este é um módulo de pagamento para OpenCart que permite a comunicação DIRETA entre a sua loja e a Cielo sem utilizar NENHUM gateway de pagamento!

Livre-se para sempre das tarifas e percentuais dos gateways de pagamento tais como PayPal, PagSeguro, BCash e etc. e passe a pagar apenas o percentual negociado entre você e sua operadora!

Um exemplo: se sua loja realiza duas vendas por dia, num valor médio de R$ 100,00.
== PayPal seus custos serão: 6,4% + R$ 0,60 por transação => R$ 420,00
== Cielo: um contrato normal da Cielo é de cerca de 3%* => R$ 180,00.
(* Estimativa. A taxa efetiva depende da sua negociação com o Banco e a Cielo).

Uma economia de R$ 240,00 por mês, mais de 50%! E o melhor é que, até o presente momento, a afiliação de e-commerce da Cielo não está sujeita a nenhuma mensalidade!

Você poderá oferecer parcelamentos personalizados com e sem juros. É possível personalizar descontos, valores mínimos e múltiplos parcelamento para cada bandeira, separadamente.

As operações de consulta, captura (total e parcial) e cancelamento (total e parcial) são feitas diretamente na área administrativa da sua loja. Você não precisará acessar o site da Cielo para essas operações administrativas, tudo é feito na sua própria loja.

Toda a comunicação com a Cielo (XML) é armazenada em uma tabela separada no DB, possibilitando a resolução de pendências.

Compatível com qualquer moeda, desde que tenha o Real (BRL) cadastrado como moeda principal ou secundária. Todos os valores são autorizados em reais, convertidos automaticamente. Já vem com o português e inglês configurados.

Compatível com "buy page" na loja ou na Cielo. Para a "buy page" na loja você será obrigado a passar pelo PCI compliance (boa sorte!), o que é caro e complicado. Recomendamos utilizar a "buy page" na Cielo, pois é muito mais simples e seguro.

Mas se alguém quiser tentar homologar uma "buy page" na loja, teremos prazer em tentar ajudar (na verdade temos curiosidade de descobrir as dificuldades junto com você).

A licença é POR LOJA onde for utilizado este módulo de pagamento.

Você precisa ser afiliado à Cielo (veja: http://www.cielo.com.br/). Atualmente compatível com Visa, Mastercard, American Express, Diners Club, Elo, Discover, JCB e Aura. Cartões internacionais são suportados, basta a liberação da Cielo para a sua loja.

Você pode utilizar o módulo sem um certificado SSL. No entanto, recomendamos que você tenha esse certificado (mesmo que seja compartilhado), pois a Cielo vai pedir um logotipo em GIF, hospedado em https. Eu recomendo a Hostgator (visite esta página: http://www.hostgator.com.br/6860.html). Todos os planos tem SSL compartilhado grátis e o plano G vem com SSL e IP dedicado gratuito. Eu uso esse provedor em alguns sites e funciona perfeito com este módulo.

Observação 1: acompanharemos suas dúvidas durante o procedimento de homologação da Cielo, mas não somos responsáveis pela homologação. Utilize uma página com SSL e "buy page" na Cielo e você provavelmente não terá problemas. Se você já tem a Cielo homologada (em outro site ou gateway) então poderá começar a utilizar este módulo sem uma nova homologação.

Observação 2: embora este módulo preveja a configuração para cartões de débito e cobranças recorrentes, estas funções ainda não estão operacionais. Não é culpa do módulo, mas dos bancos e da Cielo. Se você é um mortal normal, evite essas opções e trabalhe com o crédito, ok?

CHANGELOG:

Versão 1.3.1:
    Consertado o bug de criação das tabelas do banco de dados na instalação.
    Adicionado suporte à versão 1.5.6 do OpenCart, na versão com vQmod.

Versão 1.3:
    Atualização para o novo padrão de XML da Cielo (1.2.1).
    Acrescentado suporte às bandeiras JCB e Aura.
    Corrigido bug de seleção de parcelas e bandeira no checkout.
    Adicionada opção de exibição das figuras das bandeiras no checkout.
    Melhorias na interface de configuração do módulo no Admin.
    Corrigido bug da ordem de exibição do módulo.
    Funcionalidade de normalização das configurações no update (upgrade suave).

Versão 1.2.1:
    Corrigido bug de cookie.
    Suprimidos erros no GA.
    Melhorias na página de transação negada.
    Nova versão de XML no vQmod para sistemas Linux.
    Não liberada para distribuição.

Versão 1.2:
    Corrigido erro de variável não declarada (erro raro)
    Incluído o suporte às versões 1.5.5 e 1.5.5.1 do OpenCart

Versão 1.1:
    Incluído suporte à versão 1.5.4 e 1.5.4.1 do OpenCart
    Corrigido alguns bugs que ocorriam com versões antigas do PHP
    Incluído suporte ao Google Analytics (estatísticas de uso)
    Corrigido erro de "headers already sent"
    Apromirada a view área administrativa

Versão 1.0:
    Bugs corrigidos
    Incluído o tratamento de erros
    Incluído Sandbox automático (não é mais necessário preencher o número de estabelecimento e chave de testes)
    Melhorada a view do checkout
    Introdução da versão com vQmod

Versão 0.8:
    Versão de testes inicial com vários bugs. Não liberada para distribuição.

Informações para Upgrade:
- Para atualizar o módulo para a versão mais recente, basta sobrescrever os arquivos antigos com os novos. No primeiro acesso às configurações do módulo no admin, este fará a atualização automática (upgrade suave), sem perda das configurações atuais e você já terá acesso às novas opções. Não há necessidade de desinstalação e reinstalação (aliás, NÃO faça isso).

Informações comerciais:
- Solução de pagamento com a Cielo, sem utilização de gateways;
- Suporte a Visa, Mastercard, Diners Club, American Express, Elo e Discover. O suporte a Visa Electron e Redeshop é limitado pelo emissor do cartão. Autorizações recorrentes precisam de condições especiais na Cielo;
- Suporte a cartões internacionais, desde que sua loja seja autorizada pela Cielo para este tipo de operação.

Informações técnicas:
- Compatível com OpenCart 1.5.3.1, 1.5.4, 1.5.4.1, 1.5.5, 1.5.5.1 e 1.5.6. Não temos planos de preparar o módulo para as versões mais antigas, mas se você precisar, basta nos mandar uma mensagem que tentaremos criar a adaptação;
- Se possível, utilize PHP 5.3 (mas funciona no 5.2);
- Funciona com ou sem vQmod. O download vem com ambas as versões. Caso opte pela versão sem vQmod, dois arquivos do OpenCart serão modificados (admin/sale/order.php e admin/view/template/sale/order_info.tpl);
- Com OpenCart versão 1.5.6 utilize sempre a versão COM vQmod;
- A tabela no banco de dados é independente. As tabelas originais do OpenCart não são modificadas;
- Não precisa mexer em código. Toda a instalação e operação ocorre na área administrativa;
- Sandbox mode para testes (não precisa de n° de afiliação, nem chave de segurança)
- Os valores mínimos, parcelas mínimas, descontos, parcelamentos sem juros, com juros da loja e com juros da administradora podem ser configurados independentemente para cada bandeira;
- É possível operar com parcelamentos com e sem juros ao mesmo tempo (ex: de 2 a 4 parcelas sem juros, de 5 a 8 parcelas com juros da loja e de 9 a 12 parcelas com juros da administradora, etc..);
- Todas as operações administrativas (consulta, autorização, captura e cancelamento) estão disponíveis para dentro da área administrativa do OpenCart, na página do pedido;
- Todos os XML's enviados e recebidos da Cielo são armazenados em bando de dados;
- Compatível com qualquer moeda, desde que tenha o Real cadastrado como moeda principal ou secundária com o código correto 'BRL'.
- Preparado para internacionalização e já vem com o português brasileiro e inglês configurados;
- Preparado para "buy page" na loja ou na Cielo, sendo este último a modalidade mais recomendada para pequenas lojas, devido aos custos e dificuldades do PCI compliance (procedimento de auditoria exigido pela Cielo);
- O uso de certificado SSL não é obrigatório, mas altamente recomendado. Além de aumentar a segurança de seus clientes (e melhorar as vendas) será exigido pela Cielo um logotipo da sua loja hospedado em ambiente seguro (https);
- O código-fonte possui implementação de ferramenta de análise server side (GA) para log informações de instalação e desempenho (apenas PHP >= 5.3) em shutdown function;

Informações sobre a licença:
- Este NÃO É um software livre. A licença é comercial e POR LOJA onde for utilizado este módulo de pagamento. Se você é um desenvolvedor, repasse o custo desse módulo aos seus clientes e adquira uma licença para cada site desenvolvido.
- Não temos nenhuma relação com a Cielo. Esse desenvolvimento é uma solução independente que utiliza a API da Cielo;
- Todos os direitos do código fonte e sua funcionalidade são reservados ao autor, Victor Schröder. Todos os direitos da marca Cielo, logotipo e ambiente de operação são reservados à Cielo.
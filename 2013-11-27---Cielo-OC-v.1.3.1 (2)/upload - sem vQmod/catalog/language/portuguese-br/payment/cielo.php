<?php
/**
 * Módulo Cielo para OpenCart 1.5.3.1 a 1.5.6
 * Integração direta com a Cielo,
 * sem utilização de Gateways de pagamento
 * 
 * Todos os direitos reservados.
 * Proibido modificar, distribuir, reutilizar, etc.,
 * seja no todo ou em parte, sem a permissão do autor.
 * 
 * Para utilizar esse módulo, você deve comprar uma licença
 * Visite a página de módulos do OpenCart
 * ou envie um e-mail para mim.
 * 
 * As licenças são por loja. Cada loja, uma licença.
 * 
 * Os arquivos 'language' podem ser livremente traduzidos,
 * conforme a sua necessidade. Os arquivos 'template' podem
 * ser alterados para adequação ao seu layout.
 * 
 * Se você precisar de um serviço de hospedagem bom e barato para a sua loja
 * recomendamos a Hostgator - http://www.hostgator.com.br/6860.html
 * No plano G você obtém SSL e IP dedicado grátis.
 * 
 * @author  Victor Schröder <domains@egeeks.com.br>
 * @copyright  Copyright (c) 2012, Victor Schröder. All rights reserved. Must buy a Commercial Licence (per store).
 * @link  http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8855
 */

// Model
$_['text_title'] = 'Cartões de crédito/débito';
$_['text_total_cielo_desc'] = 'Desconto';
$_['text_total_cielo_juros'] = 'Juros';

// View
$_['warning_sandbox_mode'] = 'O sistema de cartões da loja está operando em modo de testes. Por favor escolha outra forma de pagamento.';
$_['cielo_buy_page_info'] = 'Por favor selecione abaixo a forma de pagamento desejada e clique em confirmar. Você preencherá os dados de seu cartão na página seguinte, em ambiente seguro.';
$_['loja_buy_page_info'] = 'Por favor, insira abaixo as informações de seu cartão e selecione a forma de pagamento desejada';
$_['erro_sem_operacoes'] = 'Ops, parece que não estamos com nenhum cartão habilitado para essa compra. Talvez o valor da sua compra seja muito baixo. Por favor, escolha outra forma de pagamento ou acrescente mais itens ao carrinho.';
$_['entry_nome_portador'] = 'Nome do portador do cartão:';
$_['entry_numero_cartao'] = 'Número do cartão:';
$_['entry_validade_cartao'] = 'Validade (MM/AAAA):';
$_['entry_codigo_seguranca'] = 'Código de segurança:';
$_['text_codigo_inexistente'] = 'código inexistente';
$_['text_codigo_ilegivel'] = 'código ilegível';
$_['text_envia_erro'] = 'Estava tentando fazer uma compra na loja quando recebi essa mensagem de erro:\\n\\n';
$_['cielo_instrucoes_cvv'] = '<b>Como localizar o código de segurança:</b><br /><br />Para cartões Visa, Mastercard, Diners Club, Elo e Discover: três últimos números no verso do cartão próximo do local de assinatura.<br /><br />Para cartões American Express: quatro números na frente do cartão acima da numeração principal.<br /><br />Caso seu cartão não tenha código ou esteja ilegível, marque a opção adequada. Contudo, seu cartão poderá ser recusado pela operadora pela falta do código de segurança.';
$_['form_1_parcela'] = '%1$02d parcela de %2$s';
$_['form_1_parcela_desconto'] = ' com desconto de %01.2f%%.';
$_['form_parcelas_sem_juros'] = '%1$02d parcelas de %2$s sem juros.';
$_['form_parcelas_com_juros'] = '%1$02d parcelas de %2$s com juros de %3$01.2f%% a.m.';
$_['form_parcelas_juros_adm'] = '%02d parcelas iguais com juros calculados pela sua administradora.';
$_['text_script_nao_feche'] = 'Não feche essa janela. Estamos processando as informações do seu cartão. Este processo pode demorar até 40 segundos, por favor aguarde.';
$_['text_script_title'] = 'Processamento de Cartão de Crédito';
$_['text_script_erro_preenchimento'] = 'Ocorreu um erro de preenchimento. Por favor retorne à página anterior e confira se as informações do seu cartão estão corretas ou escolha outra forma de pagamento:<br /><br />Informações sobre o erro:<br />Código:';
$_['text_script_falha_comunicacao'] = 'Ocorreu uma falha na comunicação. Você pode tentar novamente ou voltar e escolher outra forma de pagamento:<br /><br />Informações sobre o erro:<br />Código';
$_['text_script_ocorreu_um_erro'] = 'Ocorreu um erro. Por favor confira se as informações do seu cartão estão corretas ou escolha outra forma de pagamento:<br /><br />Informações sobre o erro:<br />Código:';
$_['text_script_redirecionando'] = 'Você será redirecionado para o site seguro da Cielo. Caso você não seja redirecionado, clique no botão abaixo.';
$_['text_script_pedido_aprovado'] = 'Seu pedido foi aprovado com sucesso! Clique no botão abaixo para ver as informações do seu pedido.';
$_['text_script_erro_inesperado'] = 'Ocorreu um erro inesperado. Não tente fazer o pedido novamente pois poderá haver duplicidade. Por favor entre em contato conosco.';
$_['text_script_erro_timeout'] = 'Tempo de operação esgotado. Não tente fazer o pedido novamente pois poderá haver duplicidade. Por favor entre em contato conosco.<br /><br />Informações sobre o erro:';
$_['text_script_erro_tecnico'] = 'Ocorreu um erro técnico em nossos servidores. Não tente fazer o pedido novamente pois poderá haver duplicidade. Por favor entre em contato conosco.<br /><br />Informações sobre o erro:';


$_['text_script_botao_retornar'] = 'Retornar';
$_['text_script_botao_retry'] = 'Tentar novamente';
$_['text_script_botao_redirecionar'] = 'Ir para o site da Cielo';
$_['text_script_botao_finalizar'] = 'Finalizar';
$_['text_script_botao_contato'] = 'Ir para a página de contato';


// Cielo => Confirm
$_['erro_preenchimento'] = 'Erro no preenchimento do formulário do cartão';
$_['erro_bandeira_nao_selecionada'] = 'Bandeira não selecionada';
$_['erro_bandeira_invalida'] = 'Bandeira inválida ou não ativa';
$_['erro_numero_parcelas_nao_selecionado'] = 'Número de parcelas não selecionado';
$_['erro_numero_parcelas_invalido'] ='Número de parcelas inválido';
$_['erro_numero_cartao_nao_preenchido'] = 'Número do cartão não preenchido';
$_['erro_numero_cartao_invalido'] = 'Número de cartão inválido';
$_['erro_validade_nao_preenchida'] = 'Data de validade não preenchida';
$_['erro_validade_inferior_atual'] = 'A data de validade não pode ser menor que a data atual';

// Error codes
$_['erro_code_server'] = 'Erro interno, falha de comunicação (cURL)';

// XML error codes
$_['XML_error_code_001'] = 'Erro de configuração (XML). Favor entrar em contato.';
$_['XML_error_code_002'] = 'Erro de configuração (credenciais). Favor entrar em contato.';
$_['XML_error_code_003'] = 'Forma de pagamento inválida ou inexistente.';
$_['XML_error_code_010'] = 'Erro de configuração (buy page). Favor entrar em contato.';
$_['XML_error_code_011'] = 'Forma de pagamento não habilitada na loja. Favor entrar em contato.';
$_['XML_error_code_012'] = 'Número de parcelas superior ao permitido.';
$_['XML_error_code_013'] = 'Erro de configuração (flag de autorização). Favor entrar em contato.';
$_['XML_error_code_014'] = 'Erro de configuração (autorização 3). Favor entrar em contato.';
$_['XML_error_code_015'] = 'Não constam os dados do cartão para autorização. Favor entrar em contato.';
$_['XML_error_code_016'] = 'Erro de configuração (TID). Favor entrar em contato.';
$_['XML_error_code_017'] = 'Código de segurança ausente. Se estiver utilizando American Express essa informação é obrigatória.';
$_['XML_error_code_018'] = 'Problemas com o identificador do código de segurança. Favor entrar em contato.';
$_['XML_error_code_019'] = 'Erro de configuração (URL de retorno). Favor entrar em contato.';
$_['XML_error_code_020'] = 'Essa transação já foi autorizada ou não permite autorização. Favor entrar em contato.';
$_['XML_error_code_021'] = 'Prazo de autorização vencido.';
$_['XML_error_code_025'] = 'Problemas no processo de autorização. Favor entrar em contato.';
$_['XML_error_code_030'] = 'Essa transação já foi capturada ou não permite captura. Favor entrar em contato.';
$_['XML_error_code_031'] = 'Prazo de captura vencido.';
$_['XML_error_code_032'] = 'O valor indicado para captura é inválido. Favor entrar em contato.';
$_['XML_error_code_033'] = 'Falha na captura. Tente novamente.';
$_['XML_error_code_040'] = 'Prazo de cancelamento vencido.';
$_['XML_error_code_041'] = 'Essa transação já foi cancelada ou não permite cancelamento.';
$_['XML_error_code_042'] = 'Falha no cancelamento. Tente novamente.';
$_['XML_error_code_043'] = 'O valor de cancelamento não pode ser maior que o valor capturado.';
$_['XML_error_code_053'] = 'Cobrança recorrente não habilitada na loja. Favor entrar em contato.';
$_['XML_error_code_097'] = 'Sistema temporariamente indisponível. Tente novamente em alguns minutos.';
$_['XML_error_code_098'] = 'Tempo de operação esgotado. Tente novamente.';
$_['XML_error_code_099'] = 'Falha de sistema na operadora. Favor entrar em contato.';
$_['XML_error_code_NNN'] = 'Código de erro não cadastrado. Favor entrar em contato.';

// XML lr codes
$_['XML_lr_code_00'] = 'Transação autorizada com sucesso.';
$_['XML_lr_code_01'] = 'Transação referida pelo emissor. Por favor entre em contato com o emissor do seu cartão.';
$_['XML_lr_code_04'] = 'Seu cartão encontra-se com restrição(ões). Por favor entre em contato com o emissor do seu cartão.';
$_['XML_lr_code_05'] = 'Transação não autorizada.';
$_['XML_lr_code_06'] = 'Erro de comunicação. Por favor tente novamente.';
$_['XML_lr_code_07'] = 'Seu cartão encontra-se com restrição(ões). Por favor entre em contato com o emissor do seu cartão.';
$_['XML_lr_code_12'] = 'Tipo de transação inválida para o seu cartão.';
$_['XML_lr_code_13'] = 'Valor inválido para autorização. Foi atingido o valor mínimo de R$ 5,00?';
$_['XML_lr_code_14'] = 'Cartão inválido.';
$_['XML_lr_code_15'] = 'O emissor do seu cartão não é válido para essa transação.';
$_['XML_lr_code_41'] = 'Seu cartão encontra-se com restrição(ões). Por favor entre em contato com o emissor do seu cartão.';
$_['XML_lr_code_51'] = 'Saldo insuficiente para essa operação. Verifique seu saldo e tente novamente';
$_['XML_lr_code_54'] = 'Seu cartão encontra-se vencido.';
$_['XML_lr_code_57'] = 'Esse tipo de transação não é permitida para o seu cartão';
$_['XML_lr_code_58'] = 'Esse tipo de transação não é permitida para o seu cartão';
$_['XML_lr_code_62'] = 'Seu cartão encontra-se com restrição(ões). Por favor entre em contato com o emissor do seu cartão.';
$_['XML_lr_code_63'] = 'Seu cartão encontra-se com restrição(ões). Por favor entre em contato com o emissor do seu cartão.';
$_['XML_lr_code_76'] = 'Erro de comunicação. Por favor tente novamente.';
$_['XML_lr_code_78'] = 'Seu cartão ainda não foi desbloqueado junto ao emissor. Entre em contato com o emissor de seu cartão para desbloqueá-lo e tente novamente.';
$_['XML_lr_code_82'] = 'Tipo de transação inválida para o seu cartão.';
$_['XML_lr_code_91'] = 'O sistema do banco emissor de seu cartão encontra-se indisponível. Por favor tente novamente em alguns minutos.';
$_['XML_lr_code_96'] = 'Erro de comunicação. Por favor tente novamente.';
$_['XML_lr_code_AA'] = 'Erro de comunicação. Por favor tente novamente.';
$_['XML_lr_code_AC'] = 'Operações de crédito não são permitidas para cartões de débito.';
$_['XML_lr_code_GA'] = 'Transação referida pela Cielo. Por favor entre em contato.';
$_['XML_lr_code_N7'] = 'Código de segurança inválido (Visa).';
$_['XML_lr_code_NNN'] = 'Código de erro não cadastrado. Favor entrar em contato.';

// XML status codes
$_['XML_status_code_4'] = 'Transação autorizada com sucesso.';
$_['XML_status_code_6'] = 'Transação autorizada com sucesso.';

$_['XML_status_code_0'] = 'Transação criada mas ainda não processada.';
$_['XML_status_code_1'] = 'Transação em andamento.';
$_['XML_status_code_3'] = 'Transação não autenticada.';
$_['XML_status_code_10'] = 'Transação em processo de autenticação.';

$_['XML_status_code_5'] = 'Transação não autorizada.';
$_['XML_status_code_9'] = 'Transação cancelada.';
$_['XML_status_code_12'] = 'Transação processo de cancelamento.';

$_['XML_status_code_2'] = 'Transação autenticada mas ainda não processada.';
$_['XML_status_code_8'] = 'Transação processada mas ainda não debitada.';

$_['XML_status_code_NA'] = 'Código de status não cadastrado. Favor entrar em contato.';

// Cielo => retorno
$_['retorno_heading_title'] = 'Página de retorno do cartão: <b>Transação Negada</b>';
$_['text_checkout'] = 'Finalizar compra';
$_['retorno_compra_nao_confirmada'] = 'Sua compra <b><u>não foi confirmada</u></b>. Veja abaixo o motivo:';
$_['retorno_codigo_evento'] = 'Código do evento ou erro:';
$_['retorno_descricao_evento'] = 'Descrição:';
$_['retorno_erro_nao_definitivo'] = 'Este erro não é definitivo, você ainda pode tentar passar novamente o mesmo cartão ou escolher outra forma de pagamento. Não se preocupe, os itens que você escolheu ainda estão no carrinho de compras!';
$_['retorno_escolher_outra_forma'] = 'Não deixe suas compras para trás! Os itens que você escolheu ainda estão no carrinho de compras. Você ainda pode voltar e escolher outra forma de pagamento.';
$_['retorno_voltar_ao_checkout'] = 'Clique aqui para retornar ao checkout do pedido.';

 ?>
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

// Heading
$_['heading_title'] = 'Cielo (por Victor Schröder)';

// Text Success and Error
$_['text_success'] = 'Configurações do módulo de pagamentos Cielo modificadas com sucesso.';
$_['install_success'] = 'O módulo de pagamentos Cielo foi corretamente instalado e as tabelas necessárias foram criadas no banco de dados.';
$_['error_permission'] = 'Você não tem as permissões necessárias para operar/modificar o módulo de pagamentos Cielo.';
$_['uninstall_success'] = 'É triste vê-lo partir... O módulo de pagamentos Cielo foi desinstalado, as tabelas do módulo foram apagadas e um backup foi criado na pasta de logs do OpenCart.';

// Payments => Cielo
$_['text_description'] = 'O módulo de pagamentos Cielo para OpenCart foi criado para possibilitar a comunicação direta da sua loja com os servidores da Cielo, sem a necessidade de intermediários, diminuindo assim os custos com gateways de pagamento. Alguns requisitos são necessários para utilizar este módulo. Para saber mais, <a href="http://developers.egeeks.com.br/modulo-cielo-opencart.html" target="_blank">clique aqui</a><br /><br />Este módulo é uma solução independente utilizando a API de comunicação da Cielo, não sendo endossado nem possuindo qualquer relação oficial com a Cielo.';
$_['entry_sandbox_mode'] = 'Operar em modo de testes (Sandbox)?&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Com o modo sandbox ativado, você pode efetuar testes com números de cartão fictícios. Neste caso, não é necessário preencher o número do estabelecimento e a chave de segurança." />';
$_['entry_estabelecimento'] = 'Número do Estabelecimento&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Insira o número de afiliação do seu estabelecimento, fornecido pela Cielo." />';
$_['entry_chave_seguranca'] = 'Chave de Segurança&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Insira a chave de segurança fornecida pela Cielo. A chave de segurança é secreta e não deve ser compartilhada com terceiros." />';
$_['entry_buy_page'] = 'Modalidade de <i>Buy Page</i><br /><span class="help">Duas opções: "Cielo" <img src="view/image/cielo_help.png" class="tip" title="Ao utilizar Buy Page &quot;Cielo&quot;, o preenchimento dos dados do cartão pelo consumidor será efetuado na página segura da Cielo após um redirecionamento, retornando em seguida novamente para a loja" /> ou "Loja" <img src="view/image/cielo_help.png" class="tip" title="Ao utilizar Buy Page &quot;Loja&quot;, os dados serão preenchidos diretamente na página de checkout, sem redirecionamentos. Isso pode ser positivo para diminuir as taxas de abandono de carrinho, mas as exigências de segurança e a responsabilidade do lojista são maiores."  />';
$_['text_buy_page_loja'] = 'Loja';
$_['entry_exibicao_checkout'] = 'Exibição no checkout&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Escolha se serão exibidos os logotipos dos cartões ou apenas seus nomes." />';
$_['text_exibicao_checkout_img'] = 'Imagens das bandeiras';
$_['text_exibicao_checkout_text'] = 'Nome das bandeiras';
$_['entry_soft_descriptor'] = '<i>Soft Descriptor</i>&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="A soma do número de caracteres do nome da sua loja na Cielo e do soft descriptor não deve ultrapassar 19 caracteres. Selecionando &quot;n° do pedido&quot;, o sistema gerará automaticamente uma identificação de sete caracteres do tipo &quot;P000123&quot;" /><br /><span class="help">Texto personalizado que aparecerá na fatura do cartão de crédito de seu cliente, ao lado do nome da loja (tal como feito pelo PayPal, Facebook, Google, etc.).</span>';
$_['text_usar_nenhum'] = 'Não utilizar';
$_['text_usar_num_pedido'] = 'N° do pedido';
$_['text_usar_outro'] = 'Outro texto (max. 13 caracteres):';
$_['entry_habilitar_operacao'] = 'Habilitar essa operação?';
$_['entry_operacao_nome'] = 'Nome de exibição:';
$_['entry_operacao_valor_minimo'] = 'Valor mínimo:';
$_['entry_operacao_parc_minima'] = 'Parcela mínima:';
$_['entry_operacao_desconto'] = 'Desconto:<br /><span class="help">Para uma parcela</span>';
$_['entry_operacao_max_parc'] = 'N° máximo de parcelas:';
$_['entry_operacao_max_parc_sj'] = 'N° máximo de parcelas<br />sem juros:';
$_['entry_operacao_max_parc_jl'] = 'N° máximo de parcelas<br />com juros da loja:';
$_['entry_operacao_juros_loja'] = 'Taxa de juros da loja';
$_['entry_operacao_auto_capturar'] = 'Capturar automaticamente?&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Operações não capturadas automaticamente devem ser capturadas em até cinco dias ou serão canceladas!" />';
$_['entry_operacao_autorizacao'] = 'Tipo de autorização';
$_['text_autorizacao_0'] = '0-Não autorizar, somente autenticar';
$_['text_autorizacao_1'] = '1-Autorizar somente autenticada';
$_['text_autorizacao_2'] = '2-Autorizar autenticada e não autenticada';
$_['text_autorizacao_3'] = '3-Autorização direta (sem autenticação)';
$_['text_autorizacao_4'] = '4-Autorização recorrente';
$_['entry_status_pedido_pendente'] = 'Status para pedido pendente de pagamento';
$_['entry_status_pedido_erro_sem_retry'] = 'Status para pedido com erro sem direito a nova tentativa';
$_['entry_status_pedido_erro_com_retry'] = 'Status para pedido com erro com direito a nova tentativa';
$_['entry_status_pedido_sucesso_sem_captura'] = 'Status para pedido autorizado e não capturado';
$_['entry_status_pedido_sucesso_com_captura'] = 'Status para pedido autorizado e capturado';
$_['entry_geo_zone'] = 'Selecione as regiões habilitadas para essa forma de pagamento';
$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Ordem de exibição';
$_['text_author'] = 'Módulo de pagamentos Cielo para OpenCart criado por <a href="http://developers.egeeks.com.br/">Victor Schröder</a>.<br />Todos os direitos reservados. Este módulo está sujeito à compra de licença comercial.<br />Caso você não tenha comprado este módulo <a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8855" target="_blank">clique aqui</a> para adquirir uma licença.<br /><br />O plugin jQuery clueTip é de uso livre (MIT/GPL licences) e pode ser encontrado <a href="http://plugins.learningjquery.com/cluetip/" target="_blank">aqui</a>.';
$_['text_payment'] = 'Pagamentos';



// Operações
$_['entry_operacao_visa_electron'] = 'Configurar Visa Electron (débito)';
$_['entry_operacao_redeshop'] = 'Configurar Redeshop/Maestro (débito)';
$_['entry_operacao_visa'] = 'Configurar Visa (crédito)';
$_['entry_operacao_mastercard'] = 'Configurar Mastercard (crédito)';
$_['entry_operacao_diners'] = 'Configurar Diners Club (crédito)';
$_['entry_operacao_amex'] = 'Configurar American Express (crédito)';
$_['entry_operacao_elo'] = 'Configurar Elo (crédito)';
$_['entry_operacao_discover'] = 'Configurar Discover (crédito)';
$_['entry_operacao_jcb'] = 'Configurar JCB (crédito)';
$_['entry_operacao_aura'] = 'Configurar Aura (crédito)';


//Sale => Order => getCielo
$_['tab_cielo'] = 'Histórico Cielo';
$_['table_resumo_title'] = 'Resumo TID';
$_['table_resumo_sem_consultas'] = 'Este TID ainda não tem consultas realizadas<br />Realize uma consulta para atualizar o status.';
$_['table_resumo_transacao'] = 'Transação:';
$_['table_resumo_status'] = 'Status atual:';
$_['table_resumo_bandeira'] = 'Bandeira:';
$_['table_resumo_operacao'] = 'Operação:';
$_['table_resumo_n_parcelas'] = 'N° de parcelas:';
$_['table_resumo_autenticacao'] = 'Autenticação (ECI):';
$_['table_resumo_autorizacao'] = 'Autorização:';
$_['table_resumo_codigo_lr'] = 'Código LR:';
$_['table_resumo_mensagem_cielo'] = 'Mensagem Cielo:';
$_['table_resumo_data'] = 'Data:';
$_['table_resumo_valor'] = 'Valor:';
$_['table_resumo_captura'] = 'Captura:';
$_['table_resumo_cancelamentos'] = 'Cancelamento(s):';
$_['table_resumo_cancel_valor_data'] = '%1$s em %2$s';
$_['table_resumo_cancel_total'] = 'Total cancelado:';
$_['cielo_text_table_title'] = 'Histórico de operações Cielo';
$_['cielo_text_tab_transacao'] = 'Tipo';
$_['cielo_text_tab_tid'] = 'TID';
$_['cielo_text_tab_buy_page'] = 'Buy Page';
$_['cielo_text_tab_teste'] = 'Teste?';
$_['cielo_text_tab_operacao'] = 'Operação';
$_['cielo_text_tab_status'] = 'Status';
$_['cielo_text_tab_valor'] = 'Valor';
$_['cielo_text_tab_parcelas'] = 'Parcelas';
$_['cielo_text_selecione_tid'] = 'TID para operação';
$_['cielo_text_selecione_acao'] = 'Ação a ser enviada';
$_['cielo_text_selecione_valor'] = 'Valor&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Valor em reais (R$ BRL). Apenas para captura e cancelamento parcial. Caso não preenchido será admitido o valor total." />';
$_['cielo_text_proxima_acao'] = 'Enviar operação administrativa?';
$_['cielo_text_option_tid'] = '----- Selecione TID -----';
$_['cielo_text_option_acao'] = '----- Selecione ação -----';
$_['cielo_text_capturar'] = 'Capturar';
$_['cielo_text_cancelar'] = 'Cancelar';
$_['cielo_text_consultar'] = 'Consultar';
$_['cielo_text_autorizar'] = 'Autorizar';
$_['cielo_text_executar'] = 'Enviar à Cielo';
$_['transacao_transacao'] = 'Transação';
$_['transacao_capturar'] = 'Captura';
$_['transacao_capturar_parcial'] = 'Captura parcial';
$_['transacao_cancelar'] = 'Cancelamento';
$_['transacao_cancelar_parcial'] = 'Cancelamento parcial';
$_['transacao_consultar'] = 'Consulta';
$_['transacao_autorizar_tid'] = 'Autorização';
$_['buy_page_loja'] = 'Loja';
$_['buy_page_cielo'] = 'Cielo';
$_['buy_page_admin'] = 'Admin';

$_['traduz_status_'] = 'Não definido';
$_['traduz_status_0'] = '0-Criada';
$_['traduz_status_1'] = '1-Em andamento';
$_['traduz_status_10'] = '10-Em autenticação';
$_['traduz_status_2'] = '2-Autenticada';
$_['traduz_status_3'] = '3-Não autenticada';
$_['traduz_status_5'] = '5-Não autorizada';
$_['traduz_status_4'] = '4-Autorizada';
$_['traduz_status_12'] = '12-Em cancelamento';
$_['traduz_status_9'] = '9-Cancelada';
$_['traduz_status_6'] = '6-Capturada';

$_['traduz_bandeira_visa'] = 'Visa';
$_['traduz_bandeira_mastercard'] = 'Mastercard';
$_['traduz_bandeira_amex'] = 'American Express';
$_['traduz_bandeira_diners'] = 'Diners Club';
$_['traduz_bandeira_elo'] = 'Elo';
$_['traduz_bandeira_discover'] = 'Discover';
$_['traduz_bandeira_jcb'] = 'JCB';
$_['traduz_bandeira_aura'] = 'Aura';

$_['traduz_produto_A'] = 'Débito';
$_['traduz_produto_1'] = 'Crédito à vista';
$_['traduz_produto_2'] = 'Parcelado Loja';
$_['traduz_produto_3'] = 'Parcelado Administradora';

$_['traduz_eci_0'] = '0-Sem autenticação';
$_['traduz_eci_1'] = '1-Sem mecanismos de autenticação no emissor';
$_['traduz_eci_2'] = '2-Autenticado com sucesso';
$_['traduz_eci_5'] = '5-Autenticado com sucesso';
$_['traduz_eci_6'] = '6-Sem mecanismos de autenticação no emissor';
$_['traduz_eci_7'] = '7-Sem autenticação';
$_['traduz_eci_NNN'] = 'Ainda não consta status de autenticação<br />É recomendável fazer uma consulta<br />para verificar o status atual.';

$_['traduz_lr_00'] = '00-Autorizado com sucesso.';
$_['traduz_lr_01'] = '01-Referido pelo emissor. Verificar com a Cielo.';
$_['traduz_lr_04'] = '04-Cartão com restrições.';
$_['traduz_lr_05'] = '05-Não autorizado.';
$_['traduz_lr_06'] = '06-Erro de comunicação.';
$_['traduz_lr_07'] = '07-Cartão com restrições.';
$_['traduz_lr_12'] = '12-Transação inválida.';
$_['traduz_lr_13'] = '13-Valor inválido.';
$_['traduz_lr_14'] = '14-Cartão inválido.';
$_['traduz_lr_15'] = '15-Emissor inválido.';
$_['traduz_lr_41'] = '41-Cartão com restrições.';
$_['traduz_lr_51'] = '51-Saldo insuficiente.';
$_['traduz_lr_54'] = '54-Cartão vencido.';
$_['traduz_lr_57'] = '57-Não permitido.';
$_['traduz_lr_58'] = '58-Não permitido.';
$_['traduz_lr_62'] = '62-Cartão com restrições.';
$_['traduz_lr_63'] = '63-Cartão com restrições.';
$_['traduz_lr_76'] = '76-Erro de comunicação.';
$_['traduz_lr_78'] = '78-Cartão sem desbloqueio.';
$_['traduz_lr_82'] = '82-Transação inválida.';
$_['traduz_lr_91'] = '91-Banco indisponível.';
$_['traduz_lr_96'] = '96-Erro de comunicação.';
$_['traduz_lr_AA'] = 'AA-Erro de comunicação.';
$_['traduz_lr_AC'] = 'AC-Crédito não permitido para cartão de débito.';
$_['traduz_lr_GA'] = 'GA-Referido pela Cielo. Verificar com a Cielo.';
$_['traduz_lr_N7'] = 'N7-Código de segurança inválido.';
$_['traduz_lr_NNN'] = 'Código não cadastrado.';


// Text script
$_['text_script_title'] = 'Processamento de Operação';
$_['text_script_title_alerta'] = 'Alerta';
$_['text_script_nao_feche'] = 'Não feche essa janela. Aguardando retorno da Cielo. Este processo pode demorar até 40 segundos, por favor aguarde.';
$_['text_script_ocorreu_um_erro'] = 'Ocorreu um erro.<br /><br />Informações sobre o erro:<br />Código:';
$_['text_script_captura_processada'] = 'Operação de captura processada, veja o resultado:<br /><br />Código:';
$_['text_script_cancelamento_processado'] = 'Operação de cancelamento processada, veja o resultado:<br /><br />Código:';
$_['text_script_consulta_processada'] = 'Operação de consulta processada, veja o resultado:<br /><br />XML:';
$_['text_script_autorizacao_processada'] = 'Operação de autorizacao processada, veja o resultado:<br /><br />Código:';
$_['text_script_erro_inesperado'] = 'Ocorreu um erro inesperado.';
$_['text_script_erro_timeout'] = 'Tempo de operação esgotado.<br /><br />Informações sobre o erro:';
$_['text_script_erro_comunicacao'] = 'Ocorreu um erro técnico na comunicação com os servidores.<br /><br />Informações sobre o erro:';
$_['text_script_erro_negativo'] = 'Este campo não aceita valores negativos.';
$_['text_script_erro_NAN'] = 'O valor inserido não é um número ou está formatado incorretamente.';
$_['text_script_erro_soft_descriptor'] = 'A Cielo não aceita <i>soft descriptor</i> com mais de 13 caracteres.';
$_['text_script_erro_valor_minimo'] = 'A Cielo não aceita valores de parcela menores que R$ 5.00.';
$_['text_script_botao_retornar'] = 'Retornar';
$_['text_script_botao_fechar'] = 'Fechar';
$_['text_script_mensagem'] = 'Mensagem';
$_['text_script_valor'] = 'Valor';
$_['text_script_parc_sj_desativado'] = 'Parcelamento sem juros desativado.';
$_['text_script_parc_loja_desativado'] = 'Parcelamento com juros da loja desativado.';
$_['text_script_parc_admin_desativado'] = 'Parcelamento com juros da administradora desativado.';
$_['text_script_parc_sj_ativo'] = 'de 2 a {0} parcelas sem juros.';
$_['text_script_parc_loja_ativo'] = 'de {0} a {1} parcelas com juros da loja.';
$_['text_script_parc_admin_ativo'] = 'de {0} a {1} parcelas com juros da administradora.';



//Sale => Order => ajaxcielo
$_['cielo_erro_inesperado'] = 'Ocorreu um erro inesperado!';



 ?>
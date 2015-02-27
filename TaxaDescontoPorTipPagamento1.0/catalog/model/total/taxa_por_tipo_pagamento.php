<?php
class ModelTotalTaxaPorTipoPagamento extends Model {
	
	public function getTotal(&$total_data, &$total, &$taxes) {
		
		if ($this->config->get('taxa_por_tipo_pagamento_status')) {
			
			$metodos_pagamento_array = $this->config->get('taxa_por_tipo_pagamento_metodos');
			
			if(isset($this->session->data['payment_method']['code'])) {
				$metodo_pagamento_selecionado = $this->session->data['payment_method']['code'];
			}
			
			if(isset($metodo_pagamento_selecionado)) {
				
				for($i=0; $i < count($metodos_pagamento_array); $i++ ) {
					
					if ($metodo_pagamento_selecionado == $metodos_pagamento_array[$i]['metodo_pagamento']) {
						
						$this->load->language('total/taxa_por_tipo_pagamento');
						
						$operador = $metodos_pagamento_array[$i]['operador'];
						$taxa = $metodos_pagamento_array[$i]['taxa'];
						$tipo_taxa = $metodos_pagamento_array[$i]['tipo_taxa'];
					
						if (!$metodos_pagamento_array[$i]['valor_minimo']) {
							$valor_minimo = 0;
						} else {
							$valor_minimo = $metodos_pagamento_array[$i]['valor_minimo'];
						}
						
						if (!$metodos_pagamento_array[$i]['valor_maximo']) {
							$valor_maximo = 0;
						} else {
							$valor_maximo = $metodos_pagamento_array[$i]['valor_maximo'];
						}
						
						$descricao = $metodos_pagamento_array[$i]['descricao'];
						
						#Se o Total do Pedido for Maior/Igual ao Minimo e Menor/Igual ao Maximo --ou-- o Total do Pedido for Maior/Igual ao Minimo e o valor Maximo for igual a Zero
						if ( (($total >= $valor_minimo) && ($total <= $valor_maximo)) || (($total >= $valor_minimo) && ($valor_maximo == 0)) ) {
							
							$valor_taxa_aplicada = $tipo_taxa == "$" ? $taxa : $total * ($taxa/100);

							$texto_descricao_taxa_aplicada = $tipo_taxa == "$" ? $descricao." (".$this->currency->format($valor_taxa_aplicada).")" : $descricao." (".$taxa."%)";
							
							$texto_taxa_aplicada = $operador == "+" ? $this->currency->format($valor_taxa_aplicada) : "- ".$this->currency->format($valor_taxa_aplicada);
							
							$total_data[] = array( 
								'code'		 => 'taxa_por_tipo_pagamento',
								'title'      => $texto_descricao_taxa_aplicada,
								'text'       => '<span class="discont">'.$texto_taxa_aplicada.'</span>',
								'value'      => $valor_taxa_aplicada,
								'sort_order' => $this->config->get('taxa_por_tipo_pagamento_sort_order')
							);
							
							$total = $operador == "+" ? ($total + $valor_taxa_aplicada) : $total - $valor_taxa_aplicada;
						}
					}
				}
			}
		}
	}
	
}
?>
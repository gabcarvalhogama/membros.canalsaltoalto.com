<?php 
	
	class Validation{
		public static function validateCNPJ($cnpj)
		{
			$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
			
			if (strlen($cnpj) != 14)
				return false;

			if (preg_match('/(\d)\1{13}/', $cnpj))
				return false;	


			for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
			{
				$soma += $cnpj[$i] * $j;
				$j = ($j == 2) ? 9 : $j - 1;
			}

			$resto = $soma % 11;

			if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
				return false;

			for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
			{
				$soma += $cnpj[$i] * $j;
				$j = ($j == 2) ? 9 : $j - 1;
			}

			$resto = $soma % 11;

			return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
		}

		public static function validateCPF( $cpf = false ) {
		    if ( ! function_exists('calc_digitos_posicoes') ) {
		        function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
		            for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
		                $soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
		                $posicoes--;
		            }
		            
		            $soma_digitos = $soma_digitos % 11;
		            if ($soma_digitos < 2) $soma_digitos = 0;
		            else $soma_digitos = 11 - $soma_digitos;
		            
		            $cpf = $digitos . $soma_digitos;
		            
		            return $cpf;
		        }
		    }
		    
		    if (!$cpf) return false;

		    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
		 
		    if ( strlen( $cpf ) != 11 ) return false;
		 
		    $digitos = substr($cpf, 0, 9);
		    
		    $novo_cpf = calc_digitos_posicoes( $digitos );
		    
		    $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
		    
		    if ( $novo_cpf === $cpf ) return true;
		    else return false;
		    
		}

		public static function realToDecimal($realValue){
			return (float) number_format((float) str_replace(",",".",str_replace(".","",$realValue)), 2, '.', '');
		}

		public static function decimalToReal($decimalValue) {
		    return number_format($decimalValue, 2, ',', '.');
		}


		public static function convertUSDateToBr($date_conv){
			return (date("d/m/Y", strtotime($date_conv)));
		}


		public static function formatDateToUs($datebr){
			$vari = str_replace('/', '-', $datebr);
			return date('Y-m-d', strtotime($vari));
		}
	}

?>
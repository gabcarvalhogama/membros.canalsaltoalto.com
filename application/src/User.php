<?php

	class User{

		public function create($firstname, $lastname, $cpf, $birthdate, $zipcode, $state, $city, $address, $address_number, $neighborhood, $complement, $cellphone, $email, $password, $type){
			$sql = DB::open()->prepare("INSERT INTO csa_users () VALUES (default, :firstname, :lastname, null, null, :cpf, :birthdate, :zipcode, :state, :city, :address, :address_number, :neighborhood, :complement, :cellphone, :email, :password, :type, NOW(), null)");
			return $sql->execute([
				":firstname" => ucfirst(trim($firstname)),
				":lastname" => ucfirst(trim($lastname)),
				":cpf" => preg_replace('/\D/', '', $cpf),
				":birthdate" => $birthdate,
				":zipcode" => preg_replace('/\D/', '', $zipcode),
				":state" => intval($state),
				":city" => intval($city),
				":address" => ucfirst(trim($address)),
				":address_number" => trim($address_number),
				":neighborhood" => ucfirst(trim($neighborhood)),
				":complement" => ucfirst(trim($complement)),
				":cellphone" => preg_replace('/\D/', '', $cellphone),
				":email" => filter_var($email, FILTER_SANITIZE_EMAIL),
				":password" => Bcrypt::hash($password),
				":type" => intval($type)
			]);
		}

		public function getUserIdByEmail($email){
			$sql = DB::open()->prepare("SELECT iduser FROM csa_users WHERE email = :email LIMIT 1");
			$sql->execute([
				":email" => filter_var($email, FILTER_SANITIZE_EMAIL)
			]);

			return ($sql->rowCount() > 0) ? $sql->fetchObject()->iduser : 0;
		}

		public function getUserByEmail($email){
			$sql = DB::open()->prepare("SELECT * FROM csa_users WHERE email = :email LIMIT 1");
			$sql->execute([
				":email" => filter_var($email, FILTER_SANITIZE_EMAIL)
			]);

			return $sql;
		}

		public function getUserById($iduser){
			$sql = DB::open()->prepare("SELECT 
			    u.iduser, 
			    u.firstname, 
			    u.lastname, 
			    u.profile_photo, 
			    u.biography,
			    u.cpf, 
			    u.birthdate, 
			    u.zipcode, 
			    u.address_state, 
			    u.address_city, 
			    u.address, 
			    u.address_number, 
			    u.address_neighborhood, 
			    u.address_complement, 
			    u.cellphone, 
			    u.email, 
			    u.user_type, 
			    u.created_at, 
			    u.updated_at,
			    um.starts_at, 
			    um.ends_at,
			    m.membership_title,
			    (SELECT COUNT(company_id) FROM csa_companies c WHERE c.iduser = u.iduser) as company_counter
			FROM 
			    csa_users u
			LEFT JOIN 
			    csa_users_memberships um ON u.iduser = um.iduser
			LEFT JOIN 
			    csa_memberships m ON um.membership_id = m.membership_id;
			WHERE u.iduser = :iduser
			LIMIT 1");
			$sql->execute([
				":iduser" => intval($iduser)
			]);

			return $sql;
		}


		public function isUserAdminByEmail($email){
			$sql = DB::open()->prepare("SELECT user_type FROM csa_users WHERE email = :email LIMIT 1");
			$sql->execute([
				":email" => filter_var($email, FILTER_SANITIZE_EMAIL)
			]);

			return ($sql->rowCount() > 0) ? ( ($sql->fetchObject()->user_type) == 1 ) : 0;
		}

	    

	    
	    public function isUserAuthenticated(){
	        if (session_status() == PHP_SESSION_NONE) session_start();
	        
	        return (!empty($_SESSION["csa_email"]) AND !empty($_SESSION["csa_password"])) ? $this->login($_SESSION["csa_email"], $_SESSION["csa_password"]) : false;
	    }

	    public function getPasswordByEmail($email){
	        $sql = DB::open()->prepare("SELECT password FROM csa_users WHERE email = :email  
	            LIMIT 1");
	        $sql->execute([
	            ":email" => filter_var($email, FILTER_SANITIZE_EMAIL)
	        ]);
	        return ($sql->rowCount() > 0) ? $sql->fetchObject()->password : null;
	    }

	    public function login($email, $password){
	        return $this->checkPasswordHashed($password, $this->getPasswordByEmail($email));
	    }
	    
	    public function checkPasswordHashed($password, $dbPassword){
	        return Bcrypt::check($password, $dbPassword);
	    }



		public static function getStates(){
			$sql = DB::open()->prepare("SELECT * FROM csa_states ORDER BY uf");
			$sql->execute();

			return $sql;
		}
		public static function getCitiesByUf($uf){
			$sql = DB::open()->prepare("SELECT * FROM csa_cities WHERE uf = :uf ORDER BY city");
			$sql->execute([
				":uf" => intval($uf)
			]);

			return $sql;
		}

		public function getUsers(){
			$sql = DB::open()->prepare("SELECT 
			    u.iduser, 
			    u.firstname, 
			    u.lastname, 
			    u.profile_photo, 
			    u.biography,
			    u.cpf, 
			    u.birthdate, 
			    u.zipcode, 
			    u.address_state, 
			    u.address_city, 
			    u.address, 
			    u.address_number, 
			    u.address_neighborhood, 
			    u.address_complement, 
			    u.cellphone, 
			    u.email, 
			    u.user_type, 
			    u.created_at, 
			    u.updated_at,
			    um.starts_at, 
			    um.ends_at,
			    m.membership_title,
			    (SELECT COUNT(company_id) FROM csa_companies c WHERE c.iduser = u.iduser) as company_counter
			FROM 
			    csa_users u
			LEFT JOIN 
			    csa_users_memberships um ON u.iduser = um.iduser
			LEFT JOIN 
			    csa_memberships m ON um.membership_id = m.membership_id;
			");
			$sql->execute();

			return $sql;
		}





		public static function validateCNPJ($cnpj){
			$cnpj = preg_replace('/\D/', '', (string) $cnpj);

		    if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
		        return false;
		    }

		    for ($t = 12; $t < 14; $t++) {
		        for ($d = 0, $i = 0, $j = ($t == 12 ? 5 : 6); $i < $t; $i++) {
		            $d += $cnpj[$i] * $j;
		            $j = ($j == 2) ? 9 : $j - 1;
		        }
		        $d = ((10 * $d) % 11) % 10;
		        if ($cnpj[$t] != $d) {
		            return false;
		        }
		    }

		    return true;
		}


		public static function validateCPF( $cpf = false ) {
		    if (!$cpf) return false;

		    $cpf = preg_replace('/\D/', '', $cpf);
		    if (strlen($cpf) != 11) return false;

		    for ($t = 9; $t < 11; $t++) {
		        for ($d = 0, $c = 0; $c < $t; $c++) {
		            $d += $cpf[$c] * (($t + 1) - $c);
		        }
		        $d = ((10 * $d) % 11) % 10;
		        if ($cpf[$c] != $d) return false;
		    }

		    return true;
		}

		public static function realToDecimal($realValue){
			return (float) number_format((float) str_replace(",",".",str_replace(".","",$realValue)), 2, '.', '');
		}

		public static function decimalToReal($decimalValue){
			return str_replace(".", ",", $decimalValue);
		}

		public static function convertUSDateToBr($date_conv){
			return (date("d/m/Y", strtotime($date_conv)));
		}


		public static function formatDateToUs($datebr){
			$vari = str_replace('/', '-', $datebr);
			return date('Y-m-d', strtotime($vari));
		}
	}
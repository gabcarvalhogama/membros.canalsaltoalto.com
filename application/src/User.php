<?php

	class User{
		public $user;

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
				":email" => strtolower(filter_var($email, FILTER_SANITIZE_EMAIL)),
				":password" => Bcrypt::hash($password),
				":type" => intval($type)
			]);
		}

		public function update($firstname = null, $lastname = null, $profile_photo = null, $biography = null, $cpf = null, $birthdate = null, $zipcode = null, $address_state = null, $address_city = null, $address = null, $address_number = null, $address_neighborhood = null, $address_complement = null, $cellphone = null, $iduser) {
		    $sql = DB::open()->prepare("UPDATE csa_users SET 
		        firstname = COALESCE(:firstname, firstname),
		        lastname = COALESCE(:lastname, lastname),
		        profile_photo = COALESCE(:profile_photo, profile_photo),
		        biography = COALESCE(:biography, biography),
		        cpf = COALESCE(:cpf, cpf),
		        birthdate = COALESCE(:birthdate, birthdate),
		        zipcode = COALESCE(:zipcode, zipcode),
		        address_state = COALESCE(:address_state, address_state),
		        address_city = COALESCE(:address_city, address_city),
		        address = COALESCE(:address, address),
		        address_number = COALESCE(:address_number, address_number),
		        address_neighborhood = COALESCE(:address_neighborhood, address_neighborhood),
		        address_complement = COALESCE(:address_complement, address_complement),
		        cellphone = COALESCE(:cellphone, cellphone),
				updated_at = NOW()
		    WHERE iduser = :iduser");

		    return $sql->execute([
		        ":firstname" => ucfirst(trim($firstname)),
		        ":lastname" => ucfirst(trim($lastname)),
		        ":profile_photo" => $profile_photo,
		        ":biography" => ucfirst(trim($biography)),
		        ":cpf" => preg_replace('/\D/', '', $cpf),
		        ":birthdate" => $birthdate,
		        ":zipcode" => preg_replace('/\D/', '', $zipcode),
		        ":address_state" => intval($address_state),
		        ":address_city" => intval($address_city),
		        ":address" => ucfirst(trim($address)),
		        ":address_number" => trim($address_number),
		        ":address_neighborhood" => ucfirst(trim($address_neighborhood)),
		        ":address_complement" => ucfirst(trim($address_complement)),
		        ":cellphone" => preg_replace('/\D/', '', $cellphone),
		        ":iduser" => intval($iduser)
		    ]);
		}

		public function updatePassword($iduser, $password){
			$sql = DB::open()->prepare("UPDATE csa_users SET 
		        password = :password, updated_at = NOW()
		    WHERE iduser = :iduser");

		    return $sql->execute([
		        ":password" => Bcrypt::hash($password),
		        ":iduser" => intval($iduser)
		    ]);
		}


		public function getUserIdByEmail($email){
			$sql = DB::open()->prepare("SELECT iduser FROM csa_users WHERE email = :email LIMIT 1");
			$sql->execute([
				":email" => strtolower(filter_var($email, FILTER_SANITIZE_EMAIL))
			]);

			return ($sql->rowCount() > 0) ? $sql->fetchObject()->iduser : 0;
		}

		public static function getUserIdByEmail2($email){
			$sql = DB::open()->prepare("SELECT iduser FROM csa_users WHERE email = :email LIMIT 1");
			$sql->execute([
				":email" => strtolower(filter_var($email, FILTER_SANITIZE_EMAIL))
			]);

			return ($sql->rowCount() > 0) ? $sql->fetchObject()->iduser : 0;
		}

		public function getUserByEmail($email){
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
			    (SELECT uf FROM csa_states WHERE idstate = u.address_state LIMIT 1) as address_state_name,
			    u.address_city, 
			    (SELECT city FROM csa_cities WHERE idcity = u.address_city LIMIT 1) as address_city_name,
			    u.address, 
			    u.address_number, 
			    u.address_neighborhood, 
			    u.address_complement, 
			    u.cellphone, 
			    u.email, 
			    u.user_type,
			    (SELECT COUNT(company_id) FROM csa_companies WHERE iduser = u.iduser) as company_counter,
			    (SELECT ends_at FROM csa_users_memberships um WHERE um.iduser = u.iduser AND um.status = 'paid' AND ends_at > NOW() ORDER BY ends_at DESC LIMIT 1) as membership_ends_at,
				(SELECT SUM(diamond_value) FROM csa_user_diamonds ud WHERE ud.user_id = u.iduser) as diamonds
			FROM 
			    csa_users u
			WHERE u.email = :email
			LIMIT 1");
			$sql->execute([
				":email" => strtolower(filter_var($email, FILTER_SANITIZE_EMAIL))
			]);

			return $sql;
		}

		public function getUserByCPF($cpf){
			$sql = DB::open()->prepare("SELECT * FROM csa_users WHERE cpf = :cpf LIMIT 1");
			$sql->execute([
				":cpf" => preg_replace('/\D/', '', $cpf)
			]);

			return $sql;
		}

		public function getUserByCNPJ($cnpj){
			$sql = DB::open()->prepare("SELECT * FROM csa_users WHERE cnpj = :cnpj LIMIT 1");
			$sql->execute([
				":cnpj" => preg_replace('/\D/', '', $cnpj)
			]);

			return $sql;
		}

		public function getUserByCellphone($cellphone){
			$sql = DB::open()->prepare("SELECT * FROM csa_users WHERE cellphone = :cellphone LIMIT 1");
			$sql->execute([
				":cellphone" => preg_replace('/\D/', '', $cellphone)
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
			    (SELECT COUNT(company_id) FROM csa_companies c WHERE c.iduser = u.iduser) as company_counter,
				(SELECT SUM(diamond_value) FROM csa_user_diamonds ud WHERE ud.user_id = :iduser) as diamonds
			FROM 
			    csa_users u
			LEFT JOIN 
			    csa_users_memberships um ON u.iduser = um.iduser
			LEFT JOIN 
			    csa_memberships m ON um.membership_id = m.membership_id
			WHERE u.iduser = :iduser
			LIMIT 1");
			$sql->execute([
				":iduser" => intval($iduser)
			]);

			return $sql;
		}


		public static function addDiamond($user_id, $diamond_value, $diamond_origin_id, $diamond_origin_type, $diamond_observation){
			$sql = DB::open()->prepare("INSERT INTO csa_user_diamonds () VALUES (default, :user_id, :diamond_value, :diamond_origin_id, :diamond_origin_type, :diamond_observation, NOW())");
			$sql->execute([
				":diamond_value" => floatval($diamond_value),
				":diamond_origin_id" => intval($diamond_origin_id),
				":diamond_origin_type" => strtolower(trim($diamond_origin_type)),
				":diamond_observation" => ($diamond_observation) ? ucfirst(trim($diamond_observation)) : null,
				":user_id" => intval($user_id)
			]);
		}

		public function getDiamondByUserId($user_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_user_diamonds WHERE user_id = :user_id ORDER BY created_at DESC");
			$sql->execute([
				":user_id" => intval($user_id)
			]);

			return $sql;
		}


		public static function getActiveMembersCount() {
		    $sql = DB::open()->prepare("
		        SELECT COUNT(m.idusermembership) as active_members_count
		        FROM csa_users_memberships m
		        INNER JOIN csa_users u ON m.iduser = u.iduser
		        WHERE m.starts_at <= NOW()
		        AND m.ends_at >= NOW()
		        AND m.status = 'paid'
		        AND u.user_type = 0
		    ");
		    $sql->execute();

		    return $sql->fetchObject()->active_members_count;
		}


		public static function getInactiveMembersCount(){
			$sql = DB::open()->prepare("SELECT COUNT(idusermembership) as inactive_members_count FROM csa_users_memberships WHERE ends_at >= NOW()");
			$sql->execute();

			return $sql->fetchObject()->inactive_members_count;
		}

		public function getNextExpirationMembers($days = 15){
			$sql = DB::open()->prepare("SELECT 
					um.*, 
					u.firstname, 
					u.lastname, 
					u.profile_photo 
				FROM csa_users_memberships um
				LEFT JOIN csa_users u ON um.iduser = u.iduser
				LEFT JOIN (
					SELECT iduser, MAX(ends_at) AS max_ends_at 
					FROM csa_users_memberships 
					WHERE ends_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :days_int DAY)
					GROUP BY iduser
				) um_max ON um.iduser = um_max.iduser AND um.ends_at = um_max.max_ends_at
				WHERE um_max.max_ends_at IS NOT NULL
				ORDER BY um.ends_at ASC;
");
			$sql->execute([
				":days_int" => $days
			]);

			return $sql;
		}

		public function updatePhotoByEmail($email, $file_path){
			$sql = DB::open()->prepare("UPDATE csa_users SET profile_photo = :profile_photo WHERE email = :email");
			return $sql->execute([
				":profile_photo" => strtolower(trim($file_path)),
				":email" => strtolower(filter_var($email, FILTER_SANITIZE_EMAIL))
			]);
		}


		public function isUserAdminByEmail($email){
			$sql = DB::open()->prepare("SELECT user_type FROM csa_users WHERE email = :email LIMIT 1");
			$sql->execute([
				":email" => strtolower(filter_var($email, FILTER_SANITIZE_EMAIL))
			]);

			return ($sql->rowCount() > 0) ? ( ($sql->fetchObject()->user_type) == 1 ) : 0;
		}

	    

	    
	    public function isUserAuthenticated(){
			if (session_status() == PHP_SESSION_NONE) session_start();
			
			// Verifica login normal (com senha)
			if(!empty($_SESSION["csa_email"]) && !empty($_SESSION["csa_password"])){
				return $this->login($_SESSION["csa_email"], $_SESSION["csa_password"]);
			}
			// Verifica se está autenticado via token (sem senha)
			elseif(!empty($_SESSION["csa_email"]) && !empty($_SESSION["csa_user_id"])){
				return true; // Já foi validado pelo token
			}
			
			return false;
		}

	    public function isUserAMember($email){
	    	$sql = DB::open()->prepare("SELECT
			    um.iduser,
			    um.membership_id,
			    um.starts_at,
			    um.ends_at,
			    um.status,
			    CASE
			        WHEN um.starts_at <= NOW() AND um.ends_at >= NOW() THEN TRUE
			        ELSE FALSE
			    END AS is_valid_member
			FROM
			    csa_users_memberships um
			LEFT JOIN
			    csa_users u ON u.iduser = um.iduser
			WHERE
			    u.email = :email
				AND 
				um.status = 'paid'
				AND um.ends_at > NOW()
				AND u.user_type = 0
			LIMIT 1;");
			$sql->execute([
				":email" => strtolower(filter_var($email, FILTER_VALIDATE_EMAIL))
			]);

			return (($sql->rowCount() > 0));
	    }

		public function isUserActiveMember($email){
	    	$sql = DB::open()->prepare("SELECT
			    um.iduser,
			    um.membership_id,
			    um.starts_at,
			    um.ends_at,
			    um.status,
			    CASE
			        WHEN um.starts_at <= NOW() AND um.ends_at >= NOW() THEN TRUE
			        ELSE FALSE
			    END AS is_valid_member
			FROM
			    csa_users_memberships um
			LEFT JOIN
			    csa_users u ON u.iduser = um.iduser
			WHERE
			    u.email = :email
			LIMIT 1;");
			$sql->execute([
				":email" => strtolower(filter_var($email, FILTER_VALIDATE_EMAIL))
			]);

			return (($sql->rowCount() > 0));
	    }

	    public function isMemberEligibleForRenewallDiscount($email){
	    	$sql = DB::open()->prepare("SELECT
            um.iduser,
            um.membership_id,
            um.starts_at,
            um.ends_at,
            um.status,
	            CASE
	                -- Verifica se o usuário foi um membro ativo nos últimos 30 dias
	                WHEN um.ends_at BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() THEN TRUE
	                ELSE FALSE
	            END AS was_recently_valid_member
	        FROM
	            csa_users_memberships um
	        LEFT JOIN
	            csa_users u ON u.iduser = um.iduser
	        WHERE
	            u.email = :email
	        LIMIT 1;");
			$sql->execute([
				":email" => strtolower(filter_var($email, FILTER_VALIDATE_EMAIL))
			]);

			$result = $sql->fetch(PDO::FETCH_ASSOC);
		    
		    // Verifica se o membro foi ativo nos últimos 30 dias
		    return ($result && $result['was_recently_valid_member'] == TRUE);
	    }

	    public function getPasswordByEmail($email){
	        $sql = DB::open()->prepare("SELECT password FROM csa_users WHERE email = :email  
	            LIMIT 1");
	        $sql->execute([
	            ":email" => strtolower(filter_var($email, FILTER_SANITIZE_EMAIL))
	        ]);
	        return ($sql->rowCount() > 0) ? $sql->fetchObject()->password : null;
	    }

	    public function login($email, $password){
	        return $this->checkPasswordHashed($password, $this->getPasswordByEmail($email));
	    }

		public function loginWithRememberToken($email) {
			if (session_status() == PHP_SESSION_NONE) session_start();
			
			// Verifica se o email existe e obtém os dados básicos do usuário
			$sql = DB::open()->prepare("SELECT iduser, email FROM csa_users WHERE email = :email LIMIT 1");
			$sql->execute([":email" => strtolower(filter_var($email, FILTER_VALIDATE_EMAIL))]);
			
			if ($sql->rowCount() > 0) {
				$user = $sql->fetchObject();
				$_SESSION["csa_email"] = $user->email;
				
				// Aqui você pode armazenar o ID do usuário também se precisar
				$_SESSION["csa_user_id"] = $user->iduser;
				
				// Não armazenamos a senha na sessão para login por token
				return true;
			}
			
			return false;
		}
	    
	    public function checkPasswordHashed($password, $dbPassword){
	        return Bcrypt::check($password, $dbPassword);
	    }


		// Na classe User
		public function generateRememberToken() {
			return bin2hex(random_bytes(32));
		}

		public function saveRememberToken($email, $token) {
			$token_hash = hash('sha256', $token);
			$expiry = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30); // 30 dias
			
			$sql = DB::open()->prepare("INSERT INTO csa_remember_tokens 
									(email, token_hash, expires_at) 
									VALUES (:email, :token_hash, :expires_at)");
			return $sql->execute([
				':email' => strtolower(filter_var($email, FILTER_VALIDATE_EMAIL)),
				':token_hash' => $token_hash,
				':expires_at' => $expiry
			]);
		}

		public function verifyRememberToken($email, $token) {
			$token_hash = hash('sha256', $token);
			
			$sql = DB::open()->prepare("SELECT id FROM csa_remember_tokens 
									WHERE email = :email 
									AND token_hash = :token_hash 
									AND expires_at > NOW()");
			$sql->execute([
				':email' => strtolower(filter_var($email, FILTER_VALIDATE_EMAIL)),
				':token_hash' => $token_hash
			]);
			
			return $sql->rowCount() > 0;
		}

		public function deleteRememberToken($email, $token) {
			$token_hash = hash('sha256', $token);
			
			$sql = DB::open()->prepare("DELETE FROM csa_remember_tokens 
									WHERE email = :email 
									AND token_hash = :token_hash");
			return $sql->execute([
				':email' => strtolower(filter_var($email, FILTER_VALIDATE_EMAIL)),
				':token_hash' => $token_hash
			]);
		}


	    public function addMembership($iduser, $membership_id, $order_id, $coupon_id, $payment_method, $payment_value, $starts_at, $ends_at, $status){
	    	$sql = DB::open()->prepare("INSERT INTO csa_users_memberships() VALUES (default, :iduser, :membership_id, :order_id, :coupon_id, :payment_method, :payment_value, :starts_at, :ends_at, :status, NOW())");

	    	return $sql->execute([
	    		":iduser" => intval($iduser),
	    		":membership_id" => intval($membership_id),
	    		":order_id" => $order_id,
	    		":coupon_id" => $coupon_id,
	    		":payment_method" => $payment_method,
	    		":payment_value" => $payment_value,
	    		":starts_at" => $starts_at,
	    		":ends_at" => $ends_at,
	    		":status" => $status
	    	]);
	    }

	    public function updateMembershipByOrderId($order_id, $status, $starts_at, $ends_at){
	    	$sql = DB::open()->prepare("UPDATE csa_users_memberships um 
	    		SET 
	    			um.status = :status,
	    			um.starts_at = :starts_at,
	    			um.ends_at = :ends_at
	    		WHERE
	    			um.order_id = :order_id");
	    	return $sql->execute([
	    		":status" => trim(strtolower($status)),
	    		":starts_at" => $starts_at,
	    		":ends_at" => $ends_at,
	    		":order_id" => $order_id
	    	]);
	    }

	    public function getUserMembershipByOrderId($order_id){
	    	$sql = DB::open()->prepare("SELECT * FROM csa_users_memberships WHERE order_id = :order_id LIMIT 1");
	    	$sql->execute([
	    		":order_id" => $order_id
    		]);

    		return $sql;
	    }

	    public function getUserMembershipById($idusermembership){
	    	$sql = DB::open()->prepare("SELECT * FROM csa_users_memberships WHERE idusermembership = :idusermembership LIMIT 1");
	    	$sql->execute([
	    		":idusermembership" => $idusermembership
    		]);

    		return $sql;
	    }

	    public function deleteUserMembershipById($idusermembership){
	    	$sql = DB::open()->prepare("DELETE FROM csa_users_memberships WHERE idusermembership = :idusermembership");
	    	$sql->execute([
	    		":idusermembership" => $idusermembership
    		]);

    		return $sql->rowCount() > 0;
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

		public function getUsers($limit = null) {
		    $limitClause = ($limit !== null && intval($limit) > 0) ? "LIMIT :limit" : "";

		    $sql = DB::open()->prepare("
		        SELECT 
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
				(SELECT COUNT(*) FROM csa_companies c WHERE c.iduser = u.iduser) AS company_counter,
				CASE 
					WHEN um.iduser IS NOT NULL THEN '1'
					ELSE '0'
				END AS is_member
			FROM 
				csa_users u
			LEFT JOIN 
				(
					SELECT um1.* 
					FROM csa_users_memberships um1
					WHERE um1.ends_at > NOW() 
					AND um1.status = 'paid'
				) um ON um.iduser = u.iduser
			LEFT JOIN 
				csa_memberships m ON um.membership_id = m.membership_id
			ORDER BY 
				u.firstname ASC

		        $limitClause
		    ");

		    if ($limit !== null && intval($limit) > 0) {
		        $sql->bindValue(':limit', intval($limit), PDO::PARAM_INT);
		    }

		    $sql->execute();
		    return $sql;
		}
		public function getAllUsersWithLastSubscription($limit = null) {
		    $limitClause = ($limit !== null && intval($limit) > 0) ? "LIMIT :limit" : "";

		    $sql = DB::open()->prepare("
		        SELECT 
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
				(SELECT COUNT(*) FROM csa_companies c WHERE c.iduser = u.iduser) AS company_counter,
				CASE 
					WHEN um.iduser IS NOT NULL THEN '1'
					ELSE '0'
				END AS is_member
			FROM 
				csa_users u
			LEFT JOIN 
				(
					SELECT um1.* 
					FROM csa_users_memberships um1
					WHERE um1.ends_at > NOW() 
					AND um1.status = 'paid'
				) um ON um.iduser = u.iduser
			LEFT JOIN 
				csa_memberships m ON um.membership_id = m.membership_id
			ORDER BY 
				u.firstname ASC

		        $limitClause
		    ");

		    if ($limit !== null && intval($limit) > 0) {
		        $sql->bindValue(':limit', intval($limit), PDO::PARAM_INT);
		    }

		    $sql->execute();
		    return $sql;
		}


		public function getUsersByDiamonds() {
		    $sql = DB::open()->prepare("
		        SELECT 
				u.iduser, 
				u.firstname, 
				u.lastname, 
				u.profile_photo,
				(SELECT SUM(diamond_value) 
				 FROM csa_user_diamonds ud 
				 WHERE ud.user_id = u.iduser) AS diamonds
			FROM 
				csa_users u
			ORDER BY 
				diamonds DESC
		    ");

		    $sql->execute();
		    return $sql;
		}

		


		public function getInactiveUsers($limit = null){
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
			    (SELECT COUNT(company_id) FROM csa_companies c WHERE c.iduser = u.iduser) as company_counter,
			    (SELECT COUNT(idusermembership) FROM csa_users_memberships um WHERE um.iduser = u.iduser AND um.status = 'paid' AND um.ends_at > NOW()) as is_member

			FROM 
			    csa_users u	
                
            HAVING is_member < 1 AND user_type = 0

			ORDER BY u.firstname ASC ". (((intval($limit) == null) ? "" : "LIMIT {$limit}")));
			$sql->execute();

			return $sql;
		}



		public function getActiveUsers($limit = null) {
		    $limitClause = ($limit !== null && intval($limit) > 0) ? "LIMIT :limit" : "";

		    $sql = DB::open()->prepare("
		    	SELECT  
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
				    (SELECT COUNT(company_id) 
				     FROM csa_companies c 
				     WHERE c.iduser = u.iduser AND c.status = 1) AS company_counter,
					(SELECT SUM(diamond_value) FROM csa_user_diamonds ud WHERE ud.user_id = u.iduser) as diamonds
				FROM 
				    csa_users u
				INNER JOIN 
				    csa_users_memberships um ON u.iduser = um.iduser
				LEFT JOIN 
				    csa_memberships m ON um.membership_id = m.membership_id
				WHERE 
				    um.status = 'paid'
				    AND um.ends_at > NOW()
				    AND u.user_type = 0
				ORDER BY 
				    u.firstname ASC;

		        $limitClause
		    ");

		    if ($limit !== null && intval($limit) > 0) {
		        $sql->bindValue(':limit', intval($limit), PDO::PARAM_INT);
		    }

		    $sql->execute();

		    return $sql;
		}

		public function getActiveUsersOrderByDiamonds($limit = null) {
		    $limitClause = ($limit !== null && intval($limit) > 0) ? "LIMIT :limit" : "";

		    $sql = DB::open()->prepare("
		    	SELECT  
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
				    (SELECT COUNT(company_id) 
				     FROM csa_companies c 
				     WHERE c.iduser = u.iduser AND c.status = 1) AS company_counter,
					(SELECT SUM(diamond_value) FROM csa_user_diamonds ud WHERE ud.user_id = u.iduser) as diamonds
				FROM 
				    csa_users u
				INNER JOIN 
				    csa_users_memberships um ON u.iduser = um.iduser
				LEFT JOIN 
				    csa_memberships m ON um.membership_id = m.membership_id
				WHERE 
				    um.status = 'paid'
				    AND um.ends_at > NOW()
				    AND u.user_type = 0
				ORDER BY 
				    diamonds DESC;

		        $limitClause
		    ");

		    if ($limit !== null && intval($limit) > 0) {
		        $sql->bindValue(':limit', intval($limit), PDO::PARAM_INT);
		    }

		    $sql->execute();

		    return $sql;
		}


		public function getLastUsersWithMembership($limit = null){
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
			    csa_memberships m ON um.membership_id = m.membership_id

			WHERE um.status = 'paid' AND u.user_type = 0

			ORDER BY um.starts_at DESC ". (((intval($limit) == null) ? "" : "LIMIT {$limit}")));
			$sql->execute();

			return $sql;
		}
		public function getLastUsersWithFirstMembership($limit = null){
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
			    (SELECT COUNT(company_id) 
			     FROM csa_companies c 
			     WHERE c.iduser = u.iduser) as company_counter
			FROM 
			    csa_users u
			LEFT JOIN 
			    csa_users_memberships um 
			    ON u.iduser = um.iduser
			LEFT JOIN 
			    csa_memberships m 
			    ON um.membership_id = m.membership_id
			WHERE 
			    um.status = 'paid'
			    AND u.user_type = 0
			    AND (
			        SELECT COUNT(*) 
			        FROM csa_users_memberships um1 
			        WHERE um1.iduser = u.iduser
			        AND um1.status = 'paid'
			    ) = 1
			ORDER BY 
			    um.starts_at DESC ". (((intval($limit) == null) ? "" : "LIMIT {$limit}")));
			$sql->execute();

			return $sql;
		}

		public function createPasswordReset($user_id, $token){
			$sql = DB::open()->prepare("INSERT INTO csa_users_passwords_resets () VALUES (default, :user_id, :token, DATE_ADD(NOW(), INTERVAL 2 HOUR), 0, NOW())");
			return $sql->execute([
				":user_id" => intval($user_id),
				":token" => $token
			]);
		}

		public function isTokenValid($token){
			$sql = DB::open()->prepare("SELECT * FROM csa_users_passwords_resets WHERE used = 0 AND expires_at > NOW() AND token = :token");
			$sql->execute([
				":token" => $token
			]);

			return $sql->rowCount() > 0;
		}

		public function getToken($token){
			$sql = DB::open()->prepare("SELECT * FROM csa_users_passwords_resets WHERE token = :token LIMIT 1");
			$sql->execute([
				":token" => $token
			]);

			return $sql;
		}

		public function updateTokenToUsed($token){
			$sql = DB::open()->prepare("UPDATE csa_users_passwords_resets SET used = 1 WHERE token = :token");
			$sql->execute([
				":token" => $token
			]);

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


		public static function convertDate($original_date){
			if (preg_match('/\d{4}-\d{2}-\d{2}/', $original_date)) {
	            // Converte a data para o formato DD/MM/AAAA
	            return date("d/m/Y", strtotime($original_date));
	        } else {
	        	return $original_date;
	        }
		}
	}
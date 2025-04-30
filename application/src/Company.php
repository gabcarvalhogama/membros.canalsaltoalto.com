<?php
	class Company{
		public function getCompanies(){
			$sql = DB::open()->prepare("SELECT 
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
				c.company_category_id,
			    c.has_place,
			    c.address_zipcode,
			    c.address_state,
			    c.address_city,
			    c.address,
			    c.address_number,
			    c.address_neighborhood,
			    c.address_complement,
			    c.cellphone,
			    c.instagram_url,
			    c.site_url,
			    c.facebook_url,
			    c.status,
			    c.created_at,
			    c.updated_at,
			    u.profile_photo,
			    u.firstname,
			    u.lastname,
				u.email
			FROM 
			    csa_companies c
			LEFT JOIN 
			    csa_users u ON c.iduser = u.iduser

			ORDER BY c.company_name ASC;");

			$sql->execute();

			return $sql;
		}

		public function getCompaniesByStatus($status = 1){
			$sql = DB::open()->prepare("SELECT DISTINCT 
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
				c.company_category_id,
			    c.has_place,
			    c.address_zipcode,
			    c.address_state,
			    c.address_city,
			    c.address,
			    c.address_number,
			    c.address_neighborhood,
			    c.address_complement,
			    c.cellphone,
			    c.instagram_url,
			    c.site_url,
			    c.facebook_url,
			    c.status,
			    c.created_at,
			    c.updated_at,
			    u.profile_photo,
			    u.firstname,
			    u.lastname
				FROM 
				    csa_companies c
				LEFT JOIN 
				    csa_users u ON c.iduser = u.iduser
				LEFT JOIN 
				    csa_users_memberships um ON u.iduser = um.iduser
				WHERE 
				    c.status = :status
				    AND um.status = 'paid'
				    AND um.ends_at > NOW()
					AND u.user_type = 0
				ORDER BY 
				    c.company_name ASC;");

			$sql->execute([
				":status" => intval($status)
			]);

			return $sql;
		}

		public function getCompaniesPendingApproval(){
			$sql = DB::open()->prepare("SELECT DISTINCT 
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
				c.company_category_id,
			    c.has_place,
			    c.address_zipcode,
			    c.address_state,
			    c.address_city,
			    c.address,
			    c.address_number,
			    c.address_neighborhood,
			    c.address_complement,
			    c.cellphone,
			    c.instagram_url,
			    c.site_url,
			    c.facebook_url,
			    c.status,
			    c.created_at,
			    c.updated_at,
			    u.profile_photo,
			    u.firstname,
			    u.lastname
				FROM 
				    csa_companies c
				LEFT JOIN 
				    csa_users u ON c.iduser = u.iduser
				LEFT JOIN 
				    csa_users_memberships um ON u.iduser = um.iduser
				WHERE 
				    (c.status = 2 OR c.status = 3)
				    AND um.status = 'paid'
				    AND um.ends_at > NOW()
				ORDER BY 
				    c.company_name ASC;");

			$sql->execute();

			return $sql;
		}


		public function getCompaniesByStatusAndPagination($limit = 12, $offset = 0, $status = 1){
			$sql = DB::open()->prepare("SELECT DISTINCT
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
				c.company_category_id,
			    c.has_place,
			    c.address_zipcode,
			    c.address_state,
			    c.address_city,
			    c.address,
			    c.address_number,
			    c.address_neighborhood,
			    c.address_complement,
			    c.cellphone,
			    c.instagram_url,
			    c.site_url,
			    c.facebook_url,
			    c.status,
			    c.created_at,
			    c.updated_at,
			    u.profile_photo,
			    u.firstname,
			    u.lastname
				FROM 
				    csa_companies c
				LEFT JOIN 
				    csa_users u ON c.iduser = u.iduser
				LEFT JOIN 
				    csa_users_memberships um ON u.iduser = um.iduser
				WHERE 
				    c.status = :status
				    AND um.status = 'paid'
				    AND um.ends_at > NOW()
					AND u.user_type = 0
				ORDER BY 
				    c.company_name ASC
				    LIMIT :limit_events OFFSET :offset_events;");

			$sql->bindParam(':limit_events', $limit, \PDO::PARAM_INT);
			$sql->bindParam(':offset_events', $offset, \PDO::PARAM_INT);
			$sql->bindParam(':status', $status, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}


		public function getCompaniesByStatusCategoryAndPagination($limit = 12, $offset = 0, $status = 1, $company_category_id){
			$sql = DB::open()->prepare("SELECT DISTINCT
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
				c.company_category_id,
			    c.has_place,
			    c.address_zipcode,
			    c.address_state,
			    c.address_city,
			    c.address,
			    c.address_number,
			    c.address_neighborhood,
			    c.address_complement,
			    c.cellphone,
			    c.instagram_url,
			    c.site_url,
			    c.facebook_url,
			    c.status,
			    c.created_at,
			    c.updated_at,
			    u.profile_photo,
			    u.firstname,
			    u.lastname
				FROM 
				    csa_companies c
				LEFT JOIN 
				    csa_users u ON c.iduser = u.iduser
				LEFT JOIN 
				    csa_users_memberships um ON u.iduser = um.iduser
				WHERE 
				    c.status = :status
				    AND um.status = 'paid'
				    AND um.ends_at > NOW()
					AND u.user_type = 0
					AND c.company_category_id = :company_category_id
				ORDER BY 
				    c.company_name ASC
				    LIMIT :limit_events OFFSET :offset_events;");

			$sql->bindParam(':limit_events', $limit, \PDO::PARAM_INT);
			$sql->bindParam(':offset_events', $offset, \PDO::PARAM_INT);
			$sql->bindParam(':status', $status, \PDO::PARAM_INT);
			$sql->bindParam(':company_category_id', $company_category_id, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}



		public function getCompaniesEnabledAndActiveMembers($limit = 12){
			$sql = DB::open()->prepare("SELECT DISTINCT
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
				c.company_category_id,
			    c.has_place,
			    c.address_zipcode,
			    c.address_state,
			    c.address_city,
			    c.address,
			    c.address_number,
			    c.address_neighborhood,
			    c.address_complement,
			    c.cellphone,
			    c.instagram_url,
			    c.site_url,
			    c.facebook_url,
			    c.status,
			    c.created_at,
			    c.updated_at,
			    u.profile_photo,
			    u.firstname,
			    u.lastname
			FROM 
			    csa_companies c
			LEFT JOIN 
			    csa_users u ON c.iduser = u.iduser
			LEFT JOIN 
			    csa_users_memberships um ON u.iduser = um.iduser
			WHERE 
			    c.status = 1
			    AND um.status = 'paid'
			    AND um.ends_at > NOW()
				AND c.company_image IS NOT NULL
			ORDER BY 
			    c.created_at DESC
			LIMIT :limit_posts
			");

			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}


		public function create($company_owner, $company_name, $company_description, $company_image, $has_place, $address_zipcode, $address_state, $address_city, $address, $address_number, $address_neighborhood, $address_complement, $cellphone, $instagram_url, $site_url, $facebook_url, $status){
			$sql = DB::open()->prepare("
	            INSERT INTO csa_companies (
	            	company_id,
	                iduser,
	                company_name,
	                company_description,
	                company_image,
					company_category_id,
	                has_place,
	                address_zipcode,
	                address_state,
	                address_city,
	                address,
	                address_number,
	                address_neighborhood,
	                address_complement,
	                cellphone,
	                instagram_url,
	                site_url,
	                facebook_url,
	                status,
	                created_at
	            ) VALUES (
		            default, 
	                :company_owner,
	                :company_name,
	                :company_description,
	                :company_image,
					null,
	                :has_place,
	                :address_zipcode,
	                :address_state,
	                :address_city,
	                :address,
	                :address_number,
	                :address_neighborhood,
	                :address_complement,
	                :cellphone,
	                :instagram_url,
	                :site_url,
	                :facebook_url,
	                :status,
	                NOW()
	            )
	        ");

	        return $sql->execute([
	            ":company_owner" => intval($company_owner),
	            ":company_name" => ucfirst(trim($company_name)),
	            ":company_description" => ucfirst(trim($company_description)),
	            ":company_image" => $company_image,
	            ":has_place" => intval($has_place),
	            ":address_zipcode" => ($address_zipcode == "") ? NULL : preg_replace('/\D/', '', $address_zipcode),
	            ":address_state" => $address_state,
	            ":address_city" => $address_city,
	            ":address" => ucfirst(trim($address)),
	            ":address_number" => $address_number,
	            ":address_neighborhood" => ucfirst(trim($address_neighborhood)),
	            ":address_complement" => ucfirst(trim($address_complement)),
	            ":cellphone" => $cellphone,
	            ":instagram_url" => filter_var($instagram_url, FILTER_SANITIZE_URL),
	            ":site_url" => filter_var($site_url, FILTER_SANITIZE_URL),
	            ":facebook_url" => filter_var($facebook_url, FILTER_SANITIZE_URL),
	            ":status" => intval($status)
	        ]);
		}


		public function getCompanyById($company_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_companies WHERE company_id = :company_id LIMIT 1");
			$sql->execute([
				":company_id" => intval($company_id)
			]);

			return $sql;
		}
		public function getCompanyByIdAndUser($company_id, $user_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_companies WHERE company_id = :company_id AND iduser = :user_id LIMIT 1");
			$sql->execute([
				":company_id" => intval($company_id),
				":user_id" => intval($user_id)
			]);

			return $sql;
		}


		public function update($company_id, $company_owner, $company_name, $company_description, $company_image, $has_place, $address_zipcode, $address_state, $address_city, $address, $address_number, $address_neighborhood, $address_complement, $cellphone, $instagram_url, $site_url, $facebook_url, $status) {

			$sql = DB::open()->prepare("
	            UPDATE csa_companies
	            SET 
	                iduser = :company_owner,
	                company_name = :company_name,
	                company_description = :company_description,
	                company_image = IFNULL(:company_image, company_image),
	                has_place = :has_place,
	                address_zipcode = :address_zipcode,
	                address_state = :address_state,
	                address_city = :address_city,
	                address = :address,
	                address_number = :address_number,
	                address_neighborhood = :address_neighborhood,
	                address_complement = :address_complement,
	                cellphone = :cellphone,
	                instagram_url = :instagram_url,
	                site_url = :site_url,
	                facebook_url = :facebook_url,
	                status = :status,
	                updated_at = NOW()
	            WHERE company_id = :company_id
	        ");

	        return $sql->execute([
	            ":company_id" => intval($company_id),
	            ":company_owner" => intval($company_owner),
	            ":company_name" => ucfirst(trim($company_name)),
	            ":company_description" => ucfirst(trim($company_description)),
	            ":company_image" => $company_image,
	            ":has_place" => intval($has_place),
				":address_zipcode" => ($address_zipcode == "") ? NULL : preg_replace('/\D/', '', $address_zipcode),
	            ":address_state" => $address_state,
	            ":address_city" => $address_city,
	            ":address" => ucfirst(trim($address)),
	            ":address_number" => $address_number,
	            ":address_neighborhood" => ucfirst(trim($address_neighborhood)),
	            ":address_complement" => ucfirst(trim($address_complement)),
	            ":cellphone" => $cellphone,
	            ":instagram_url" => filter_var($instagram_url, FILTER_SANITIZE_URL),
	            ":site_url" => filter_var($site_url, FILTER_SANITIZE_URL),
	            ":facebook_url" => filter_var($facebook_url, FILTER_SANITIZE_URL),
	            ":status" => intval($status)
	        ]);
		}


		public function getCompaniesByOwner($user_id){
			$sql = DB::open()->prepare("SELECT 
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
				c.company_category_id,
			    c.has_place,
			    c.address_zipcode,
			    c.address_state,
			    c.address_city,
			    c.address,
			    c.address_number,
			    c.address_neighborhood,
			    c.address_complement,
			    c.cellphone,
			    c.instagram_url,
			    c.site_url,
			    c.facebook_url,
			    c.status,
			    c.created_at,
			    c.updated_at,
			    u.profile_photo,
			    u.firstname,
			    u.lastname
			FROM 
			    csa_companies c
			LEFT JOIN 
			    csa_users u ON c.iduser = u.iduser
			WHERE c.iduser = :user_id ");

			$sql->execute([
				":user_id" => intval($user_id)
			]);

			return $sql;
		}


		public function getCompaniesByOwnerAndStatus($user_id, $status){
			$sql = DB::open()->prepare("SELECT 
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
				c.company_category_id,
			    c.has_place,
			    c.address_zipcode,
			    c.address_state,
			    c.address_city,
			    c.address,
			    c.address_number,
			    c.address_neighborhood,
			    c.address_complement,
			    c.cellphone,
			    c.instagram_url,
			    c.site_url,
			    c.facebook_url,
			    c.status,
			    c.created_at,
			    c.updated_at,
			    u.profile_photo,
			    u.firstname,
			    u.lastname
			FROM 
			    csa_companies c
			LEFT JOIN 
			    csa_users u ON c.iduser = u.iduser
			WHERE c.iduser = :user_id
			AND c.status = :status
			");

			$sql->execute([
				":user_id" => intval($user_id),
				":status" => intval($status)
			]);

			return $sql;
		}

		public function getCompaniesCategories(){
			$sql = DB::open()->prepare("SELECT * FROM csa_companies_categories ORDER BY category_name ASC;");
			$sql->execute();
			return $sql;
		}


		// public function userHasCompany($email){

		// 	$sql = DB::open()->prepare("SELECT company_id FROM csa_companies WHERE iduser = (SELECT iduser FROM csa_users WHERE email = :email)");
		// 	$sql->execute([
		// 		":email" => 
		// 	]);


		// }

		public function delete($company_id){
		    $sql = DB::open()->prepare("DELETE FROM csa_companies WHERE company_id = :company_id");
		    return $sql->execute([
		        ":company_id" => intval($company_id)
		    ]);
		}

	}
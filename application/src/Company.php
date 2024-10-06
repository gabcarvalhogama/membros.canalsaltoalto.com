<?php
	class Company{
		public function getCompanies(){
			$sql = DB::open()->prepare("SELECT 
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
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
			    csa_users u ON c.iduser = u.iduser;");

			$sql->execute();

			return $sql;
		}

		public function getCompaniesByStatus($status = 1){
			$sql = DB::open()->prepare("SELECT 
			    c.company_id,
			    c.iduser,
			    c.company_name,
			    c.company_description,
			    c.company_image,
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


			WHERE status = :status;");

			$sql->execute([
				":status" => intval($status)
			]);

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
	            ":address_zipcode" => $address_zipcode,
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


		public function update($company_id, $company_owner, $company_name, $company_description, $company_image, $has_place, $address_zipcode, $address_state, $address_city, $address, $address_number, $address_neighborhood, $address_complement, $cellphone, $instagram_url, $site_url, $facebook_url, $status) {

			$sql = DB::open()->prepare("
	            UPDATE csa_companies
	            SET 
	                iduser = :company_owner,
	                company_name = :company_name,
	                company_description = :company_description,
	                company_image = :company_image,
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
	            ":address_zipcode" => $address_zipcode,
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
	}
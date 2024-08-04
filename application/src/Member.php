<?php
	class Member{

		public function create($member_name, $member_lastname, $member_photo, $member_biography, $member_cpf, $member_birthdate, $member_zipcode, $member_state, $member_city, $member_address, $member_address_number, $member_neighborhood, $member_complement, $member_cellphone, $member_email, $member_password){
			$sql = DB::open()->prepare("INSERT INTO csa_users () VALUES (default, :firstname, :lastname, :profile_photo, :biography, :cpf, :birthdate, :zipcode, :address_state, :address_city, :address, :address_number, :address_neighborhood, :address_complement, :cellphone, :email, :password, 0, NOW(), null)");
			return $sql->execute([
				":firstname" => ucfirst(trim($member_name)),
				":lastname" => ucfirst(trim($member_lastname)),
				":profile_photo" => $member_photo,
				":biography" => ucfirst(trim($member_biography)),
				":cpf" => preg_replace('/\D/', '', $member_cpf),
				":birthdate" => $member_birthdate,
				":zipcode" => preg_replace('/\D/', '', $member_zipcode),
				":address_state" => intval($member_state),
				":address_city" => intval($member_city),
				":address" => ucfirst(trim($member_address)),
				":address_number" => ucfirst(trim($member_address_number)),
				":address_neighborhood" => ucfirst(trim($member_neighborhood)),
				":address_complement" => ucfirst(trim($member_complement)),
				":cellphone" => preg_replace('/\D/', '', $member_cellphone),
				":email" => filter_var($member_email, FILTER_SANITIZE_EMAIL),
				":password" => Bcrypt::hash($member_password)
			]);
		}

	}
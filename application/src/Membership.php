<?php 
	class Membership{

		public function getMembershipByOrderId($order_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_users_memberships WHERE order_id = :order_id LIMIT 1");
			$sql->execute([
				":order_id" => $order_id
			]);
			return $sql;
		}

		public function getMembershipsByUser($iduser){
			$sql = DB::open()->prepare("SELECT * FROM csa_users_memberships WHERE iduser = :iduser LIMIT 1");
			$sql->execute([
				":iduser" => $iduser
			]);
			return $sql;
		}


	}
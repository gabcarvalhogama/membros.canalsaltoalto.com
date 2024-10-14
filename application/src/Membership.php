<?php 
	class Membership{

		public function getMembershipByOrderId($order_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_users_memberships WHERE order_id = :order_id LIMIT 1");
			$sql->execute([
				":order_id" => $order_id
			]);
			return $sql;
		}


	}
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
			$sql = DB::open()->prepare("SELECT * FROM csa_users_memberships WHERE iduser = :iduser");
			$sql->execute([
				":iduser" => $iduser
			]);
			return $sql;
		}

		public function getMembershipsByUserAndStatus($iduser, $status){
			$sql = DB::open()->prepare("SELECT um.*, m.membership_title, m.membership_description FROM csa_users_memberships um 
LEFT JOIN csa_memberships m ON um.membership_id = m.membership_id


WHERE iduser = :iduser AND status = :status");
			$sql->execute([
				":iduser" => $iduser,
				":status" => $status
			]);
			return $sql;
		}


	}
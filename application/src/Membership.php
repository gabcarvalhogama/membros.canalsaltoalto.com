<?php 
	class Membership{

		public function getMemberships(){
			$sql = DB::open()->prepare("SELECT 
				um.idusermembership,
				um.order_id,
				um.coupon_id,
				um.payment_method,
				um.payment_value,
				um.starts_at,
				um.ends_at,
				um.status,
				um.created_at,
				u.iduser,
				u.firstname,
				u.lastname,
				u.profile_photo,
				m.membership_title
				FROM csa_users_memberships um
				LEFT JOIN csa_users u 
				ON um.iduser = u.iduser
				LEFT JOIN csa_memberships m ON um.membership_id = m.membership_id
				ORDER BY starts_at DESC");
			$sql->execute();
			return $sql;
		}

		public static function getPaidMembershipsByUserEmail($email){
			$sql = DB::open()->prepare("SELECT um.* FROM csa_users_memberships um LEFT JOIN csa_users u ON um.iduser = u.iduser WHERE u.email = :email AND um.status = 'paid' ORDER BY um.starts_at DESC;");
			$sql->execute([
				":email" => $email
			]);
			return $sql;
		}

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



		public function getMembershipPlanById($membership_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_memberships WHERE membership_id = :membership_id LIMIT 1");
			$sql->execute([
				":membership_id" => intval($membership_id)
			]);

			return $sql;
		}


		public function create($iduser, $membership_id, $order_id, $coupon_id, $payment_method, $payment_value, $starts_at, $ends_at, $status){

			$sql = DB::open()->prepare("INSERT INTO csa_users_memberships () VALUES (
				default,
				:iduser,
				:membership_id,
				:order_id,
				:coupon_id,
				:payment_method,
				:payment_value,
				:starts_at,
				:ends_at,
				:status,
				NOW()
			)");

			$sql->execute([
				":iduser" => intval($iduser),
				":membership_id" => intval($membership_id),
				":order_id" => $order_id,
				":coupon_id" => $coupon_id,
				":payment_method" => $payment_method,
				":payment_value" => $payment_value,
				":starts_at" => $starts_at,
				":ends_at" => $ends_at,
				":status" => ($status)
			]);

			return $sql->rowCount() > 0;

		}


	}
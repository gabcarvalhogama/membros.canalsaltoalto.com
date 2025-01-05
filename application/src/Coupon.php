<?php

	class Coupon{

		public function getCoupons(){
			$sql = DB::open()->prepare("SELECT * FROM csa_coupons ORDER BY expiration_date DESC");
			$sql->execute();

			return $sql;
		}

		public function create($code, $discount_type, $discount_value, $expiration_date, $status){
			$sql = DB::open()->prepare("INSERT INTO csa_coupons (coupon_id, code, discount_type, discount_value, expiration_date, status, created_at, updated_at)
			            VALUES (default, :code, :discount_type, :discount_value, :expiration_date, :status, NOW(), null)");
			
			$sql->execute([
	            ":code" => $code,
	            ":discount_type" => $discount_type,
	            ":discount_value" => $discount_value,
	            ":expiration_date" => $expiration_date,
	            ":status" => isset($status) ? intval($status) : 1 // Padrão: ativo
	        ]);

	        return $sql->rowCount() > 0;
		}

		public function getCouponByCode($coupon){
			$sql = DB::open()->prepare("SELECT * FROM csa_coupons WHERE code = :code LIMIT 1");
			$sql->execute([
				":code" => strtoupper($coupon)
			]);

			return $sql;
		}


		public function getCouponById($coupon_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_coupons WHERE coupon_id = :coupon_id LIMIT 1");
			$sql->execute([
				":coupon_id" => intval($coupon_id)
			]);

			return $sql;
		}
	}
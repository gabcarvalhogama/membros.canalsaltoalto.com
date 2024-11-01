<?php

	class Coupon{
		public function getCouponByCode($coupon){
			$sql = DB::open()->prepare("SELECT * FROM csa_coupons WHERE code = :code LIMIT 1");
			$sql->execute([
				":code" => strtoupper($coupon)
			]);

			return $sql;
		}
	}
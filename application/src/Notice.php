<?php
	class Notice{
		public function getNotices($limit = 12){
			$sql = DB::open()->prepare("SELECT * FROM csa_notices ORDER BY published_at DESC LIMIT :limit_notices");
			$sql->bindParam(':limit_notices', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function create($notice_title, $notice_content, $user_email){
			$sql = DB::open()->prepare("INSERT INTO csa_notices () VALUES (default, :notice_title, :notice_content, :status, (SELECT iduser FROM csa_users WHERE email = :user_email LIMIT 1), NOW(), NOW(), null)");
			return $sql->execute([
				":notice_title" => trim($notice_title),
				":notice_content" => trim($notice_content),
				":status" => 1,
				":user_email" => $user_email
			]);
		}

		public function getNoticeById($notice_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_notices WHERE idnotice = :notice_id LIMIT 1");
			$sql->execute([":notice_id" => intval($notice_id)]);
			return $sql;
		}
	}
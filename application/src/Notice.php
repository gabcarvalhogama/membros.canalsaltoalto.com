<?php
	class Notice{
		public function getNotices($limit = 12){
			$sql = DB::open()->prepare("SELECT * FROM csa_notices ORDER BY published_at DESC LIMIT :limit_notices");
			$sql->bindParam(':limit_notices', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function create($notice_title, $notice_content, $notice_status, $user_email){
			$sql = DB::open()->prepare("INSERT INTO csa_notices () VALUES (default, :notice_title, :notice_content, :status, (SELECT iduser FROM csa_users WHERE email = :user_email LIMIT 1), NOW(), NOW(), null)");
			return $sql->execute([
				":notice_title" => trim($notice_title),
				":notice_content" => trim($notice_content),
				":status" => $notice_status,
				":user_email" => $user_email
			]);
		}

		public function getNoticeById($notice_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_notices WHERE idnotice = :notice_id LIMIT 1");
			$sql->execute([":notice_id" => intval($notice_id)]);
			return $sql;
		}


		public function delete($notice_id){
			$sql = DB::open()->prepare("DELETE FROM csa_notices WHERE idnotice = :notice_id");
			$sql->execute([
				":notice_id" => $notice_id
			]);

			return $sql->rowCount() > 0;
		}

		public function update($idnotice, $notice_title, $notice_content, $status, $published_at){
			$sql = DB::open()->prepare("UPDATE csa_notices 
				SET notice_title = :notice_title, 
					notice_content = :notice_content,
					status = :status,
					published_at = :published_at,
					updated_at = NOW()

				WHERE idnotice = :idnotice
			");

			$sql->execute([
				":notice_title" => trim(ucfirst($notice_title)),
				":notice_content" => trim(ucfirst($notice_content)),
				":status" => intval($status),
				":published_at" => $published_at,
				":idnotice" => intval($idnotice)
			]);

			return $sql->rowCount() > 0;
		}
	}
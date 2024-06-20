<?php
	class Notice{
		public function getNotices($limit = 12){
			$sql = DB::open()->prepare("SELECT * FROM csa_notices ORDER BY published_at DESC LIMIT :limit_notices");
			$sql->bindParam(':limit_notices', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}
	}
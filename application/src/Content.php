<?php
	class Content{
		public function getContents($limit = 12){
			$sql = DB::open()->prepare("SELECT * FROM csa_contents ORDER BY published_at DESC LIMIT :limit_posts");
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function getContentBySlug($slug){
			$sql = DB::open()->prepare("SELECT c.*, u.firstname, u.lastname, (SELECT COUNT(idcomment) FROM csa_contents_comments WHERE idcontent = c.idcontent) as number_comments FROM csa_contents c LEFT JOIN csa_users u ON c.author = u.iduser WHERE slug = :slug");
			$sql->execute([
				":slug" => strtolower($slug)
			]);

			return $sql;
		}

		public function getComments($idcontent){
			$sql = DB::open()->prepare("SELECT * FROM csa_contents_comments WHERE idcontent = :idcontent ORDER BY created_at DESC");
			$sql->execute([
				":idcontent" => intval($idcontent)
			]);

			return $sql;
		}
		public function getRelatedContents($limit = 12, $actual_content){
			$sql = DB::open()->prepare("SELECT * FROM csa_contents WHERE idcontent != :actual_content ORDER BY published_at DESC LIMIT :limit_contents");
			$sql->bindParam(':actual_content', $actual_content, \PDO::PARAM_INT);
			$sql->bindParam(':limit_contents', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

	}
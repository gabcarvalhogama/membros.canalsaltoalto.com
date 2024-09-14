<?php
	class Publi{
		public function create($publi_title, $publi_content, $publi_status, $user_id){
			$sql = DB::open()->prepare("INSERT INTO 
				csa_publis () 
				VALUES 
				(default, :publi_title, :publi_content, :publi_status, :user_id, NOW(), NOW(), null)");
			return $sql->execute([
				":publi_title" => ucfirst(trim($publi_title)),
				":publi_content" => ucfirst(trim($publi_content)),
				":publi_status" => intval($publi_status),
				":user_id" => intval($user_id)
			]);
		}

		public function update($publi_id, $publi_title, $publi_content, $user_id){
		    $sql = DB::open()->prepare("
		        UPDATE csa_publis SET
		            publi_title = :publi_title,
		            publi_content = :publi_content,
		            user_id = :user_id,
		            updated_at = NOW()
		        WHERE
		            publi_id = :publi_id
		    ");

		    return $sql->execute([
		        ":publi_title" => ucfirst(trim($publi_title)),
		        ":publi_content" => ucfirst(trim($publi_content)),
		        ":user_id" => intval($user_id),
		        ":publi_id" => intval($publi_id)
		    ]);
		}


		public function getPublis($limit = 12){
			$sql = DB::open()->prepare("SELECT 
			    csa_publis.*, 
			    csa_users.firstname, 
			    csa_users.lastname, 
			    csa_users.profile_photo 
			FROM 
			    csa_publis 
			JOIN 
			    csa_users 
			ON 
			    csa_publis.user_id = csa_users.iduser 
			ORDER BY 
			    csa_publis.created_at DESC 
			LIMIT 
			    :limit_posts");
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function getPublisByStatus($limit = 12, $status){
			$sql = DB::open()->prepare("SELECT 
			    csa_publis.*, 
			    csa_users.firstname, 
			    csa_users.lastname, 
			    csa_users.profile_photo 
			FROM 
			    csa_publis 
			JOIN 
			    csa_users 
			ON 
			    csa_publis.user_id = csa_users.iduser 

			WHERE publi_status = :publi_status
			ORDER BY 
			    csa_publis.created_at DESC 
			LIMIT 
			    :limit_posts");
			$sql->bindParam(':publi_status', $status, \PDO::PARAM_INT);
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function getPubliById($publi_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_publis WHERE publi_id = :publi_id LIMIT 1");
			$sql->execute([
				":publi_id" => intval($publi_id)
			]);

			return $sql;
		}
	}
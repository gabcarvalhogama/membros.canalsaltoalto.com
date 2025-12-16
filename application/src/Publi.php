<?php
	class Publi{
		public function create($publi_content, $publi_image = null, $publi_status, $user_id){
			$sql = DB::open()->prepare("INSERT INTO 
				csa_publis () 
				VALUES 
				(default, :publi_title, :publi_content, :publi_image, :publi_status, :user_id, NOW(), NOW(), null)");
			return $sql->execute([
				":publi_title" => null,
				":publi_content" => ucfirst(trim($publi_content)),
				":publi_image" => trim($publi_image),
				":publi_status" => intval($publi_status),
				":user_id" => intval($user_id)
			]);
		}

		public function update($publi_id, $publi_content, $publi_image, $publi_status, $user_id){
		    $sql = DB::open()->prepare("
		        UPDATE csa_publis SET
		            -- publi_title = :publi_title,
		            publi_content = :publi_content,
		            publi_image = COALESCE(:publi_image, publi_image),
		            user_id = :user_id,
		            publi_status = :publi_status,
		            updated_at = NOW()
		        WHERE
		            publi_id = :publi_id
		    ");

		    return $sql->execute([
		        // ":publi_title" => null,
		        ":publi_content" => ucfirst(trim($publi_content)),
		        ":publi_image" => $publi_image,
		        ":publi_status" => intval($publi_status),
		        ":user_id" => intval($user_id),
		        ":publi_id" => intval($publi_id)
		    ]);
		}


		public function getPublis($limit = 12){
			$sql = DB::open()->prepare("SELECT 
			    csa_publis.*, 
			    csa_users.firstname, 
			    csa_users.lastname, 
			    csa_users.profile_photo,
			    (SELECT COUNT(publi_likes_id) FROM csa_publis_likes pl WHERE pl.publi_id = csa_publis.publi_id) as likes
			FROM 
			    csa_publis 
			LEFT JOIN 
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
			    csa_users.profile_photo,
			     (SELECT COUNT(publi_likes_id) FROM csa_publis_likes pl WHERE pl.publi_id = csa_publis.publi_id) as likes
			FROM 
			    csa_publis 
			LEFT JOIN 
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






		public function delete($publi_id){
			$sql = DB::open()->prepare("DELETE FROM csa_publis WHERE publi_id = :publi_id");
			return $sql->execute([
				":publi_id" => intval($publi_id)
			]);
		}



		public function disablePubli($publi_id){
			$sql = DB::open()->prepare("UPDATE csa_publis SET publi_status = 3 WHERE publi_id = :publi_id");
			$sql->execute([
				":publi_id" => intval($publi_id)
			]);

			return $sql->rowCount() > 0;
		}



		public function getComments($publi_id){
			$sql = DB::open()->prepare("SELECT c.*, u.firstname, u.lastname, u.profile_photo FROM csa_publis_comments c 
				LEFT JOIN csa_users u ON c.user_id = u.iduser 
				WHERE publi_id = :publi_id");
			$sql->execute([
				":publi_id" => intval($publi_id)
			]);
			return ($sql->rowCount() > 0) ? $sql->fetchAll(PDO::FETCH_ASSOC) : [];
		}

		public function setComment($publi_id, $user_id, $comment, $parent_id){
			$sql = DB::open()->prepare("INSERT INTO csa_publis_comments () VALUES (
				default,
				:publi_id,
				:user_id,
				:comment,
				:parent_id,
				NOW()
				)");
			$sql->execute([
				":publi_id" => intval($publi_id),
				":user_id" => intval($user_id),
				":comment" => ucfirst(trim($comment)),
				":parent_id" => $parent_id
			]);

			return $sql->rowCount() > 0;
		}

		public function updateComment($publi_comment_id, $comment){
			$sql = DB::open()->prepare("UPDATE csa_publis_comments SET comment = :comment WHERE publi_comment_id = :publi_comment_id");
			$sql->execute([
				":comment" => ucfirst(trim($comment)),
				":publi_comment_id" => intval($publi_comment_id)
			]);
			return $sql->rowCount() > 0;
		}

		public function deleteComment($publi_comment_id){
			$sql = DB::open()->prepare("DELETE FROM csa_publis_comments WHERE publi_comment_id = :publi_comment_id");
			$sql->execute([
				":publi_comment_id" => intval($publi_comment_id)
			]);

			return $sql->rowCount();
		}



		public function getLike($publi_id, $user_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_publis_likes WHERE publi_id = :publi_id AND user_id = :user_id");
			$sql->execute([
				":publi_id" => $publi_id,
				":user_id" => $user_id
			]);

			return $sql;
		}

		public function setLike($publi_id, $user_id){
			$sql = DB::open()->prepare("INSERT INTO csa_publis_likes () VALUES (null, :publi_id, :user_id)");
			$sql->execute([
				":publi_id" => $publi_id,
				":user_id" => $user_id
			]);

			return $sql->rowCount() > 0;
		}

		public function deleteLike($publi_id, $user_id){
		    $sql = DB::open()->prepare("DELETE FROM csa_publis_likes WHERE publi_id = :publi_id AND user_id = :user_id");
		    $sql->execute([
		        ":publi_id" => $publi_id,
		        ":user_id" => $user_id
		    ]);

		    return $sql->rowCount() > 0;
		}


		public static function isPubliAlreadyLiked($publi_id, $user_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_publis_likes WHERE publi_id = :publi_id AND user_id = :user_id");
			$sql->execute([
		        ":publi_id" => $publi_id,
		        ":user_id" => $user_id
		    ]);

		    return $sql->rowCount() > 0;
		}




	}
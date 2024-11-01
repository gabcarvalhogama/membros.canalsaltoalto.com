<?php
	class Club{
		public function create($club_title, $club_description, $club_image, $club_status, $author_email){
			$sql = DB::open()->prepare("
				INSERT INTO csa_clubs ()

				VALUES (default, :club_title, :club_description, :club_image, :club_status, (SELECT iduser FROM csa_users WHERE email = :created_by_email LIMIT 1), NOW(), null, null)

				");
			return $sql->execute([
				":club_title" => ucfirst(ltrim($club_title)),
				":club_description" => ucfirst(ltrim($club_description)),
				":club_image" => $club_image,
				":club_status" => intval($club_status),
				":created_by_email" => filter_var($author_email, FILTER_SANITIZE_EMAIL)
			]);
		}

		public function getClubs($limit = 12){
			$sql = DB::open()->prepare("SELECT * FROM csa_clubs ORDER BY created_at DESC LIMIT :limit_posts");
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function getClubById($club_id){
			$sql = DB::open()->Prepare("SELECT * FROM csa_clubs WHERE club_id = :club_id LIMIT 1");
			$sql->execute([
				":club_id" => intval($club_id)
			]);

			return $sql;
		}


		public function update($club_id, $club_title, $club_description, $club_image, $club_status) {
		    $sql = DB::open()->prepare("
		        UPDATE csa_clubs
		        SET
		            club_title = :club_title,
		            club_description = :club_description,
		            club_image = :club_image,
		            club_status = :club_status,
		            updated_at = NOW()
		        WHERE
		            club_id = :club_id
		    ");
		    return $sql->execute([
		        ":club_id" => intval($club_id),
		        ":club_title" => ucfirst(ltrim($club_title)),
		        ":club_description" => ucfirst(ltrim($club_description)),
		        ":club_image" => $club_image,
		        ":club_status" => intval($club_status)
		    ]);
		}


		public function delete($club_id){
			$sql = DB::open()->prepare("DELETE FROM csa_clubs WHERE club_id = :club_id");
			return $sql->execute([
				":club_id" => intval($club_id)
			]);
		}


	}
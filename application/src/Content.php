<?php
	class Content{
		public function generateSlug($content){
			// Converter para minúsculas
		    $titulo_minusculo = strtolower($content);
		    // Substituir caracteres acentuados por seus equivalentes sem acento
		    $titulo_sem_acentos = iconv('UTF-8', 'ASCII//TRANSLIT', $titulo_minusculo);
		    // Substituir caracteres não alfanuméricos e espaços por hífen
		    $slug = preg_replace('/[^a-z0-9]+/', '-', $titulo_sem_acentos);
		    // Remover hífens no início e no final
		    $slug = trim($slug, '-');
		    return $slug;
		}

		public function create($title, $excerpt, $content, $featured_image, $featured_video, $author_email, $status, $published_at){
			$sql = DB::open()->prepare("
				INSERT INTO csa_contents ()

				VALUES (default, :title, :excerpt, :content, :featured_image, :featured_video, (SELECT iduser FROM csa_users WHERE email = :author_email LIMIT 1), :slug, :term_id, :status, :published_at, NOW(), NOW())
				");
			return $sql->execute([
				":title" => ucfirst(trim($title)),
				":excerpt" => ucfirst(trim($excerpt)),
				":content" => $content,
				":featured_image" => $featured_image,
				":featured_video" => $featured_video,
				":author_email" => $author_email,
				":slug" => $this->generateSlug($title),
				":term_id" => 0,
				":status" => intval($status),
				":published_at" => date("Y-m-d H:i:s", strtotime($published_at))
			]);
		}


		public function update($content_id, $title, $excerpt, $content, $featured_image, $featured_video, $status, $published_at){
			$sql = DB::open()->prepare("
				UPDATE csa_contents SET
				title = :title,
				excerpt = :excerpt,
				content = :content,
				featured_image = :featured_image,
				featured_video = :featured_video,
				status = :status,
				published_at = :published_at,
				updated_at = NOW()

				WHERE idcontent = :content_id
				");
			return $sql->execute([
				":title" => ucfirst(trim($title)),
				":excerpt" => ucfirst(trim($excerpt)),
				":content" => $content,
				":featured_image" => $featured_image,
				":featured_video" => $featured_video,
				":status" => $status,
				":published_at" => $published_at,
				":content_id" => intval($content_id)
			]);
		}


		public function delete($content_id){
			$sql = DB::open()->prepare("DELETE FROM csa_contents WHERE idcontent = :content_id");
			return $sql->execute([":content_id" => intval($content_id)]);
		}




		public function getContents($limit = 12){
			$sql = DB::open()->prepare("SELECT * FROM csa_contents ORDER BY published_at DESC LIMIT :limit_posts");
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function getContentsWithPagination($limit = 12, $offset = 0, $status = 1){
			$sql = DB::open()->prepare("SELECT * FROM csa_contents WHERE status = :status ORDER BY published_at DESC LIMIT :limit_contents OFFSET :offset_contents");
			$sql->bindParam(':limit_contents', $limit, \PDO::PARAM_INT);
			$sql->bindParam(':offset_contents', $offset, \PDO::PARAM_INT);
			$sql->bindParam(':status', $status, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function getContentsTotalNumber(){
			$sql = DB::open()->prepare("SELECT * FROM csa_contents ORDER BY published_at DESC");
			$sql->execute();

			return $sql->rowCount();
		}

		public function getContentBySlug($slug){
			$sql = DB::open()->prepare("SELECT c.*, u.firstname, u.lastname, (SELECT COUNT(idcomment) FROM csa_contents_comments WHERE idcontent = c.idcontent) as number_comments FROM csa_contents c LEFT JOIN csa_users u ON c.author = u.iduser WHERE slug = :slug");
			$sql->execute([
				":slug" => strtolower($slug)
			]);

			return $sql;
		}

		public function getComments($idcontent){
			$sql = DB::open()->prepare("
				SELECT cc.*, u.firstname, u.lastname 
				FROM csa_contents_comments cc 
				LEFT JOIN csa_users u 
					ON cc.user_id = u.iduser
				WHERE 
					idcontent = :idcontent AND 
					is_approved = 1 
				ORDER BY created_at DESC
			");
			$sql->execute([
				":idcontent" => intval($idcontent)
			]);

			return $sql;
		}


		public function createComment($idcontent, $user_id, $comment, $is_approved){
			$sql = DB::open()->prepare("INSERT INTO csa_contents_comments (idcomment, idcontent, user_id, comment, is_approved, created_at) VALUES (default, :idcontent, :user_id, :comment, :is_approved, NOW())");
			return $sql->execute([
				":idcontent" => intval($idcontent),
				":user_id" => $user_id,
				":comment" => $comment,
				":is_approved" => $is_approved
			]);
		}	

		public function getRelatedContents($limit = 12, $actual_content){
			$sql = DB::open()->prepare("SELECT * FROM csa_contents WHERE idcontent != :actual_content ORDER BY published_at DESC LIMIT :limit_contents");
			$sql->bindParam(':actual_content', $actual_content, \PDO::PARAM_INT);
			$sql->bindParam(':limit_contents', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}


		public function getContentById($content_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_contents WHERE idcontent = :content_id LIMIT 1");
			$sql->execute([
				":content_id" => intval($content_id)
			]);

			return $sql;
		}

	}
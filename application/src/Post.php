<?php
	class Post{

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


		public function create($post_title, $post_excerpt, $post_content, $post_featured_image, $created_by_email){
			$sql = DB::open()->prepare("INSERT INTO csa_posts (
				title,
				excerpt,
				post_content,
				featured_image,
				author,
				slug,
				published_at,
				created_at,
				updated_at
			) VALUES (
				:post_title,
				:post_excerpt,
				:post_content,
				:post_featured_image,
				(SELECT iduser FROM csa_users WHERE email = :created_by_email LIMIT 1),
				:slug,
				NOW(),
				NOW(),
				null
			)");

			return $sql->execute([
				":post_title" => $post_title,
				":post_excerpt" => $post_excerpt,
				":post_content" => $post_content,
				":post_featured_image" => $post_featured_image,
				":created_by_email" => filter_var($created_by_email, FILTER_SANITIZE_EMAIL),
				":slug" => $this->generateSlug($post_title)
			]);
		}

		public function update($post_id, $post_title, $post_excerpt, $post_content, $post_featured_image){
		    $sql = DB::open()->prepare("
		        UPDATE csa_posts 
		        SET 
		            title = :post_title,
		            excerpt = :post_excerpt,
		            post_content = :post_content,
		            featured_image = :post_featured_image,
		            updated_at = NOW()
		        WHERE post_id = :post_id
		    ");

		    return $sql->execute([
		        ":post_id" => intval($post_id),
		        ":post_title" => $post_title,
		        ":post_excerpt" => $post_excerpt,
		        ":post_content" => $post_content,
		        ":post_featured_image" => $post_featured_image,
		    ]);
		}


		public function getPosts($limit = 12, $offset = 0){
			$sql = DB::open()->prepare("SELECT * FROM csa_posts ORDER BY published_at DESC LIMIT :limit_posts OFFSET :offset_posts");
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->bindParam(':offset_posts', $offset, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}


		public function getRelatedPosts($limit = 12, $actual_post){
			$sql = DB::open()->prepare("SELECT * FROM csa_posts WHERE post_id != :actual_post ORDER BY published_at DESC LIMIT :limit_posts");
			$sql->bindParam(':actual_post', $actual_post, \PDO::PARAM_INT);
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}


		public function getPost($post_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_posts WHERE post_id = :post_id");
			$sql->execute([
				":post_id" => intval($post_id)
			]);

			return $sql;
		}


		public function getPostBySlug($slug){
			$sql = DB::open()->prepare("SELECT p.*, u.firstname, u.lastname, u.email, (SELECT COUNT(comment_id) FROM csa_posts_comments WHERE post_id = p.post_id) as number_comments FROM csa_posts p LEFT JOIN csa_users u ON p.author = u.iduser WHERE slug = :slug");
			$sql->execute([
				":slug" => strtolower($slug)
			]);

			return $sql;
		}



		public function addComment($post_id, $name, $email, $comment, $is_approved, $ip){
			$sql = DB::open()->prepare("INSERT INTO csa_posts_comments () VALUES (default, :post_id, :user_name, :user_email, :comment, :is_approved, :ip, NOW())");
			return $sql->execute([
				":post_id" => intval($post_id),
				":user_name" => ucfirst($name),
				":user_email" => filter_var($email, FILTER_SANITIZE_EMAIL),
				":comment" => ucfirst(trim($comment)),
				":is_approved" => intval($is_approved),
				":ip" => $ip
			]);
		}

		public function getComments($post_id){
			$sql = DB::open()->prepare("SELECT * FROM csa_posts_comments WHERE post_id = :post_id ORDER BY created_at DESC");
			$sql->execute([
				":post_id" => intval($post_id)
			]);

			return $sql;
		}


	}
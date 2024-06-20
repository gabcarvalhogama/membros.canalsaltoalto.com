<?php
	class Post{



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
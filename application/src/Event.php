<?php
	class Event{
		public function create($event_title, $event_excerpt, $event_datetime, $event_poster, $event_content, $created_by_email){
			$sql = DB::open()->prepare("
		        INSERT INTO csa_events (
		        	idevent,
		            event_title,
		            event_excerpt,
		            event_datetime,
		            event_poster,
		            event_content,
		            slug,
		            created_by,
		            status,
		            created_at,
		            updated_at
		        ) VALUES (
		            default,
		            :event_title,
		            :event_excerpt,
		            :event_datetime,
		            :event_poster,
		            :event_content,
		            :slug,
		            (SELECT iduser FROM csa_users WHERE email = :created_by_email LIMIT 1),
		            :status,
		            NOW(),
		            null
		        )
		    ");

		    return $sql->execute([
	            ":event_title" => ucfirst(trim($event_title)),
	            ":event_excerpt" => ucfirst(trim($event_excerpt)),
	            ":event_datetime" => $event_datetime,
	            ":event_poster" => $event_poster,
	            ":event_content" => ucfirst(trim($event_content)),
	            ":slug" => $this->generateSlug(trim($event_title)),
	            ":created_by_email" => $created_by_email,
	            ":status" => 0,
		    ]);
		}

		public function update($idevent, $event_title, $event_excerpt, $event_datetime, $event_poster, $event_content) {
		    $sql = DB::open()->prepare("
		        UPDATE csa_events SET
		            event_title = :event_title,
		            event_excerpt = :event_excerpt,
		            event_datetime = :event_datetime,
		            event_poster = :event_poster,
		            event_content = :event_content,
		            updated_at = NOW()
		        WHERE
		            idevent = :idevent
		    ");

		    return $sql->execute([
		        ":event_title" => ucfirst(trim($event_title)),
		        ":event_excerpt" => ucfirst(trim($event_excerpt)),
		        ":event_datetime" => $event_datetime,
		        ":event_poster" => $event_poster,
		        ":event_content" => ucfirst(trim($event_content)),
		        ":idevent" => $idevent,
		    ]);
		}


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

		public function getEvents($limit = 12){
			$sql = DB::open()->prepare("SELECT * FROM csa_events ORDER BY event_datetime DESC LIMIT :limit_posts");
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function getEventsTotalNumber(){
			$sql = DB::open()->prepare("SELECT * FROM csa_events");
			$sql->execute();

			return $sql->rowCount();
		}

		public function getEventsWithPagination($limit = 12, $offset = 0, $status = 1){
			$sql = DB::open()->prepare("SELECT * FROM csa_events WHERE status = :status ORDER BY event_datetime DESC LIMIT :limit_events OFFSET :offset_events");
			$sql->bindParam(':limit_events', $limit, \PDO::PARAM_INT);
			$sql->bindParam(':offset_events', $offset, \PDO::PARAM_INT);
			$sql->bindParam(':status', $status, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}

		public function getEventBySlug($slug){
			$sql = DB::open()->prepare("SELECT * FROM csa_events WHERE slug = :slug LIMIT 1");
			$sql->execute([
				":slug" => $slug
			]);

			return $sql;
		}

		public function getEventById($idevent){
			$sql = DB::open()->prepare("SELECT * FROM csa_events WHERE idevent = :idevent LIMIT 1");
			$sql->execute([
				":idevent" => $idevent
			]);

			return $sql;
		}



		
	}
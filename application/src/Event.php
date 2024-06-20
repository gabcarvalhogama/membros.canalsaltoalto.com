<?php
	class Event{
		public function getEvents($limit = 12){
			$sql = DB::open()->prepare("SELECT * FROM csa_events ORDER BY event_datetime DESC LIMIT :limit_posts");
			$sql->bindParam(':limit_posts', $limit, \PDO::PARAM_INT);
			$sql->execute();

			return $sql;
		}
	}
<?php
	class Consulting{
        public function getConsultingByUserId($user_id){
            $sql = DB::open()->prepare("SELECT * FROM csa_users_consulting WHERE user_id = :user_id");
            $sql->execute([
                ":user_id" => intval($user_id)
            ]);

            return $sql;
        }

        public function create($user_id, $consulting_date, $consulting_observation){
            $sql = DB::open()->prepare("INSERT INTO csa_users_consulting () VALUES (default, :user_id, :consulting_date, :consulting_observation, NOW(), NOW())");
            return $sql->execute([
                ":user_id" => intval($user_id),
                ":consulting_date" => $consulting_date,
                ":consulting_observation" => ucfirst(trim($consulting_observation))
            ]);
            
        }

        public function deleteConsultingById($user_consulting_id){
            $sql = DB::open()->prepare("DELETE FROM csa_users_consulting WHERE user_consulting_id = :user_consulting_id");
            return $sql->execute([
                ":user_consulting_id" => intval($user_consulting_id)
            ]);
        }

    }

?>
<?php
    class Tutorial
    {
        /*
            * tutorial_id, tutorial_title, tutorial_content, author, status, published_at, created_at, updated_at
        */

        public function get($tutorial_id){
            $sql = DB::open()->prepare("SELECT * FROM csa_tutorials WHERE tutorial_id = :tutorial_id");
            $sql->bindParam(':tutorial_id', $tutorial_id);
            $sql->execute();

            return $sql;
        }

        public function getAll(){
            $sql = DB::open()->prepare("SELECT * FROM csa_tutorials ORDER BY published_at DESC");
            $sql->execute();

            return $sql;
        }

        public function getTutorials($limit = 12){
            $sql = DB::open()->prepare("SELECT * FROM csa_tutorials WHERE  status = 1 AND published_at <= NOW() ORDER BY tutorial_order ASC LIMIT :limit_tutorials");
            $sql->bindParam(':limit_tutorials', $limit, \PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        public function create($tutorial_title, $tutorial_content, $tutorial_order, $author, $status, $published_at) {
            $sql = DB::open()->prepare(
            "INSERT INTO csa_tutorials (tutorial_title, tutorial_content, tutorial_order, author, status, published_at, created_at, updated_at)
             VALUES (:title, :content, :tutorial_order, :author, :status, :published_at, NOW(), NOW())"
            );
            $sql->bindParam(':title', $tutorial_title);
            $sql->bindParam(':content', $tutorial_content);
            $sql->bindParam(':tutorial_order', $tutorial_order);
            $sql->bindParam(':author', $author);
            $sql->bindParam(':status', $status);
            $sql->bindParam(':published_at', $published_at);
            return $sql->execute();
        }

        public function update($tutorial_id, $tutorial_title, $tutorial_content, $tutorial_order, $status, $published_at) {
            $sql = DB::open()->prepare(
            "UPDATE csa_tutorials SET
                tutorial_title = :title,
                tutorial_content = :content,
                tutorial_order = :tutorial_order,   
                status = :status,
                published_at = :published_at,
                updated_at = NOW()
             WHERE tutorial_id = :tutorial_id"
            );
            $sql->bindParam(':title', $tutorial_title);
            $sql->bindParam(':content', $tutorial_content);
            $sql->bindParam(':tutorial_order', $tutorial_order);
            $sql->bindParam(':status', $status);
            $sql->bindParam(':published_at', $published_at);
            $sql->bindParam(':tutorial_id', $tutorial_id);
            return $sql->execute();
        }

        public function delete($tutorial_id) {
            $sql = DB::open()->prepare("DELETE FROM csa_tutorials WHERE tutorial_id = :tutorial_id");
            $sql->bindParam(':tutorial_id', $tutorial_id);
            return $sql->execute();
        }
    }
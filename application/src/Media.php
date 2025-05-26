<?php
    class Media
    {
        public function getMedias()
        {
            $sql = DB::open()->prepare("SELECT * FROM csa_medias ORDER BY created_at DESC LIMIT 100");
            $sql->execute();
            return $sql;
        }

        public function getMediaById($media_id)
        {
            $sql = DB::open()->prepare("SELECT * FROM csa_medias WHERE media_id = :media_id");
            $sql->bindParam(':media_id', $media_id, PDO::PARAM_INT);
            $sql->execute();
            return $sql;
        }

        public function updateMedia($media_id, $attributes)
        {
            $sql = DB::open()->prepare("UPDATE csa_medias SET `attributes` = :attributes WHERE media_id = :media_id");
            $sql->bindParam(':media_id', $media_id, PDO::PARAM_INT);
            $sql->bindParam(':attributes', $attributes, PDO::PARAM_STR);
            return $sql->execute();
        }
    }
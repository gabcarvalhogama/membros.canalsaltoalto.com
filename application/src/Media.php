<?php
    class Media
    {
        public function getMedias()
        {
            $sql = DB::open()->prepare("SELECT * FROM csa_medias ORDER BY created_at DESC LIMIT 100");
            $sql->execute();
            return $sql;
        }
    }
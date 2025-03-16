<?php
	class Banner{
		public $positions = array(
			"public_home_hero" => "Página Inicial - Hero",
			"public_home_ad1" => "Página Inicial - Espaço 1",
			"public_home_ad2" => "Página Inicial - Espaço 2",
			"public_home_ad3" => "Página Inicial - Espaço 3",
			"app_home_hero" => "App - Hero"
		);

		public function getBanners(){
			$sql = DB::open()->prepare("SELECT * FROM csa_banners ORDER BY banner_id ASC");
			$sql->execute();

			return $sql;
		}

		public function getBannersByPosition($position = ''){
			$sql = DB::open()->prepare("SELECT * FROM csa_banners WHERE position = :position ORDER BY banner_order ASC");
			$sql->execute([
				":position" => trim(strtolower($position))
			]);

			return $sql;
		}

		public function getBannerById($banner_id) {
		    $sql = DB::open()->prepare("SELECT * FROM csa_banners WHERE banner_id = :banner_id LIMIT 1");
		    $sql->execute([":banner_id" => $banner_id]);

		    return $sql->fetch(PDO::FETCH_ASSOC);
		}


		public function create($path_desktop, $path_mobile, $position, $link, $banner_order, $banner_status, $user_id) {
	        $sql = DB::open()->prepare("INSERT INTO csa_banners (path_desktop, path_mobile, position, link, banner_order, banner_status, user_id) 
	                                    VALUES (:path_desktop, :path_mobile, :position, :link, :banner_order, :banner_status, :user_id)");
	        $sql->execute([
	            ":path_desktop" => $path_desktop,
	            ":path_mobile" => $path_mobile,
	            ":position" => $position,
	            ":link" => $link,
	            ":banner_order" => $banner_order,
	            ":banner_status" => $banner_status,
	            ":user_id" => $user_id
	        ]);
	        return $sql->rowCount() > 0; // Retorna verdadeiro se a inserção for bem-sucedida
	    }

	    public function update($banner_id, $path_desktop, $path_mobile, $position, $link, $banner_order, $banner_status, $user_id) {
	        $sql = DB::open()->prepare("UPDATE csa_banners 
	                                    SET path_desktop = :path_desktop, path_mobile = :path_mobile, position = :position, 
	                                        link = :link, banner_order = :banner_order, banner_status = :banner_status, user_id = :user_id, updated_at = NOW()
	                                    WHERE banner_id = :banner_id");
	        $sql->execute([
	            ":banner_id" => $banner_id,
	            ":path_desktop" => $path_desktop,
	            ":path_mobile" => $path_mobile,
	            ":position" => $position,
	            ":link" => $link,
	            ":banner_order" => $banner_order,
	            ":banner_status" => $banner_status,
	            ":user_id" => $user_id
	        ]);
	        return $sql->rowCount() > 0; // Retorna verdadeiro se a atualização for bem-sucedida
	    }

	    public function delete($banner_id) {
	        $sql = DB::open()->prepare("DELETE FROM csa_banners WHERE banner_id = :banner_id");
	        $sql->execute([
	            ":banner_id" => $banner_id
	        ]);
	        return $sql->rowCount() > 0; // Retorna verdadeiro se a exclusão for bem-sucedida
	    }



	}
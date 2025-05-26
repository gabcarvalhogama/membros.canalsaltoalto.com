<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Mídias ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">
		<?=Template::render(null, "after-body-tags")?>

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
                    <h1>Mídias</h1>
                    <ul class="d-flex flex-row medias">
                        <?php
                            $Media = new Media();
                            $medias = $Media->getMedias();
                            foreach ($medias->fetchAll(PDO::FETCH_ASSOC) as $media)
                                echo Template::render(["media" => $media], "media_item");
                        ?>
                    </ul>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>
	</body>
</html>
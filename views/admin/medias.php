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


		<!-- Button trigger modal -->
		<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewMedia">
		Launch demo modal
		</button> -->

		<!-- Modal -->
		<div class="modal fade" id="viewMedia" tabindex="-1" aria-labelledby="viewMediaLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<img src="/" alt="" class="img-fluid mb-3" id="mediaPath" />
					<form action="javascript:void(0)" onsubmit="Admin.Medias.updateMedia(this)">
						<div class="message"></div>
						<div class="form-group mb-3">
							<label for="mediaUrl">URL da Mídia</label>
							<input type="text" class="form-control" id="mediaUrl" placeholder="" disabled />
						</div>
						<div class="form-group mb-3">
							<label for="mediaAlt">Texto Alternativo</label>
							<input type="text" class="form-control" id="mediaAlt" placeholder="Atributo ALT" />
						</div>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
						<button type="submit" class="btn btn-primary">Salvar alterações</button>

						<input type="hidden" id="mediaId" value="" />
					</form>
				</div>
			</div>
		</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>
	</body>
</html>
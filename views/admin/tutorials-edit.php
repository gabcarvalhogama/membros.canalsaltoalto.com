<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$tutorial->tutorial_title?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">
	<?=Template::render(null, "after-body-tags")?>

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Editando: <?=$tutorial->tutorial_title?></h1>
					<form action="javascript:void(0)" method="post" onsubmit="Admin.Tutorials.update(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>

						<div class="row">
							<div class="col mb-3">
								<label for="tutorial_order" class="form-label">Ordem</label>
								<input type="number" class="form-control" id="tutorial_order" name="tutorial_order" placeholder="Digite a ordem do tutorial." value="<?=$tutorial->tutorial_order?>" required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="tutorial_title" class="form-label">Título do Tutorial</label>
								<input type="text" class="form-control" id="tutorial_title" name="tutorial_title" placeholder="Escreva aqui o título do tutorial." required value="<?=$tutorial->tutorial_title?>" />
							</div>
						</div>
						

						<div class="row">
							<div class="col mb-3">
								<label for="tutorial_video_url" class="form-label">URL do Vídeo</label>
								<input type="text" class="form-control" id="tutorial_video_url" name="tutorial_video_url" placeholder="Ex: https://www.youtube.com/watch?v=1234567890" value="<?=$tutorial->tutorial_video_url?>" />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<textarea name="tutorial_content" id="tutorial_content" class="form-control" placeholder="Escreva aqui seu conteúdo."><?=$tutorial->tutorial_content?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="tutorial_status" class="form-label">Status</label>
								<select name="tutorial_status" id="tutorial_status" class="form-control" required>
									<option value="0" <?=(($tutorial->status == 0) ? 'selected' : '')?>>Rascunho</option>
									<option value="1" <?=(($tutorial->status == 1) ? 'selected' : '')?>>Publicado</option>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label for="tutorial_publish_date" class="form-label">Data de Publicação</label>
								<input type="text" name="tutorial_publish_date" id="tutorial_publish_date" class="form-control" data-mask="00/00/0000 00:00" placeholder="dd/mm/aaaa hh:mm" value="<?=DateTime::createFromFormat('Y-m-d H:i:s', $tutorial->published_at)->format('d-m-Y H:i')?>" />
								<!-- <small>Deixe em branco para publicar agora.</small> -->
							</div>
						</div>

						<div class="form-group row align-items-center">
							<div class="col-md-6">
								<input type="submit" value="Atualizar tutoriais" class="btn btn-rose btn-rose-light btn-full btn-medium" />
							</div>
							<div class="col-md-6">
								<a href="javascript:void(0)" style="color: #000;" onclick="Admin.Tutorials.delete('<?=$tutorial->tutorial_id?>')"><i class="fa-solid fa-trash"></i> Apagar tutorial</a>
							</div>
						</div>

                        <input type="hidden" id="tutorial_id" value="<?=$tutorial->tutorial_id?>"/>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce-setup.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
		<script type="text/javascript">
			setupTinyMCE('textarea#tutorial_content', '<?=PATH?>upload/image');
		</script>	
	</body>
</html>
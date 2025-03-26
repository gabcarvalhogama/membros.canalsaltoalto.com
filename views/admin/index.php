<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Canal Salto Alto - Painel Administrativo</title>
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
				<h1>Dashboard</h1>
				<div class="row mb-3">
					<div class="col-xl-4 col-lg-6">
						<div class="card card-stats mb-4 mb-xl-0">
							<div class="card-body">
								<div class="row">
									<div class="col">
										<h5 class="card-title text-muted mb-0"><a href="/admin/members/active" style="color: #000">Membros Ativos</a></h5>
										<span class="h2 font-weight-bold mb-0"><?=User::getActiveMembersCount()?></span>
									</div>
									<div class="col-auto">
										<div class="icon icon-shape bg-primary text-white rounded-circle shadow" style="width: 25px;height: 25px;text-align: center;">
											<i class="fa-solid fa-user"></i>
										</div>
									</div>
								</div>
			                  <!-- <p class="mt-3 mb-0 text-muted text-sm">
			                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
			                    <span class="text-nowrap">Since last month</span>
			                </p> -->
			            </div>
			        </div>
			    </div>
			    <div class="col-xl-4 col-lg-6">
			    	<div class="card card-stats mb-4 mb-xl-0">
			    		<div class="card-body">
			    			<div class="row">
			    				<div class="col">
			    					<h5 class="card-title text-muted mb-0"><a href="/admin/members/inactive" style="color: #000">Membros Inativos</a></h5>
			    					<span class="h2 font-weight-bold mb-0"><?php
			    						$User = new User;
			    						echo $User->getInactiveUsers()->rowCount()?></span>
			    				</div>
			    				<div class="col-auto">
			    					<div class="icon icon-shape bg-primary text-white rounded-circle shadow" style="width: 25px;height: 25px;text-align: center;">
			    						<i class="fa-solid fa-user"></i>
			    					</div>
			    				</div>
			    			</div>
			                  <!-- <p class="mt-3 mb-0 text-muted text-sm">
			                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
			                    <span class="text-nowrap">Since last week</span>
			                </p> -->
			            </div>
			        </div>
			    </div>
			    <div class="col-xl-4 col-lg-6">
			    	<div class="card card-stats mb-4 mb-xl-0">
			    		<div class="card-body">
			    			<div class="row">
			    				<div class="col">
			    					<h5 class="card-title text-muted mb-0">Total de Membros</h5>
			    					<span class="h2 font-weight-bold mb-0"><?=(User::getActiveMembersCount() + $User->getInactiveUsers()->rowCount())?></span>
			    				</div>
			    				<div class="col-auto">
			    					<div class="icon icon-shape bg-primary text-white rounded-circle shadow" style="width: 25px;height: 25px;text-align: center;">
			    						<i class="fa-solid fa-handshake"></i>
			    					</div>
			    				</div>
			    			</div>
			                  <!-- <p class="mt-3 mb-0 text-muted text-sm">
			                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
			                    <span class="text-nowrap">Since yesterday</span>
			                </p> -->
			            </div>
			        </div>
			    </div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-header-tab card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
								<i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"></i> Expirações nos próximos 15 dias
							</div>
						</div>

						<div class="card-body">
							<?php
								$Users = new User;
								$nextExpirations = $Users->getNextExpirationMembers(15);
								foreach($nextExpirations->fetchAll(PDO::FETCH_ASSOC) as $user_exp):
									// var_dump($user_exp);
									?>
									<div class="row mb-3 align-items-center">
										<div class="col-8">
											<a href="/admin/members/edit/<?=$user_exp['iduser']?>" style="color: #333;"><?=$user_exp['firstname']." ".$user_exp["lastname"]?></a>
										</div>
										<div class="col-4 text-end">
											<?=date("d/m/Y", strtotime($user_exp['ends_at']))?>
										</div>
									</div>
								<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
</body>
</html>
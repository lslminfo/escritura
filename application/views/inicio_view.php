<!DOCTYPE html>
<!--Esse aquivo é simplesmente para monstar informações ao usuario "TELA NAO TEM PROCESAMENTO"-->

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="pt-br"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
	  <meta charset="utf-8" />
	  <!-- Set the viewport width to device width for mobile -->
	  <meta name="viewport" content="width=device-width" />
	
	  <title>{tituloaba}</title>
	  
	  <!-- Included CSS Files (Compressed) -->
	  {headerinc}
	  <!--<link rel="stylesheet" href="http://localhost/escritura/css/foundation.min.css">
	  <link rel="stylesheet" href="http://localhost/escritura/css/app.css">-->
	</head>

	<body>
		<div class="row">
			<div class="twelve columns principal">
				<?php if(esta_logado(FALSE)): ?> <!--COMEÇA IF-->
					<div class="row">
						<div class="three columns informa">
							<p class="text-center">{logo}
						</div>
						<div class="six columns informa">
							{titulop}
							{subtitulo}
						</div>
						<div class="three columns informa">
							<span class="radius secondary label">Logado como: <strong><?php echo strtoupper($this->session->userdata('user_nome')); ?></strong></span>
							<br /><br />
							<span class="radius secondary label">Empreend: <strong><?php echo strtoupper($this->session->userdata('fantasia')); ?></strong></span>
							<br /><br />
							<p class="text-right">
								<?php echo anchor('escrituras_controle/altera_senha/'.$this->session->userdata('user_id'), 'Alterar senha', 'class="button radius tiny"') ?>
								<?php echo anchor('escrituras_controle/logoff', ' Sair! ', 'class="button radius alert tiny"') ?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="twelve columns menu-site">
							<ul class="nav-bar">
								<li><?php echo anchor('inicio_controle', 'Inicio'); ?></li>
								<li class="has-flyout">
									<?php echo anchor('telas_modulos/gerenciar', 'Resumos'); ?>
									<ul class="flyout">
										<li><?php echo anchor('escrituras_controle/cadastrar','Cadastrar') ?></li>
										<li><?php echo anchor('telas_modulos/gerenciar','Gerenciar') ?></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				<?php endif; ?>	<!--TERMINA IF-->
					
					<div class="row">
						<div class="twelve columns c_modulos">
							<div class="row">
								{aviso}
								{telas_sistema}
							</div>
						</div>
					</div>

				
			</div>
			{rodape}
		</div>
		
		<!-- Included JS Files (Compressed) -->
		{footerinc}
	</body>

</html>

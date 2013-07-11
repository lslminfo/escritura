<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Este arquivo vai interagir com o "inicio_view" para montar as telas que se fizerem necessárias.
//Vamos usar um "switch" cada opção dele é um complemento de tela a ser gerada dentro "inicio_view".
//Na (class='???? columns') por padrão ela esta alinhada a Esquerda=>'LEFHT' para colocar ao Centro=>'CENTERED' para colocar a Direita=>'offset-by-###' onde ### é a diferença das colunas '????' informadas

switch ($tela):
	case 'login':
		//echo 'Exibe tela de LOGIN do "CASE - TELAS_MODULOS.PHP "';
		echo '<div class="four columns centered">';
			echo form_open('escrituras_controle/login', array('class'=>'custom loginform'));
			echo form_fieldset('Identifique-se');
			erros_validacao();
			get_msg('logoffok');
			get_msg('errologin');
			echo form_label('Login');
			echo form_input(array('name'=>'login'), set_value('login'), 'autofocus');
			echo form_label('Senha');
			echo form_password(array('name'=>'senha'), set_value('senha'));
			echo form_dropdown('empr', $this->geral_m->get_empreend(), '0');
			//echo form_dropdown('empreend', $emp, '0');
			//echo form_hidden('redirect', $this->session->userdata('redir_para'));
			echo form_submit(array('name'=>'logar', 'class'=>'button radius right tiny'), 'Logar!');
			echo '<p class="esqueci">'.anchor('escrituras_controle/nova_senha_off', 'Esqueci minha senha').'</p>';
			echo form_fieldset_close();
			echo form_close();
		echo '</div>';
		break;
		
	case 'empreendimento':
		esta_logado();
		echo '<div class="twelve columns telas_c">';
			//echo '<br /><br />Na espera por ação do USUÁRIO "CASE - TELAS_MODULOS.PHP "';
			get_msg('msgerro');
			get_msg('msgok');
		echo '</div>';
			
		break;
		
	case 'nova_senha_off':
		echo '<div class="four columns centered">';
			echo form_open('escrituras_controle/nova_senha_off', array('class'=>'custom loginform'));
			echo form_fieldset('Solicitação de senha');
			get_msg('msgok');
			get_msg('msgerro');
			erros_validacao();
			echo form_label('Seu e-mail');
			echo form_input(array('name'=>'email'), set_value('email'), 'autofocus');
			//echo form_hidden('redirect', $this->session->userdata('redir_para'));
			echo form_submit(array('name'=>'novasenha', 'class'=>'button radius right tiny'), 'Enviar senha!');
			echo '<p class="esqueci">'.anchor('escrituras_controle/login', 'Fazer login').'</p>';
			echo form_fieldset_close();
			echo form_close();
		echo '</div>';
		break;
		
	case 'altera_senha':
		$iduser = $this->uri->segment(3);
		if ($iduser == 1 || $iduser != $this->session->userdata('user_id')):
			set_msg('msgerro', 'Ação solicitada não é permitida!', 'erro');
			redirect('escrituras_controle/empreendimento');
		else:
			echo '<div class="four columns centered">';
				echo form_open(current_url(), array('class'=>'custom'));
				echo form_fieldset('Alterar senha atual');
				get_msg('msgok');
				erros_validacao();
				echo '<div class="row">';
					echo '<div class="four mobile-one columns">';
						echo form_label('Senha atual: ','', array('class' => 'in_line',));
					echo '</div>';
					echo '<div class="eight mobile-three columns">';
						echo form_password(array('name'=>'senhaatual'), set_value(''), 'autofocus');
			    	echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="four mobile-one columns">';
						echo form_label('Nova Senha:','', array('class' => 'in_line',));
					echo '</div>';
					echo '<div class="eight mobile-three columns">';
						echo form_password(array('name'=>'novasenha'), set_value(''));
			    	echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="four mobile-one columns">';
						echo form_label('Repita senha','', array('class' => 'in_line',));
					echo '</div>';
					echo '<div class="eight mobile-three columns">';
						echo form_password(array('name'=>'novasenha2'), set_value(''));
			    	echo '</div>';
				echo '</div>';
				//echo form_hidden('redirect', $this->session->userdata('redir_para'));
				echo anchor('escrituras_controle/empreendimento', 'Desistir !', array('class'=>'button alert tiny espaco'));
				echo form_submit(array('name'=>'alterasenha', 'class'=>'button tiny'), 'Alterar senha!');
				echo form_fieldset_close();
				echo form_close();
			echo '</div>';
		endif;
		break;
		
	case 'cadastrar':
		esta_logado();

		echo '<div class="twelve columns telas_c">';
			//echo '<br /><br />Na espera por ação do USUÁRIO "CASE - TELAS_MODULOS.PHP "';
			?>
			<script type="text/javascript">
				var path = '<?php echo site_url(); ?>'
			</script>
			<?php
			get_msg('msgerro');
			get_msg('msgok');
			erros_validacao();
			
			echo form_open(current_url(), array('class'=>'custon'));
				echo '<div class="row collapse">';
					echo '<div class="one mobile-one columns">';
						echo '<span class="prefix" class="has-tip tip-left" title="Selecione o corretor que fez a venda!">Corretor 1:</span>';
					echo '</div>';
					echo '<div class="two mobile-one columns">';
						echo form_dropdown('corretor1', $this->geral_m->get_corretor1($this->session->userdata('id_emp')), '', 'class="drop"');
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo '<span class="prefix" class="has-tip tip-top" title="O corretor 2 só aparece após a escolha do corretor 1">Corretor 2:</span>';
					echo '</div>';
					echo '<div class="two mobile-one columns">';
						echo form_dropdown('corretor2', array(''=>'Selecione corretor 1'), '', 'class="drop"');
					echo '</div>';

					echo '<div class="one mobile-one columns offset-by-one">';
						echo '<span class="prefix">Quadra:</span>';
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo form_dropdown('quadra', $this->geral_m->getQuadra($this->session->userdata('id_emp')), '', 'class="drop"');
					echo '</div>';
					echo '<div class="one mobile-one columns offset-by-one">';
						echo '<span class="prefix">Lote:</span>';
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo form_dropdown('lote', array(''=>'Lote'), '', 'class="drop"');
					echo '</div>';
				echo '</div>';

				echo '<div class="row collapse">';
					echo '<div class="two mobile-one columns">';
						echo '<span class="prefix">Área do lote (m²):</span>';
					echo '</div>';
					echo '<div class="two mobile-one columns">';
						echo '<p id="mquadrado" class="txt_fixo"><p>';
					echo '</div>';
					echo '<div class="two mobile-one columns">';
						echo '<span class="prefix">Valor de tabela:</span>';
					echo '</div>';
					echo '<div class="two mobile-one columns end">';
						echo '<p id="vlmquadrado" class="txt_fixo"><p>';
					echo '</div>';
					echo '<div class="two mobile-one columns">';
						echo '<span class="prefix">Status:</span>';
					echo '</div>';
					echo '<div class="two mobile-one columns end">';
						echo '<p id="situacao" class="txt_fixo"><p>';
					echo '</div>';
				echo '</div>';
				
				echo '<div class="row">';
					echo '<div class="twelve columns">';
						echo '<div class="alert-box secondary">';
							echo 'Qualificação dos compradores';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				
				echo '<dl class="tabs contained">';
				  echo '<dd class="active"><a href="#comprador1">Comprador 1</a></dd>';
				  echo '<dd><a href="#comprador2">Comprador 2</a></dd>';
				  echo '<dd><a href="#comprador3">Comprador 3</a></dd>';
				  echo '<dd><a href="#comprador4">Comprador 4</a></dd>';
				echo '</dl>';
				echo '<ul class="tabs-content contained">';
				  echo '<li class="active" id="comprador1Tab">';
				  		echo '<div class="row collapse">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Nome:</span>';
							echo '</div>';
							echo '<div class="four mobile-one columns">';
								echo form_input(array('name'=>'comp1', 'id'=>'comp1', 'value'=>'', 'maxlength'=>'50'), '', 'placeholder="<Completo com no máximo de 50 caracteres>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Sexo:</span>';
							echo '</div>';
							echo '<div class="three mobile-one columns txt_fixo2">';
								echo form_radio(array('name'=>'sexo_comp1', 'value'=>'masculino', 'checked'=>TRUE, 'style'=>'margin:8px')).'Masculino &nbsp;&nbsp;&nbsp;';
								echo form_radio(array('name'=>'sexo_comp1', 'value'=>'feminino')).'Feminino';
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Data Nasc.:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'dtnasc_comp1', 'id'=>'dtnasc_comp1', 'value'=>''), '', 'placeholder="<dd/mm/aaaa>"');
							echo '</div>';
						echo '</div>';
						echo '<div class="row collapse">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">RG:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'rg_comp1', 'id'=>'rg_comp1', 'value'=>''), '', 'placeholder="<99.999.999-9>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Expedido:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'rgdtexp_comp1', 'id'=>'rgdtexp_comp1', 'value'=>''), '', 'placeholder="<dd/mm/aaaa>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Orgão:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'rgorg_comp1', 'id'=>'rgorg_comp1', 'value'=>''), '', 'placeholder="<SSP-SP>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">CPF:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'cpf_comp1', 'id'=>'cpf_comp1', 'value'=>''), '', 'placeholder="<999.999.999-99>"');
							echo '</div>';						
						echo '</div>';
						echo '<div class="row collapse">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Mãe:</span>';
							echo '</div>';
							echo '<div class="five mobile-one columns">';
								echo form_input(array('name'=>'mae_comp1', 'id'=>'mae_comp1', 'value'=>'', 'maxlength'=>'50'), '', 'placeholder="<Completo com no máximo de 50 caracteres>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Pai:</span>';
							echo '</div>';
							echo '<div class="five mobile-one columns">';
								echo form_input(array('name'=>'pai_comp1', 'id'=>'pai_comp1', 'value'=>'', 'maxlength'=>'50'), '', 'placeholder="<Completo com no máximo de 50 caracteres>"');
							echo '</div>';
						echo '</div>';
						echo '<div class="row collapse">';
							echo '<div class="two mobile-one columns">';
								echo '<span class="prefix">Nacionalidade:</span>';
							echo '</div>';
							echo '<div class="four mobile-one columns">';
								echo form_input(array('name'=>'nacio_comp1', 'id'=>'nacio_comp1', 'value'=>''), '', 'placeholder="<Pais em que nasceu> - Brasileira"');
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo '<span class="prefix">Naturalidade:</span>';
							echo '</div>';
							echo '<div class="four mobile-one columns">';
								echo form_input(array('name'=>'natur_comp1', 'id'=>'natur_comp1', 'value'=>''), '', 'placeholder="<Estado em que nasceu> - São Paulo-SP"');
							echo '</div>';
						echo '</div>';
						echo '<div class="row collapse">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">CEP:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'cep_comp1', 'id'=>'cep_comp1', 'value'=>'', 'maxlength'=>'9'), '', 'placeholder="<99999-999>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">BAIRRO:</span>';
							echo '</div>';
							echo '<div class="three mobile-one columns">';
								echo form_input(array('name'=>'bairro_comp1', 'id'=>'bairro_comp1', 'value'=>''), '', 'placeholder="<Nome do JARDIM BAIRRO>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Cidade:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'cid_comp1', 'id'=>'cid_comp1', 'value'=>''), '', 'placeholder="<CIDADE>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">UF:</span>';
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo form_input(array('name'=>'uf_comp1', 'id'=>'uf_comp1', 'value'=>''), '', 'placeholder="<ESTADO>"');
							echo '</div>';
								echo '</div>';
						echo '<div class="row collapse">';
							echo '<div class="two mobile-one columns">';
								echo '<span class="prefix">Endereço Residêncial:</span>';
							echo '</div>';
							echo '<div class="ten mobile-one columns">';
								echo form_input(array('name'=>'end_comp1', 'id'=>'end_comp1', 'value'=>''), '', 'placeholder="<Completo com RUA, AV, TRAVESSA e COMPLEMENTO>"');
							echo '</div>';
						echo '</div>';

						echo '<div class="row collapse">';
							echo '<div class="two mobile-one columns">';
								echo '<span class="prefix">Estado Civil:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_dropdown('civil_comp1', $this->geral_m->getcivil(), '5', 'class="drop"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix" id="escondeR">Regime:</span>';
							echo '</div>';
							echo '<div class="three mobile-one columns" id="escondeD">';
								echo form_dropdown('regime_comp1', array(''=>'Escolha estado civil'), '2', 'class="drop"');
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo '<span class="prefix" id="escondeU">Data da união:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'dtcasam_comp1', 'id'=>'dtcasam_comp1', 'value'=>''), '', 'placeholder="<dd/mm/aaaa>"');
							echo '</div>';
						echo '</div>';
						
						echo '<div class="row collapse" id="conjuge">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Conjuge:</span>';
							echo '</div>';
							echo '<div class="four mobile-one columns">';
								echo form_input(array('name'=>'conj_comp1', 'id'=>'conj_comp1', 'value'=>'', 'maxlength'=>'50'), '', 'placeholder="<Completo com no máximo de 50 caracteres>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Sexo:</span>';
							echo '</div>';
							echo '<div class="three mobile-one columns txt_fixo2">';
								echo form_radio(array('name'=>'sexconj_comp1', 'value'=>'masculino', 'style'=>'margin:8px')).'Masculino &nbsp;&nbsp;&nbsp;';
								echo form_radio(array('name'=>'sexconj_comp1', 'value'=>'feminino')).'Feminino';
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Data Nasc.:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'dtnascconj_comp1', 'id'=>'dtnascconj_comp1', 'value'=>''), '', 'placeholder="<dd/mm/aaaa>"');
							echo '</div>';
						echo '</div>';
						echo '<div class="row collapse" id="conjuge_DOC">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">RG:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'rgconj_comp1', 'id'=>'rgconj_comp1', 'value'=>''), '', 'placeholder="<99.999.999-9>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Expedido:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'rgdtexpconj_comp1', 'id'=>'rgdtexpconj_comp1', 'value'=>''), '', 'placeholder="<dd/mm/aaaa>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Orgão:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'rgorgconj_comp1', 'id'=>'rgorgconj_comp1', 'value'=>''), '', 'placeholder="<SSP-SP>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">CPF:</span>';
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo form_input(array('name'=>'cpfconj_comp1', 'id'=>'cpfconj_comp1', 'value'=>''), '', 'placeholder="<999.999.999-99>"');
							echo '</div>';						
						echo '</div>';
						echo '<div class="row collapse" id="conjuge_FILIACAO">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Mãe:</span>';
							echo '</div>';
							echo '<div class="five mobile-one columns">';
								echo form_input(array('name'=>'maeconj_comp1', 'id'=>'maeconj_comp1', 'value'=>'', 'maxlength'=>'50'), '', 'placeholder="<Completo com no máximo de 50 caracteres>"');
							echo '</div>';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Pai:</span>';
							echo '</div>';
							echo '<div class="five mobile-one columns">';
								echo form_input(array('name'=>'paiconj_comp1', 'id'=>'paiconj_comp1', 'value'=>'', 'maxlength'=>'50'), '', 'placeholder="<Completo com no máximo de 50 caracteres>"');
							echo '</div>';
						echo '</div>';
						echo '<div class="row collapse" id="conjuge_NACIDO">';
							echo '<div class="two mobile-one columns">';
								echo '<span class="prefix">Nacionalidade:</span>';
							echo '</div>';
							echo '<div class="four mobile-one columns">';
								echo form_input(array('name'=>'nacioconj_comp1', 'id'=>'nacioconj_comp1', 'value'=>''), '', 'placeholder="<Pais em que nasceu> - Brasileira"');
							echo '</div>';
							echo '<div class="two mobile-one columns">';
								echo '<span class="prefix">Naturalidade:</span>';
							echo '</div>';
							echo '<div class="four mobile-one columns">';
								echo form_input(array('name'=>'naturconj_comp1', 'id'=>'naturconj_comp1', 'value'=>''), '', 'placeholder="<Estado em que nasceu> - São Paulo-SP"');
							echo '</div>';
						echo '</div>';
						
						
				  echo '</li>';
				  
				  echo '<li id="comprador2Tab">';
				  		echo '<div class="row collapse">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Nome:</span>';
							echo '</div>';
						echo '</div>';
				  echo '</li>';
				  echo '<li id="comprador3Tab">';
				  		echo '<div class="row collapse">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Nome:</span>';
							echo '</div>';
						echo '</div>';
				  echo '</li>';
				  echo '<li id="comprador4Tab">';
				  		echo '<div class="row collapse">';
							echo '<div class="one mobile-one columns">';
								echo '<span class="prefix">Nome:</span>';
							echo '</div>';
						echo '</div>';
				  echo '</li>';
				echo '</ul>';
				
				echo '<div class="row">';
					echo '<div class="twelve columns">';
						echo '<div class="alert-box secondary">';
							echo 'DAQUI PARA BAIXO VAI SER O BICHO, CALCULOS !!!';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				
			echo form_fieldset_close();
			echo form_close();
		echo '</div>';
		break;
		
	default:
		echo '<span class="alert label">Tela solicitada não existe</span>'; //Essa nessagem é exibida sempre que se solicita uma tela que ainda não foi criada no "SWITCH"
		break;
endswitch;

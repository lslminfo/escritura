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
		?>
		<script type="text/javascript">
			var path = '<?php echo base_url(); ?>'
		</script>
		<?php
		
		echo '<div class="twelve columns telas_c">';
			//echo '<br /><br />Na espera por ação do USUÁRIO "CASE - TELAS_MODULOS.PHP "';
			get_msg('msgerro');
			get_msg('msgok');
			erros_validacao();
			echo form_open(current_url(), array('class'=>'custon'));
				echo '<div class="row">';
					echo '<div class="one mobile-one columns">';
						echo 'Corretor 1:';
					echo '</div>';
					echo '<div class="three mobile-one columns">';
						echo form_dropdown('corretor1', $this->geral_m->get_corretor($this->session->userdata('id_emp')));
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo 'Corretor 2:';
					echo '</div>';
					echo '<div class="three mobile-one columns">';
						echo form_dropdown('corretor1', $this->geral_m->get_corretor($this->session->userdata('id_emp')));
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo 'Quadra:';
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo form_dropdown('quadra', $this->geral_m->getQuadra($this->session->userdata('id_emp')));
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo 'Lote:';
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo form_dropdown('lote', $this->geral_m->getLote('', $this->session->userdata('id_emp')));
					echo '</div>';
				echo '</div>';
				
				echo '<br />';
				echo '<div class="row">';
					echo '<div class="three mobile-one columns">';
						echo '';
					echo '</div>';
					echo '<div class="two mobile-one columns">';
						echo 'Área do Lote (m²):';
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo form_label('<strong>'.'307,62'.'</strong>');
					echo '</div>';
					echo '<div class="two mobile-one columns">';
						echo 'Valor de tabela (R$):';
					echo '</div>';
					echo '<div class="one mobile-one columns">';
						echo form_label('<strong>'.'55.833,03'.'</strong>');
					echo '</div>';
					echo '<div class="three mobile-one columns">';
						echo '';
					echo '</div>';
					
				echo '</div>';
				
				echo '<br />';
				echo '<div class="row">';
					echo '<div class="twelve columns">';

						echo '<ul class="accordion">';
						  echo '<li class="active">';
						    echo '<div class="title titulo_comprador">';
						      echo '<h6>Dados do Comprador 1</h6>';
						    echo '</div>';
						    echo '<div class="content">';
						       	echo '<div class="row">';
									echo '<div class="two mobile-one columns">';
										echo 'Nome Completo:';
									echo '</div>';
									echo '<div class="ten mobile-one columns">';
										echo form_input(array('name'=>'cliente1'), set_value('cliente1'));
									echo '</div>';
								echo '</div>';
								
								echo '<div class="row">';
									echo '<div class="two mobile-one columns">';
										echo 'Estado Civil: ';
									echo '</div>';
									echo '<div class="four mobile-one columns">';
										echo form_dropdown('civil', array('casado'=>'Casado', 'solteiro'=>'Solteiro', 'divorciado'=>'Divorciado', 'estavel'=>'União estável', 'viuvo'=>'Viuvo', ), 'solteiro');
									echo '</div>';
									echo '<div class="one mobile-one columns">';
										echo 'Regime:';
									echo '</div>';
									echo '<div class="five mobile-one columns">';
										echo form_dropdown('regime', array('', ''));
									echo '</div>';
								echo '</div>';
								echo '<br />';
								echo '<div class="row">';
									echo '<div class="two mobile-one columns">';
										echo 'Numero do CPF:';
									echo '</div>';
									echo '<div class="four mobile-one columns">';
										echo form_input(array('cpf'=>'cpf'), set_value('cpf'));
									echo '</div>';
									echo '<div class="two mobile-one columns">';
										echo 'Numero do RG:';
									echo '</div>';
									echo '<div class="four mobile-one columns">';
										echo form_input(array('rg'=>'rg'), set_value('rg'));
									echo '</div>';
								echo '</div>';
								
								echo '<div class="row">';
									echo '<div class="two mobile-one columns">';
										echo 'Nacionalidade:';
									echo '</div>';
									echo '<div class="four mobile-one columns">';
										echo form_input(array('nacionalidade'=>'nacionalidade'), set_value('nacionalidade'));
									echo '</div>';
									echo '<div class="two mobile-one columns">';
										echo 'Data Nascimento';
									echo '</div>';
									echo '<div class="four mobile-one columns">';
										echo form_input(array('dtnascimento'=>'dtnascimento'), set_value('dtnascimento'));
									echo '</div>';
								echo '</div>';
								
								echo '<div class="row">';
									echo '<div class="two mobile-one columns">';
										echo 'Endereço Completo:';
									echo '</div>';
									echo '<div class="ten mobile-one columns">';
										echo form_input(array('endereco'=>'endereco'), set_value('endereco'));
									echo '</div>';
								echo '</div>';

								echo '<div class="row">';
									echo '<div class="one mobile-one columns">';
										echo 'CEP:';
									echo '</div>';
									echo '<div class="two mobile-one columns">';
										echo form_input(array('cep'=>'cep'), set_value('cep'));
									echo '</div>';
									
									echo '<div class="one mobile-one columns">';
										echo 'Estado:';
									echo '</div>';
									echo '<div class="three mobile-one columns">';
									
										$estados = $this->geral_m->getEstados();
										$options = array('' => 'Escolha');
											foreach ($estados as $linha):
												$options[$linha->id] = $linha->nome;
											endforeach;
										echo form_dropdown('estado', $options);
									
									echo '</div>';
									echo '<div class="two mobile-one columns">';
										echo 'Cidades:';
									echo '</div>';
									echo '<div class="three mobile-one columns">';
										echo form_dropdown('cidade', array('' => 'Escolha um Estado'), '', 'id="cidade"');
									echo '</div>';
								echo '</div>';
								
								
						    echo '</div>';
						  echo '</li>';
						  echo '<li>';
						    echo '<div class="title titulo_comprador">';
						      echo '<h6>Dados do Comprador 2</h6>';
						    echo '</div>';
						    echo '<div class="content">';
						      echo '<p>Continuar FORM para pegar os dados do segundo comprador!</p>';
						    echo '</div>';
						  echo '</li>';
						echo '</ul>';
					
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

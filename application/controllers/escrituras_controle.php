<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Esse é o segundo arquivo a ser carregado no sistema um controlador "ONDE HAVERA PROCESSAMENTO"
// A funcão "login()" vai carregar a minha tela "inicio_view" que é padrão
// Ele controlará "TUDO"


class Escrituras_controle extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		//$this->load->library('sistema'); não esta aqui pois foi carregado no autoload da pasta config
		init_painel();
	}

	public function index(){
		$this->load->view('nomeview');
	}
	
	
//########################	
	public function login(){
		
		$this->form_validation->set_rules('login', 'LOGIN', 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('senha', 'SENHA', 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('empr', 'EMPREENDIMENTO', 'callback_lms_check');
		
		if ($this->form_validation->run()==TRUE):
			$login = $this->input->post('login', TRUE);
			$senha = md5($this->input->post('senha', TRUE));
			$empreendimento = $this->input->post('empr');

			if ($this->geral_m->do_login($login,$senha) == TRUE):
				$query1 = $this->geral_m->get_bylogin($login)->row();
				$query2 = $this->geral_m->get_byempreend($empreendimento)->row();
				$dados = array(
					'user_id' => $query1->id,
					'user_nome' => $query1->nome,
					'user_login' => $query1->login,
					'user_admin' => $query1->adm,
					'user_logado' => TRUE,
					'razao' => $query2->razao,
					'fantasia' => $query2->fantasia,
					'id_emp' => $query2->id,
				);
				$this->session->set_userdata($dados);
				redirect('inicio_controle');
			else:
				$query = $this->geral_m->get_bylogin($login)->row();
				if (empty($query)):
					set_msg('errologin', 'Usuário inexsitente', 'erro');
				elseif ($query->senha != $senha):
					set_msg('errologin', 'Senha incorreta', 'erro');
				elseif ($query->ativo == 0):
					set_msg('errologin', 'Este usuário esta inativo', 'erro');
				else:
					set_msg('errologin', 'Erro desconhecido, contate o desenvolvedor', 'erro');
				endif;
				redirect('escrituras_controle/login');
			endif;

		endif;

		set_tema('tituloaba', 'Login', FALSE);
		set_tema('aviso', '');
		set_tema('rodape', '<h5><small>Solicite seu acesso <a href="#">WEBMASTER</a></small></h5>');
		set_tema('telas_sistema', load_modulo('telas_modulos', 'login')); //$tema['conteudo'] = load_modulo('telas_modulos', 'login');
		load_template(); //$this->load->view('inicio_view', get_tema());
	}

//########################
	public function logoff(){
		//auditoria('Logoff no sistema', 'Logoff efetuado com sucesso');
		$this->session->unset_userdata(array('user_id'=>'', 'user_nome'=>'', 'user_login'=>'', 'user_admin'=>'', 'user_logado'=>'', 'razao'=>'', 'fantasia'=>''));
		$this->session->sess_destroy();
		$this->session->sess_create();
		set_msg('logoffok', 'Logoff efetuado com sucesso', 'sucesso');
		redirect('escrituras_controle/login');
	}

//########################
	public function empreendimento(){
		
		
		set_tema('tituloaba', 'Empreendimentos', FALSE);
		set_tema('titulop', '<h3 class="text-center">RESUMO DE ESCRITURAS</h3>');
		set_tema('subtitulo', '<h4 class="subheader text-center">'.$this->session->userdata('razao').'</h4>');
		set_tema('aviso', '<span class="label round">Escolha uma opção no Menu acima</span>');
		set_tema('telas_sistema', load_modulo('telas_modulos', 'empreendimento')); //$tema['conteudo'] = load_modulo('telas_modulos', 'login');
		load_template(); //$this->load->view('inicio_view', get_tema());
	}
	
	
//########################
	public function nova_senha_off(){
		
		$this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|strtolower');
	
		if ($this->form_validation->run()==TRUE):
			$email = $this->input->post('email');
			$query = $this->geral_m->get_byemail($email);
			if ($query->num_rows()==1):
				$novasenha = substr(str_shuffle('qwertyuiopasdfghjklzxcvbnm0123456789'), 0, 6);
				$mensagem = "<p>Você solicitou uma nova senha para acesso ao Resumo de Escrituras, a partir de agora use a seguinte senha para acesso: <strong>$novasenha</strong></p>
							 <p>Troque essa senha para uma senha segura e de sua preferência o quanto antes.</p>";
				if ($this->sistema->enviar_email($email, 'Nova senha de acesso', $mensagem)):
					$dados['senha'] = md5($novasenha);
					$this->geral_m->do_update($dados, array('email'=>$email), FALSE);
					//auditoria('Redefinição de senha', 'Usuário solicitou uma nova senha por email');
					set_msg('msgok', 'Nova senha foi enviada para seu email', 'sucesso');
					redirect('escrituras_controle/nova_senha_off');
				else:
					set_msg('msgerro', 'Erro ao enviar nova senha, contate o administrador', 'erro');
					redirect('escrituras_controle/nova_senha_off');
				endif;
			else:
				set_msg('msgerro', 'Este email não esta cadastrado no sistema', 'erro');
				redirect('escrituras_controle/nova_senha_off');
			endif;
		endif;
		
		
		set_tema('tituloaba', 'Esqueci minha senha', FALSE);
		set_tema('titulop', '<h3 class="text-center">RESUMO DE ESCRITURAS</h3>');
		set_tema('subtitulo', '<h4 class="subheader text-center">Recuperação de Senha</h4>');
		//set_tema('mensagem', '<span class="label round">Solicitação de nova senha</span>');
		set_tema('aviso', '');
		set_tema('telas_sistema', load_modulo('telas_modulos', 'nova_senha_off')); //$tema['conteudo'] = load_modulo('telas_modulos', 'login');
		set_tema('rodape', '<h5><small>Solicite seu acesso <a href="#">WEBMASTER</a></small></h5>');
		load_template(); //$this->load->view('inicio_view', get_tema());
	}

//########################
	public function altera_senha(){
		esta_logado();
		$this->form_validation->set_rules('senhaatual', 'SENHA ATUAL', 'trim|required|strtolower|callback_senha_check');
		$this->form_validation->set_message('matches', 'O campo %s, está diferente do campo %s.');
		$this->form_validation->set_rules('novasenha', 'NOVA SENHA', 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('novasenha2', 'REPITA A SENHA', 'trim|required|min_length[4]|matches[novasenha]|strtolower');

		if ($this->form_validation->run()==TRUE):
			set_msg('msgok', 'OK... Senha alterada com sucesso', 'sucesso');
			redirect('escrituras_controle/empreendimento');
		endif;
	
		set_tema('tituloaba', 'Alterar senha', FALSE);
		set_tema('titulop', '<h3 class="text-center">RESUMO DE ESCRITURAS</h3>');
		set_tema('aviso', '');
		set_tema('subtitulo', '<h4 class="subheader text-center">Alteração de Senha</h4>');
		set_tema('telas_sistema', load_modulo('telas_modulos', 'altera_senha')); //$tema['conteudo'] = load_modulo('telas_modulos', 'login');
		load_template(); //$this->load->view('inicio_view', get_tema());
	}

//########################
	public function cadastrar(){
		esta_logado();
		
		set_tema('footerinc', load_js(array('escritura')), FALSE);
		set_tema('tituloaba', 'Cadastra RE', FALSE);
		set_tema('titulop', '<h3 class="text-center">RESUMO DE ESCRITURAS</h3>');
		set_tema('subtitulo', '<h4 class="subheader text-center">'.$this->session->userdata('razao').'</h4>');
		set_tema('aviso', '<span class="label round">Preencha todos os campos abaixo!</span>');
		set_tema('telas_sistema', load_modulo('telas_modulos', 'cadastrar')); //$tema['conteudo'] = load_modulo('telas_modulos', 'login');
		load_template(); //$this->load->view('inicio_view', get_tema());
	}

//######################## FUNÇÕES AUXILIARES DO ESCRITURA.JS
	function getCorretor2($idcorr1){
		
		$corretor2 = $this->geral_m->getCorretor2($this->session->userdata('id_emp'), $idcorr1);
		if(empty($corretor2)):
			return '{"nome": "Nenhum corretor encontrado"}';
		endif;
		
		$arr_corretor2 = array();
		foreach ($corretor2 as $linha):
			$arr_corretor2[]='{"id":'.$linha->id.',"nome":"'.$linha->c_nome.'"}';
		endforeach;
		
		echo '['.implode(",", $arr_corretor2).']';
		
		return;
		
	}

	function getLote($idqd){
		$lote = $this->geral_m->getLote($this->session->userdata('id_emp'), $idqd);
		if(empty($lote)):
			return '{"lote": "Nenhum lote encontrado"}';
		endif;
		echo json_encode($lote);
		return;
	}


	
	
//######################## VALIDATION
	public function lms_check($empreend){
		if ($empreend == 'Lista de empreendimento'):
			$this->form_validation->set_message('lms_check', 'Selecionar um %s é obrigatório!');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	public function senha_check($senha){
		$query = $this->geral_m->get_senha(md5($senha));
		if ($query == FALSE):
			$this->form_validation->set_message('senha_check', 'A %s é diferente da cadastrada!');
			return FALSE;
		endif;
	}
}
/* End of file escrituras_controle.php */
/* Location: ./application/controllers/escritura_controle.php */
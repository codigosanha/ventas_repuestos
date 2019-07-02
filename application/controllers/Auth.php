<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	private $modulo = "Usuarios";
	public function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model");
	}
	public function index()
	{
		if ($this->session->userdata("login")) {
			redirect(base_url()."backend/dashboard");
		}
		else{
			$this->load->view("auth/login");
		}
		

	}

	public function validar(){
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$res = $this->Usuarios_model->login($username, sha1($password));

		if (!$res) {
			/*$this->session->set_flashdata("error","El usuario y/o contraseña son incorrectos");
			redirect(base_url());*/
			echo "0";
		}
		else{
			$data  = array(
				'id' => $res->id, 
				'username' => $res->username,
				'rol' => $res->rol_id,
				'sucursal' => $res->sucursal_id,
				'total_access' => get_record("roles","id=".$res->rol_id)->total_access,
				'login' => TRUE
			);
			$this->session->set_userdata($data);
			/*redirect(base_url()."backend/dashboard");*/
			echo "1";
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}

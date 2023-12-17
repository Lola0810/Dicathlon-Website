<?php
defined('BASEPATH') OR exit('No direct script access allowed');

session_start();

class AdminController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model('usersModel');
	}

	public function createAgent() {
		if(@$_SESSION["user"]["type_utilisateur"] !== "admin") {
			redirect("/");
			exit;
		}

		$field_required = array('required' => 'Champ %s requis.');
		$this->form_validation->set_rules('nom', 'Nom de famille', 'required', $field_required);
		$this->form_validation->set_rules('prenom', 'Prénom', 'required', $field_required);
		$this->form_validation->set_rules('login', 'Login', 'required|is_unique[utilisateur.login]', array_merge(
			$field_required,
			array("is_unique" => "Le login renseigné est déjà associé à un compte.")
		));
		$this->form_validation->set_rules('ddn', 'Date de naissance', 'required|callback_date_validator', $field_required);
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[utilisateur.email]', array_merge(
			$field_required,
			array(
				"valid_email", "L'email saisie n'est pas valide.",
				"is_unique" => "Le mail est déjà assigné à un comtpe."
			)
		));
		$this->form_validation->set_rules('password', 'Mot de passe', 'required', $field_required);

		if($this->form_validation->run()) {
			// cela veut dire que le formulaire est bon, on insère dans la db le contenu du post
			$data = $this->input->post(); // on récupère les données du formulaires (celles envoyées)
			$data["type_utilisateur"] = "agent";
			$this->usersModel->create($data);
			redirect("/");
			exit;
		}

		$this->load->view('layout/header', ['title' => "Produits"]);
		$this->load->view('admin/agent');
		$this->load->view('layout/footer');
	}

	public function date_validator($date) {
		$year = (int) substr($date, 0, 4);
		$curr_year = (int) date("Y");
		if($curr_year-$year < 18) {
			$this->form_validation->set_message('date_validator', 'Vous devez avoir plus 18 ans pour vous inscrire.');
			return FALSE;
		}
		return TRUE;
	}

}

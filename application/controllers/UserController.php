<?php
defined('BASEPATH') OR exit('No direct script access allowed');

session_start();

class UserController extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model('usersModel');
		$this->load->model('locationsModel');
	}

	public function profile() {
		$data = $this->input->post(NULL, TRUE);

		if(empty(@$_SESSION["user"])) {
			redirect("/");
			exit;
		}

		switch(@$data["type"]) {
			case "delete_account":
				$id = $_SESSION["user"]["id"];
				$user_type = $_SESSION["user"]["type_utilisateur"];
				if(empty($this->locationsModel->get_active_by_user_id($id)) && $user_type !== "agent") {
					$this->usersModel->delete((int) $id);
					session_destroy();
					redirect("/");
					exit;
				}
				break;
			case "edit_account":
				$field_required = array('required' => 'Champ %s requis.');
				$this->form_validation->set_rules('nom', 'Nom de famille', 'required', $field_required);
				$this->form_validation->set_rules('prenom', 'Prénom', 'required', $field_required);
				$this->form_validation->set_rules('ddn', 'Date de naissance', 'required|callback_date_validator', $field_required);
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email', array_merge(
					$field_required,
					array("valid_email", "L'email saisie n'est pas valide.")
				));

				if($this->form_validation->run()) {
					$data["id"] = $_SESSION["user"]["id"];
					$this->usersModel->edit($data); 
					foreach($data as $key => $value)
						$_SESSION["user"][$key] = $value;
				}
				break;
		}

		$this->load->view('layout/header', ['title' => "Mon profil"]);
		$this->load->view('user/profile', ["user" => $_SESSION["user"]]);
		$this->load->view('layout/footer');
	}

	public function register() {
		if(!empty(@$_SESSION["user"])) {
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
			$user = $this->usersModel->create($data);
			$this->store_in_session($user);
			redirect("/");
			exit;
		}

		$this->load->view('layout/header', ['title' => "Inscription"]);
		$this->load->view('user/register');
		$this->load->view('layout/footer');
	}

	public function login() {
		if(!empty(@$_SESSION["user"])) {
			redirect("/");
			exit;
		}

		$field_required = array('required' => 'Champ %s requis.');
		$user_found = $this->usersModel->get_by_login($this->input->post("login"));

		$this->form_validation->set_rules('login', 'Login', 'required|callback_login_validator['.empty($user_found).']', $field_required);
		$this->form_validation->set_rules('password', 'Mot de passe', 'required|callback_password_validator['. @$user_found["password"].']', $field_required);

		if($this->form_validation->run()) {
			$this->store_in_session($user_found);
			redirect("/");
			exit;
		}

		$this->load->view('layout/header', ['title' => "Connexion"]);
		$this->load->view('user/login');
		$this->load->view('layout/footer');
	}

	public function disconnect() {
		session_start();
		session_destroy();
		redirect("/");
	}

	public function login_validator($login, $has_result) {
		if($has_result) {
			$this->form_validation->set_message('login_validator', 'Utilisateur introuvable.');
			return FALSE;
		}
		return TRUE;
	}

	public function password_validator($password, $hashed_password) {
		// on compare les deux mots de passe (pas sécurisé avec md5 mais tant pis)
		if($hashed_password !== md5($password)) {
			$this->form_validation->set_message('password_validator', 'Mot de passe incorrect.');
			return FALSE;
		}
		return TRUE;
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

	public function store_in_session($data) {
		$_SESSION["user"] = $data;
	}

}

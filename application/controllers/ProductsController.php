<?php
defined('BASEPATH') OR exit('No direct script access allowed');

session_start();

class ProductsController extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model('productsModel');
		$this->load->model('locationsModel');
	}

    public function index() {
		$this->load->view('layout/header', ['title' => "Produits"]);
		$this->load->view('products/products', [
			"products" => $this->productsModel->get_all(),
			"user" => @$_SESSION["user"]
		]);
		$this->load->view('layout/footer');
	}

	public function create() {
    	$user_type = @$_SESSION["user"]["type_utilisateur"];
    	if($user_type === "client") {
    		redirect("/produits");
    		exit;
		}

		$data = $this->input->post();
		$field_required = array('required' => 'Champ %s requis.');
		$this->form_validation->set_rules('type', 'Type', 'required', $field_required);
		$this->form_validation->set_rules('description', 'Description', 'required', $field_required);
		$this->form_validation->set_rules('modele', 'Modèle', 'required', $field_required);
		$this->form_validation->set_rules('marque', 'Marque', 'required', $field_required);
		$this->form_validation->set_rules('prix_location', 'Prix location', 'required', $field_required);

		if($this->form_validation->run() && in_array($user_type, ["admin", "agent"])) {
			$data["prix_location"] = (int) $data["prix_location"];
			$this->productsModel->create($data);
			redirect("/produits");
			exit;
		}

		$this->load->view('layout/header', ['title' => "Nouveau produit"]);
		$this->load->view('products/newProduct');
		$this->load->view('layout/footer');
	}

	public function product($id) {
    	$data = $this->input->post();
    	if(
    		@$data["type"] === "delete_product" &&
			in_array(@$_SESSION["user"]["type_utilisateur"], ["admin", "agent"]) &&
			empty($this->locationsModel->get_active_by_product_id($id))
		) {
			$this->productsModel->delete((int) $id);
			redirect("/produits");
			exit;
		}

		$this->load->view('layout/header', ['title' => "Produit"]);
		$this->load->view('products/product', [
			"product" => $this->productsModel->get_by_id((int) $id),
			"user" => @$_SESSION["user"]
		]);
		$this->load->view('layout/footer');
	}


}

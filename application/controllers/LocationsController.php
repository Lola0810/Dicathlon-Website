<?php
defined('BASEPATH') OR exit('No direct script access allowed');

session_start();

class LocationsController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model('locationsModel');
		$this->load->model('productsModel');
	}

	public function index() {
		$user = @$_SESSION["user"];
		$id = $user["id"];
		if(!$id) {
			redirect("/");
			exit;
		}

		$locations = $this->locationsModel->get_by_user_id($id);
		if(in_array($user["type_utilisateur"], ["admin", "agent"])) {
			$locations = $this->locationsModel->get_all();
		}
		$this->load->view('layout/header', ['title' => "Mes locations"]);
		$this->load->view('locations/locations', ["locations" => $locations]);
		$this->load->view('layout/footer');
	}

	public function location($id) {
		$data = $this->input->post();
		$location = $this->locationsModel->get_by_id((int) $id);

		if(
			@$data["type"] === "delete_location" &&
			$this->locationsModel->location_not_started((int) $id)
		) {
			$this->locationsModel->delete((int) $id);
			redirect("/locations");
			exit;
		} else if(@$data["type"] === "getback_location") {
			$newTotal = $location["prix_total"];
			$dateRetour = date("Y-m-d H:i:s");
			$nbJours = $this->get_day_diff($location["date_retour_prevue"], $dateRetour);
			if($nbJours > 30) {
				$newTotal = $newTotal+($newTotal*(1-(20/100))); // si la location depasse 30 jours alors on ajoute 20% du prix de la location
			}

			$this->locationsModel->set_as_getback($location["id"], $dateRetour, $newTotal);
			redirect("/location/".$location["id"]);
			exit;
		}

		$this->load->view('layout/header', ['title' => "Location"]);
		$this->load->view('locations/location', [
			"location" => $location,
			"user" => $_SESSION["user"]
		]);
		$this->load->view('layout/footer');
	}

	public function rent($id) {
		$utilisateur_id = @$_SESSION["user"]["id"];
		$product = $this->productsModel->get_by_id($id);
		if(!$utilisateur_id) {
			redirect("/produit/".$id);
			exit;
		}
		$data = $this->input->post();
		$field_required = array('required' => 'Champ %s requis.');
		$this->form_validation->set_rules('date_debut', 'Date de début', 'required', $field_required);
		$this->form_validation->set_rules('date_retour_prevue', 'Date de retour prévue', 'required', $field_required);

		// vérifier que le produit n'est pas déjà en location sur les dates
		if($this->form_validation->run()) {
			if(!$this->locationsModel->is_location_rented($data["date_debut"], $data["date_retour_prevue"], $product["id"])) {
				// todo  calculer le prix total
				$data["utilisateur_id"] = $utilisateur_id;
				$data["produit_id"] = $product["id"];

				// calculer le prix total
				$nb_jours = $this->get_day_diff($data["date_debut"], $data["date_retour_prevue"]);
				if($nb_jours > 30) {
					// todo afficher un message custom disant qu'il ne faut pas que ça dépasse 30 Jours
					echo "Impossible de louer plus de 30 jours";
					return;
				}

				$data["prix_total"] = $this->get_prix_location(
					(int) $product["prix_location"],
					$nb_jours
				);
				$this->locationsModel->create($data);
				redirect("/locations");
				exit;
			} else {
				// TO DO : afficher un message "impossible de louer le produit sur ces dates"
				echo "Produit déjà loué sur ces périodes";
			}
		}

		$this->load->view('layout/header', ['title' => "Louer une location"]);
		$this->load->view('locations/rent');
		$this->load->view('layout/footer');
	}

	public function get_prix_location($prix_location, $nb_jours) {
		return $prix_location*$nb_jours;
	}

	public function get_day_diff($date_debut, $date_fin) {
		$date_debut = strtotime($date_debut);
		$date_fin = strtotime($date_fin);
		$datediff = $date_fin - $date_debut;
		return round($datediff / (60 * 60 * 24));
	}
	// TO DO : Vérifier que la réservation dépasse pas 30j et afficher un message "impossible de louer le produit pour plus de 30 jours 

}

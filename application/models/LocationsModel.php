<?php

class LocationsModel extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_by_user_id($user_id) {
		return $this->db
			->select('*')
			->from('location')
			->where(["utilisateur_id" => $user_id])
			->get()
			->result_array();
	}

	public function get_all() {
		return $this->db->get('location')->result_array();
	}

	public function get_by_id($id) {
		return $this->db
			->select('*')
			->from('location')
			->join('produit', 'produit.id = location.produit_id')
			->where(["location.id" => $id])
			->get()
			->row_array(); 
	}

	public function is_location_rented($starts_at, $ends_at, $product_id) {
		return !empty($this->db
			->select('*')
			->from('location')
			->where(" 
				produit_id='".$product_id."' and 
				((date_debut between '".$starts_at."' and '".$ends_at."') or
				(date_retour_prevue between '".$starts_at."' and '".$ends_at."') or
				(date_debut < '".$starts_at."' and date_retour_prevue > '".$ends_at."') or
				(date_debut > '".$starts_at."' and date_retour_prevue < '".$ends_at."'))
		  	") // Où le produit_id = $id du produit ET :
			
			/* OR date_debut (dans la db) est entre les valeurs saisies OR date_fin entre les valeurs saisies
			Vérifie si la date de début est comprise entre le début et la fin et que la date de fin est compris entre le début et la fin
			
			/* OR que la réservation saisi soit pendant la période date_debut, date_fin
			Exemple : quelqu'un a réservé du 20 au 30 et l'autre souhaite réserver du 25 au 29 */

			/* OR que si la réservation saisie est avant la prochaine réservation en db et que la date de fin saisie est après la réservation déjà en db
			Exemple : Quelqu'un a reservé du 20 au 30, l'autre personne essaie de réserver du 15 au 31 */
			->get()
			->result_array());
			//Si le résultat est pas vide, il y a une location en cours (True = déjà une location)
	}

	public function set_as_getback($id, $date_effective, $total) {
		$this->db->set("date_retour_effective", $date_effective);
		$this->db->set("prix_total", $total);
		$this->db->where('id', $id);
		return $this->db->update('location');
	}

	public function get_active_by_user_id($user_id) {
		return $this->db
			->select('*')
			->from('location')
			->where(["utilisateur_id" => $user_id, "date_debut <" => date("Y-m-d")])
			->get()
			->result_array();
	}

	public function get_active_by_product_id($id) { 
		return $this->db
			->select('*')
			->from('location')
			->where(["produit_id" => $id, "date_debut <" => date("Y-m-d")])
			->get()
			->result_array();
	}

	public function location_not_started($id) { 
		return !empty($this->db
			->select('*')
			->from('location')
			->where(["id" => $id, "date_debut <" => date("Y-m-d")])
			->get()
			->row_array());
	} // Si c'est vide, ca retourne true

	public function create(&$data) {
		return $this->db->insert("location", [
			"date_debut" => $data["date_debut"],
			"date_retour_prevue" => $data["date_retour_prevue"],
			"date_retour_effective" => NULL,
			"prix_total" => $data["prix_total"],
			"utilisateur_id" => $data["utilisateur_id"],
			"produit_id" => $data["produit_id"]
		]);
	}

	public function delete($id) {
		$this->db->delete("location", ["id" => $id]);
	}

}

<?php

class ProductsModel extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->get("produit")->result_array(); 
    }

    public function get_by_id($id) {
        return $this->db 
            ->select('*')
            ->from('produit')
            ->where("id", $id)
            ->get()
            ->row_array();
    }

    public function create($data) { // Elements de la base : type, description, marque, modèle, prix_location, etat
        return $this->db->insert("produit", [
			"type" => $data["type"],
			"description"=> $data["description"],
			"marque" => $data["marque"],
			"modele" => $data["modele"],
			"prix_location" => $data["prix_location"],
			"etat" => $data["etat"]
		]); 
    }

    public function delete($id) {
		$this->db->delete('produit', ["id" => $id]);
		$this->db->delete("location", ["produit_id", $id]); // Supprime les locations associé à $id du produit
    }
}

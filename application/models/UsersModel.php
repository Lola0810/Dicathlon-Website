<?php

class UsersModel extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database(); // charge la db dans le modèle 
    }

    public function get_all(){
        return $this->db->get('utilisateur')->result_array(); 
    }

    public function get_by_login($login) {
    	return $this->db 
			->select('*')
			->from('utilisateur')
			->where("login", $login)
			->get()
			->row_array(); // Request pour récupérer les utilisateurs par un $login
	}

	public function create(&$data) { // &$data -> & au début pour pouvoir écrire sur data
    	// transformer la date de naissance en date lisible
    	$data["ddn"] = date("Y-m-d", strtotime($data["ddn"]));
		$data["password"] = md5($data["password"]); // les mots de passe sont hashé via md5 ici
		$data["type_utilisateur"] = @$data["type_utilisateur"] ?: "client"; //si type_utilisateur n'est pas renseigné (e est null) alors on met client à la place 
			// client, admin, agent

		// Insérer les données dans la db (id généré auto)
		return $this->db->insert("utilisateur", [
			"login" => $data["login"],
			"password" => $data["password"], // mot de passe hashé au préalable
			"nom" => $data["nom"],
			"prenom" => $data["prenom"],
			"ddn" => $data["ddn"],
			"email" => $data["email"],
			"type_utilisateur" => $data["type_utilisateur"]
		]); 
	}

	public function edit(&$data) { // On ne peut modifier le mot de passe, 
		$this->db->set("prenom", $data["prenom"]);
		$this->db->set("nom", $data["nom"]);
		$this->db->set("ddn", $data["ddn"]);
		$this->db->set("email", $data["email"]);
		$this->db->where('id', $data["id"]);
		return $this->db->update('utilisateur');
	}

    public function delete($id){
        $this->db->delete('utilisateur', ["id" => $id]); // Suprimer dans le db l'utilisateur qui a comme id $id
        $this->db->delete("location", ["utilisateur_id", $id]); // Supprime les locations associé a $id de l'utilisateur
    }
}

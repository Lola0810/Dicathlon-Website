<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	public function index() {
		$this->load->helper('url');
		$this->load->view('layout/header', ['title' => "Accueil"]);
		$this->load->view('home');
		$this->load->view('layout/footer');
	}
}

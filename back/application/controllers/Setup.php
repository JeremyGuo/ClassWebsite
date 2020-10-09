<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller{
    function index(){
        if(!isset($_GET['password']) || $_GET['password'] != "19260817turing10")
            show_error("FUCK 你想做什么");
        $this->load->model('dbInitializer', 'init', TRUE);
        $this->init->initTables();
    }
}
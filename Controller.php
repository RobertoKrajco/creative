<?php
class Controller {

    protected $db;

    function __construct() {

        $this->db = new DatabaseConnection('localhost', 'root', '', 'creative_sites');
        
    }
}
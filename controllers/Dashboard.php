<?php


class Dashboard extends Controller{


    public function __construct(){

    }


    public function index(){

        
        $this->getView("dashboard", []);
    }

    public function layoutStatic(){

        
        $this->getView("layout-static", []);
    }

    public function layoutSidenavLight(){

        
        $this->getView("layout-sidenav-light", []);
    }

    public function charts(){

        
        $this->getView("charts", []);
    }

    public function tables(){

        
        $this->getView("tables", []);
    }


}
<?php


class Main extends Controller{


    public function index(){

        $this->getView("index", ["name"=>ENV("APP_NAME"), "desc"=>ENV("APP_DESC")]);

    }

    public function documentation(){

        $this->getView("documentation", []);

    }


}
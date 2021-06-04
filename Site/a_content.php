<?php

include_once "json_parser.php";

abstract class a_content
{
    protected $title;
    private $menu_file = "menu.json";
    protected $request = array();

    public function __construct(){
        session_start();
        $this->get_user_data();
    }

    private function get_user_data()
    {
        foreach ($_REQUEST as $key=>$req){
            $this->request[$key] = htmlspecialchars($req);
        }
    }

    public function get_user_value($key){
        if (isset($this->request[$key]))
            return $this->request[$key];
        return null;
    }

    public function get_title(){
        $m = json_parser::get_full_info($this->menu_file);
        foreach ($m as $page_info){
            if (
                "/Site/".$page_info['addr'] === $_SERVER['PHP_SELF'] ||
                ($page_info['addr'] === 'index.php' && $_SERVER['PHP_SELF'] === '/')
            ){
                return $page_info['title'];
            }
        }
        return null;
    }

    public abstract function show_content();
}
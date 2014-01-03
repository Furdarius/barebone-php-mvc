<?php
class Template 
{
    private $registry;
    private $vars = array();
    private $func;
    private $scripts = array();
    private $styles = array();


    public function __construct($registry) 
    {
        $this->registry = $registry;
        $this->set("SITE_DESCRIPTION", $registry->config->site_description);
        $this->set("SITE_KEYWORDS", $registry->config->site_keywords);
    }

    public function set($varname, $value, $overwrite=false) 
    {
        if (isset($this->vars[$varname]) AND !$overwrite) 
            exit('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.');
        $this->vars[$varname] = $value;
    }

    public function remove($varname) 
    {
        unset($this->vars[ $varname ]);
    }
    
    public function show($name) 
    {
        $viewPath = APPLICATION_DIR . 'views/' . $name . '.php';
        if(file_exists($viewPath) && is_readable($viewPath))
        {
            extract($this->vars);
            return include($viewPath);
        }
        exit('Error: View  "' . $name . '" can\'t be loaded');
    }

    public function redirect($url) 
    {
        header('Location: ' . $url);
        exit;
    }

    public function setTitle($title) 
    {
        $title .= " " . $this->registry->config->site_title;
        $this->set("TITLE", $title);
    }

    // Custom JS scripts
    public function addScript($script) 
    {
        $this->scripts[] = $script;
    }
    
    public function getScripts() 
    {
        return $this->scripts;
    }

    // Custom CSS styles
    public function addStyle($style) 
    {
        $this->styles[] = $style;
    }
    
    public function getStyles() 
    {
        return $this->styles;
    }
}

?>
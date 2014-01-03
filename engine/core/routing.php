<?php
class Router 
{
    private $registry;

    private $folder;
    private $controller;
    private $method;
    private $args;
    
    public function __construct($registry)
    {
        $this->registry = $registry;
    }
    
    private function parse($action) 
    {
        $this->folder = null;
        $this->controller = null;
        $this->method = null;
        $this->args = null;
        
        $action = preg_replace("/[^\w\d\s\/]/", '', $action);
        $parts = explode('/', $action);
        $parts = array_filter($parts);
        
        foreach($parts as $item) 
        {
            $fullpath = APPLICATION_DIR . 'controllers' . $this->folder . '/' . $item;
            if(is_dir($fullpath)) 
            {
                $this->folder .= '/' . $item;
                array_shift($parts);
                continue;
            }
            elseif(is_file($fullpath . '.php')) 
            {
                $this->controller = $item;
                array_shift($parts);
                break;
            } 
            else break;
        }
            
        if(empty($this->folder))
            $this->folder = 'base';


        if(empty($this->controller))
            $this->controller = 'index';

        if($c = array_shift($parts))
            $this->method = $c;
        else
            $this->method = 'index';

        if(isset($parts[0]))
            $this->args = $parts;
        
    }
    
    private function go($commonEnable = false) 
    {
        $controllerFile = APPLICATION_DIR . 'controllers/' . $this->folder . '/' . $this->controller . '.php';
        $controllerClass = $this->controller . '_Controller';

        // "common" folder protection
        if($this->folder != "common" || $commonEnable == true) 
        {
            if(is_readable($controllerFile)) {
                require_once($controllerFile);
                
                $controller = new $controllerClass($this->registry);
                
                if(is_callable(array($controller, $this->method)))
                    $this->method = $this->method;
                else 
                    $this->method = 'index';

                if(empty($this->args))
                    return call_user_func(array($controller, $this->method));
                else
                    return call_user_func_array(array($controller, $this->method), $this->args);
            }
        }
        exit('Error: Controller "' . $this->controller . '" can\'t be loaded');
    }

    public function init()
    {
        $url = $this->registry->request->get['route'];
        if(!isset($url))
            $url = "base/index";
        $this->parse($url);
        $this->go();
    }
}
?>
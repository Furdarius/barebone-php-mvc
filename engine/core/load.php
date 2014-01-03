<?php
class Load 
{
    private $registry;

    public function __construct($registry) 
    {
        $this->registry = $registry;
    }

    public function model($name)
    {
        $modelClass = $name . 'Model';
        $modelPath = APPLICATION_DIR . 'models/' . $name . '.php';

        if(is_readable($modelPath))
        {
            require_once($modelPath);
            
            if(class_exists($modelClass))
                return new $modelClass($this->registry);
        }
        exit('Error: Model "' . $name . '" can\'t be loaded');
    }

    public function library($name)
    {
        $libClass = $name . 'Library';
        $libPath = ENGINE_DIR . 'libs/' . $name . '.php';

        if(is_readable($libPath))
            return require_once($libPath);

        exit('Error: Library "' . $name . '" can\'t be loaded');
    }
}
?>
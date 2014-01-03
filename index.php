<?php
    mb_internal_encoding("UTF-8");

    define('ENGINE_DIR', dirname(__FILE__) . '/engine/');
    define('APPLICATION_DIR', dirname(__FILE__) . '/application/');

    require_once(ENGINE_DIR . 'core/controller.php');
    require_once(ENGINE_DIR . 'core/model.php');

    require_once(ENGINE_DIR . 'core/registry.php');
    require_once(ENGINE_DIR . 'core/request.php');
    require_once(ENGINE_DIR . 'core/routing.php');
    require_once(ENGINE_DIR . 'core/config.php');
    require_once(ENGINE_DIR . 'core/session.php');
    require_once(ENGINE_DIR . 'core/load.php');
    require_once(ENGINE_DIR . 'core/template.php');

    $registry = new Registry();

    $config = new Config();
    $registry->config = $config;

    // Create Database connection, using PDO driver.
    $db = new PDO($config->db_type . ':host=' . $config->db_host . ';dbname=' . $config->db_database, 
        $config->db_user, $config->db_pass, 
        array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $registry->db = $db;

    $request = new Request();
    $registry->request = $request;

    $session = new Session();
    $registry->session = $session;

    $load = new Load($registry);
    $registry->load = $load;

    $template = new Template($registry);
    $registry->template = $template;

    $router = new Router($registry);

    // Start processing GET requests
    $router->init();
?>
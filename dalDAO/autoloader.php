<?php
register_autoloaders();

function register_autoloaders()
{
    spl_autoload_register('autoload_models');
    spl_autoload_register('autoload_dao');
}

function autoload_models($class)
{
    // echo "Modèle : $class\n";
    $fichier = 'models/'.$class.'.php';
    if (is_readable($fichier))
    {
        require_once $fichier;
    }
}

function autoload_dao($class)
{
    // echo "DAO : $class\n";
    $fichier = 'dao/'.$class.'.php';
    if (is_readable($fichier))
    {
        require_once $fichier;
    }
}
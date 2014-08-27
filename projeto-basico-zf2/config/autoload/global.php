<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'navigation' => array(
         'default' => array(
             array(
                 'label' => 'Home',
                 'route' => 'rota_padrao',
             ),
             array(
                 'label' => 'Produtos',
                 'route' => 'rota_padrao',
                 'controller' => 'produtos',
//                 'pages' => array(
//                     array(
//                         'label' => 'Adiciona',
//                         'route' => 'rota_padrao',
//                         'controller' => 'produtos',
//                         'action' => 'add',
//                     )
//                 )
             ),
             array(
                 'label' => 'Clientes',
                 'route' => 'rota_padrao',
                 'controller' => 'clientes',
             )
         )
     ),
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=projeto_basico_zf2;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),    
);

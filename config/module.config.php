<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'balexception/index',

        'template_map' => array(
            'error/index'                   => __DIR__ . '/../view/exception/exception.phtml',
            'balexception/index'            => __DIR__ . '/../view/exception/index.phtml',
            'balexception/exception'        => __DIR__ . '/../view/exception/exception.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'BalExceptions\Options\ModuleOptions' => 'BalExceptions\Options\ModuleOptionsFactory',
        ),
    ),
);

<?php

namespace BalExceptions\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExceptionViewerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        return new ExceptionViewer($serviceLocator->get('BalExceptions\Options\ModuleOptions'));
    }
}
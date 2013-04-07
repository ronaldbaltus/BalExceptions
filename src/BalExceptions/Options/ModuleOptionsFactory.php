<?php
namespace BalExceptions\Options;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * The options for the BalException module
 */
class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        die('joi');

        $config = $serviceLocator->get('config');

        return new BalExceptions\Options\ModuleOptions($config);
    }
}
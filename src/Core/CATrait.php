<?php

namespace App\Core;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait CATrait
{
    /** @var EntityManager */
    protected $em;

    /** @var ContainerInterface */
    protected $sc;

    protected function initContainer(ManagerRegistry $managerRegistry, ContainerInterface $container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->sc = $container;
    }
}
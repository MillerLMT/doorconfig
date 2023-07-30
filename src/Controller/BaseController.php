<?php

namespace App\Controller;

use App\Core\CATrait;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;

class BaseController extends AbstractController
{
    use CATrait;

    public function __construct(ManagerRegistry $managerRegistry, ContainerInterface $container)
    {
        $this->initContainer($managerRegistry, $container);
    }
}
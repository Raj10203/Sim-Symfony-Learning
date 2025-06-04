<?php

namespace App\Controller\Api;

use App\Controller\BaseController;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @method User getUser()
 */
#[IsGranted('ROLE_USER')]
class DefaultApiController extends AbstractController
{

}
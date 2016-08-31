<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     * @Template()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return [];
    }

    /**
     * @Route("/resources", name="resources")
     * @Template()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resourcesAction()
    {
        return [];
    }

    /**
     * @Route("/statistics", name="statistics")
     * @Template()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticsAction()
    {
        return [];
    }
}

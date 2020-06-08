<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Base');
    }

}

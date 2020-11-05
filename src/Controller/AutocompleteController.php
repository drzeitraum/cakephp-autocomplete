<?php
namespace App\Controller;

use App\Controller\AppController;

class AutocompleteController extends AppController
{

    /**
     * initialize
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel($this->getRequest()->getQuery('where'));
    }

    /**
     * Index method
     */
    public function index()
    {
        $results = [];

        if ($this->request->getParam('isAjax')) {
            $results = $this->{$this->getRequest()->getQuery('where')}->find('all')
                ->select(['id', 'name'])
                ->where(['name LIKE' => '%' . $this->getRequest()->getQuery('search') . '%'])
                ->limit(10)
                ->toArray();
         }

        $this->set(compact('results'));

    }

}

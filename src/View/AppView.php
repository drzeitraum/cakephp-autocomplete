<?php
namespace App\View;

use Cake\View\View;

class AppView extends View
{
    public function initialize()
    {
        $this->loadHelper('Form',
            [
                'templates' => 'tpl-form',
                'widgets' => [
                    'ac' => ['CustomAC'],
                ]
            ]
        );
    }
}

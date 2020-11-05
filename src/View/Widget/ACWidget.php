<?php
namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\Widget\WidgetInterface;

/**
 * ACWidget - custom autocomplete input class.
 */
class ACWidget implements WidgetInterface
{

    protected $_templates;

    public function __construct($templates)
    {
        $this->_templates = $templates;
    }

    public function render(array $data, ContextInterface $context)
    {
        // prefix
        $ac[] = $this->_templates->format('ac_prefix', []);
        $ac[] = $this->_templates->format('ac', [
            'name' => $data['name'],
            'id' => $data['id'],
            'class' => $data['class'],
            'val' => $data['val'] ? $data['val'] : '', // value id list
            'value' => isset($data['options']->toArray()[$data['val']]) ? $data['options']->toArray()[$data['val']] : '', // value name list
            'where' => $data['options']->getRepository()->getAlias() // table name
        ]);
        //suffix
        $ac[] = $this->_templates->format('ac_suffix', []);
        return $ac;
    }

    public function secureFields(array $data)
    {
        return [
            $data['name']
        ];
    }

}

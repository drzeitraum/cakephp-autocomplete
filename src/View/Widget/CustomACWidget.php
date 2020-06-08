<?
namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\Widget\WidgetInterface;

/**
 * CustomACWidget - custom autocomplete input class.
 */
class CustomACWidget implements WidgetInterface
{

    protected $_templates;

    public function __construct($templates)
    {
        $this->_templates = $templates;
    }

    public function render(array $data, ContextInterface $context)
    {

        $ac[] = $this->_templates->format('ac_prefix', [
            // you can add your data in prefix
        ]);

        $ac[] = $this->_templates->format('ac', [
            'name' => $data['name'],
            'id' => $data['id'],
            'val' => $data['val'] ? $data['val'] : '', // value id list
            'value' => isset($data['options']->toArray()[$data['val']]) ? $data['options']->toArray()[$data['val']] : '', // value name list
            'where' => $data['options']->getRepository()->getAlias() // table name
        ]);

        $ac[] = $this->_templates->format('ac_suffix', [
            // you can add your data in suffix
        ]);

        return $ac;

    }

    public function secureFields(array $data)
    {
        return [
            $data['name']
        ];
    }
}

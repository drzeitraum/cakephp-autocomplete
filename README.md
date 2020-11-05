# CakePHP 3.x autocomplete input ([DEMO](https://kotlyarov.us/cakephp-autocomplete/edit/1))
This is a simple example: how to create autocomplete input using widget and controller in CakePHP 3.x

### Create tables for `users` and `countries`

See the [db.sql](https://github.com/drzeitraum/cakephp-autocomplete/blob/master/db.sql) file

### Create new widget file [ACWidget.php](https://github.com/drzeitraum/cakephp-autocomplete/blob/master/db.sql) in `/src/View/Widget/`

```php
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
```

### Create template [tpl-form.php](https://github.com/drzeitraum/cakephp-autocomplete/blob/master/config/tpl-form.php) for FormHelper in `/config/` or include in your file

```php
<?php
return [
    'ac_prefix' => '<div>',
    'ac' => '<input type="text" id="{{id}}" name="{{where}}" class="ac-input" autocomplete="off" value="{{value}}"><input type="hidden" id="{{name}}" name="{{name}}" value="{{val}}"><div id="{{where}}_result"></div>',
    'ac_suffix' => '</div>'
];
```

### Include custom template [AppView.php](https://github.com/drzeitraum/cakephp-autocomplete/blob/master/src/View/AppView.php) for form helper and our widget in `src/View/`

```php
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
                    'ac' => ['AC'],
                ]
            ]
        );
    }
}

```

### Create controller [AutocompleteController.php](https://github.com/drzeitraum/cakephp-autocomplete/blob/master/src/Controller/AutocompleteController.php) in `/src/controller/`

```php
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
                ->where(['name LIKE' => '%' . $this->getRequest()->getQuery('search') . '%'])
                ->limit(10)
                ->toArray();
         }

        $this->set(compact('results'));

    }

}

```

### Create view [index.ctp](https://github.com/drzeitraum/cakephp-autocomplete/blob/master/src/Template/Autocomplete/index.ctp) for controller Autocomplete in `/src/Template/Autocomplete/`

```html
<ul class='ac-list'>
    <? if (count($results)) { ?>
        <? foreach ($results as $result) { ?>
            <li id='<?= $result->id ?>'><?= $this->Base->illumination($_REQUEST['search'], $result->name) ?></li>
        <? } ?>
    <? } else { ?>
        <li id='ac_not_found'>At your request <b><?= $_REQUEST['search'] ?></b> nothing found</li>
    <? } ?>
</ul>
```

### Add template [edit.ctp](https://github.com/drzeitraum/cakephp-autocomplete/blob/master/src/Template/Users/edit.ctp) for users edit action in `/src/Template/Users/`

```php
<?= $this->Form->create($user, ['id' => 'user']) ?>
<?= $this->Form->control('country_id', ['type' => 'ac', 'class' => 'ac-input', 'options' => $countries]) ?>
<?= $this->Form->button('Save') ?>
<?= $this->Form->end() ?>
```

### Add JavaScript
This simple script. You can use library (jQuery UI, EasyAutocomplete, etc) or modify this script.

```javascript
ac();
function ac() {
    $('form').unbind("keyup").on('keyup', '.ac-input', function () {
        var id_up = $(this).attr('id'); // this id
        var id_next = $(this).next().attr('id'); // next id
        var search = $(this).val(); // search word
        var where = $(this).attr('name'); // where search
        $.ajax({
            url: '/cakephp-autocomplete/autocomplete/', //change this path to the name of your Autocomplete controller
            data: ({
                search: search,
                where: where
            }),
            success: function (result) {
                $("#" + where + "_result").html(result); // print
                $('.ac-list li').click(function () {
                    $('.ac-list').addClass('ac-none'); // hide ul ac-list
                    $('#' + id_up).val($(this).text());  // insert name
                    $("#" + id_next).val($(this).attr('id')); // insert id
                });
            }
        });
    });
    // hide ul ac-list whatever
    $('body').click(function () {
        $('.ac-list').addClass('ac-none');
    });
}

```

### Add Styles 

```css
.ac {
    position: relative;
}

.ac ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.ac .ac-none {
    position: absolute;
    z-index: 0;
    left: -9999px;
}

.ac .ac-list {
    background: white;
    border-left: 1px solid gray;
    border-right: 1px solid gray;
    margin: 5px 0;
    position: absolute;
    text-align: left;
    z-index: 10000;
    width: 100%;
}

.ac .ac-list li {
    cursor: pointer;
    margin: 0;
    border-bottom: 1px solid gray;
    padding: 0 10px;
}

.ac .ac-list li:hover {
    color: red;
}

.ac .ac-list li#ac_not_found {
    cursor: default;
}

.ac .ac-list li#ac_not_found:hover {
    color: black;
}

```

> After setting, the output of our custom fields in views becomes simple:
```php
echo $this->Form->control('<your_id>', ['type' => '<your_widget_name>']);
```

### Security
This is a simplified version of autocomplete created using a widget. To protect the application from searching through data in the database, specify only the data that you need in the `Autocomplete` controller. You can also create separate actions with different conditions in the `Countries` controller instead.

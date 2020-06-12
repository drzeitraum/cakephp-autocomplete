# Cakephp autocomplete input
This is a simple example: how to create autocomplete input using widget and controller in CakePHP 3.

#### Tables for `users` and `countries`

```mysql
CREATE TABLE `countries` (
  `id` int(10) NOT NULL,
  `name` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Russia'),
(2, 'Canada'),
(3, 'China'),
(4, 'USA'),
(5, 'Brazil'),
(6, 'Australia'),
(7, 'India'),
(8, 'Argentina'),
(9, 'Kazakhstan'),
(10, 'Algeria');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` char(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `country_id` int(5) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `users` (`id`, `login`, `password`, `country_id`) VALUES
(1, 'admin', NULL, NULL);

```

#### Create new widget file `ACWidget.php` in `/src/View/Widget/`

```php
<?
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

```

#### Create template `tpl-form.php` for FormHelper in `/config/` or include in your file

```php
<?php
return [
    'ac_prefix' => '<div>',
    'ac' => '<input type="text" id="{{id}}" name="{{where}}" class="ac-input" autocomplete="off" value="{{value}}"><input type="hidden" id="{{name}}" name="{{name}}" value="{{val}}"><div id="{{where}}_result"></div>',
    'ac_suffix' => '</div>'
];
```

#### Include custom template for form helper and our widget in `src/View/AppView.php`

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

#### Create controller `AutocompleteController.php` in `/src/controller/`

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
          //  if ($this->request->is(['patch', 'post', 'put'])) {
            $results = $this->{$this->getRequest()->getQuery('where')}->find('all')
                ->where(['name LIKE' => '%' . $this->getRequest()->getQuery('search') . '%'])
                ->limit(10)
                ->toArray();
         }

        $this->set(compact('results'));

    }

}

```

#### Create view `index.ctp` for controller Autocomplete in `/src/Template/Autocomplete/`

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

#### Add template `edit.ctp` for users edit action in `/src/Template/Users/`

```php
<?= $this->Form->create($user, ['id' => 'user']) ?>
<?= $this->Form->control('country_id', ['type' => 'ac', 'class' => 'ac-input', 'options' => $countries]) ?>
<?= $this->Form->button('Save') ?>
<?= $this->Form->end() ?>
```

#### Add JS script for processing request with AJAX
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

#### And style

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
echo $this->Form->control('<your_id>', ['type' => '<your_widget_name>']
```
> Similar to other custom fields, like `image radio`, `multi checkbox` & etc.

[Look the DEMO](https://kotlyarov.us/cakephp-autocomplete/edit/1)
<?php
namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Base component
 */
class BaseHelper extends Helper
{

    /**
     * illumination method - highlighting the search phrase
     */
    public function illumination($search = null, $name = null)
    {
        $pattern = "/({$search})/iu";
        $replacement = "<b>$1</b>";
        return preg_replace($pattern, $replacement, $name);
    }

}

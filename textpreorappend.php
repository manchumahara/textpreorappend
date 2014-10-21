<?php
/**
 * TextPreorAppend  - Text field with add-on preend or append
 *
 * @package   mod_instaphotodisplay
 * @author    Codeboxr ( http://codeboxr.com )
 * @copyright Copyright (C) 2011-2014 http://codeboxr.com. All rights reserved.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @ help: http://codeboxr.com/product/instagram-photo-display-for-joomla
 */


defined('_JEXEC') or die('Restricted access');


jimport('joomla.form.formfield');

class JFormFieldTextPreorAppend extends JFormFieldText {

    protected $type = 'textpreorappend';

    protected $addontext;
    protected $appendtext;



    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   11.1
     */
    protected function getInput()    {




        // Translate placeholder text
        $hint = $this->translateHint ? JText::_($this->hint) : $this->hint;

        // Initialize some field attributes.
        $size         = !empty($this->size) ? ' size="' . $this->size . '"' : '';
        $maxLength    = !empty($this->maxLength) ? ' maxlength="' . $this->maxLength . '"' : '';
        $class        = !empty($this->class) ? ' class="' . $this->class . '"' : '';
        $readonly     = $this->readonly ? ' readonly' : '';
        $disabled     = $this->disabled ? ' disabled' : '';
        $required     = $this->required ? ' required aria-required="true"' : '';
        $hint         = $hint ? ' placeholder="' . $hint . '"' : '';
        $autocomplete = !$this->autocomplete ? ' autocomplete="off"' : ' autocomplete="' . $this->autocomplete . '"';
        $autocomplete = $autocomplete == ' autocomplete="on"' ? '' : $autocomplete;
        $autofocus    = $this->autofocus ? ' autofocus' : '';
        $spellcheck   = $this->spellcheck ? '' : ' spellcheck="false"';
        $pattern      = !empty($this->pattern) ? ' pattern="' . $this->pattern . '"' : '';
        $inputmode    = !empty($this->inputmode) ? ' inputmode="' . $this->inputmode . '"' : '';
        $dirname      = !empty($this->dirname) ? ' dirname="' . $this->dirname . '"' : '';

        $append       = $this->element['appendtext'] ? intval($this->element['appendtext']) : 0;





        $addontext       = $this->element['addontext'] ? (string) $this->element['addontext'] : '';

        // Initialize JavaScript field attributes.
        $onchange = !empty($this->onchange) ? ' onchange="' . $this->onchange . '"' : '';

        // Including fallback code for HTML5 non supported browsers.
        JHtml::_('jquery.framework');
        JHtml::_('script', 'system/html5fallback.js', false, true);

        $datalist = '';
        $list     = '';

        /* Get the field options for the datalist.
        Note: getSuggestions() is deprecated and will be changed to getOptions() with 4.0. */
        $options  = (array) $this->getSuggestions();

        if ($options)
        {
            $datalist = '<datalist id="' . $this->id . '_datalist">';

            foreach ($options as $option)
            {
                if (!$option->value)
                {
                    continue;
                }

                $datalist .= '<option value="' . $option->value . '">' . $option->text . '</option>';
            }

            $datalist .= '</datalist>';
            $list     = ' list="' . $this->id . '_datalist"';
        }

        //var_dump($addontext);

        if($addontext != ''){
            $wrapclass = ($append) ? 'input-append' : 'input-prepend';
            $html[] = '<div class="'.$wrapclass.'">'.( (!$append)? '<span class="add-on">'.$addontext.'</span>':''  ).'<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . $dirname . ' value="'
                . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . $class . $size . $disabled . $readonly . $list
                . $hint . $onchange . $maxLength . $required . $autocomplete . $autofocus . $spellcheck . $inputmode . $pattern . ' />'.( ($append)? '<span class="add-on">'.$addontext.'</span>':''  ).'</div>';
        }
        else{
            $html[] = '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . $dirname . ' value="'
                . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . $class . $size . $disabled . $readonly . $list
                . $hint . $onchange . $maxLength . $required . $autocomplete . $autofocus . $spellcheck . $inputmode . $pattern . ' />';
        }



        $html[] = $datalist;

        return implode($html);
    }
}
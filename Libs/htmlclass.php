<?php

class html {

    public static $MONTHS_LONG = array('January', 'February', 'March', 'April', 'May', 'June', 'July',
        'August', 'September', 'October', 'November', 'December');

    public function startForm($action = '#', $method = 'post', $id = NULL, $attr_ar = array()) {
        $str = "<form action=\"$action\" method=\"$method\"";
        if (isset($id)) {
            $str .= " id=\"$id\"";
        }
        $str .= $attr_ar ? $this->addAttributes($attr_ar) . '>' : '>';
        return $str;
    }

    private function addAttributes($attr_ar) {
        $str = '';
        // check minimized attributes
        $min_atts = array('checked', 'disabled', 'readonly', 'multiple');
        foreach ($attr_ar as $key => $val) {
            if (in_array($key, $min_atts)) {
                if (!empty($val)) {
                    $str .= " $key=\"$key\"";
                }
            } else {
                $str .= " $key=\"$val\"";
            }
        }
        return $str;
    }

    public function addInput($type, $name, $attr_ar = array(), $value=null, $checked=null, $text=null) {
        if ($value == null) {
            $value = '';
        }
        $str = '<input ';
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        switch ($type) {
            case 'text':
            case 'password':
            case 'submit':
            case 'button':
            case 'hidden':
            case 'file':
                $str .= ' type="' . $type . '" name="' . $name . '" value="' . $value . '"/>';
                break;
            case 'radio':
            case 'checkbox':
                $str.='type="' . $type . '"  name="' . $name . '"';
                if ($checked == $value) {
                    $str .= ' checked="checked" ';
                } else {
                    // $str .= ' checked="checked" ';
                }
                $str .= 'value="' . $value . '" /><span>' . $text . '</span>';
                break;
        }
//        $str = "<input type=\"$type\" name=\"$name\" value=\"$value\"";


        return $str;
    }

    public function addTextarea($name, $rows = 4, $cols = 30, $value = '', $attr_ar = array()) {
        $str = "<textarea name=\"$name\" rows=\"$rows\" cols=\"$cols\"";
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        $str .= ">$value</textarea>";
        return $str;
    }

    // for attribute refers to id of associated form element
    public function addLabelFor($forID, $text, $attr_ar = array()) {
        $str = "<label for=\"$forID\"";
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        $str .= ">$text</label>";
        return $str;
    }

    // from parallel arrays for option values and text
    public function addSelectListArrays($name, $val_list, $txt_list, $selected_value = NULL, $header = NULL, $attr_ar = array()) {
        $option_list = array_combine($val_list, $txt_list);
        $str = $this->addSelectList($name, $option_list, true, $selected_value, $header, $attr_ar);
        return $str;
    }

    // option values and text come from one array (can be assoc)
    // $bVal false if text serves as value (no value attr)
    public function addSelectList($name, $option_list, $bVal = true, $selected_value = NULL, $header = null, $attr_ar = array()) {
        $str = "<select name=\"$name\"";
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        $str .= ">\n";
        if (isset($header)) {
            $str .= "  <option value=\" \">$header</option>\n";
        }
//        foreach ($option_list as $text) {
//            $str .= $bVal ? "  <option value=\"$text->id\"" : "  <option";
//            if (isset($selected_value) && ( $selected_value === $text->id)) {
//                $str .= ' selected="selected"';
//            }
//            $str .= ">$text->group</option>\n";
//        }
        foreach ($option_list as $val => $text) {
            $str .= $bVal ? "  <option value=\"$val\"" : "  <option";
//            if (isset($selected_value) && ( $selected_value === $val || $selected_value === $text)) {
            if (isset($selected_value) && ( $selected_value == $val )) {
                $str .= ' selected="selected"';
            }
            $str .= ">$text</option>\n";
        }
        $str .= "</select>";
        return $str;
    }

    public function endForm() {
        return "</form>";
    }

    public function ahref($text, $url=null, $atribute=array()) {
        $html = '<a ';
        if ($url) {
            $html.= 'href="' . $url . '" ';
        }
        if (is_array($atribute)) {
            $html.= $this->addAttributes($atribute);
        }
        $html .= ' >' . Basic::__($text) . '</a>';
        return $html;
    }

    public function bold($kata) {
        $html = '<b>';
        $html .= $kata;
        $html .='</b>';
        return $html;
    }

    public function AddFieldset($id, $class, $atribute) {
        $html = '<fieldset ';
        if ($id) {
            $html .= 'id="' . $id . '"';
        }
        if ($class) {
            $html .= 'class="' . $class . '"';
        }
        if ($atribute) {
            $html.= $this->addAttributes($atribute);
        }
        $html .=' >';

        return $html;
    }

    public function EndFieldset() {
        $html = '</fieldset>';
        return $html;
    }

    public function AddLegend($text, $atribute=null) {
        $html = '<legend ';
        if ($atribute != null) {
            $html.= $this->addAttributes($atribute);
        }
        $html.= ' >' . $text . '</legend>';
        return $html;
    }

}

?>
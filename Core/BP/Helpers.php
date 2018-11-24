<?php

class Core_BP_Helpers {

    public static function coreRegistry($param) {

        $registry = Zend_Registry::getInstance();
        return $registry->core_config->$param;
    }

    public static function appRegistry($param) {

        $registry = Zend_Registry::getInstance();

        return $registry->app_config->$param;
    }

    public function addtexttoimage($image, $imagetype, $string = '', $fontsize, $red = 0, $green = 0, $blue = 0, $x = 0, $y = 0) {

        $obj = new Core_BP_Addtexttoimage();
        return $obj->editImage($image, $imagetype, $string, $fontsize, $red, $green, $blue, $x, $y);
    }

    public function buildOptions($table, $preselected_id = 0, $name_col = "name", $id_col = "id") {
        $db = Zend_Db_Table::getDefaultAdapter();
        $ret = "<option value=''>Select...</option>";
        $rows = $db->fetchAll("SELECT $name_col,$id_col FROM $table ORDER BY $name_col");
        ;
        while ($r = array_shift($rows)) {
            $ret .= "<option value='" . $r[$id_col] . "' " . ($preselected_id == $r[$id_col] ? "selected='selected'" : "") . ">" . $r[$name_col] . "</option>";
        }

        return $ret;
    }

    function get_current_page_link() {
        if (count($_GET) > 0) {
            $link = "";
            $amp = "";
            foreach ($_GET as $key => $value) {
                if ($key == "limit") {
                    
                } else if ($key == "page") {
                    
                } else {
                    $link .= $amp . $key . "=" . $value;
                    $amp = "&";
                }
            }
        } else {
            $link = "";
        }
        $actionname = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $controller_name = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        if ($link != "") {
            $link2 = "/" . $controller_name . "/" . $actionname . '?' . $link . '&limit=';
        } else {
            $link2 = "/" . $controller_name . "/" . $actionname . '?limit=';
        }
        return $link2;
    }
    function get_pagination_link() {        
        if (count($_GET) > 0 ) {
            $link = "";
            $amp = "";
            foreach ($_GET as $key => $value) {
                if ($key == "page") {
                    
                } 
                else {
                    $link .= $amp . $key . "=" . $value;
                    $amp = "&";
                }
            }
        } else {
            $link = "";
        }
        $actionname=Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $controller_name=Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        if ($link != "") {
            $link2 =  "/".$controller_name ."/" .$actionname. '?' . $link;
        } else {
            $link2 = "/".$controller_name ."/" .$actionname . '?';
        }        
        return $link2;
    }
    function check_num($number) {
        if ($number > 1) {
            throw new Exception("The value has to be 1 or lower");
        }
        return true;
    }

}

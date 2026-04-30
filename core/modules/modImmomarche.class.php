<?php
declare(strict_types=1);
require_once DOL_DOCUMENT_ROOT . '/core/modules/DolibarrModules.class.php';
class modImmomarche extends DolibarrModules {
    public function __construct($db) {
        $this->db = $db; $this->numero = 700007; $this->rights_class = 'immomarche';
        $this->family = "other"; $this->module_position = '90';
        $this->name = preg_replace('/^mod/i', '', get_class($this));
        $this->description = "Etude de marche";
        $this->version = '1.0.0'; $this->const_name = 'MAIN_MODULE_' . strtoupper($this->name);
        $this->picto = 'company'; $this->config_page_url = array("");
        $this->depends = array('mod_immocore'=>1);
        $this->langfiles = array("immomarche"); $this->phpmin = array(8,1);
        $this->need_dolibarr_version = array(23,0);
        $this->menu = array(); $r=0;
        $this->menu[$r] = array('fk_menu'=>'fk_mainmenu=immobilier','type'=>'left','titre'=>'Etude de marche','mainmenu'=>'immobilier','leftmenu'=>'immomarche','url'=>'/custom/immomarche/index.php','langs'=>'immomarche','position'=>700014,'perms'=>'1','user'=>2); $r++;
        $this->rights = array(); $this->rights_class = 'immomarche'; $r=0;
        $this->rights[$r][0] = 700007001; $this->rights[$r][1] = 'Lire'; $this->rights[$r][3] = 0; $this->rights[$r][4] = 'read'; $r++;
        $this->rights[$r][0] = 700007002; $this->rights[$r][1] = 'Ecrire'; $this->rights[$r][3] = 0; $this->rights[$r][4] = 'write'; $r++;
        $this->rights[$r][0] = 700007003; $this->rights[$r][1] = 'Supprimer'; $this->rights[$r][3] = 0; $this->rights[$r][4] = 'delete';
    }
    public function init($options=''): int { $sql=array(); return $this->_init($sql,$options); }
    public function remove($options=''): int { $sql=array(); return $this->_remove($sql,$options); }
}

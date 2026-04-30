<?php
declare(strict_types=1);
if (!class_exists('CommonObject')) { require_once DOL_DOCUMENT_ROOT . '/core/class/commonobject.class.php'; }
class ImmomarcheObject extends CommonObject {
    public $table_element = 'llx_immo_marche_comparable';
    public $element = 'immomarche';
    public $ref; public $label; public $description;
    protected $fields = array(
        'rowid'=>array('type'=>'integer','enabled'=>1,'visible'=>-1,'position'=>10,'notnull'=>1),
        'ref'=>array('type'=>'varchar(128)','label'=>'Ref','enabled'=>1,'visible'=>1,'position'=>20,'notnull'=>1),
        'label'=>array('type'=>'varchar(255)','label'=>'Libelle','enabled'=>1,'visible'=>1,'position'=>30),
        'description'=>array('type'=>'text','label'=>'Description','enabled'=>1,'visible'=>1,'position'=>40),
        'fk_user_creat'=>array('type'=>'integer','label'=>'Auteur','enabled'=>1,'visible'=>-2,'position'=>510),
        'datec'=>array('type'=>'datetime','enabled'=>1,'visible'=>-2,'position'=>520),
        'tms'=>array('type'=>'timestamp','enabled'=>1,'visible'=>-2,'position'=>530),
        'status'=>array('type'=>'integer','enabled'=>1,'visible'=>1,'position'=>1000,'default'=>0),
    );
    public function __construct(DoliDB $db) { $this->db = $db; }
    public function create(User $user, $notrigger=false): int { $this->ref = $this->getRefNum(); return $this->createCommon($user,$notrigger); }
    public function fetch($id,$ref=''): int { return $this->fetchCommon($id,$ref); }
    public function update(User $user, $notrigger=false): int { return $this->updateCommon($user,$notrigger); }
    public function delete(User $user, $notrigger=false): int { return $this->deleteCommon($user,$notrigger); }
    protected function getRefNum(): string {
        $sql = "SELECT MAX(CAST(SUBSTRING(ref FROM '.*-([0-9]+)$') AS INTEGER)) as maxref FROM " . $this->db->prefix() . $this->table_element;
        $resql = $this->db->query($sql); $num = ($resql && ($obj=$this->db->fetch_object($resql))) ? ((int)$obj->maxref + 1) : 1;
        return 'im' . date('Y') . '-' . str_pad((string)$num, 4, '0', STR_PAD_LEFT);
    }
}

<?php
declare(strict_types=1);

if (!class_exists('CommonObject')) {
    require_once DOL_DOCUMENT_ROOT . '/core/class/commonobject.class.php';
}

class ImmoVenteComp extends CommonObject
{
    public $table_element = 'immo_vente_comp';
    public $element = 'immoventecomp';

    public $quartier;
    public $ville;
    public $type_bien;
    public $surface;
    public $nb_pieces;
    public $prix_vente;
    public $prix_m2;
    public $date_transaction;
    public $source;

    protected $fields = array(
        'rowid' => array('type' => 'integer', 'enabled' => 1, 'visible' => -1, 'position' => 10, 'notnull' => 1),
        'ref' => array('type' => 'varchar(30)', 'label' => 'Ref', 'enabled' => 1, 'visible' => 1, 'position' => 20, 'notnull' => 1),
        'entity' => array('type' => 'integer', 'enabled' => 1, 'visible' => 0, 'position' => 25, 'default' => 1),
        'quartier' => array('type' => 'varchar(255)', 'label' => 'Quartier', 'enabled' => 1, 'visible' => 1, 'position' => 30),
        'ville' => array('type' => 'varchar(255)', 'label' => 'Ville', 'enabled' => 1, 'visible' => 1, 'position' => 40),
        'type_bien' => array('type' => 'varchar(50)', 'label' => 'Type de bien', 'enabled' => 1, 'visible' => 1, 'position' => 50),
        'surface' => array('type' => 'real', 'label' => 'Surface', 'enabled' => 1, 'visible' => 1, 'position' => 60),
        'nb_pieces' => array('type' => 'integer', 'label' => 'Nb pieces', 'enabled' => 1, 'visible' => 1, 'position' => 70),
        'prix_vente' => array('type' => 'real', 'label' => 'Prix de vente', 'enabled' => 1, 'visible' => 1, 'position' => 80),
        'prix_m2' => array('type' => 'real', 'label' => 'Prix au m2', 'enabled' => 1, 'visible' => 1, 'position' => 90),
        'date_transaction' => array('type' => 'date', 'label' => 'Date transaction', 'enabled' => 1, 'visible' => 1, 'position' => 100),
        'source' => array('type' => 'varchar(255)', 'label' => 'Source', 'enabled' => 1, 'visible' => 1, 'position' => 110),
        'fk_user_creat' => array('type' => 'integer', 'label' => 'Auteur', 'enabled' => 1, 'visible' => -2, 'position' => 510),
        'fk_user_modif' => array('type' => 'integer', 'label' => 'Modifie par', 'enabled' => 1, 'visible' => -2, 'position' => 515),
        'tms' => array('type' => 'timestamp', 'enabled' => 1, 'visible' => -2, 'position' => 530),
        'date_creation' => array('type' => 'datetime', 'enabled' => 1, 'visible' => -2, 'position' => 520),
    );

    public function __construct(DoliDB $db)
    {
        $this->db = $db;
    }

    public function create(User $user, $notrigger = false): int
    {
        $this->ref = $this->getNextNumRef();

        return $this->createCommon($user, $notrigger);
    }

    public function fetch($id, $ref = ''): int
    {
        return $this->fetchCommon($id, $ref);
    }

    public function update(User $user, $notrigger = false): int
    {
        return $this->updateCommon($user, $notrigger);
    }

    public function delete(User $user, $notrigger = false): int
    {
        return $this->deleteCommon($user, $notrigger);
    }

    public function calculPrixAuM2(): float
    {
        if (empty($this->surface)) {
            return 0.0;
        }

        return (float) $this->prix_vente / (float) $this->surface;
    }

    public function getNextNumRef(): string
    {
        return 'MBV-' . date('Y') . '-0001';
    }
}

class ImmoLocationComp extends CommonObject
{
    public $table_element = 'immo_location_comp';
    public $element = 'immolocationcomp';

    public $quartier;
    public $ville;
    public $type_bien;
    public $surface;
    public $nb_pieces;
    public $loyer_mensuel;
    public $charges_mensuelles;
    public $loyer_m2;
    public $date_mise_location;
    public $source;

    protected $fields = array(
        'rowid' => array('type' => 'integer', 'enabled' => 1, 'visible' => -1, 'position' => 10, 'notnull' => 1),
        'ref' => array('type' => 'varchar(30)', 'label' => 'Ref', 'enabled' => 1, 'visible' => 1, 'position' => 20, 'notnull' => 1),
        'entity' => array('type' => 'integer', 'enabled' => 1, 'visible' => 0, 'position' => 25, 'default' => 1),
        'quartier' => array('type' => 'varchar(255)', 'label' => 'Quartier', 'enabled' => 1, 'visible' => 1, 'position' => 30),
        'ville' => array('type' => 'varchar(255)', 'label' => 'Ville', 'enabled' => 1, 'visible' => 1, 'position' => 40),
        'type_bien' => array('type' => 'varchar(50)', 'label' => 'Type de bien', 'enabled' => 1, 'visible' => 1, 'position' => 50),
        'surface' => array('type' => 'real', 'label' => 'Surface', 'enabled' => 1, 'visible' => 1, 'position' => 60),
        'nb_pieces' => array('type' => 'integer', 'label' => 'Nb pieces', 'enabled' => 1, 'visible' => 1, 'position' => 70),
        'loyer_mensuel' => array('type' => 'real', 'label' => 'Loyer mensuel', 'enabled' => 1, 'visible' => 1, 'position' => 80),
        'charges_mensuelles' => array('type' => 'real', 'label' => 'Charges mensuelles', 'enabled' => 1, 'visible' => 1, 'position' => 90),
        'loyer_m2' => array('type' => 'real', 'label' => 'Loyer au m2', 'enabled' => 1, 'visible' => 1, 'position' => 100),
        'date_mise_location' => array('type' => 'date', 'label' => 'Date mise en location', 'enabled' => 1, 'visible' => 1, 'position' => 110),
        'source' => array('type' => 'varchar(255)', 'label' => 'Source', 'enabled' => 1, 'visible' => 1, 'position' => 120),
        'fk_user_creat' => array('type' => 'integer', 'label' => 'Auteur', 'enabled' => 1, 'visible' => -2, 'position' => 510),
        'fk_user_modif' => array('type' => 'integer', 'label' => 'Modifie par', 'enabled' => 1, 'visible' => -2, 'position' => 515),
        'tms' => array('type' => 'timestamp', 'enabled' => 1, 'visible' => -2, 'position' => 530),
        'date_creation' => array('type' => 'datetime', 'enabled' => 1, 'visible' => -2, 'position' => 520),
    );

    public function __construct(DoliDB $db)
    {
        $this->db = $db;
    }

    public function create(User $user, $notrigger = false): int
    {
        $this->ref = $this->getNextNumRef();

        return $this->createCommon($user, $notrigger);
    }

    public function fetch($id, $ref = ''): int
    {
        return $this->fetchCommon($id, $ref);
    }

    public function update(User $user, $notrigger = false): int
    {
        return $this->updateCommon($user, $notrigger);
    }

    public function delete(User $user, $notrigger = false): int
    {
        return $this->deleteCommon($user, $notrigger);
    }

    public function calculPrixAuM2(): float
    {
        if (empty($this->surface)) {
            return 0.0;
        }

        return (float) $this->loyer_mensuel / (float) $this->surface;
    }

    public function getNextNumRef(): string
    {
        return 'MBL-' . date('Y') . '-0001';
    }
}

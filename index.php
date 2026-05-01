<?php
declare(strict_types=1);

require_once __DIR__ . '/../../main.inc.php';
require_once __DIR__ . '/class/immomarche.class.php';

$langs->load("immomarche@immomarche");

$action = GETPOST('action', 'aZ09');
$id = GETPOST('id', 'int');
$type = GETPOST('type', 'alpha') === 'location' ? 'location' : 'vente';

if ($action === 'delete' && $id > 0) {
    $object = ($type === 'location') ? new ImmoLocationComp($db) : new ImmoVenteComp($db);
    if ($object->fetch($id) > 0) {
        $object->delete($user);
        setEventMessages('Supprime', null, 'mesgs');
    }
    header("Location: " . $_SERVER["PHP_SELF"] . "?type=" . $type);
    exit;
}

llxHeader('', 'Etude de marche');
print load_fiche_titre('Etude de marche', '', 'company.png');

print '<div class="tabsAction">';
print '<a class="butAction' . ($type === 'vente' ? 'Delete' : '') . '" href="' . $_SERVER["PHP_SELF"] . '?type=vente">Ventes comparables</a> ';
print '<a class="butAction' . ($type === 'location' ? 'Delete' : '') . '" href="' . $_SERVER["PHP_SELF"] . '?type=location">Locations comparables</a> ';
print '<a class="butAction" href="card.php?type=' . $type . '&action=create">Nouveau</a>';
print '</div><br>';

$table = ($type === 'location') ? 'immo_location_comp' : 'immo_vente_comp';
$sql = "SELECT rowid, ref, quartier, ville, type_bien, surface, prix_vente, loyer_mensuel, prix_m2, loyer_m2, date_creation"
    . " FROM " . $db->prefix() . $table
    . " ORDER BY date_creation DESC";
$resql = $db->query($sql);

print '<table class="noborder centpercent liste">';
print '<tr class="liste_titre">'
    . '<th>Ref</th>'
    . '<th>Quartier</th>'
    . '<th>Ville</th>'
    . '<th>Type</th>'
    . '<th class="right">Surface</th>'
    . '<th class="right">' . ($type === 'location' ? 'Loyer' : 'Prix') . '</th>'
    . '<th class="right">Prix/m2</th>'
    . '<th class="center">Actions</th>'
    . '</tr>';

if ($resql) {
    while ($obj = $db->fetch_object($resql)) {
        $prix = ($type === 'location') ? $obj->loyer_mensuel : $obj->prix_vente;
        $prixM2 = ($type === 'location') ? $obj->loyer_m2 : $obj->prix_m2;

        print '<tr class="oddeven">';
        print '<td><a href="card.php?type=' . $type . '&id=' . $obj->rowid . '">' . $obj->ref . '</a></td>';
        print '<td>' . dol_escape_htmltag($obj->quartier) . '</td>';
        print '<td>' . dol_escape_htmltag($obj->ville) . '</td>';
        print '<td>' . dol_escape_htmltag($obj->type_bien) . '</td>';
        print '<td class="right">' . price($obj->surface, 0, '', 0, 0, 0) . ' m2</td>';
        print '<td class="right">' . price($prix, 0, '', 0, 0, 0) . ' &euro;</td>';
        print '<td class="right">' . price($prixM2, 0, '', 0, 0, 0) . ' &euro;/m2</td>';
        print '<td class="center">'
            . '<a href="card.php?type=' . $type . '&action=edit&id=' . $obj->rowid . '">' . img_edit() . '</a> '
            . '<a href="' . $_SERVER["PHP_SELF"] . '?type=' . $type . '&action=delete&id=' . $obj->rowid . '&token=' . newToken() . '" onclick="return confirm(\'Supprimer ?\')">' . img_delete() . '</a>'
            . '</td>';
        print '</tr>';
    }
}

print '</table>';
llxFooter();

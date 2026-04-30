<?php
declare(strict_types=1);
require_once __DIR__ . '/../../main.inc.php';
require_once __DIR__ . '/class/immo_marche_comparable.class.php';
$langs->load("immomarche@immomarche");
$action = GETPOST('action', 'aZ09'); $id = GETPOST('id', 'int');
if ($action === 'delete' && $id > 0) {
    $object = new ImmomarcheObject($db);
    if ($object->fetch($id) > 0) { $object->delete($user); setEventMessages('Supprime', null, 'mesgs'); }
    header("Location: " . $_SERVER["PHP_SELF"]); exit;
}
llxHeader('', 'Etude de marche');
print load_fiche_titre('Etude de marche', '', 'company.png');
print '<div class="tabsAction"><a class="butAction" href="card.php?action=create">Nouveau</a></div><br>';
$sql = "SELECT rowid, ref, label, description, status FROM " . $db->prefix() . "immo_marche_comparable ORDER BY datec DESC";
$resql = $db->query($sql);
print '<table class="noborder centpercent liste"><tr class="liste_titre"><th>Ref</th><th>Libelle</th><th>Description</th><th class="center">Actions</th></tr>';
if ($resql) { while ($obj = $db->fetch_object($resql)) {
    print '<tr class="oddeven"><td><a href="card.php?id=' . $obj->rowid . '">' . $obj->ref . '</a></td>';
    print '<td>' . dol_escape_htmltag($obj->label) . '</td><td>' . dol_escape_htmltag($obj->description) . '</td>';
    print '<td class="center"><a href="card.php?action=edit&id=' . $obj->rowid . '">' . img_edit() . '</a> <a href="' . $_SERVER["PHP_SELF"] . '?action=delete&id=' . $obj->rowid . '&token=' . newToken() . '" onclick="return confirm(\'Supprimer ?\')">' . img_delete() . '</a></td></tr>';
}}
print '</table>'; llxFooter();

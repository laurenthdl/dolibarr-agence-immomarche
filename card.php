<?php
declare(strict_types=1);
require_once __DIR__ . '/../../main.inc.php';
require_once __DIR__ . '/class/immo_marche_comparable.class.php';
$langs->load("immomarche@immomarche");
$action = GETPOST('action', 'aZ09'); $id = GETPOST('id', 'int');
$object = new ImmomarcheObject($db);
if ($action === 'create' && !empty($_POST['label'])) {
    $object->label = GETPOST('label','alpha'); $object->description = GETPOST('description','none'); $object->status = 1;
    $res = $object->create($user);
    if ($res > 0) { setEventMessages('Cree : ' . $object->ref, null, 'mesgs'); header("Location: card.php?id=" . $object->rowid); exit; }
}
if ($action === 'update' && $id > 0 && $object->fetch($id) > 0) {
    $object->label = GETPOST('label','alpha'); $object->description = GETPOST('description','none');
    if ($object->update($user) > 0) { setEventMessages('Modifie', null, 'mesgs'); header("Location: card.php?id=" . $id); exit; }
}
if ($id > 0) $object->fetch($id);
$title = ($action === 'create') ? 'Nouveau' : (($action === 'edit') ? 'Modifier' : 'Fiche');
llxHeader('', $title); print load_fiche_titre($title, '', 'company.png');
if ($action === 'create' || $action === 'edit') {
    print '<form method="POST"><input type="hidden" name="token" value="' . newToken() . '">';
    if ($action === 'edit') print '<input type="hidden" name="id" value="' . $id . '">';
    print '<input type="hidden" name="action" value="' . ($action === 'create' ? 'create' : 'update') . '">';
    print '<table class="border centpercent">';
    print '<tr><td class="fieldrequired">Libelle</td><td><input name="label" value="' . dol_escape_htmltag($object->label ?? '') . '" class="minwidth300"></td></tr>';
    print '<tr><td>Description</td><td><textarea name="description" rows="3">' . dol_escape_htmltag($object->description ?? '') . '</textarea></td></tr>';
    print '</table>';
    print '<div class="center"><input type="submit" class="button" value="Enregistrer"> <a class="butActionDelete" href="index.php">Annuler</a></div></form>';
} else {
    print '<table class="border centpercent">';
    print '<tr><td class="titlefield">Ref</td><td>' . $object->ref . '</td></tr>';
    print '<tr><td>Libelle</td><td>' . dol_escape_htmltag($object->label) . '</td></tr>';
    print '<tr><td>Description</td><td>' . nl2br(dol_escape_htmltag($object->description)) . '</td></tr>';
    print '</table>';
    print '<div class="tabsAction"><a class="butAction" href="card.php?action=edit&id=' . $id . '">Modifier</a> <a class="butAction" href="index.php">Retour</a></div>';
}
llyFooter();

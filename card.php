<?php
declare(strict_types=1);

require_once __DIR__ . '/../../main.inc.php';
require_once __DIR__ . '/class/immomarche.class.php';

$langs->load("immomarche@immomarche");

$action = GETPOST('action', 'aZ09');
$id = GETPOST('id', 'int');
$type = GETPOST('type', 'alpha') === 'location' ? 'location' : 'vente';
$isLocation = $type === 'location';

$object = $isLocation ? new ImmoLocationComp($db) : new ImmoVenteComp($db);

if ($action === 'create' && GETPOSTISSET('quartier')) {
    $object->quartier = GETPOST('quartier', 'alpha');
    $object->ville = GETPOST('ville', 'alpha');
    $object->type_bien = GETPOST('type_bien', 'alpha');
    $object->surface = (float) GETPOST('surface', 'int');
    $object->nb_pieces = (int) GETPOST('nb_pieces', 'int');
    if ($isLocation) {
        $object->loyer_mensuel = (float) GETPOST('loyer_mensuel', 'int');
        $object->charges_mensuelles = (float) GETPOST('charges_mensuelles', 'int');
        $object->date_mise_location = GETPOST('date_mise_location', 'alpha');
    } else {
        $object->prix_vente = (float) GETPOST('prix_vente', 'int');
        $object->date_transaction = GETPOST('date_transaction', 'alpha');
    }
    $object->source = GETPOST('source', 'alpha');
    $prixM2 = $object->calculPrixAuM2();
    if ($isLocation) {
        $object->loyer_m2 = $prixM2;
    } else {
        $object->prix_m2 = $prixM2;
    }
    $res = $object->create($user);
    if ($res > 0) {
        setEventMessages('Cree : ' . $object->ref, null, 'mesgs');
        header("Location: card.php?type=" . $type . "&id=" . $object->rowid);
        exit;
    }
}

if ($action === 'update' && $id > 0 && $object->fetch($id) > 0) {
    $object->quartier = GETPOST('quartier', 'alpha');
    $object->ville = GETPOST('ville', 'alpha');
    $object->type_bien = GETPOST('type_bien', 'alpha');
    $object->surface = (float) GETPOST('surface', 'int');
    $object->nb_pieces = (int) GETPOST('nb_pieces', 'int');
    if ($isLocation) {
        $object->loyer_mensuel = (float) GETPOST('loyer_mensuel', 'int');
        $object->charges_mensuelles = (float) GETPOST('charges_mensuelles', 'int');
        $object->date_mise_location = GETPOST('date_mise_location', 'alpha');
    } else {
        $object->prix_vente = (float) GETPOST('prix_vente', 'int');
        $object->date_transaction = GETPOST('date_transaction', 'alpha');
    }
    $object->source = GETPOST('source', 'alpha');
    $prixM2 = $object->calculPrixAuM2();
    if ($isLocation) {
        $object->loyer_m2 = $prixM2;
    } else {
        $object->prix_m2 = $prixM2;
    }
    if ($object->update($user) > 0) {
        setEventMessages('Modifie', null, 'mesgs');
        header("Location: card.php?type=" . $type . "&id=" . $id);
        exit;
    }
}

if ($id > 0) {
    $object->fetch($id);
}

$titlePrefix = $isLocation ? 'Location comparable' : 'Vente comparable';
$title = $action === 'create' ? 'Nouveau ' . $titlePrefix : ($action === 'edit' ? 'Modifier ' . $titlePrefix : $titlePrefix);
llxHeader('', $title);
print load_fiche_titre($title, '', 'company.png');

print '<form method="POST"><input type="hidden" name="token" value="' . newToken() . '">';
if ($action === 'edit') {
    print '<input type="hidden" name="id" value="' . $id . '">';
}
print '<input type="hidden" name="action" value="' . ($action === 'create' ? 'create' : 'update') . '">';
print '<input type="hidden" name="type" value="' . $type . '">';

if ($action === 'create' || $action === 'edit') {
    print '<table class="border centpercent">';
    print '<tr><td class="fieldrequired">Quartier</td><td><input name="quartier" value="' . dol_escape_htmltag($object->quartier ?? '') . '" class="minwidth200"></td></tr>';
    print '<tr><td>Ville</td><td><input name="ville" value="' . dol_escape_htmltag($object->ville ?? '') . '" class="minwidth200"></td></tr>';
    print '<tr><td>Type de bien</td><td><input name="type_bien" value="' . dol_escape_htmltag($object->type_bien ?? '') . '" class="minwidth200"></td></tr>';
    print '<tr><td class="fieldrequired">Surface (m2)</td><td><input name="surface" type="number" step="0.1" value="' . dol_escape_htmltag((string) ($object->surface ?? '')) . '" class="minwidth100"></td></tr>';
    print '<tr><td>Nb pieces</td><td><input name="nb_pieces" type="number" value="' . dol_escape_htmltag((string) ($object->nb_pieces ?? '')) . '" class="minwidth100"></td></tr>';
    if ($isLocation) {
        print '<tr><td class="fieldrequired">Loyer mensuel</td><td><input name="loyer_mensuel" type="number" step="0.01" value="' . dol_escape_htmltag((string) ($object->loyer_mensuel ?? '')) . '" class="minwidth150"> &euro;</td></tr>';
        print '<tr><td>Charges mensuelles</td><td><input name="charges_mensuelles" type="number" step="0.01" value="' . dol_escape_htmltag((string) ($object->charges_mensuelles ?? '')) . '" class="minwidth150"> &euro;</td></tr>';
        print '<tr><td>Date mise en location</td><td><input name="date_mise_location" type="date" value="' . dol_escape_htmltag($object->date_mise_location ?? '') . '" class="minwidth150"></td></tr>';
    } else {
        print '<tr><td class="fieldrequired">Prix de vente</td><td><input name="prix_vente" type="number" step="0.01" value="' . dol_escape_htmltag((string) ($object->prix_vente ?? '')) . '" class="minwidth150"> &euro;</td></tr>';
        print '<tr><td>Date transaction</td><td><input name="date_transaction" type="date" value="' . dol_escape_htmltag($object->date_transaction ?? '') . '" class="minwidth150"></td></tr>';
    }
    print '<tr><td>Source</td><td><input name="source" value="' . dol_escape_htmltag($object->source ?? '') . '" class="minwidth300"></td></tr>';
    print '</table>';
    print '<div class="center"><input type="submit" class="button" value="Enregistrer"> <a class="butActionDelete" href="index.php?type=' . $type . '">Annuler</a></div>';
} else {
    print '<table class="border centpercent">';
    print '<tr><td class="titlefield">Ref</td><td>' . $object->ref . '</td></tr>';
    print '<tr><td>Quartier</td><td>' . dol_escape_htmltag($object->quartier) . '</td></tr>';
    print '<tr><td>Ville</td><td>' . dol_escape_htmltag($object->ville) . '</td></tr>';
    print '<tr><td>Type de bien</td><td>' . dol_escape_htmltag($object->type_bien) . '</td></tr>';
    print '<tr><td>Surface</td><td>' . price($object->surface, 0, '', 0, 0, 0) . ' m2</td></tr>';
    print '<tr><td>Nb pieces</td><td>' . ((int) $object->nb_pieces) . '</td></tr>';
    if ($isLocation) {
        $prixAffiche = $object->loyer_mensuel;
        $prixM2Affiche = $object->loyer_m2;
        $labelPrix = 'Loyer mensuel';
        $labelPrixM2 = 'Loyer au m2';
    } else {
        $prixAffiche = $object->prix_vente;
        $prixM2Affiche = $object->prix_m2;
        $labelPrix = 'Prix de vente';
        $labelPrixM2 = 'Prix au m2';
    }
    print '<tr><td>' . $labelPrix . '</td><td>' . price($prixAffiche, 0, '', 0, 0, 0) . ' &euro;</td></tr>';
    print '<tr><td>' . $labelPrixM2 . '</td><td>' . price($prixM2Affiche, 0, '', 0, 0, 0) . ' &euro;/m2</td></tr>';
    print '<tr><td>Source</td><td>' . dol_escape_htmltag($object->source) . '</td></tr>';
    print '</table>';
    print '<div class="tabsAction">'
        . '<a class="butAction" href="card.php?type=' . $type . '&action=edit&id=' . $id . '">Modifier</a> '
        . '<a class="butAction" href="index.php?type=' . $type . '">Retour</a>'
        . '</div>';
}

print '</form>';
llxFooter();

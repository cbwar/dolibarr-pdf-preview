<?php


if (false === (@include '../../main.inc.php')) // From htdocs directory
    require '../../../main.inc.php'; // From "custom" directory

require_once DOL_DOCUMENT_ROOT . '/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT . '/ecm/class/ecmdirectory.class.php';

if (!$user->admin or empty($conf->pdfreview->enabled))
    accessforbidden();

$action = GETPOST('action', 'alpha');
if ($action == 'save') {
    $position_facture_client = (int)GETPOST('position_facture_client', 'int');
    $position_facture_proposition_commerciale = (int)GETPOST('position_facture_proposition_commerciale', 'int');
    $position_facture_commande_client = (int)GETPOST('position_facture_commande_client', 'int');
    $position_facture_commande_fourniseure = (int)GETPOST('position_facture_commande_fourniseure', 'int');
    $position_facture_proposition_commerciale_fournisseur = (int)GETPOST('position_facture_proposition_commerciale_fournisseur', 'int');
    $position_facture_fournisseur = (int)GETPOST('position_facture_fournisseur', 'int');

    dolibarr_set_const($db, "position_facture_client", $position_facture_client, 'chaine', 0, "Factures clients", $conf->entity);
    dolibarr_set_const($db, "position_facture_proposition_commerciale", $position_facture_proposition_commerciale, 'chaine', 0, "Propositions commerciales", $conf->entity);
    dolibarr_set_const($db, "position_facture_commande_client", $position_facture_commande_client, 'chaine', 0, "Commandes clients", $conf->entity);
    dolibarr_set_const($db, "position_facture_commande_fourniseure", $position_facture_commande_fourniseure, 'chaine', 0, "Commandes fournisseurs", $conf->entity);
    dolibarr_set_const($db, "position_facture_proposition_commerciale_fournisseur", $position_facture_proposition_commerciale_fournisseur, 'chaine', 0, "Propositions commerciale fournisseurs", $conf->entity);
    dolibarr_set_const($db, "position_facture_fournisseur", $position_facture_fournisseur, 'chaine', 0, "Factures fournisseurs", $conf->entity);
}

$langs->load("pdfreview@pdfreview");

$title = $langs->trans("pdfreview setup");
llxHeader('', $title);

$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">' . $langs->trans("Back to module list") . '</a>';
print_fiche_titre($title, $linkback, 'setup');

print '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';
print '<input type="hidden" name="action" value="save">';
print '<table class="noborder" width="100%">' . "\n";

print '<tr class="liste_titre">';
print '  <td>' . $langs->trans("Facture") . '</td>';
print '  <td >' . $langs->trans("Position") . '</td>';
print '</tr>';

print '<tr class="impair">';
print '  <td align="left" class="fieldrequired">Factures clients</td>';
print '  <td>';
print '<select name="position_facture_client" id="position_facture_client">';
print '<option value="0"' . ($conf->global->position_facture_client == 0 ? ' selected="selected"' : '') . '>Non</option>';
print '<option value="1"' . ($conf->global->position_facture_client == 1 ? ' selected="selected"' : '') . '>Afficher à droite</option>';
print '<option value="2"' . ($conf->global->position_facture_client == 2 ? ' selected="selected"' : '') . '>Afficher en bas</option>';
print '</select>';
print '  </td>';
print '</tr>';

print '<tr class="impair">';
print '  <td align="left" class="fieldrequired">Factures fournisseurs</td>';
print '  <td>';
print '<select name="position_facture_fournisseur" id="position_facture_fournisseur">';
print '<option value="0"' . ($conf->global->position_facture_fournisseur == 0 ? ' selected="selected"' : '') . '>Non</option>';
print '<option value="1"' . ($conf->global->position_facture_fournisseur == 1 ? ' selected="selected"' : '') . '>Afficher à droite</option>';
print '<option value="2"' . ($conf->global->position_facture_fournisseur == 2 ? ' selected="selected"' : '') . '>Afficher en bas</option>';
print '</select>';
print '  </td>';
print '</tr>';

print '<tr class="impair">';
print '  <td align="left" class="fieldrequired">Propositions commerciales</td>';
print '  <td>';
print '<select name="position_facture_proposition_commerciale" id="position_facture_proposition_commerciale">';
print '<option value="0"' . ($conf->global->position_facture_proposition_commerciale == 0 ? ' selected="selected"' : '') . '>Non</option>';
print '<option value="1"' . ($conf->global->position_facture_proposition_commerciale == 1 ? ' selected="selected"' : '') . '>Afficher à droite</option>';
print '<option value="2"' . ($conf->global->position_facture_proposition_commerciale == 2 ? ' selected="selected"' : '') . '>Afficher en bas</option>';
print '</select>';
print '  </td>';
print '</tr>';

print '<tr class="impair">';
print '  <td align="left" class="fieldrequired">Commandes clients</td>';
print '  <td>';
print '<select name="position_facture_commande_client" id="position_facture_commande_client">';
print '<option value="0"' . ($conf->global->position_facture_commande_client == 0 ? ' selected="selected"' : '') . '>Non</option>';
print '<option value="1"' . ($conf->global->position_facture_commande_client == 1 ? ' selected="selected"' : '') . '>Afficher à droite</option>';
print '<option value="2"' . ($conf->global->position_facture_commande_client == 2 ? ' selected="selected"' : '') . '>Afficher en bas</option>';
print '</select>';
print '  </td>';
print '</tr>';

print '<tr class="impair">';
print '  <td align="left" class="fieldrequired">Commandes fournisseurs</td>';
print '  <td>';
print '<select name="position_facture_commande_fourniseure" id="position_facture_commande_fourniseure">';
print '<option value="0"' . ($conf->global->position_facture_commande_fourniseure == 0 ? ' selected="selected"' : '') . '>Non</option>';
print '<option value="1"' . ($conf->global->position_facture_commande_fourniseure == 1 ? ' selected="selected"' : '') . '>Afficher à droite</option>';
print '<option value="2"' . ($conf->global->position_facture_commande_fourniseure == 2 ? ' selected="selected"' : '') . '>Afficher en bas</option>';
print '</select>';
print '  </td>';
print '</tr>';

print '<tr class="impair">';
print '  <td align="left" class="fieldrequired">Propositions commerciale fournisseurs</td>';
print '  <td>';
print '<select name="position_facture_proposition_commerciale_fournisseur" id="position_facture_proposition_commerciale_fournisseur">';
print '<option value="0"' . ($conf->global->position_facture_proposition_commerciale_fournisseur == 0 ? ' selected="selected"' : '') . '>Non</option>';
print '<option value="1"' . ($conf->global->position_facture_proposition_commerciale_fournisseur == 1 ? ' selected="selected"' : '') . '>Afficher à droite</option>';
print '<option value="2"' . ($conf->global->position_facture_proposition_commerciale_fournisseur == 2 ? ' selected="selected"' : '') . '>Afficher en bas</option>';
print '</select>';
print '  </td>';
print '</tr>';


print '</table><br>';
print '<center><input type="submit" class="button" value="' . $langs->trans("Modify") . '"></center>';
print '</form>';

llxFooter();
?>
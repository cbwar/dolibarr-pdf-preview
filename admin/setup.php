<?php
require_once __DIR__ . '/../../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT . '/ecm/class/ecmdirectory.class.php';

/** @var User $user */
/** @var Translate $langs */
/** @var DoliDB $db */
/** @var Conf $conf */

if (!$user->admin || empty($conf->pdfpreview->enabled)) {
	accessforbidden();
}

$options = [
	'Factures clients' => 'position_facture_client',
	'Factures fournisseurs' => 'position_facture_fournisseur',
	'Propositions commerciales' => 'position_facture_proposition_commerciale',
	'Commandes clients' => 'position_facture_commande_client',
	'Commandes fournisseurs' => 'position_facture_commande_fourniseure',
	'Propositions commerciale fournisseurs' => 'position_facture_proposition_commerciale_fournisseur',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	foreach ($options as $label => $code) {
		dolibarr_set_const($db, $code, (int)GETPOST($code, 'int'), 'chaine', 0, $label, $conf->entity);
	}
	/** @var Translate $langs */
	setEventMessages($langs->trans("SetupSaved"), []);
}

$langs->load("pdfpreview@pdfpreview");

$title = $langs->trans("pdfpreview setup");
llxHeader('', $title);

$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">' . $langs->trans("Back to module list") . '</a>';

print load_fiche_titre($title, $linkback, 'setup');

function print_opt(string $label, string $code): void
{
	global $conf;
	global $db;
	$value = (int)dolibarr_get_const($db, $code, $conf->entity)
	?>
	<tr class="impair">
		<td class="fieldrequired">
			<label for="<?= $code ?>"><?= $label ?></label>
		</td>
		<td>
			<select name="<?= $code ?>" id="<?= $code ?>">
				<option value="0" <?= ($value === 0 ? 'selected="selected"' : '') ?>>Non</option>
				<option value="1" <?= ($value === 1 ? 'selected="selected"' : '') ?>>Afficher à droite</option>
				<option value="2" <?= ($value === 2 ? 'selected="selected"' : '') ?>>Afficher en bas</option>
			</select>
		</td>
	</tr>
	<?php
}

?>
	<form method="post">
		<input type="hidden" name="action" value="save">
		<table class="noborder">
			<thead>
			<tr class="liste_titre">
				<th><?= $langs->trans("Facture") ?></th>
				<th><?= $langs->trans("Position") ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($options as $label => $code) {
				print_opt($label, $code);
			} ?>
			</tbody>
		</table>
		<br>
		<input type="submit" class="button" value="<?= $langs->trans("Save") ?>">
	</form>

<?php
llxFooter();

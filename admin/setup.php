<?php

use CBWar\PDFPreview\PDFPreview;

require_once dirname(__DIR__) . '/bootstrap.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT . '/ecm/class/ecmdirectory.class.php';

/** @var User $user */
/** @var Translate $langs */
/** @var DoliDB $db */
/** @var Conf $conf */

if (!$user->admin) {
	accessforbidden();
}
$langs->loadLangs(array('admin'));


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	foreach (PDFPreview::getLabels() as $code => $label) {
		dolibarr_set_const($db, $code, (int)GETPOST($code, 'int'), 'chaine', 0, $label, $conf->entity);
	}
	/** @var Translate $langs */
	setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
}

$title = $langs->trans("");
llxHeader('', $langs->trans("PDF Preview Setup"));

$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php?restore_lastsearch_values=1">' . $langs->trans("BackToModuleList") . '</a>';
print load_fiche_titre($langs->trans("PDF Preview Setup"), $linkback, 'title_setup');

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
				<th><?= $langs->trans("Invoice") ?></th>
				<th><?= $langs->trans("Position") ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach (PDFPreview::getLabels() as $code => $label) {
				print_opt($label, $code);
			} ?>
			</tbody>
		</table>
		<br>
		<input type="submit" class="button" value="<?= $langs->trans("Save") ?>">
	</form>

<?php
llxFooter();

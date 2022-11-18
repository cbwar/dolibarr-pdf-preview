<?php

namespace CBWar\PDFPreview;

class PDFPreview
{
	public const OPT_CLIENT = 'PDFPREVIEW_CLIENT';
	public const OPT_FOURNISSEUR = 'PDFPREVIEW_FOURNISSEUR';
	public const OPT_PROPOSITION_COMMERCIALE = 'PDFPREVIEW_PROPOSITION_COMMERCIALE';
	public const OPT_COMMANDE_CLIENT = 'PDFPREVIEW_COMMANDE_CLIENT';
	public const OPT_COMMANDE_FOURNISSEUR = 'PDFPREVIEW_COMMANDE_FOURNISSEUR';
	public const OPT_PROPOSITION_COMMERCIALE_FOURNISSEUR = 'PDFPREVIEW_PROPOSITION_COMMERCIALE_FOURNISSEUR';

	public static function getLabels(): array
	{
		return [
			self::OPT_CLIENT => 'Factures clients',
			self::OPT_FOURNISSEUR => 'Factures fournisseurs',
			self::OPT_PROPOSITION_COMMERCIALE => 'Propositions commerciales',
			self::OPT_COMMANDE_CLIENT => 'Commandes clients',
			self::OPT_COMMANDE_FOURNISSEUR => 'Commandes fournisseurs',
			self::OPT_PROPOSITION_COMMERCIALE_FOURNISSEUR => 'Propositions commerciale fournisseurs',
		];
	}

	public static function getLabel(string $opt): ?string
	{
		return self::getLabels()[$opt] ?? null;
	}

	public static function getPageUrls(): array
	{
		return [
			self::OPT_CLIENT => ['compta/facture/card.php'],
			self::OPT_FOURNISSEUR => ['fourn/facture/card.php'],
			self::OPT_PROPOSITION_COMMERCIALE => ['comm/propal/card.php'],
			self::OPT_COMMANDE_CLIENT => ['commande/card.php'],
			self::OPT_COMMANDE_FOURNISSEUR => ['fourn/commande/card.php'],
			self::OPT_PROPOSITION_COMMERCIALE_FOURNISSEUR => ['supplier_proposal/card.php'],
		];
	}

	public static function computePagesUrlsToJson(): string
	{
		global $db, $conf;
		$paths = [];
		foreach (self::getPageUrls() as $code => $urls) {
			foreach ($urls as $url) {
				$paths[] = [
					'path' => DOL_URL_ROOT . '/' . $url,
					'position' => (int)$conf->global->{$code},
				];
			}
		}
		$paths[] = [
			'path' => DOL_URL_ROOT . '/accountancy/supplier/list.php',
			'position' => 2
		];
		return json_encode($paths);
	}
}

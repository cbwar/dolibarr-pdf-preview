<?php 
if(false === (@include '../../main.inc.php')) // From htdocs directory
  require '../../../main.inc.php'; // From "custom" directory

header('Content-type: text/javascript; charset=UTF-8');

?>

$(document).ready(function() {
	var pathReview = ["/compta/facture.php", "/fourn/facture/card.php", "/comm/propal/card.php", "commande/card.php", "/fourn/commande/card.php", "/supplier_proposal/card.php"];
	var hrefOrigin = new URL(window.location.href);

	if ($.inArray(hrefOrigin.pathname, pathReview) > -1) {
		
		var urlView = hrefOrigin.origin + '/custom/pdfrendering/js/pdfjs-1.6.210/web/viewer.html?pdfurl=' + hrefOrigin.origin;
        pdfURL = "";
        display = "none";
        var pdfURL = "";
		if (hrefOrigin.searchParams.has('facid') || hrefOrigin.searchParams.has('id')) {
        	if($('#builddoc_form > .liste > tbody > tr').length > 2)
            	pdfURL = $('#builddoc_form > .liste > tbody > tr:eq(2) > td > a:eq(0)').attr('href');
            else
            	pdfURL = $('#builddoc_form > .liste > tbody > tr:eq(1) > td > a:eq(0)').attr('href');

            if(typeof(pdfURL) != "undefined")
            	display = "block";
        }


		if(hrefOrigin.pathname == "/compta/facture.php")
			var position = "<?php echo $conf->global->position_facture_client; ?>";
		else if(hrefOrigin.pathname == "/fourn/facture/card.php")
			var position = "<?php echo $conf->global->position_facture_fournisseur; ?>";
		else if(hrefOrigin.pathname == "/comm/propal/card.php")
			var position = "<?php echo $conf->global->position_facture_proposition_commerciale; ?>";
		else if(hrefOrigin.pathname == "commande/card.php")
			var position = "<?php echo $conf->global->position_facture_commande_client; ?>";
		else if(hrefOrigin.pathname == "/fourn/commande/card.php")
			var position = "<?php echo $conf->global->position_facture_commande_fourniseure; ?>";
		else if(hrefOrigin.pathname == "/supplier_proposal/card.php")
			var position = "<?php echo $conf->global->position_facture_proposition_commerciale_fournisseur; ?>";
		
		console.log(position);
		if(position == 1){
			$('#id-right > .fiche').prepend('<div id="content-review"></div>');
			var content_review = $('#content-review');
			content_review.append('<div id="content-tab"></div>');
			var content_tab = $('#content-tab');
			content_tab.append($('#id-right > .fiche > .tabs'));
			content_tab.append($('#id-right > .fiche > .tabBar'));	
			content_review.append('<div id="content-pdf-review"></div>');
			var content_pdf_review = $('#content-pdf-review');	
			var iframe = $('<iframe id="pdf-review" src="' + urlView + pdfURL + '" style="display: ' + display + ';" class="pdf-viewer-' + ((hrefOrigin.searchParams.has('action') && hrefOrigin.searchParams.get('action') == "create") ? "create" : "edit") + '"></iframe>');
			content_pdf_review.append(iframe);
		}
		else if(position = 2)
		{
			var iframe = $('<iframe id="pdf-review" src="' + urlView + pdfURL + '" style="display: ' + display + ';" class="pdf-viewer-' + ((hrefOrigin.searchParams.has('action') && hrefOrigin.searchParams.get('action') == "create") ? "create" : "edit") + '"></iframe>');
       		iframe.insertAfter($(".tabsAction"));
		}

		$(document).on('click', 'a.pictopreview', function(event) {
            event.preventDefault();
            var pdfURL = $(this).parent('td').find('a:eq(0)').attr('href');
            var srcIframe = urlView + pdfURL;
            $('#pdf-review').attr("src", srcIframe).show();
        });
	}
});

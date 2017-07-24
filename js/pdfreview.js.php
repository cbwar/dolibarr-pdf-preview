<?php
if (false === (@include '../../main.inc.php')) // From htdocs directory
    require '../../../main.inc.php'; // From "custom" directory

header('Content-type: text/javascript; charset=UTF-8');

print("var DOL_URL_ROOT = '" . DOL_URL_ROOT . "';\n");

?>


function pdf_review_show_pdf(position, pdfUrl) {

    if (position == 0) {
        console.log('display pdf disabled');
        return;
    }

    console.log('display pdf in position ' + position);

    var hrefOrigin = new URL(window.location.href);

    if (pdfUrl == undefined) {

        // Onglet fiche
        var $tab = $('.tabsElemActive>a');

        if (hrefOrigin.searchParams.has('facid') || hrefOrigin.searchParams.has('id') || $tab.length > 0) {

            if ($('#builddoc_form > .liste > tbody > tr').length > 2)
                pdfUrl = $('#builddoc_form > .liste > tbody > tr:eq(2) > td > a:eq(0)').attr('href');
            else
                pdfUrl = $('#builddoc_form > .liste > tbody > tr:eq(1) > td > a:eq(0)').attr('href');
        }
    }

    if (pdfUrl == undefined || pdfUrl == '') {
        console.log('nothing to show: pdfUrl undefined');
        return;
    }

    console.log('pdfUrl = ' + pdfUrl);
    var urlView = hrefOrigin.origin + '/' + DOL_URL_ROOT + '/custom/pdfreview/js/pdfjs-1.6.210/web/viewer.html?pdfurl=' + hrefOrigin.origin;

    console.log('urlView = ' + urlView);

    var $iframe = $('<iframe id="pdf-viewer" src="' + urlView + pdfUrl + '" class="pdf-viewer-' + ((hrefOrigin.searchParams.has('action') && hrefOrigin.searchParams.get('action') == "create") ? "create" : "edit") + '"></iframe>');

    var $content_pdf_review = $('#content-pdf-review');
    if ($content_pdf_review.length == 0) {
        $content_pdf_review = $('<div id="content-pdf-review">');
    }
    $content_pdf_review.empty().append($iframe);

    var $fiche = $('.fiche');
    if (position == 1) {
        // Config droite
        $content_pdf_review.addClass('pdf-viewer-right');
        $fiche.css({
            'width': '59%',
            'display': 'inline-block',
            'margin-right': '0'
        });
        $content_pdf_review.insertAfter($fiche);
    } else if (position == 2) {
        // Config bottom
        $content_pdf_review.addClass('pdf-viewer-bottom');
        $content_pdf_review.insertAfter($(".tabsAction"));
    } else if (position == 3) {
        // Ajout rapide
        $content_pdf_review.addClass('pdf-viewer-bottom');
        $content_pdf_review.insertAfter($fiche);
    }

}
// Common pages
$(document).ready(function () {

    $('body').on('click', '#ecm-layout-center a.pictopreview', function (event) {
        event.preventDefault();
        var pdfUrl = $(this).parent('td').find('a:eq(0)').attr('href');
        console.log('Click on invoice checkbox pdfUrl = ' + pdfUrl);
        pdf_review_show_pdf(3, pdfUrl);
    });


    var pathReview = [
        {
            path: DOL_URL_ROOT + "/compta/facture.php",
            position: '<?= $conf->global->position_facture_client ?>'
        },
        {
            path: DOL_URL_ROOT + "/fourn/facture/card.php",
            position: '<?= $conf->global->position_facture_fournisseur ?>'
        },
        {
            path: DOL_URL_ROOT + "/comm/propal/card.php",
            position: '<?= $conf->global->position_facture_proposition_commerciale ?>'
        },
        {
            path: DOL_URL_ROOT + "/commande/card.php",
            position: '<?= $conf->global->position_facture_commande_client ?>'
        },
        {
            path: DOL_URL_ROOT + "/fourn/commande/card.php",
            position: '<?= $conf->global->position_facture_commande_fourniseure ?>'
        },
        {
            path: DOL_URL_ROOT + "/supplier_proposal/card.php",
            position: '<?= $conf->global->position_facture_proposition_commerciale_fournisseur ?>'
        },
        {
            path: DOL_URL_ROOT + "/custom/quikaddinvoice/quikaddinvoicesupplier.php",
            position: '<?= $conf->global->position_facture_fournisseur ?>'
        },
        {
            path: DOL_URL_ROOT + "/custom/quikaddinvoice/quikaddinvoicecustomer.php",
            position: '<?= $conf->global->position_facture_client ?>'
        }
    ];

    var hrefOrigin = new URL(window.location.href);
//
//    console.dir(pathReview);
//    console.dir(hrefOrigin.pathname);

    var currentPage = $.grep(pathReview, function (n) {
        if (n.path == hrefOrigin.pathname) {
            return n;
        }
    });
//    console.dir(currentPage);

    if (currentPage.length > 0) {
        pdf_review_show_pdf(currentPage[0].position);
    }
});

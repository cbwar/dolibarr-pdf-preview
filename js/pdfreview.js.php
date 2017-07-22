<?php
if (false === (@include '../../main.inc.php')) // From htdocs directory
    require '../../../main.inc.php'; // From "custom" directory

header('Content-type: text/javascript; charset=UTF-8');

print("var DOL_URL_ROOT = '" . DOL_URL_ROOT . "';\n");

?>


function pdf_review_show_pdf(position) {

    if (position == 0) {
        console.log('display pdf disabled');
        return;
    }

    console.log('display pdf in position ' + position);

    var hrefOrigin = new URL(window.location.href);
    var pdfURL = "";

    if (hrefOrigin.searchParams.has('facid') || hrefOrigin.searchParams.has('id')) {
        if ($('#builddoc_form > .liste > tbody > tr').length > 2)
            pdfURL = $('#builddoc_form > .liste > tbody > tr:eq(2) > td > a:eq(0)').attr('href');
        else
            pdfURL = $('#builddoc_form > .liste > tbody > tr:eq(1) > td > a:eq(0)').attr('href');

        if (pdfURL == undefined) {
            console.log('nothing to show: pdfURL undefined');
            return;
        }
    }

    console.log('pdfURL = ' + pdfURL);
    var urlView = hrefOrigin.origin + '/' + DOL_URL_ROOT + '/custom/pdfreview/js/pdfjs-1.6.210/web/viewer.html?pdfurl=' + hrefOrigin.origin;

    console.log('urlView = ' + urlView);

    var $iframe = $('<iframe id="pdf-viewer" src="' + urlView + pdfURL + '" class="pdf-viewer-' + ((hrefOrigin.searchParams.has('action') && hrefOrigin.searchParams.get('action') == "create") ? "create" : "edit") + '"></iframe>');
    var $content_pdf_review = $('<div id="content-pdf-review">').append($iframe);

    if (position == 1) {
        $content_pdf_review.addClass('pdf-viewer-right');
        var $fiche = $('.fiche');
        $fiche.css({
            'width': '59%',
            'display': 'inline-block',
            'margin-right': '0'
        });
        $content_pdf_review.insertAfter($fiche);


//            $('#id-right > .fiche').prepend('<div id="content-review"></div>');
//            var content_review = $('#content-review');
//            content_review.append('<div id="content-tab"></div>');
//            var content_tab = $('#content-tab');
//            content_tab.append($('#id-right > .fiche > .tabs'));
//            content_tab.append($('#id-right > .fiche > .tabBar'));
//            content_review.append('<div id="content-pdf-review"></div>');

    } else {
        $content_pdf_review.addClass('pdf-viewer-bottom');
        $content_pdf_review.insertAfter($(".tabsAction"));
    }

    $(document).on('click', 'a.pictopreview', function (event) {
        event.preventDefault();
        var pdfURL = $(this).parent('td').find('a:eq(0)').attr('href');
        var srcIframe = urlView + pdfURL;
        $('#pdf-review').attr("src", srcIframe).show();
    });


}
// Common pages
$(document).ready(function () {

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

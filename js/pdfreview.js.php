<?php
if (false === (@include '../../main.inc.php')) // From htdocs directory
    require '../../../main.inc.php'; // From "custom" directory

header('Content-type: text/javascript; charset=UTF-8');

print("var DOL_URL_ROOT = '" . DOL_URL_ROOT . "';\n");

?>

function pdf_review_find_pdf_url() {

    var hrefOrigin = new URL(window.location.href);
    var pdfUrl;

    // Onglet fiche
    var $tab = $('.tabsElemActive>a');

    if (hrefOrigin.searchParams.has('facid') || hrefOrigin.searchParams.has('id') || $tab.length > 0) {

        if ($('#builddoc_form > .liste > tbody > tr').length > 2)
            pdfUrl = $('#builddoc_form > .liste > tbody > tr:eq(2) > td > a:eq(0)').attr('href');
        else
            pdfUrl = $('#builddoc_form > .liste > tbody > tr:eq(1) > td > a:eq(0)').attr('href');
    }

    if (pdfUrl == undefined || pdfUrl == '') {
        console.log('pdf_review_get_pdf_url: nothing to show: pdfUrl undefined');
        return;
    }

    pdfUrl = hrefOrigin.origin + pdfUrl;
    console.log('pdf_review_get_pdf_url: pdfUrl = ' + pdfUrl);
    return pdfUrl;

}

function pdf_review_load_iframe(pdfUrl) {

    var hrefOrigin = new URL(window.location.href);
    if (pdfUrl == undefined) {
        pdfUrl = pdf_review_find_pdf_url();
    }

    if (pdfUrl !== undefined) {
        var urlView = hrefOrigin.origin + '/' + DOL_URL_ROOT + '/custom/pdfreview/js/pdfjs-1.6.210/web/viewer.html?pdfurl=' + pdfUrl;
        console.log('pdf_review_load_iframe: urlView = ' + urlView);

        return $('<iframe id="pdf-viewer" src="' + urlView + '"></iframe>');
    }
}


function pdf_review_show_pdf(position, pdfUrl, switchButtons = true) {

    if (position == 0) {
        console.log('pdf_review_show_pdf: display pdf disabled');
        return;
    }

    console.log('pdf_review_show_pdf: display pdf in position ' + position);

    var $fiche = $('.fiche');

    var $placeholder_bottom = $('.pdf-review-placeholder-bottom');
    if ($placeholder_bottom.length == 0) {
        $placeholder_bottom = $('<div class="pdf-review-placeholder-bottom"></div>').hide();
        if ($(".fiche .tabsAction").length > 0) {
            $placeholder_bottom.insertAfter($(".fiche .tabsAction"));
        } else {
            $placeholder_bottom.insertAfter($(".fiche"));
        }
    }

    var $placeholder_bottom2 = $('.pdf-review-placeholder-bottom-2');
    if ($placeholder_bottom2.length == 0) {
        $placeholder_bottom2 = $('<div class="pdf-review-placeholder-bottom-2"></div>').hide().insertAfter($fiche);
    }

    var $placeholder_right = $('.pdf-review-placeholder-right');
    if ($placeholder_right.length == 0) {
        $placeholder_right = $('<div class="pdf-review-placeholder-right"></div>').hide().insertAfter($fiche);
    }

//    var $pdf_review_contents = $('.pdf-review-contents');

    console.log('pdf_review_show_pdf: new load');
    var $pdf_review_contents = $('<div class="pdf-review-contents">');
    var $iframe = pdf_review_load_iframe(pdfUrl);
    $pdf_review_contents.append($iframe);

    $fiche.removeClass('pdf-review-fiche-left');

    if (position == 1) {
        // Config droite
        var $button = $('<button class="butAction pdf-review-switch-button">Déplacer en bas</button>')
            .click(function (e) {
                e.preventDefault();
                pdf_review_show_pdf(2);
            })
        $placeholder_right.empty();
        if (switchButtons) $placeholder_right.append($button);
        $placeholder_right.append($pdf_review_contents).show();
        $placeholder_bottom.hide();
        $fiche.addClass('pdf-review-fiche-left');

    } else if (position == 2) {
        // Config bottom
        var $button = $('<button class="butAction pdf-review-switch-button">Déplacer à droite</button>')
            .click(function (e) {
                e.preventDefault();
                pdf_review_show_pdf(1);
            });

        $placeholder_bottom.empty();
        if (switchButtons) $placeholder_bottom.append($button);
        $placeholder_bottom.append($pdf_review_contents).show();
        $placeholder_right.hide();

    } else if (position == 3) {
        // Ajout rapide
        $placeholder_bottom2.empty().append($pdf_review_contents).show();
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

    $('.pdf-review-link').click(function () {
        pdf_review_show_pdf(1, $(this).attr('data-src'), false);
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
        },
        {
            path: DOL_URL_ROOT + "/accountancy/supplier/list.php",
            position: '2'
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

    if (currentPage.length > 0 && invoice_quick_add_step() != 1 && hrefOrigin.pathname != DOL_URL_ROOT + "/accountancy/supplier/list.php") {
        pdf_review_show_pdf(currentPage[0].position);
    }
});

$(document).ready(function() {
    var hrefOrigin = new URL(window.location.href);
    
    if ((hrefOrigin.pathname == "/custom/quikaddinvoice/quikaddinvoicesupplier.php"  || hrefOrigin.pathname == "/custom/quikaddinvoice/quikaddinvoicecustomer.php")) {
        var urlView = hrefOrigin.origin + '/custom/pdfrendering/js/pdfjs-1.6.210/web/viewer.html?pdfurl=' + hrefOrigin.origin;
        pdfURL = "";
        display = "none";

        if (hrefOrigin.searchParams.has('facid') || hrefOrigin.searchParams.has('id')) {
        	if($('#builddoc_form > .liste > tbody > tr').length > 2)
            	var pdfURL = $('#builddoc_form > .liste > tbody > tr:eq(2) > td > a:eq(0)').attr('href');
            else
            	var pdfURL = $('#builddoc_form > .liste > tbody > tr:eq(1) > td > a:eq(0)').attr('href');
            var formInsertAfter = $(".tabsAction");
            display = "block";
        }
        else
             var formInsertAfter = $("#containerlayout");

        $(document).on('click', 'a.pictopreview', function(event) {
            event.preventDefault();
            var pdfURL = $(this).parent('td').find('a:eq(0)').attr('href');
            var srcIframe = urlView + pdfURL;
            $('#pdf-viewer').attr("src", srcIframe).show();
        });

        var iframe = $('<iframe id="pdf-viewer" src="' + urlView + pdfURL + '" style="display: ' + display + ';" class="pdf-viewer-' + ((hrefOrigin.searchParams.has('action') && hrefOrigin.searchParams.get('action') == "create") ? "create" : "edit") + '"></iframe>');
        iframe.insertAfter(formInsertAfter);
    }
});

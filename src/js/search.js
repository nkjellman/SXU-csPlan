var loadSearch = function (id) {
    var inputSearch = $('.search');
    var tableBody = inputSearch.parentsUntil('div.active').siblings('table');
    var tableRowsClass = $('tbody > tr', tableBody);
    var activeSystemClass = $('.list-group-item.active');
    inputSearch.keyup(function (e) {
        var that = this;
        if ($(that).val().trim() === '') {
            $(id + "> tbody").pageMe('goToPage', $(id + ' > tbody').pageMe('current'));
             $('.search-query-sf').remove();
            $('.search-sf').remove();
            return;
        }
        tableRowsClass.each(function (i, val) {
            var rowText = '';
            $('td', val).each(function (i, element) {
                rowText += $(element).text().toLowerCase() + ' ';
            });
            var inputText = $(that).val().trim();
            $('.search-query-sf').remove();
            $('.search-sf').remove();
            if (inputText.toLowerCase() != '') {
                tableBody.prepend('<tr class="search-query-sf"><td colspan="6"><strong>Searching for: "' + inputText + '"</strong></td></tr>');
            }
            if (rowText.indexOf(inputText) == -1) {
                tableRowsClass.eq(i).hide();
            }
            else {
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        if (tableRowsClass.children(':visible').length == 0) {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="6">No entries found.</td></tr>');
        }
    });
};
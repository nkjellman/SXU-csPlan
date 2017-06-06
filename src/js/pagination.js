$.fn.pageMe = function (opts) {
    var $this = this,
        defaults = {
            perPage: 10,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
        var pager =  $($this).data('pager');
    var methods = {
        init: function (options) {
        $(this).data('pager',(settings.pagerSelector != "undefined") ? $(settings.pagerSelector) : $('.pager'));
        pager = $(this).data('pager');
            var listElement = $this;
            pager.data('perPage',settings.perPage || defaults.perPage);

            pager.data('children', listElement.children());
            if (typeof settings.childSelector != "undefined") {
                children = listElement.find(settings.childSelector);
            }
            var numItems = pager.data('children').length;
            pager.data('numPages',Math.ceil(numItems / parseInt(pager.data('perPage'))));
            pager.empty();
            pager.data("curr", 0);
            if (settings.showPrevNext) {
                $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
            }
            var curr = 0;
            while (parseInt(pager.data('numPages')) > curr && (settings.hidePageNumbers == false)) {
                $('<li><a href="#" class="page_link">' + (curr + 1) + '</a></li>').appendTo(pager);
                curr++;
            }
            if (settings.showPrevNext) {
                $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
            }
            pager.find('.page_link:first').addClass('active');
            pager.find('.prev_link').hide();
            if (parseInt(pager.data('numPages')) <= 1) {
                pager.find('.next_link').hide();
            }
            pager.children().eq(0).addClass("active");
            pager.data('children').hide();
            pager.data('children').slice(0,  parseInt(pager.data('perPage'))).show();
            pager.find('li .page_link').click(function () {
                var clickedPage = $(this).html().valueOf() - 1;
                methods.goToPage(clickedPage);
                return false;
            });
            pager.find('li .prev_link').click(function () {
                previous();
                return false;
            });
            pager.find('li .next_link').click(function () {
                next();
                return false;
            });
            function previous() {
                goToPage(parseInt(pager.data("curr")) - 1);
            }
            function next() {
                goToPage(parseInt(pager.data("curr")) + 1);
            }
        },
        goToPage: function (page) {
            console.log(pager);
            var startAt = page *  parseInt(pager.data('perPage')),
                endOn = startAt +  parseInt(pager.data('perPage'));
            pager.data('children').css('display', 'none').slice(startAt, endOn).show();
            if (page >= 1) {
                pager.find('.prev_link').show();
            }
            else {
                pager.find('.prev_link').hide();
            }
            if (page < (parseInt(pager.data('numPages')) - 1)) {
                pager.find('.next_link').show();
            }
            else {
                pager.find('.next_link').hide();
            }
            pager.data("curr", page);
            pager.children().removeClass("active");
            pager.children().eq(page).addClass("active");
        },
        current: function () {
            return parseInt(pager.data("curr"));
        }
    };
    if (methods[opts]) {
        return methods[opts].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof opts === 'object' || !opts) {
        return methods.init.apply(this, arguments);
    }
};
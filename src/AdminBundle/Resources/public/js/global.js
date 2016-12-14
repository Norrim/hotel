$(document).ready(function() {
    $(".fancybox").fancybox({
        beforeShow: function () {
            var alt = this.element.find('img').attr('alt');
            var caption = this.element.find('img').attr('data-caption');

            this.inner.find('img').attr('alt', alt);

            this.title = caption;
        }
    });
});
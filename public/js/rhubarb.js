$(function() {
    $('.movie').click(function() {
        $('.details').load(this.href);

        return false;
    });
});
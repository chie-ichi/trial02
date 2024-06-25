/** hamburger menu **/
$('.header-hamburger').click(function(){
    $('.modal')[0].showModal();
    $('html, body').css('overflow', 'hidden');
});
$('.modal-menu__btn-close').click(function(){
    $('.modal')[0].close();
    $('html, body').css('overflow', 'auto');
});

/** reservation table **/
if($('input[name=\"date\"]').length) {
    $(window).on('load', function(){
        let dateValue = $('input[name=\"date\"]').val();
        let formattedDate = dateValue.replace(/-/g, '/');
        $('#date').text(formattedDate);
    });
    $('input[name=\"date\"]').on('change', function() {
        let dateValue = $(this).val()
        let formattedDate = dateValue.replace(/-/g, '/');
        $('#date').text(formattedDate);
    });
}
if($('select[name=\"time\"]').length) {
    $(window).on('load', function(){
        $('#time').text($('select[name=\"time\"] option:selected').val());
    });
    $('select[name=\"time\"]').on('change', function() {
        $('#time').text($('option:selected', this).val());
    });
}
if($('select[name=\"number\"]').length) {
    $(window).on('load', function(){
        $('#number').text($('select[name=\"number\"] option:selected').val() + '人');
    });
    $('select[name=\"number\"]').on('change', function() {
        $('#number').text($('option:selected', this).val() + '人');
    });
}
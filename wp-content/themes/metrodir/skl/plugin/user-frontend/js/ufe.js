jQuery(document).ready(function($) {

    var form = $('#your-profile');
    $('#wpbody-content').show();

    // Hide h3 titles
    form.find('h3').hide();

    // Hide personal info form
    form.find('> table').eq(0).hide();

    // Hide some contact info inputs
    form.find('> table').eq(2).find('tr').eq(1).hide();
    form.find('> table').eq(2).find('tr').eq(2).hide();
    form.find('> table').eq(2).find('tr').eq(3).hide();
    form.find('> table').eq(2).find('tr').eq(4).hide();
    form.find('> table').eq(3).find('tr').eq(0).hide();
    form.find('> table').eq(4).find('tr').eq(0).hide();
    form.find('> table').eq(5).find('tr').eq(0).hide();

});
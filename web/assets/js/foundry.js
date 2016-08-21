$(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="popover"]').popover();

    $('body').linkify({
        ignoreTags: ['textarea'],
        linkAttributes: { rel: 'noopener' }
    });

});


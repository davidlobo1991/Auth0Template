var Trenkwalder = Trenkwalder || {};

Trenkwalder.Form = {

    auth0Component : null,

    init : function() {
        $(document).ready(this.handleDocumentReady.bind(this));
    },

    handleDocumentReady : function() {
        $('body').on('submit', '.form-ajax', this.handleFormSubmit.bind(this));
    },

    handleFormSubmit: function(e) {
        e.preventDefault();

        var $form = $(e.currentTarget);
        $form.addClass('loading');
        $form.find('button').attr('disabled');

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize()
        }).done(function (data) {
            $form.html(data.form);
            Trenkwalder.Flash.notice(data.message);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (typeof jqXHR.responseJSON !== 'undefined') {
                if (jqXHR.responseJSON.hasOwnProperty('form')) $form.html(jqXHR.responseJSON.form);
                Trenkwalder.Flash.error(jqXHR.responseJSON.message);
            } else {
                Trenkwalder.Flash.error(errorThrown);
            }
        });
    }

};

Trenkwalder.Form.init();

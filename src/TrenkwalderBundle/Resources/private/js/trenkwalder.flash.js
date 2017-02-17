var Trenkwalder = Trenkwalder || {};

Trenkwalder.Flash = {

    auth0Component : null,

    init : function() {
        $(document).ready(this.handleDocumentReady.bind(this));
        $(window).on('load', this.handleWindowOnLoad.bind(this));
    },

    handleDocumentReady : function() {

    },

    handleWindowOnLoad : function() {
        this.show();
    },

    show : function() {
        var $flashmessages = $('.flash-messages .flash-message');

        $flashmessages.each(function(m, message) {
            var $message = $(message);

            $message.fadeIn();

            setTimeout(function() {
                $message.remove();
            }, 5000);

        });
    },

    add : function(message, type) {
        var $flashmessageContainer = $('.flash-messages');
        var $flashMessage = $('<div/>');
        $flashMessage.addClass('flash-' + type);
        $flashMessage.addClass('flash-message');
        $flashMessage.css({'display':'none'});
        $flashMessage.html(message);

        $flashmessageContainer.append($flashMessage);
        this.show();
    },

    notice : function(message) {
        this.add(message, 'notice');
    },

    error : function(message) {
        this.add(message, 'error');
    }

};

Trenkwalder.Flash.init();

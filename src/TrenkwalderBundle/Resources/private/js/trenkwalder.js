var Trenkwalder = Trenkwalder || {};

Trenkwalder.Main = {
    init : function() {
        $(document).ready(this.handleDocumentReady.bind(this));
    },

    handleDocumentReady : function() {
        this.initFullPage();
    },

    initFullPage : function() {

        $('.page-slider').show();

        var options = {
            controlArrows: false,
            verticalCentered: false
        };

        $('.page-slider').fullpage(options);


    },
};

Trenkwalder.Main.init();

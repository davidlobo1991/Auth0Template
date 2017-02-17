var Trenkwalder = Trenkwalder || {};

Trenkwalder.Auth0 = {

    auth0Component : null,

    init : function() {
        $(document).ready(this.handleDocumentReady.bind(this));
        $(document).on('click', 'button.auto0-login', this.handleAuth0ButtonClick.bind(this));
    },

    handleDocumentReady : function() {

        var options = {
            auth: {
                redirectUrl: window.location.origin + Trenkwalder.Config.auth0.redirect_url,
                responseType: 'code',
                params: {
                    scope: 'openid email' // Learn about scopes: https://auth0.com/docs/scopes
                }
            }
        };

        this.auth0Component = new Auth0Lock(Trenkwalder.Config.auth0.client_id, Trenkwalder.Config.auth0.base_url, options);

    },

    handleAuth0ButtonClick : function() {
        this.auth0Component.show();
    }
};

Trenkwalder.Auth0.init();

var OverviewView = require('../view/OverviewView');
var LoginView = require('../view/LoginView');
var RegisterView = require('../view/RegisterView');
var ForgotPasswordView = require('../view/ForgotPasswordView');
var Settings = require('../classes/Settings');
var User = require('../model/User');

var AppRouter = Backbone.Router.extend({
    komenBevallen: undefined,
    loginView: undefined,
    registerView: undefined,
    user: undefined,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    routes: {
        '': 'login',
        'login': 'login',
        'register': 'register',
        'overview': 'overview',
        'forgotpw': 'forgotpw',
        'logout': 'logout',
        '*path': 'login'
    },

    execute: function(callback, args) {
        if ($.isEmptyObject(this.user)) {
            var self = this;
            $.get(Settings.API + '/me', function(data) {
                if (!$.isEmptyObject(data)) {
                    self.user = new User(data);
                    console.log('hey, ik ben ingelogd!');
                }
                callback.apply(self, args); // continue...
            });
        } else {
            callback.apply(this, args);
        }
    },

    redirectIfUnauthorized: function() {
        if ($.isEmptyObject(this.user)) {
            this.navigate('login', {
                trigger: true
            });
        }
    },

    redirectIfLoggedIn: function() {
        if (!$.isEmptyObject(this.user)) {
            this.navigate('overview', {
                trigger: true
            });
        }
    },

    login: function() {
        this.loginView = new LoginView();
        this.render(this.loginView);

        this.redirectIfLoggedIn();
    },

    register: function() {
        this.registerView = new RegisterView();
        this.render(this.registerView);

        this.redirectIfLoggedIn();
    },

    forgotpw: function() {
        this.forgotPasswordView = new ForgotPasswordView();
        this.render(this.forgotPasswordView);

        this.redirectIfLoggedIn();
    },

    overview: function() {
        if (!$.isEmptyObject(this.user)) {
            this.overviewView = new OverviewView();
            this.render(this.overviewView);
        }

        this.redirectIfUnauthorized();
    },

    logout: function() {
        if (!$.isEmptyObject(this.user)) {
            this.user.destroy();
        }
        this.user = [];
        this.navigate('login', {
            trigger: true
        });
    },

    render: function(view) {
        $('.container').html(view.render().$el);
    }
});

module.exports = AppRouter;
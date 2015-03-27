var OverviewView = require('../view/OverviewView');
var LoginView = require('../view/LoginView');
var RegisterView = require('../view/RegisterView');
var ForgotPasswordView = require('../view/ForgotPasswordView');
var SettingsView = require('../view/SettingsView');
var Settings = require('../classes/Settings');
var User = require('../model/User');

var AppRouter = Backbone.Router.extend({
    user: undefined,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    routes: {
        '': 'login',
        'login': 'login',
        'register/:id': 'register',
        'forgotpw': 'forgotpw',
        'overview': 'overview',
        'settings': 'settings',
        'logout': 'logout',
        '*path': 'login'
    },

    execute: function(callback, args) {
        if ($.isEmptyObject(this.user)) {
            var self = this;
            $.get(Settings.API + '/me', function(data) {
                if (!$.isEmptyObject(data)) {
                    self.user = new User(data);
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

    register: function(id) {
        this.registerView = new RegisterView({screen: id});
        this.render(this.registerView);

        if(id < 3) {
            this.redirectIfLoggedIn();
        }
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

    settings: function() {
        if (!$.isEmptyObject(this.user)) {
            this.settingsView = new SettingsView({model: this.user});
            this.render(this.settingsView);
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
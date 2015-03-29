var LoginView = require('../view/auth/LoginView');
var RegisterView = require('../view/auth/RegisterView');
var ForgotPasswordView = require('../view/auth/ForgotPasswordView');
var OverviewView = require('../view/OverviewView');
var PregnancyView = require('../view/PregnancyView');
var RateView = require('../view/RateView');
var ReliveView = require('../view/ReliveView');
var ContendersView = require('../view/ContendersView');
var DetailView = require('../view/DetailView');
var SoundboardView = require('../view/SoundboardView');

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
        'register': 'register',
        'register/:id': 'register',
        'forgotpw': 'forgotpw',
        'overview': 'overview',
        'pregnancy': 'pregnancy',
        'rate/:id': 'rate',
        'relive': 'relive',
        'contenders': 'contenders',
        'detail/:id': 'detail',
        'soundboard': 'soundboard',
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
        this.registerView = new RegisterView();
        this.render(this.registerView);
        if(isNaN(id) || id === null) {
            id = 1;
        }
        this.registerView.showScreen(id);

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
            this.overviewView = new OverviewView({user: this.user});
            this.render(this.overviewView);
        }

        this.redirectIfUnauthorized();
    },

    pregnancy: function() {
        if (!$.isEmptyObject(this.user)) {
            this.pregnancyView = new PregnancyView({model: this.user});
            this.render(this.pregnancyView);
        }

        this.redirectIfUnauthorized();
    },

    rate: function(id) {
        if (!$.isEmptyObject(this.user)) {
            this.rateView = new RateView({model: this.user, contender_id: id});
            this.render(this.rateView);

            if(id === this.user.get('id')) {
                this.navigate('overview', {trigger: true});
            }
        }

        this.redirectIfUnauthorized();
    },

    relive: function() {
        if (!$.isEmptyObject(this.user)) {
            this.reliveView = new ReliveView({model: this.user});
            this.render(this.reliveView);
        }

        this.redirectIfUnauthorized();
    },

    contenders: function() {
        if (!$.isEmptyObject(this.user)) {
            this.contendersView = new ContendersView({group_id: this.user.get('group_id')});
            this.render(this.contendersView);
        }

        this.redirectIfUnauthorized();
    },

    detail: function(id) {
        if (!$.isEmptyObject(this.user)) {
            this.detailView = new DetailView({contender_id: id});
            this.render(this.detailView);
        }

        this.redirectIfUnauthorized();
    },

    soundboard: function() {
        if (!$.isEmptyObject(this.user)) {
            this.soundboardView = new SoundboardView();
            this.render(this.soundboardView);
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
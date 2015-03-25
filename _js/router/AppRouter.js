var KomenBevallen = require('../view/KomenBevallen');
var LoginView = require('../view/LoginView');
var RegisterView = require('../view/RegisterView');
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
        '': 'auth',
        'login': 'login',
        'register': 'register',
        'overview': 'overview',
        '*path': 'auth'
    },

    auth: function() {
        var self = this;
        $.get(Settings.API + '/me', function(data) {
            if(!$.isEmptyObject(data)) {
                self.user = new User(data);
                self.navigate('overview', {trigger: true});
            } else {
                self.navigate('login', {trigger: true});
            }
        });
    },

    login: function() {
        if($.isEmptyObject(this.user)) {
            this.loginView = new LoginView();
            this.render();
            $('body').prepend(this.loginView.render().$el);
        } else {
            this.navigate('overview', {trigger: true});
        }
    },

    register: function() {
        if($.isEmptyObject(this.user)) {
            this.registerView = new RegisterView();
            this.render();
            $('body').prepend(this.registerView.render().$el);
        } else {
            this.navigate('overview', {trigger: true});
        }
    },

    overview: function() {
        if(!$.isEmptyObject(this.user)) {
            this.komenBevallen = new KomenBevallen();
            this.render();
            $('body').prepend(this.komenBevallen.render().$el);
        } else {
            this.auth();
        }
    },

    render: function() {
        $('.container').remove();
    }
});

module.exports = AppRouter;
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
        'wachtwoordvergeten': 'register',
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
            this.render(this.loginView);
        } else {
            this.navigate('overview', {trigger: true});
        }
    },

    register: function() {
        if($.isEmptyObject(this.user)) {
            this.registerView = new RegisterView();
            this.render(this.registerView);
        } else {
            this.navigate('overview', {trigger: true});
        }
    },

    overview: function() {
        if(!$.isEmptyObject(this.user)) {
            this.komenBevallen = new KomenBevallen();
            this.render(this.komenBevallen);
        } else {
            this.auth();
        }
    },

    render: function(view) {
        $('.container').remove();
        $('body').prepend(view.render().$el);
    }
});

module.exports = AppRouter;
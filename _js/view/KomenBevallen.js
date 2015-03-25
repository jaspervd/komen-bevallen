var LoginView = require('./LoginView');
var RegisterView = require('./RegisterView');
var OverviewView = require('./OverviewView');
var ResultView = require('./ResultView');
var SettingsView = require('./SettingsView');

var KomenBevallen = Backbone.View.extend({
    className: 'container',
    tagName: 'div',

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
        this.loginView = new LoginView();
        this.registerView = new RegisterView();
    },

    render: function() {
        this.$el.append(this.loginView.render().$el);
        this.$el.append(this.registerView.render().$el);
        return this;
    },
});

module.exports = KomenBevallen;
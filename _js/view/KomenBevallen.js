var OverviewView = require('./OverviewView');
var ResultView = require('./ResultView');
var SettingsView = require('./SettingsView');

var KomenBevallen = Backbone.View.extend({
    className: 'container',
    tagName: 'div',

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    render: function() {
        return this;
    },
});

module.exports = KomenBevallen;
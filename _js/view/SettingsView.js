var template = require('../../_hbs/settings.hbs');

var SettingsView = Backbone.View.extend({
	template: template,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    render: function() {
        this.$el.append(this.template());
        return this;
    },
});

module.exports = SettingsView;

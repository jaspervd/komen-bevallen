var template = require('../../_hbs/overview.hbs');

var OverviewView = Backbone.View.extend({
	template: template,
	tagName: 'section',
	className: 'overview',

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    render: function() {
        this.$el.append(this.template());
        return this;
    },
});

module.exports = OverviewView;
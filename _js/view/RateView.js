var template = require('../../_hbs/rate.hbs');

var RateView = Backbone.View.extend({
	template: template,

	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	render: function() {
		this.$el.html(this.template());
		return this;
	},
});

module.exports = RateView;
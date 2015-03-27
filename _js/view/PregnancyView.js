var template = require('../../_hbs/pregnancy.hbs');

var PregnancyView = Backbone.View.extend({
	template: template,

	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	render: function() {
		this.$el.html(this.template());
		return this;
	},
});

module.exports = PregnancyView;
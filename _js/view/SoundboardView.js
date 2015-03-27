var template = require('../../_hbs/soundboard.hbs');

var SoundboardView = Backbone.View.extend({
	template: template,

	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	render: function() {
		this.$el.html(this.template());
		return this;
	},
});

module.exports = SoundboardView;
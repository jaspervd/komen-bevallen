var template = require('../../_hbs/signup.hbs');

var SignupView = Backbone.View.extend({
	template: template,
	success: false,

	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	events: {
		'submit': 'signup'
	},

	signup: function(e) {
		e.preventDefault();

		this.success = true;
		this.render();
	},

	render: function() {
		console.log({success: this.success});
		this.$el.html(this.template({signedup: this.success}));
		return this;
	},
});

module.exports = SignupView;
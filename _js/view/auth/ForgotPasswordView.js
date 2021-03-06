var template = require('../../../_hbs/forgotpassword.hbs');
var Settings = require('../../classes/Settings');

var ForgotPasswordView = Backbone.View.extend({
	template: template,

	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	events: {
		'submit': 'forgotPassword'
	},

	forgotPassword: function(e) {
		e.preventDefault();

		$.post(Settings.API + '/forgotpw', {email: this.$el.find('.email').val()}, function() {
			console.log('Mail is succesvol verzonden.');
		}).fail(function() {
			console.log('Mail kon niet verzonden worden.');
		});
	},

	render: function() {
		this.$el.append(this.template());
		return this;
	},
});

module.exports = ForgotPasswordView;
var template = require('../../../_hbs/register.hbs');
var User = require('../../model/User');

var RegisterView = Backbone.View.extend({
	template: template,
	user: undefined,

	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	events: {
		'click .step-1 input[type="submit"]': 'stepOne'
	},

	stepOne: function(e) {
		e.preventDefault();
		this.user = new User({
			email: $(e.currentTarget).find('#email').val(),
			password: $(e.currentTarget).find('#password').val()
		});

		this.showScreen(2);
		Backbone.history.navigate('register/2');
	},

	showScreen: function(screen) {
		this.$el.find('fieldset').hide();
		this.$el.find('fieldset.step-'+ screen).show();
	},

	render: function() {
		this.$el.html(this.template());
		return this;
	},
});

module.exports = RegisterView;
var template = require('../../_hbs/register.hbs');
var User = require('../model/User');

var RegisterView = Backbone.View.extend({
	template: template,
	screen: 1,
	user: undefined,

	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	events: {
		'submit .step-1': 'register',
		'submit .step-2': 'signup',
	},

	register: function(e) {
		e.preventDefault();
		this.user = new User({
			email: $(e.currentTarget).find('#email').val(),
			password: $(e.currentTarget).find('#password').val()
		});

		this.$el.find('.step-1').hide();
		this.$el.find('.step-2').show();
		Backbone.history.navigate('register/2');
	},

	signup: function(e) {
		e.preventDefault();
		this.user.set({
			mother: $(e.currentTarget).find('#mother').val(),
			partner: $(e.currentTarget).find('#partner').val(),
			photo: $(e.currentTarget).find('#photo').val(),
			duedate: $(e.currentTarget).find('#duedate').val(),
			type: $(e.currentTarget).find('#type').val()
		});

		this.user.save({
			success: function(model, response) {
				this.$el.find('.step-2').hide();
				this.$el.find('.step-3').show();
				Backbone.history.navigate('register/3');
			}
		});
	},

	render: function() {
		this.$el.append(this.template({screen: this.screen}));
		return this;
	},
});

module.exports = RegisterView;
var template = require('../../_hbs/register.hbs');
var User = require('../model/User');

var RegisterView = Backbone.View.extend({
	template: template,

	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},
/*
	events: {
		'submit': 'register'
	},

	register: function(e) {
		e.preventDefault();
		var user = new User({
			email: $(e.currentTarget).find('.email').val(),
			password: $(e.currentTarget).find('.password').val()
		});

		user.save(null, {
			success: function(model) {
				console.log("Woopwoop, geregistreerd!", model);
			},
			error: function(model) {
				console.log("Oei?!");
			}
		});
	},
*/
	render: function() {
		this.$el.append(this.template());
		return this;
	},
});

module.exports = RegisterView;
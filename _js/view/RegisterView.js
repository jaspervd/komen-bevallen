var template = require('../../_hbs/register.hbs');
var User = require('../model/User.js');

var RegisterView = Backbone.View.extend({
	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

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

	render: function() {
		this.$el.append(template());
		return this;
	},
});

module.exports = RegisterView;
var template = require('../../_hbs/login.hbs');
var Settings = require('../classes/Settings');

var LoginView = Backbone.View.extend({
	initialize: function() {
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	events: {
		'submit': 'login'
	},

	login: function(e) {
		e.preventDefault();

		$.post(Settings.API + '/login', {
			email: $(e.currentTarget).find('.email').val(),
			password: $(e.currentTarget).find('.password').val()
		}, function(data) {
			console.log('Hoera! Ik ben ingelogd!');
		}, "json").fail(function(data) {
			console.log(data.responseJSON);
		}, "json");
	},

	render: function() {
		this.$el.append(template());
		return this;
	},
});

module.exports = LoginView;
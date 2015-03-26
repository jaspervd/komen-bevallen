var template = require('../../_hbs/forgotpassword.hbs');
var Settings = require('../classes/Settings');

var ForgotPasswordView = Backbone.View.extend({
	template: template,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    render: function() {
        this.$el.append(this.template());
		return this;
	},
});

module.exports = ForgotPasswordView;
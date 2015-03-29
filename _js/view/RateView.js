var template = require('../../_hbs/rate.hbs');
var Rating = require('../model/Rating');

var RateView = Backbone.View.extend({
	template: template,

	initialize: function(options) {
		this.options = options;
		_.bindAll.apply(_, [this].concat(_.functions(this)));
	},

	events: {
		'submit': 'rate'
	},

	rate: function(e) {
		e.preventDefault();
		var $points_show, $points_baby, $points_partner;
		var rating = new Rating({
			points_show: $points_show,
			points_baby: $points_baby,
			points_partner: $points_partner,
			contender_id: this.options.contender_id,
			group_id: this.model.group_id
		});

		rating.save();
	},

	render: function() {
		this.$el.html(this.template());
		return this;
	},
});

module.exports = RateView;
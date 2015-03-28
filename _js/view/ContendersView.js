var template = require('../../_hbs/contenders.hbs');
var Group = require('../model/Group');

var ContendersView = Backbone.View.extend({
	template: template,
	group_id: null,

	initialize: function(options) {
		this.options = options;
		_.bindAll.apply(_, [this].concat(_.functions(this)));
		this.model = new Group();
		this.model.urlRoot += '/' + this.options.group_id;
		this.model.fetch();
		this.model.on('reset sync', this.render);
	},

	render: function() {
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	},
});

module.exports = ContendersView;
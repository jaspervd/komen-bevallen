var template = require('../../_hbs/detail.hbs');
var User = require('../model/User');

var DetailView = Backbone.View.extend({
	template: template,
	contender_id: null,

    initialize: function(options) {
    	this.options = options;
        _.bindAll.apply(_, [this].concat(_.functions(this)));
        this.model = new User();
        this.model.urlRoot += '/' + this.options.contender_id;
        this.model.fetch();
        this.model.on('reset sync', this.render);
    },

    render: function() {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    },
});

module.exports = DetailView;
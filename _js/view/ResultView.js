var template = require('../../_hbs/result.hbs');
var Ratings = require('../collection/Ratings');

var ResultView = Backbone.View.extend({
	template: template,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
        this.collection = new Ratings();
        this.collection.url += '/total/' + this.model.get('group_id');
        this.collection.fetch();
        this.collection.on('reset sync', this.render);
    },

    render: function() {
        this.$el.html(this.template(this.collection.toJSON()));
        return this;
    },
});

module.exports = ResultView;

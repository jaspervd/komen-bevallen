var template = require('../../_hbs/relive.hbs');
var Photos = require('../collection/Photos');

var ReliveView = Backbone.View.extend({
	template: template,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
        this.collection = new Photos();
        this.collection.url += '/all/' + this.model.get('group_id');
        this.collection.fetch();
        this.collection.on('reset sync', this.render);
    },

    render: function() {
        this.$el.html(this.template({photos: this.collection.toJSON()}));
        return this;
    },
});

module.exports = ReliveView;
var template = require('../../_hbs/_info.hbs');

var InfoView = Backbone.View.extend({
    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    render: function() {
        this.$el.append(template());
        return this;
    },
});

module.exports = InfoView;


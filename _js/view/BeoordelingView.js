var template = require('../../_hbs/_beoordeling.hbs');

var BeoordelingView = Backbone.View.extend({
    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    render: function() {
        this.$el.append(template());
        return this;
    },
});

module.exports = BeoordelingView;

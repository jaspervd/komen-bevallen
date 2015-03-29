var template = require('../../_hbs/pregnancy.hbs');

var PregnancyView = Backbone.View.extend({
    template: template,

    initialize: function(options) {
        this.options = options;
        _.bindAll.apply(_, [this].concat(_.functions(this)));

        this.user = this.options.user;
    },

    events: {
        'submit': 'save'
    },

    save: function(e) {
        e.preventDefault();
    },

    render: function() {
        this.$el.html(this.template(this.user.toJSON()));
        return this;
    },
});

module.exports = PregnancyView;
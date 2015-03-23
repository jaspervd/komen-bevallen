var KomenBevallen = Backbone.View.extend({
    className: 'container',
    tagName: 'div',
    template: tpl.komenBevallen,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    render: function() {
        this.$el.append(this.template());
        return this;
    },
});
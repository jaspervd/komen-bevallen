/* globals KomenBevallen:true */

var AppRouter = Backbone.Router.extend({
    komenBevallen: undefined,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
    },

    routes: {
        '': 'overview',
        '*path': 'overview'
    },

    overview: function() {
        this.komenBevallen = new KomenBevallen();
        this.render();
    },

    render: function() {
        $('.container').remove();
        $('body').prepend(this.komenBevallen.render().$el);
    }
});
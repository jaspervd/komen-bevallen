var template = require('../../_hbs/overview.hbs');
var Settings = require('../classes/Settings');
var User = require('../model/User');

var OverviewView = Backbone.View.extend({
	template: template,
	tagName: 'section',
	className: 'overview',
    today: {notThisWeek: false, finished: false},

    initialize: function(options) {
        this.options = options;
        _.bindAll.apply(_, [this].concat(_.functions(this)));
        var self = this;
        $.get(Settings.API + '/today', function(data) {
            if(!$.isEmptyObject(data)) {
                var userWeek = new Date().getWeek();
                var adminWeek = new Date(data.date).getWeek();
                self.today.notThisWeek = (userWeek !== adminWeek);
                self.today.finished = (data.finished === 'yes');
                self.render();
            }
        });
    },

    render: function() {
        this.$el.html(this.template(this.today));
        return this;
    },
});

module.exports = OverviewView;
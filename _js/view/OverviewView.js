var template = require('../../_hbs/overview.hbs');
var Settings = require('../classes/Settings');
var User = require('../model/User');
var Group = require('../model/Group');

var OverviewView = Backbone.View.extend({
	template: template,
	tagName: 'section',
	className: 'overview',
    today: {thisWeek: false, finished: false, contender_id: 0},

    initialize: function(options) {
        this.options = options;
        _.bindAll.apply(_, [this].concat(_.functions(this)));
        var self = this;
        $.get(Settings.API + '/today', function(data) {
            if(!$.isEmptyObject(data)) {
                var userWeek = new Date(self.options.user.get('duedate')).getWeek();
                var adminWeek = new Date(data.date).getWeek();
                self.today.admin = data.date;
                self.today.thisWeek = (userWeek === adminWeek);
                self.today.finished = (data.finished === 'yes');
                self.render();

                if(self.today.thisWeek) {
                    self.model = new Group();
                    self.model.urlRoot += '/' + self.options.user.get('group_id');
                    self.model.fetch();
                    self.model.on('reset sync', self.render);
                }
            }
        });
    },

    render: function() {
        if(!$.isEmptyObject(this.model)) {
            var users = this.model.get('users');
            var user = _.findWhere(users, {duedate: this.today.admin});
            console.log(user);
            this.today.contender_id = user.id;
        }
        this.$el.html(this.template(this.today));
        return this;
    },
});

module.exports = OverviewView;
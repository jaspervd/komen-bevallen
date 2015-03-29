var template = require('../../_hbs/pregnancy.hbs');
var User = require('../model/User');
var Settings = require('../classes/Settings');

var PregnancyView = Backbone.View.extend({
    template: template,
    user: undefined,

    initialize: function() {
        _.bindAll.apply(_, [this].concat(_.functions(this)));
        this.user = this.model;
    },

    events: {
        'submit': 'save'
    },

    save: function(e) {
        e.preventDefault();
        this.user.set({
            email: this.$el.find('#email').val(),
            mother: this.$el.find('#mother').val(),
            partner: this.$el.find('#partner').val(),
            type: this.$el.find('#type').val(),
            duedate: this.$el.find('#duedate').val()
        });
        this.user.save();

        var $photo = this.$el.find('#photo')[0].files[0];
        if(!$.isEmptyObject($photo)) {
            var self = this;
            var data = new FormData();
            data.append('photo', $photo);
            $.ajax({
                url: Settings.API + '/users/' + self.user.id,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'PUT',
                success: function(data){
                    console.log('hip hip hoera');
                }
            });
        }
    },

    render: function() {
        this.$el.html(this.template(this.user.toJSON()));
        return this;
    },
});

module.exports = PregnancyView;
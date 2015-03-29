var template = require('../../_hbs/detail.hbs');
var User = require('../model/User');
var Photos = require('../collection/Photos');
var Settings = require('../classes/Settings');

var DetailView = Backbone.View.extend({
	template: template,
	contender_id: null,

	initialize: function(options) {
		this.options = options;
		_.bindAll.apply(_, [this].concat(_.functions(this)));
		this.model = new User();
		this.model.urlRoot += '/' + this.options.contender_id;
		this.model.fetch();
		this.model.on('reset sync', this.render);

		this.photos = new Photos();
		this.photos.urlRoot += '/' + this.options.contender_id;
		this.photos.fetch();
		this.photos.on('reset sync', this.render);
	},

	events: {
		'change input': 'upload'
	},

	upload: function(e) {
		e.preventDefault();

		var data = new FormData();
		data.append('contender_id', this.options.contender_id);
		data.append('photo', this.$el.find('input')[0].files[0]);

		$.ajax({
			url: Settings.API + '/users',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function(data){
				console.log('hip hip hoera');
			}
		});
	},

	render: function() {
		this.$el.html(this.template({user: this.model.toJSON(), photos: this.photos.toJSON()}));
		return this;
	},
});

module.exports = DetailView;
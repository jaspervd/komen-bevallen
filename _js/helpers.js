/* global Handlebars:true */
var Handlebars = require('hbsfy/runtime');

Handlebars.registerHelper('equals', function(val1, val2) {
   return (val1 === val2);
});
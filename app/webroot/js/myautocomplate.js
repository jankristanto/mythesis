$(document).ready(function(){
// Caching the movieName textbox:
//var text = $('#text');

var text = $('#InFormalWordAsli');


// Defining a placeholder text:
text.defaultText('Search Word');

// Using jQuery UI's autocomplete widget:
text.autocomplete({
minLength    : 2,
source        : Project.basePath+'/FormalWords/search'
});

});

// A custom jQuery method for placeholder text:

$.fn.defaultText = function(value){

var element = this.eq(0);
element.data('defaultText',value);

element.focus(function(){
if(element.val() == value){
element.val('').removeClass('defaultText');
}
}).blur(function(){
if(element.val() == '' || element.val() == value){
element.addClass('defaultText').val(value);
}
});

return element.blur();
}
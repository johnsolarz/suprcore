
// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console) {
      arguments.callee = arguments.callee.caller;
      console.log( Array.prototype.slice.call(arguments) );
  }
};
// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c})(window.console=window.console||{});


// place any jQuery/helper plugins in here, instead of separate, slower script files.

/*
  Formalize - version 1.1

  Note: This file depends on the jQuery library.
*/
var FORMALIZE=function(a,b,c,d){var e="placeholder"in c.createElement("input"),f="autofocus"in c.createElement("input"),g=!!a.browser.msie&&parseInt(a.browser.version,10)===6,h=!!a.browser.msie&&parseInt(a.browser.version,10)===7;return{go:function(){for(var a in FORMALIZE.init)FORMALIZE.init[a]()},init:{full_input_size:function(){!!h&&!!a("textarea, input.input_full").length&&a("textarea, input.input_full").wrap('<span class="input_full_wrap"></span>')},ie6_skin_inputs:function(){if(!!g&&!!a("input, select, textarea").length){var b=/button|submit|reset/,c=/date|datetime|datetime-local|email|month|number|password|range|search|tel|text|time|url|week/;a("input").each(function(){var d=a(this);this.getAttribute("type").match(b)?(d.addClass("ie6_button"),this.disabled&&d.addClass("ie6_button_disabled")):this.getAttribute("type").match(c)&&(d.addClass("ie6_input"),this.disabled&&d.addClass("ie6_input_disabled"))}),a("textarea, select").each(function(){this.disabled&&a(this).addClass("ie6_input_disabled")})}},autofocus:function(){!f&&!!a(":input[autofocus]").length&&a(":input[autofocus]:visible:first").focus()},placeholder:function(){!e&&!!a(":input[placeholder]").length&&(FORMALIZE.misc.add_placeholder(),a(":input[placeholder]").each(function(){var b=a(this),c=b.attr("placeholder");b.focus(function(){b.val()===c&&b.val("").removeClass("placeholder_text")}).blur(function(){FORMALIZE.misc.add_placeholder()}),b.closest("form").submit(function(){b.val()===c&&b.val("").removeClass("placeholder_text")}).bind("reset",function(){setTimeout(FORMALIZE.misc.add_placeholder,50)})}))}},misc:{add_placeholder:function(){!e&&!!a(":input[placeholder]").length&&a(":input[placeholder]").each(function(){var b=a(this),c=b.attr("placeholder");(!b.val()||b.val()===c)&&b.val(c).addClass("placeholder_text")})}}}}(jQuery,this,this.document);jQuery(document).ready(function(){FORMALIZE.go()});
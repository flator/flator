/*  Window.Growl, version 2.0: http://icebeat.bitacoras.com
 *  Daniel Mota aka IceBeat <daniel.mota@gmail.com>
 *	Updated to 1.2b2 by Paul Streise <paulstreise@gmail.com>
--------------------------------------------------------------------------*/
var Gr0wl={};Gr0wl.Base=new Class({options:{image:"growl.jpg",title:"Window.Growl by Daniel Mota",text:"http://icebeat.bitacoras.com",duration:2},initialize:function(A){this.image=new Asset.image(A,{onload:this.create.bind(this)});return this.show.bind(this)},create:function(A){this.image.setStyles({position:"absolute",display:"none"}).setOpacity(0).injectInside(document.body);this.block=new Element("div").setStyles($extend({position:"absolute",display:"none","z-index":"999",color:"#fff",font:'12px/14px "Lucida Grande", Arial, Helvetica, Verdana, sans-serif'},A.div)).setOpacity(0).injectInside(document.body);new Element("img").setStyles(A.img).injectInside(this.block);new Element("h3").setStyles(A.h3).injectInside(this.block);new Element("p").setStyles(A.p).injectInside(this.block)},show:function(A){A=$merge(this.options,A);var B=[this.image.clone(),this.block.clone()];B.each(function(D,C){D.injectInside(document.body);D.setStyles(A.position);if(C){D.getFirst().setProperty("src",A.image).getNext().setHTML(A.title).getNext().setHTML(A.text)}});new Fx.Elements(B,{duration:400}).start({"0":{opacity:[0,0.75]},"1":{opacity:1}});this.hide.delay(A.duration*1000,this,[B])},hide:function(C,A){var B=new Fx.Elements(C,{duration:400,onComplete:function(){this.elements[0].remove();this.elements[1].empty().remove()}}).start({"0":A,"1":A})}});Gr0wl.Smoke=Gr0wl.Base.extend({create:function(){this.queue=[];this.parent({div:{width:"298px",height:"73px"},img:{"float":"left",margin:"12px"},h3:{margin:"0",padding:"10px 0px","font-size":"13px"},p:{margin:"0px 10px","font-size":"12px"}})},show:function(A){var B=this.queue.getLast(),C=window.getScrollTop()+10+(B*83);A.position={top:C+"px",right:"10px",display:"block"};this.queue.push(B+1);this.parent(A)},hide:function(A){this.queue.shift();this.parent(A,{opacity:0})}});Gr0wl.Bezel=Gr0wl.Base.extend({create:function(){this.i=0;this.parent({div:{width:"211px",height:"206px","text-align":"center"},img:{"margin-top":"25px"},h3:{margin:"0",padding:"0px","padding-top":"22px","font-size":"14px"},p:{margin:"15px","font-size":"12px"}})},show:function(A){var C=window.getScrollTop()+(window.getHeight()/2)-105,B=window.getScrollLeft()+(window.getWidth()/2)-103;A.position={top:C+"px",left:B+"px",display:"block"};this.i++;this.chain(this.parent.pass(A,this));if(this.i==1){this.callChain()}},hide:function(A){this.queue.delay(400,this);this.parent(A,{opacity:0,"margin-top":[0,50]})},queue:function(){this.i--;this.callChain()}});Gr0wl.Bezel.implement(new Chain);var Growl=function(A){if(Growl[A.type]){Growl[A.type].call(A)}else{Growl.Smoke(A)}};
/*
 *	Change url image
 *	Example:
	Growl.Smoke({
	title: 'Window.Growl By Daniel Mota',
	text: 'http://icebeat.bitacoras.com',
	image: 'growl.jpg',
	duration: 2
	});
*/
window.addEvent('domready',function() {
	Growl.Bezel = new Gr0wl.Bezel('bezel.png');
	Growl.Smoke = new Gr0wl.Smoke('smoke.png');
});
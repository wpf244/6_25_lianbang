!function(E,e,a,t){var w="ontouchstart"in e,L=w?"touchstart":"mousedown",x=w?"touchmove":"mousemove",M=w?"touchcancel":"mouseup",S=function(e){var t=Math.floor(e/3600),a=Math.floor(e%3600/60),i=Math.ceil(e%3600%60);return(0==t?"":0<t&&t.toString().length<2?"0"+t+":":t+":")+(a.toString().length<2?"0"+a:a)+":"+(i.toString().length<2?"0"+i:i)},V=function(e){var t=a.createElement("audio");return!(!t.canPlayType||!t.canPlayType("audio/"+e.split(".").pop().toLowerCase()+";").replace(/no/,""))};E.fn.audioPlayer=function(P){P=E.extend({classPrefix:"audioplayer",strPlay:"Play",strPause:"Pause",strVolume:"Volume"},P);var C={},e={playPause:"playpause",playing:"playing",time:"time",timeCurrent:"time-current",timeDuration:"time-duration",bar:"bar",barLoaded:"bar-loaded",barPlayed:"bar-played",volume:"volume",volumeButton:"volume-button",volumeAdjust:"volume-adjust",noVolume:"novolume",mute:"mute",mini:"mini"};for(var t in e)C[t]=P.classPrefix+"-"+e[t];return this.each(function(){if("audio"!=E(this).prop("tagName").toLowerCase())return!1;var e=E(this),t=e.attr("src"),a=""===(a=e.get(0).getAttribute("autoplay"))||"autoplay"===a,i=""===(i=e.get(0).getAttribute("loop"))||"loop"===i,n=!1;void 0===t?e.find("source").each(function(){if(void 0!==(t=E(this).attr("src"))&&V(t))return!(n=!0)}):V(t)&&(n=!0);var o=E('<div class="'+P.classPrefix+'">'+(n?E("<div>").append(e.eq(0).clone()).html():'<embed src="'+t+'" width="0" height="0" volume="100" autostart="'+a.toString()+'" loop="'+i.toString()+'" />')+'<div class="'+C.playPause+'" title="'+P.strPlay+'"><a href="#">'+P.strPlay+"</a></div></div>"),u=(u=n?o.find("audio"):o.find("embed")).get(0);if(n){o.find("audio").css({width:0,height:0,visibility:"hidden"}),o.append('<div class="'+C.time+" "+C.timeCurrent+'"></div><div class="'+C.bar+'"><div class="'+C.barLoaded+'"></div><div class="'+C.barPlayed+'"></div></div><div class="'+C.time+" "+C.timeDuration+'"></div><div class="'+C.volume+'"><div class="'+C.volumeButton+'" title="'+P.strVolume+'"><a href="#">'+P.strVolume+'</a></div><div class="'+C.volumeAdjust+'"><div><div></div></div></div></div>');var l=o.find("."+C.bar),d=o.find("."+C.barPlayed),r=o.find("."+C.barLoaded),s=o.find("."+C.timeCurrent),v=o.find("."+C.timeDuration),m=o.find("."+C.volumeButton),c=o.find("."+C.volumeAdjust+" > div"),f=0,h=function(e){theRealEvent=w?e.originalEvent.touches[0]:e,u.currentTime=Math.round(u.duration*(theRealEvent.pageX-l.offset().left)/l.width())},p=function(e){theRealEvent=w?e.originalEvent.touches[0]:e,u.volume=Math.abs((theRealEvent.pageY-(c.offset().top+c.height()))/c.height())},g=setInterval(function(){0<u.buffered.length&&(0<u.duration&&r.width(u.buffered.end(0)/u.duration*100+"%"),u.buffered.end(0)>=u.duration&&clearInterval(g))},100),y=u.volume,b=u.volume=.111;Math.round(1e3*u.volume)/1e3==b?u.volume=y:o.addClass(C.noVolume),v.html("&hellip;"),s.text(S(0)),u.addEventListener("loadeddata",function(){v.text(S(u.duration)),c.find("div").height(100*u.volume+"%"),f=u.volume}),u.addEventListener("timeupdate",function(){s.text(S(u.currentTime)),d.width(u.currentTime/u.duration*100+"%")}),u.addEventListener("volumechange",function(){c.find("div").height(100*u.volume+"%"),0<u.volume&&o.hasClass(C.mute)&&o.removeClass(C.mute),u.volume<=0&&!o.hasClass(C.mute)&&o.addClass(C.mute)}),u.addEventListener("ended",function(){o.removeClass(C.playing)}),l.on(L,function(e){h(e),l.on(x,function(e){h(e)})}).on(M,function(){l.unbind(x)}),m.on("click",function(){return o.hasClass(C.mute)?(o.removeClass(C.mute),u.volume=f):(o.addClass(C.mute),f=u.volume,u.volume=0),!1}),c.on(L,function(e){p(e),c.on(x,function(e){p(e)})}).on(M,function(){c.unbind(x)})}else o.addClass(C.mini);a&&o.addClass(C.playing),o.find("."+C.playPause).on("click",function(){return o.hasClass(C.playing)?(E(this).attr("title",P.strPlay).find("a").html(P.strPlay),o.removeClass(C.playing),n?u.pause():u.Stop()):(E(this).attr("title",P.strPause).find("a").html(P.strPause),o.addClass(C.playing),n?u.play():u.Play()),!1}),e.replaceWith(o)}),this}}(jQuery,window,document);
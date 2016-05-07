!function(a){a.module('dragonSearch',['ui.select','ngSanitize','angular-md5','angularMoment','l42y.sprintf']).config(['uiSelectConfig',function(a){a.appendToBody=!1,a.resetSearchInput=!0,a.searchEnabled=!0,a.theme='select2'}]).controller('BreedingHintsController',['$http','timeTweak',function(a){var b=this;b.hints=[],b.dragonBoxes=[],a.get('../php/ajax.php',{params:{request:'breedInit'}}).then(function(a){b.names=a.data}),b.requestHint=function(c){return a.get('../php/ajax.php',{params:{request:'breed',id:c||b.dragon.id,reduced:b.reduced,displayDays:b.displayDays}}).then(function(a){b.hints.unshift(a.data),b.dragonBoxes.push(a.data),a.data.parent1&&b.dragonBoxes.push(a.data.parent1),a.data.parent2&&b.dragonBoxes.push(a.data.parent2)})},b.startsWith=function(a,b){return b?(a=a.toLowerCase(),b=b.toLowerCase(),0===a.indexOf(b)):!0},b.setReduced=function(a){return b.reduced=a,this},b.setDisplayDays=function(a){return b.displayDays=a,this},b.isBasicBreedingRule=function(a){return!(a.notes||a.breedElems||a.parent1||a.parent2)}}]).service('timeTweak',['sprintfFilter','moment',function(a,b){var c='%02d:%02d:%02d:%02d',d='%02d:%02d:%02d',e=function(a){return b.isDuration(a)?a:('string'==typeof a&&a.length>8&&(a=a.replace(':','.')),b.duration(a))},f=function(b,f){b=e(b);var g=b.asDays();return f&&g>=1?a(c,g,b.hours(),b.minutes(),b.seconds()):a(d,b.asHours(),b.minutes(),b.seconds())},g=function(a,c,d){return f(b.duration(e(a).asMilliseconds()*c),d)};this.putDays=function(a){return f(a,!0)},this.convertDays=function(a){return f(a,!1)},this.reduce=function(a,b){return g(a,.8,b)},this.increase=function(a,b){return g(a,1.25,b)}}]).component('timeTweakBox',{controllerAs:'model',templateUrl:'../html/time-tweak-box.html',bindings:{dragons:'<',onReduChange:'&',onDdChange:'&'},controller:['timeTweak',function(b){this.reduced=!1,this.displayDays=!1,this.onReduChange({redu:this.reduced}),this.onDdChange({dd:this.displayDays}),this.tweakTimes=function(){var c=this.reduced?'reduce':'increase';a.forEach(this.dragons,function(a){a.time=b[c](a.time,this.displayDays)}.bind(this))},this.toggleFormat=function(){var c=this.displayDays?'putDays':'convertDays';a.forEach(this.dragons,function(a){a.time=b[c](a.time)})}}]}).service('image',['md5','moment',function(a,b){var c='//vignette3.wikia.nocookie.net/dragonvale/images',d=['Winter','Spring','Summer','Autumn'],e=function(a){return a instanceof b||(a=b()),d[a.quarter()-1]},f={Snowflake:function(a,b){return this.getImg(b+'DragonAdult'+a.slice(-1)+'.png')}.bind(this),Seasonal:function(a){return this.getImg(e(a)+'SeasonalDragonAdult.png')}.bind(this)};f.Monolith=f.Snowflake;var g=function(a){var b=a.match(/(Seasonal|Snowflake|Monolith)/);return b?b[0]:a};this.getImg=function(b){b=b.replace(/ /g,'');var d=a.createHash(b);return[c,d[0],d.substr(0,2),b].join('/')},this.getEggImg=function(a){return this.getImg(g(a)+'DragonEgg.png')},this.getDragonImg=function(a){var b=g(a);return f[b]?f[b](a,b):this.getImg(a+'DragonAdult.png')},this.getElemFlagImg=function(a){return this.getImg(a+'_Flag.png')}}]).component('dragonBox',{controllerAs:'model',templateUrl:'../html/dragon-box.html',bindings:{dragon:'<',onClick:'&'},controller:['image',function(b){this.eggImgURL=b.getEggImg(this.dragon.name),this.dragonImgURL=b.getDragonImg(this.dragon.name),this.elemsImgsURLs=[],a.forEach(this.dragon.elems,function(a){this.elemsImgsURLs.push(b.getElemFlagImg(a))}.bind(this))}]}).component('elemBox',{controllerAs:'model',templateUrl:'../html/elem-box.html',bindings:{name:'<'},controller:['image',function(a){this.imgURL=a.getElemFlagImg(this.name)}]})}(angular);
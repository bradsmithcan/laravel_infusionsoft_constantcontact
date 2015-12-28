var module;var countdown=(function(module){'use strict';var MILLISECONDS=0x001;var SECONDS=0x002;var MINUTES=0x004;var HOURS=0x008;var DAYS=0x010;var WEEKS=0x020;var MONTHS=0x040;var YEARS=0x080;var DECADES=0x100;var CENTURIES=0x200;var MILLENNIA=0x400;var DEFAULTS=YEARS|MONTHS|DAYS|HOURS|MINUTES|SECONDS;var MILLISECONDS_PER_SECOND=1000;var SECONDS_PER_MINUTE=60;var MINUTES_PER_HOUR=60;var HOURS_PER_DAY=24;var MILLISECONDS_PER_DAY=HOURS_PER_DAY*MINUTES_PER_HOUR*SECONDS_PER_MINUTE*MILLISECONDS_PER_SECOND;var DAYS_PER_WEEK=7;var MONTHS_PER_YEAR=12;var YEARS_PER_DECADE=10;var DECADES_PER_CENTURY=10;var CENTURIES_PER_MILLENNIUM=10;var ceil=Math.ceil;var floor=Math.floor;function borrowMonths(ref,shift){var prevTime=ref.getTime();ref.setMonth(ref.getMonth()+ shift);return Math.round((ref.getTime()- prevTime)/ MILLISECONDS_PER_DAY );
}
function daysPerMonth(ref){var a=ref.getTime();var b=new Date(a);b.setMonth(ref.getMonth()+ 1);return Math.round((b.getTime()- a)/ MILLISECONDS_PER_DAY );
}
function daysPerYear(ref){var a=ref.getTime();var b=new Date(a);b.setFullYear(ref.getFullYear()+ 1);return Math.round((b.getTime()- a)/ MILLISECONDS_PER_DAY );
}
function addToDate(ts,date){date=(date instanceof Date)||((date!==null)&&isFinite(date))?new Date(+date):new Date();if(!ts){return date;}
var value=+ts.value||0;if(value){date.setTime(date.getTime()+ value);return date;}
value=+ts.milliseconds||0;if(value){date.setMilliseconds(date.getMilliseconds()+ value);}
value=+ts.seconds||0;if(value){date.setSeconds(date.getSeconds()+ value);}
value=+ts.minutes||0;if(value){date.setMinutes(date.getMinutes()+ value);}
value=+ts.hours||0;if(value){date.setHours(date.getHours()+ value);}
value=+ts.weeks||0;if(value){value*=DAYS_PER_WEEK;}
value+=+ts.days||0;if(value){date.setDate(date.getDate()+ value);}
value=+ts.months||0;if(value){date.setMonth(date.getMonth()+ value);}
value=+ts.millennia||0;if(value){value*=CENTURIES_PER_MILLENNIUM;}
value+=+ts.centuries||0;if(value){value*=DECADES_PER_CENTURY;}
value+=+ts.decades||0;if(value){value*=YEARS_PER_DECADE;}
value+=+ts.years||0;if(value){date.setFullYear(date.getFullYear()+ value);}
return date;}
var LABEL_MILLISECONDS=0;var LABEL_SECONDS=1;var LABEL_MINUTES=2;var LABEL_HOURS=3;var LABEL_DAYS=4;var LABEL_WEEKS=5;var LABEL_MONTHS=6;var LABEL_YEARS=7;var LABEL_DECADES=8;var LABEL_CENTURIES=9;var LABEL_MILLENNIA=10;var LABELS_SINGLUAR;var LABELS_DVOJINA;var LABELS_3IN4;var LABELS_PLURAL;var LABEL_LAST;var LABEL_DELIM;var LABEL_NOW;var formatNumber;function plurality(value,unit){return formatNumber(value)+((value===1)?LABELS_SINGLUAR[unit]:((value===2)?LABELS_DVOJINA[unit]:(((value===3)||(value===4))?LABELS_3IN4[unit]:LABELS_PLURAL[unit])));}
var formatList;function Timespan(){}
Timespan.prototype.toString=function(emptyLabel){var label=formatList(this);var count=label.length;if(!count){return emptyLabel?''+emptyLabel:LABEL_NOW;}
if(count===1){return label[0];}
var last=LABEL_LAST+label.pop();return label.join(LABEL_DELIM)+last;};Timespan.prototype.toHTML=function(tag,emptyLabel){tag=tag||'span';var label=formatList(this);var count=label.length;if(!count){emptyLabel=emptyLabel||LABEL_NOW;return emptyLabel?'<'+tag+'>'+emptyLabel+'</'+tag+'>':emptyLabel;}
for(var i=0;i<count;i++){label[i]='<'+tag+'>'+label[i]+'</'+tag+'>';}
if(count===1){return label[0];}
var last=LABEL_LAST+label.pop();return label.join(LABEL_DELIM)+last;};Timespan.prototype.addTo=function(date){return addToDate(this,date);};formatList=function(ts){var list=[];var value=ts.millennia;if(value){list.push(plurality(value,LABEL_MILLENNIA));}
value=ts.centuries;if(value){list.push(plurality(value,LABEL_CENTURIES));}
value=ts.decades;if(value){list.push(plurality(value,LABEL_DECADES));}
value=ts.years;if(value){list.push(plurality(value,LABEL_YEARS));}
value=ts.months;if(value){list.push(plurality(value,LABEL_MONTHS));}
value=ts.weeks;if(value){list.push(plurality(value,LABEL_WEEKS));}
value=ts.days;if(value){list.push(plurality(value,LABEL_DAYS));}
value=ts.hours;if(value){list.push(plurality(value,LABEL_HOURS));}
value=ts.minutes;if(value){list.push(plurality(value,LABEL_MINUTES));}
value=ts.seconds;if(value){list.push(plurality(value,LABEL_SECONDS));}
value=ts.milliseconds;if(value){list.push(plurality(value,LABEL_MILLISECONDS));}
return list;};function rippleRounded(ts,toUnit){switch(toUnit){case'seconds':if(ts.seconds!==SECONDS_PER_MINUTE||isNaN(ts.minutes)){return;}
ts.minutes++;ts.seconds=0;case'minutes':if(ts.minutes!==MINUTES_PER_HOUR||isNaN(ts.hours)){return;}
ts.hours++;ts.minutes=0;case'hours':if(ts.hours!==HOURS_PER_DAY||isNaN(ts.days)){return;}
ts.days++;ts.hours=0;case'days':if(ts.days!==DAYS_PER_WEEK||isNaN(ts.weeks)){return;}
ts.weeks++;ts.days=0;case'weeks':if(ts.weeks!==daysPerMonth(ts.refMonth)/DAYS_PER_WEEK || isNaN(ts.months)) {
return;}
ts.months++;ts.weeks=0;case'months':if(ts.months!==MONTHS_PER_YEAR||isNaN(ts.years)){return;}
ts.years++;ts.months=0;case'years':if(ts.years!==YEARS_PER_DECADE||isNaN(ts.decades)){return;}
ts.decades++;ts.years=0;case'decades':if(ts.decades!==DECADES_PER_CENTURY||isNaN(ts.centuries)){return;}
ts.centuries++;ts.decades=0;case'centuries':if(ts.centuries!==CENTURIES_PER_MILLENNIUM||isNaN(ts.millennia)){return;}
ts.millennia++;ts.centuries=0;}}
function fraction(ts,frac,fromUnit,toUnit,conversion,digits){if(ts[fromUnit]>=0){frac+=ts[fromUnit];delete ts[fromUnit];}
frac/=conversion;if(frac+ 1<=1){return 0;}
if(ts[toUnit]>=0){ts[toUnit]=+(ts[toUnit]+ frac).toFixed(digits);rippleRounded(ts,toUnit);return 0;}
return frac;}
function fractional(ts,digits){var frac=fraction(ts,0,'milliseconds','seconds',MILLISECONDS_PER_SECOND,digits);if(!frac){return;}
frac=fraction(ts,frac,'seconds','minutes',SECONDS_PER_MINUTE,digits);if(!frac){return;}
frac=fraction(ts,frac,'minutes','hours',MINUTES_PER_HOUR,digits);if(!frac){return;}
frac=fraction(ts,frac,'hours','days',HOURS_PER_DAY,digits);if(!frac){return;}
frac=fraction(ts,frac,'days','weeks',DAYS_PER_WEEK,digits);if(!frac){return;}
frac=fraction(ts,frac,'weeks','months',daysPerMonth(ts.refMonth)/DAYS_PER_WEEK, digits);
if(!frac){return;}
frac=fraction(ts,frac,'months','years',daysPerYear(ts.refMonth)/daysPerMonth(ts.refMonth), digits);
if(!frac){return;}
frac=fraction(ts,frac,'years','decades',YEARS_PER_DECADE,digits);if(!frac){return;}
frac=fraction(ts,frac,'decades','centuries',DECADES_PER_CENTURY,digits);if(!frac){return;}
frac=fraction(ts,frac,'centuries','millennia',CENTURIES_PER_MILLENNIUM,digits);if(frac){throw new Error('Fractional unit overflow');}}
function ripple(ts){var x;if(ts.milliseconds<0){x=ceil(-ts.milliseconds/MILLISECONDS_PER_SECOND);ts.seconds-=x;ts.milliseconds+=x*MILLISECONDS_PER_SECOND;}else if(ts.milliseconds>=MILLISECONDS_PER_SECOND){ts.seconds+=floor(ts.milliseconds/MILLISECONDS_PER_SECOND);ts.milliseconds%=MILLISECONDS_PER_SECOND;}
if(ts.seconds<0){x=ceil(-ts.seconds/SECONDS_PER_MINUTE);ts.minutes-=x;ts.seconds+=x*SECONDS_PER_MINUTE;}else if(ts.seconds>=SECONDS_PER_MINUTE){ts.minutes+=floor(ts.seconds/SECONDS_PER_MINUTE);ts.seconds%=SECONDS_PER_MINUTE;}
if(ts.minutes<0){x=ceil(-ts.minutes/MINUTES_PER_HOUR);ts.hours-=x;ts.minutes+=x*MINUTES_PER_HOUR;}else if(ts.minutes>=MINUTES_PER_HOUR){ts.hours+=floor(ts.minutes/MINUTES_PER_HOUR);ts.minutes%=MINUTES_PER_HOUR;}
if(ts.hours<0){x=ceil(-ts.hours/HOURS_PER_DAY);ts.days-=x;ts.hours+=x*HOURS_PER_DAY;}else if(ts.hours>=HOURS_PER_DAY){ts.days+=floor(ts.hours/HOURS_PER_DAY);ts.hours%=HOURS_PER_DAY;}
while(ts.days<0){ts.months--;ts.days+=borrowMonths(ts.refMonth,1);}
if(ts.days>=DAYS_PER_WEEK){ts.weeks+=floor(ts.days/DAYS_PER_WEEK);ts.days%=DAYS_PER_WEEK;}
if(ts.months<0){x=ceil(-ts.months/MONTHS_PER_YEAR);ts.years-=x;ts.months+=x*MONTHS_PER_YEAR;}else if(ts.months>=MONTHS_PER_YEAR){ts.years+=floor(ts.months/MONTHS_PER_YEAR);ts.months%=MONTHS_PER_YEAR;}
if(ts.years>=YEARS_PER_DECADE){ts.decades+=floor(ts.years/YEARS_PER_DECADE);ts.years%=YEARS_PER_DECADE;if(ts.decades>=DECADES_PER_CENTURY){ts.centuries+=floor(ts.decades/DECADES_PER_CENTURY);ts.decades%=DECADES_PER_CENTURY;if(ts.centuries>=CENTURIES_PER_MILLENNIUM){ts.millennia+=floor(ts.centuries/CENTURIES_PER_MILLENNIUM);ts.centuries%=CENTURIES_PER_MILLENNIUM;}}}}
function pruneUnits(ts,units,max,digits){var count=0;if(!(units&MILLENNIA)||(count>=max)){ts.centuries+=ts.millennia*CENTURIES_PER_MILLENNIUM;delete ts.millennia;}else if(ts.millennia){count++;}
if(!(units&CENTURIES)||(count>=max)){ts.decades+=ts.centuries*DECADES_PER_CENTURY;delete ts.centuries;}else if(ts.centuries){count++;}
if(!(units&DECADES)||(count>=max)){ts.years+=ts.decades*YEARS_PER_DECADE;delete ts.decades;}else if(ts.decades){count++;}
if(!(units&YEARS)||(count>=max)){ts.months+=ts.years*MONTHS_PER_YEAR;delete ts.years;}else if(ts.years){count++;}
if(!(units&MONTHS)||(count>=max)){if(ts.months){ts.days+=borrowMonths(ts.refMonth,ts.months);}
delete ts.months;if(ts.days>=DAYS_PER_WEEK){ts.weeks+=floor(ts.days/DAYS_PER_WEEK);ts.days%=DAYS_PER_WEEK;}}else if(ts.months){count++;}
if(!(units&WEEKS)||(count>=max)){ts.days+=ts.weeks*DAYS_PER_WEEK;delete ts.weeks;}else if(ts.weeks){count++;}
if(!(units&DAYS)||(count>=max)){ts.hours+=ts.days*HOURS_PER_DAY;delete ts.days;}else if(ts.days){count++;}
if(!(units&HOURS)||(count>=max)){ts.minutes+=ts.hours*MINUTES_PER_HOUR;delete ts.hours;}else if(ts.hours){count++;}
if(!(units&MINUTES)||(count>=max)){ts.seconds+=ts.minutes*SECONDS_PER_MINUTE;delete ts.minutes;}else if(ts.minutes){count++;}
if(!(units&SECONDS)||(count>=max)){ts.milliseconds+=ts.seconds*MILLISECONDS_PER_SECOND;delete ts.seconds;}else if(ts.seconds){count++;}
if(!(units&MILLISECONDS)||(count>=max)){fractional(ts,digits);}}
function populate(ts,start,end,units,max,digits){var now=new Date();ts.start=start=start||now;ts.end=end=end||now;ts.units=units;ts.value=end.getTime()- start.getTime();if(ts.value<0){var tmp=end;end=start;start=tmp;}
ts.refMonth=new Date(start.getFullYear(),start.getMonth(),15,12,0,0);try{ts.millennia=0;ts.centuries=0;ts.decades=0;ts.years=end.getFullYear()- start.getFullYear();ts.months=end.getMonth()- start.getMonth();ts.weeks=0;ts.days=end.getDate()- start.getDate();ts.hours=end.getHours()- start.getHours();ts.minutes=end.getMinutes()- start.getMinutes();ts.seconds=end.getSeconds()- start.getSeconds();ts.milliseconds=end.getMilliseconds()- start.getMilliseconds();ripple(ts);pruneUnits(ts,units,max,digits);}finally{delete ts.refMonth;}
return ts;}
function getDelay(units){if(units&MILLISECONDS){return MILLISECONDS_PER_SECOND/30;}
if(units&SECONDS){return MILLISECONDS_PER_SECOND;}
if(units&MINUTES){return MILLISECONDS_PER_SECOND*SECONDS_PER_MINUTE;}
if(units&HOURS){return MILLISECONDS_PER_SECOND*SECONDS_PER_MINUTE*MINUTES_PER_HOUR;}
if(units&DAYS){return MILLISECONDS_PER_SECOND*SECONDS_PER_MINUTE*MINUTES_PER_HOUR*HOURS_PER_DAY;}
return MILLISECONDS_PER_SECOND*SECONDS_PER_MINUTE*MINUTES_PER_HOUR*HOURS_PER_DAY*DAYS_PER_WEEK;}
function countdown(start,end,units,max,digits){var callback;units=+units||DEFAULTS;max=(max>0)?max:NaN;digits=(digits>0)?(digits<20)?Math.round(digits):20:0;var startTS=null;if('function'===typeof start){callback=start;start=null;}else if(!(start instanceof Date)){if((start!==null)&&isFinite(start)){start=new Date(+start);}else{if('object'===typeof startTS){startTS=(start);}
start=null;}}
var endTS=null;if('function'===typeof end){callback=end;end=null;}else if(!(end instanceof Date)){if((end!==null)&&isFinite(end)){end=new Date(+end);}else{if('object'===typeof end){endTS=(end);}
end=null;}}
if(startTS){start=addToDate(startTS,end);}
if(endTS){end=addToDate(endTS,start);}
if(!start&&!end){return new Timespan();}
if(!callback){return populate(new Timespan(),(start),(end),(units),(max),(digits));}
var delay=getDelay(units),timerId,fn=function(){callback(populate(new Timespan(),(start),(end),(units),(max),(digits)),timerId);};fn();return(timerId=setInterval(fn,delay));}
countdown.MILLISECONDS=MILLISECONDS;countdown.SECONDS=SECONDS;countdown.MINUTES=MINUTES;countdown.HOURS=HOURS;countdown.DAYS=DAYS;countdown.WEEKS=WEEKS;countdown.MONTHS=MONTHS;countdown.YEARS=YEARS;countdown.DECADES=DECADES;countdown.CENTURIES=CENTURIES;countdown.MILLENNIA=MILLENNIA;countdown.DEFAULTS=DEFAULTS;countdown.ALL=MILLENNIA|CENTURIES|DECADES|YEARS|MONTHS|WEEKS|DAYS|HOURS|MINUTES|SECONDS|MILLISECONDS;countdown.setLabels=function(singular,dvojina,tri4,plural,last,delim,empty,formatter){singular=singular||[];if(singular.split){singular=singular.split('|');}
dvojina=dvojina||[];if(dvojina.split){dvojina=dvojina.split('|');}
tri4=tri4||[];if(tri4.split){tri4=tri4.split('|');}
plural=plural||[];if(plural.split){plural=plural.split('|');}
for(var i=LABEL_MILLISECONDS;i<=LABEL_MILLENNIA;i++){LABELS_SINGLUAR[i]=singular[i]||LABELS_SINGLUAR[i];LABELS_DVOJINA[i]=dvojina[i]||LABELS_DVOJINA[i];LABELS_3IN4[i]=tri4[i]||LABELS_3IN4[i];LABELS_PLURAL[i]=plural[i]||LABELS_PLURAL[i];}
LABEL_LAST=('string'===typeof last)?last:LABEL_LAST;LABEL_DELIM=('string'===typeof delim)?delim:LABEL_DELIM;LABEL_NOW=('string'===typeof empty)?empty:LABEL_NOW;formatNumber=('function'===typeof formatter)?formatter:formatNumber;};var resetLabels=countdown.resetLabels=function(){LABELS_SINGLUAR=' milisekunda| sekunda| minuta| ura| dan| teden| mesec| leto| desetletje| stoletje| tisočletje'.split('|');LABELS_DVOJINA=' milisekundi| sekundi| minuti| uri| dneva| tedna| meseca| leti| desetletji| stoletji| tisočletji'.split('|');LABELS_3IN4=' milisekunde| sekunde| minute| ure| dnevi| tedni| meseci| leta| desetletja| stoletja| tisočletja'.split('|');LABELS_PLURAL=' milisekund| sekund| minut| ur| dni| tednov| mesecev| let| desetletij| stoletij| tisočletij'.split('|');LABEL_LAST=' in ';LABEL_DELIM=', ';LABEL_NOW='';formatNumber=function(value){return value;};};resetLabels();if(module&&module.exports){module.exports=countdown;}else if(typeof window.define==='function'&&typeof window.define.amd!=='undefined'){window.define('countdown',[],function(){return countdown;});}
return countdown;})(module);
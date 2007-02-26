
function showLayer(Name) {

        switch (Name) {
        case 'config':
        document.layers.l_export.visibility = "hide";
        document.layers.l_config.visibility = "show";
        document.layers.l_import.visibility = "show";
        break;

        case 'export':

        break;

        case 'import':

        break;
    }

}


function toggleBox(szDivID) {

  if (document.layers) { // NN4+
    if (document.layers[szDivID].visibility == 'visible') {
        document.layers[szDivID].visibility = "hide";
        document.layers[szDivID].display = "none";
        document.layers[szDivID+"SD"].fontWeight = "normal";
    } else {
        document.layers[szDivID].visibility = "show";
        document.layers[szDivID].display = "inline";
    }
  } else if (document.getElementById) { // gecko(NN6) + IE 5+
    var obj = document.getElementById(szDivID);
    if (obj.style.visibility == 'visible') {
        obj.style.visibility = "hidden";
        obj.style.display    = "none";
    } else {
        obj.style.visibility = "visible";
        obj.style.display    = "inline";
    }
  } else if (document.all) { // IE 4
    if (document.all[szDivID].style.visibility == 'visible') {
        document.all[szDivID].style.visibility = "hidden";
        document.all[szDivID].style.display = "none";
    } else {
        document.all[szDivID].style.visibility = "visible";
        document.all[szDivID].style.display = "inline";
    }
  }
}

function SetFocus() {
  if (document.forms.length > 0) {
    var field = document.forms[0];
    for (i=0; i<field.length; i++) {
      if ( (field.elements[i].type != "image") && 
           (field.elements[i].type != "hidden") && 
           (field.elements[i].type != "reset") && 
           (field.elements[i].type != "submit") ) {

        document.forms[0].elements[i].focus();

        if ( (field.elements[i].type == "text") || 
             (field.elements[i].type == "password") )
          document.forms[0].elements[i].select();
        
        break;
      }
    }
  }
}
 
// initialiZe variables... 
var ppcIE=((navigator.appName == "Microsoft Internet Explorer") || ((navigator.appName == "Netscape") && (parseInt(navigator.appVersion)==5)));
var ppcNN6=((navigator.appName == "Netscape") && (parseInt(navigator.appVersion)==5));
//var ppcIE=(navigator.appName == "Microsoft Internet Explorer");
var ppcNN=((navigator.appName == "Netscape")&&(document.layers));
var ppcX = 4;
var ppcY = 4;

var IsCalendarVisible;
var calfrmName;
var maxYearList;
var minYearList;
var todayDate = new Date; 
var curDate = new Date; 
var curImg;
var curDateBox;
var minDate = new Date;
var maxDate = new Date;
var hideDropDowns;
var IsUsingMinMax;
var FuncsToRun;
var img_del;
var img_close;
img_del=new Image();
img_del.src="./images/cal_del_small.gif";
img_close=new Image();
img_close.src="./images/cal_close_small.gif";

minYearList=todayDate.getFullYear()-10;
maxYearList=todayDate.getFullYear()+10;
IsCalendarVisible=false;

img_Date_UP=new Image();
img_Date_UP.src="./images/cal_date_up.gif";

img_Date_OVER=new Image();
img_Date_OVER.src="./images/cal_date_over.gif";

img_Date_DOWN=new Image();
img_Date_DOWN.src="./images/cal_date_down.gif";


function calSwapImg(whatID, NewImg,override) {
    if (document.images) {
     if (!( IsCalendarVisible && override )) {
        document.images[whatID].src = eval(NewImg + ".src");
     }
    }
    window.status=' ';
    return true;
}

function getOffsetLeft (el) {
    var ol = el.offsetLeft;
    while ((el = el.offsetParent) != null)
        ol += el.offsetLeft;
    return ol+130;
}

function getOffsetTop (el) {
    var ot = el.offsetTop;
    while((el = el.offsetParent) != null)
        ot += el.offsetTop;
    return ot-50;
}

function showCalendar(frmName, dteBox,btnImg, hideDrops, MnDt, MnMo, MnYr, MxDt, MxMo, MxYr,runFuncs) {
    hideDropDowns = hideDrops;
    FuncsToRun = runFuncs;
    calfrmName = frmName;
    if (IsCalendarVisible) {
        hideCalendar();
    }
    else {
        if (document.images['calbtn1']!=null ) document.images['calbtn1'].src=img_del.src;
        if (document.images['calbtn2']!=null ) document.images['calbtn2'].src=img_close.src;
        
        if (hideDropDowns) {toggleDropDowns('hidden');}
        if ((MnDt!=null) && (MnMo!=null) && (MnYr!=null) && (MxDt!=null) && (MxMo!=null) && (MxYr!=null)) {
            IsUsingMinMax = true;
            minDate.setDate(MnDt);
            minDate.setMonth(MnMo-1);
            minDate.setFullYear(MnYr);
            maxDate.setDate(MxDt);
            maxDate.setMonth(MxMo-1);
            maxDate.setFullYear(MxYr);
        }
        else {
            IsUsingMinMax = false;
        }
        
        curImg = btnImg;
        curDateBox = dteBox;
        if ( ppcIE ) {
            ppcX = getOffsetLeft(document.images[btnImg]);
            ppcY = getOffsetTop(document.images[btnImg]) + document.images[btnImg].height;
        }
        else if (ppcNN){
            ppcX = document.images[btnImg].x + 90; 
            ppcY = document.images[btnImg].y - 45;
        }

        domlay('popupcalendar',1,ppcX,ppcY,Calendar(todayDate.getMonth(),todayDate.getFullYear()));       

        //domlay('popupcalendar',1,ppcX,ppcY,Calendar(curDate.getMonth(),curDate.getFullYear()));

        IsCalendarVisible = true;
    }
}

function toggleDropDowns(showHow){
    var i; var j;
    for (i=0;i<document.forms.length;i++) {
        for (j=0;j<document.forms[i].elements.length;j++) {
            if (document.forms[i].elements[j].tagName == "SELECT") {
                if (document.forms[i].name != "Cal")
                    document.forms[i].elements[j].style.visibility=showHow;
            }
        }
    }
}

function hideCalendar(){
    domlay('popupcalendar',0,ppcX,ppcY);
    calSwapImg(curImg, 'img_Date_UP');    
    IsCalendarVisible = false;
    if (hideDropDowns) {toggleDropDowns('visible');}
}

function calClick() {
        window.focus();
}

function domlay(id,trigger,lax,lay,content) {
    /*
     * Cross browser Layer visibility / Placement Routine
     * Done by Chris Heilmann (mail@ichwill.net)
     * Feel free to use with these lines included!
     * Created with help from Scott Andrews.
     * The marked part of the content change routine is taken
     * from a script by Reyn posted in the DHTML
     * Forum at Website Attraction and changed to work with
     * any layername. Cheers to that!
     * Welcome DOM-1, about time you got included... :)
     */
    // Layer visible
    if (trigger=="1"){
        if (document.layers) document.layers[''+id+''].visibility = "show"
        else if (document.all) document.all[''+id+''].style.visibility = "visible"
        else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"                
        }
    // Layer hidden
    else if (trigger=="0"){
        if (document.layers) document.layers[''+id+''].visibility = "hide"
        else if (document.all) document.all[''+id+''].style.visibility = "hidden"
        else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"             
        }
    // Set horizontal position  
    if (lax){
        if (document.layers){document.layers[''+id+''].left = lax}
        else if (document.all){document.all[''+id+''].style.left=lax}
        else if (document.getElementById){document.getElementById(''+id+'').style.left=lax+"px"}
        }
    // Set vertical position
    if (lay){
        if (document.layers){document.layers[''+id+''].top = lay}
        else if (document.all){document.all[''+id+''].style.top=lay}
        else if (document.getElementById){document.getElementById(''+id+'').style.top=lay+"px"}
        }
    // change content

    if (content){
    if (document.layers){
        sprite=document.layers[''+id+''].document;
        // add father layers if needed! document.layers[''+father+'']...
        sprite.open();
        sprite.write(content);
        sprite.close();
        }
    else if (document.all) document.all[''+id+''].innerHTML = content;  
    else if (document.getElementById){
        //Thanx Reyn!
        rng = document.createRange();
        el = document.getElementById(''+id+'');
        rng.setStartBefore(el);
        htmlFrag = rng.createContextualFragment(content)
        while(el.hasChildNodes()) el.removeChild(el.lastChild);
        el.appendChild(htmlFrag);
        // end of Reyn ;)
        }
    }
}

function Calendar(whatMonth,whatYear) {
    var output = '';
    var datecolwidth;
    var startMonth;
    var startYear;
    startMonth=whatMonth;
    startYear=whatYear;

    curDate.setMonth(whatMonth);
    curDate.setFullYear(whatYear);
    curDate.setDate(todayDate.getDate());
    if (ppcNN6) {
        output += '<form name="Cal"><table width="185" border="3" class="cal-Table" cellspacing="0" cellpadding="0"><tr>';
    }
    else {
        output += '<table width="185" border="3" class="cal-Table" cellspacing="0" cellpadding="0"><form name="Cal"><tr>';
    }
     
    output += '<td class="cal-HeadCell" align="center" width="100%"><a href="javascript:clearDay();"><img name="calbtn1" src="./images/cal_del_small.gif" border="0" width="12" height="10"></a>&nbsp;&nbsp;<a href="javascript:scrollMonth(-1);" class="cal-DayLink">&lt;</a>&nbsp;<SELECT class="cal-TextBox" NAME="cboMonth" onChange="changeMonth();">';
    for (month=0; month<12; month++) {
        if (month == whatMonth) output += '<OPTION VALUE="' + month + '" SELECTED>' + names[month] + '<\/OPTION>';
        else                output += '<OPTION VALUE="' + month + '">'          + names[month] + '<\/OPTION>';
    }

    output += '<\/SELECT><SELECT class="cal-TextBox" NAME="cboYear" onChange="changeYear();">';

    for (year=minYearList; year<maxYearList; year++) {
        if (year == whatYear) output += '<OPTION VALUE="' + year + '" SELECTED>' + year + '<\/OPTION>';
        else              output += '<OPTION VALUE="' + year + '">'          + year + '<\/OPTION>';
    }

    output += '<\/SELECT>&nbsp;<a href="javascript:scrollMonth(1);" class="cal-DayLink">&gt;</a>&nbsp;&nbsp;<a href="javascript:hideCalendar();"><img name="calbtn2" src="./images/cal_close_small.gif" border="0" width="12" height="10"></a><\/td><\/tr><tr><td width="100%" align="center">';

    firstDay = new Date(whatYear,whatMonth,1);
    startDay = firstDay.getDay();

    if (((whatYear % 4 == 0) && (whatYear % 100 != 0)) || (whatYear % 400 == 0))
         days[1] = 29;
    else
         days[1] = 28;

    output += '<table width="185" cellspacing="1" cellpadding="2" border="0"><tr>';

    for (i=0; i<7; i++) {
        if (i==0 || i==6) {
            datecolwidth="15%"
        }
        else
        {
            datecolwidth="14%"
        }
        output += '<td class="cal-HeadCell" width="' + datecolwidth + '" align="center" valign="middle">'+ dow[i] +'<\/td>';
    }
    
    output += '<\/tr><tr>';

    var column = 0;
    var lastMonth = whatMonth - 1;
    var lastYear = whatYear;
    if (lastMonth == -1) { lastMonth = 11; lastYear=lastYear-1;}

    for (i=0; i<startDay; i++, column++) {
        output += getDayLink((days[lastMonth]-startDay+i+1),true,lastMonth,lastYear);
    }

    for (i=1; i<=days[whatMonth]; i++, column++) {
        output += getDayLink(i,false,whatMonth,whatYear);
        if (column == 6) {
            output += '<\/tr><tr>';
            column = -1;
        }
    }
    
    var nextMonth = whatMonth+1;
    var nextYear = whatYear;
    if (nextMonth==12) { nextMonth=0; nextYear=nextYear+1;}
    
    if (column > 0) {
        for (i=1; column<7; i++, column++) {
            output +=  getDayLink(i,true,nextMonth,nextYear);
        }
        output += '<\/tr><\/table><\/td><\/tr>';
    }
    else {
        output = output.substr(0,output.length-4); // remove the <tr> from the end if there's no last row
        output += '<\/table><\/td><\/tr>';
    }
    
    if (ppcNN6) {
        output += '<\/table><\/form>';
    }
    else {
        output += '<\/form><\/table>';
    }
    curDate.setDate(1);
    curDate.setMonth(startMonth);
    curDate.setFullYear(startYear);
    return output;
}

function getDayLink(linkDay,isGreyDate,linkMonth,linkYear) {
    var templink;
    if (!(IsUsingMinMax)) {
        if (isGreyDate) {
            templink='<td align="center" class="cal-GreyDate">' + linkDay + '<\/td>';
        }
        else {
            if (isDayToday(linkDay)) {
                templink='<td align="center" class="cal-DayCell">' + '<a class="cal-TodayLink" onmouseover="self.status=\' \';return true" href="javascript:changeDay(' + linkDay + ');">' + linkDay + '<\/a>' +'<\/td>';
            }
            else {
                templink='<td align="center" class="cal-DayCell">' + '<a class="cal-DayLink" onmouseover="self.status=\' \';return true" href="javascript:changeDay(' + linkDay + ');">' + linkDay + '<\/a>' +'<\/td>';
            }
        }
    }
    else {
        if (isDayValid(linkDay,linkMonth,linkYear)) {

            if (isGreyDate){
                templink='<td align="center" class="cal-GreyDate">' + linkDay + '<\/td>';
            }
            else {
                if (isDayToday(linkDay)) {
                    templink='<td align="center" class="cal-DayCell">' + '<a class="cal-TodayLink" onmouseover="self.status=\' \';return true" href="javascript:changeDay(' + linkDay + ');">' + linkDay + '<\/a>' +'<\/td>';
                }
                else {
                    templink='<td align="center" class="cal-DayCell">' + '<a class="cal-DayLink" onmouseover="self.status=\' \';return true" href="javascript:changeDay(' + linkDay + ');">' + linkDay + '<\/a>' +'<\/td>';
                }
            }
        }
        else {
            templink='<td align="center" class="cal-GreyInvalidDate">'+ linkDay + '<\/td>';
        }
    }
    return templink;
}

function isDayToday(isDay) {
    if ((curDate.getFullYear() == todayDate.getFullYear()) && (curDate.getMonth() == todayDate.getMonth()) && (isDay == todayDate.getDate())) {
        return true;
    }
    else {
        return false;
    }
}

function isDayValid(validDay, validMonth, validYear){
    
    curDate.setDate(validDay);
    curDate.setMonth(validMonth);
    curDate.setFullYear(validYear);
    
    if ((curDate>=minDate) && (curDate<=maxDate)) {
        return true;
    }
    else {
        return false;
    }
}

function padout(number) { return (number < 10) ? '0' + number : number; }

function clearDay() {
    eval('document.' + calfrmName + '.day.value = \'\'');
    eval('document.' + calfrmName + '.month.value = \'\'');
    eval('document.' + calfrmName + '.year.value = \'\'');
    hideCalendar();
    if (FuncsToRun!=null)
        eval(FuncsToRun); 
}

function changeDay(whatDay) {
    curDate.setDate(whatDay);
//    eval('document.' + calfrmName + '.' + curDateBox + '.value = "'+ padout(curDate.getDate()) + '-' + padout(curDate.getMonth()+1) + '-' + curDate.getFullYear() + '"');
    eval('document.' + calfrmName + '.day.value = "'+ padout(curDate.getDate()) + '"');
    eval('document.' + calfrmName + '.month.value = "'+ padout(curDate.getMonth()+1) + '"');
    eval('document.' + calfrmName + '.year.value = "'+ curDate.getFullYear() + '"');
    hideCalendar();
    if (FuncsToRun!=null)
        eval(FuncsToRun); 
}

function scrollMonth(amount) {
    var monthCheck;
    var yearCheck;
    
    if (ppcIE) {
        monthCheck = document.forms["Cal"].cboMonth.selectedIndex + amount;
    }
    else if (ppcNN) {
        monthCheck = document.popupcalendar.document.forms["Cal"].cboMonth.selectedIndex + amount;    
    }
    if (monthCheck < 0) {
        yearCheck = curDate.getFullYear() - 1;
        if ( yearCheck < minYearList ) {
            yearCheck = minYearList;
            monthCheck = 0;
        }
        else {
            monthCheck = 11;
        }
        curDate.setFullYear(yearCheck);
    }
    else if (monthCheck >11) {
        yearCheck = curDate.getFullYear() + 1;
        if ( yearCheck > maxYearList-1 ) {
            yearCheck = maxYearList-1;
            monthCheck = 11;
        }
        else {
            monthCheck = 0;
        }      
        curDate.setFullYear(yearCheck);
    }
    
    if (ppcIE) {
        curDate.setMonth(document.forms["Cal"].cboMonth.options[monthCheck].value);
    }
    else if (ppcNN) {
        curDate.setMonth(document.popupcalendar.document.forms["Cal"].cboMonth.options[monthCheck].value );
    }
    domlay('popupcalendar',1,ppcX,ppcY,Calendar(curDate.getMonth(),curDate.getFullYear()));
}

function changeMonth() {

    if (ppcIE) {        
        curDate.setMonth(document.forms["Cal"].cboMonth.options[document.forms["Cal"].cboMonth.selectedIndex].value);
        domlay('popupcalendar',1,ppcX,ppcY,Calendar(curDate.getMonth(),curDate.getFullYear()));
    }
    else if (ppcNN) {

        curDate.setMonth(document.popupcalendar.document.forms["Cal"].cboMonth.options[document.popupcalendar.document.forms["Cal"].cboMonth.selectedIndex].value);
        domlay('popupcalendar',1,ppcX,ppcY,Calendar(curDate.getMonth(),curDate.getFullYear()));
    }

}

function changeYear() {
    if (ppcIE) {

        curDate.setFullYear(document.forms["Cal"].cboYear.options[document.forms["Cal"].cboYear.selectedIndex].value);
        domlay('popupcalendar',1,ppcX,ppcY,Calendar(curDate.getMonth(),curDate.getFullYear()));


    }
    else if (ppcNN) {

        curDate.setFullYear(document.popupcalendar.document.forms["Cal"].cboYear.options[document.popupcalendar.document.forms["Cal"].cboYear.selectedIndex].value);
        domlay('popupcalendar',1,ppcX,ppcY,Calendar(curDate.getMonth(),curDate.getFullYear()));
    }

}

function makeArray0() {
    for (i = 0; i<makeArray0.arguments.length; i++)
        this[i] = makeArray0.arguments[i];
}

var names     = new makeArray0('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
var days      = new makeArray0(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var dow       = new makeArray0('S','M','T','W','T','F','S');

//for checking if at least one element is checked
function CheckMultiForm ()
  {
    var ml = document.multi_action_form;
    var len = ml.elements.length;
    for (var i = 0; i < len; i++) 
    {
      var e = ml.elements[i];
      if (e.name == "multi_products[]" || e.name == "multi_categories[]") 
      {
          if (e.checked == true) {
              return true;
          }
      }
    }
    alert('Bitte markieren Sie mindestens ein Element!\nPlease check at least one element!');
    return false;
  }

//for reverting checkboxes
function SwitchCheck ()
  {
    var maf = document.multi_action_form;
    var len = maf.length;
    for (var i = 0; i < len; i++) 
    {
      var e = maf.elements[i];
      if (e.name == "multi_products[]" || e.name == "multi_categories[]") 
      {
          if (e.checked == true) {
              e.checked = false;
          } else {
              e.checked = true;
          }
      }
    }
  }

//for checking all checkboxes
function CheckAll (wert)
  {
    var maf = document.multi_action_form;
    var len = maf.length;
    for (var i = 0; i < len; i++) 
    {
      var e = maf.elements[i];
      if (e.name == "multi_products[]" || e.name == "multi_categories[]") 
      {
        e.checked = wert;
      }
    }
  }
  

//for checking products only
function SwitchProducts ()
  {
    var maf = document.multi_action_form;
    var len = maf.length;
    var flag = false;
    for (var i = 0; i < len; i++) 
    {
      var e = maf.elements[i];
      if (e.name == "multi_products[]") 
      {
          if (flag == false) { 
              if (e.checked == true) { 
                  wert = false; 
              } else { 
                  wert = true; 
              } 
              flag = true; 
          }
          e.checked = wert;
      }
    }
  }

//for checking categories only
function SwitchCategories ()
  {
    var maf = document.multi_action_form;
    var len = maf.length;
    var flag = false;
    for (var i = 0; i < len; i++) 
    {
      var e = maf.elements[i];
      if (e.name == "multi_categories[]") 
      {
          if (flag == false) { 
              if (e.checked == true) { 
                  wert = false; 
              } else { 
                  wert = true; 
              } 
              flag = true; 
          }
          e.checked = wert;
      }
    }
  }   
/*
 * Bazillyo's Spiffy DHTML Popup Calendar Control - version 2.1
 * �2001 S. Ousta 
 * see the included readme.htm file for license information and release notes.
 * 
 * For more information see:
 * http://www.geocities.com/bazillyo/spiffy/calendar/index.htm or
 * http://groups.yahoo.com/group/spiffyDHTML or
 * email me: bazillyo@yahoo.com
 *
 */

// GLOBAL variables
var scImgPath = '/admin/images/';

var scIE=((navigator.appName == "Microsoft Internet Explorer") || ((navigator.appName == "Netscape") && (parseInt(navigator.appVersion)==5)));
var scNN6=((navigator.appName == "Netscape") && (parseInt(navigator.appVersion)==5));
var scNN=((navigator.appName == "Netscape")&&(document.layers));

var img_Del=new Image();
var img_Close=new Image();

img_Del.src= scImgPath +"btn_del_small.gif";
img_Close.src= scImgPath +"btn_close_small.gif";

var scBTNMODE_DEFAULT=0;
var scBTNMODE_CUSTOMBLUE=1;
var scBTNMODE_CALBTN=2;

var focusHack;

/*================================================================================
 * Calendar Manager Object
 *
 * 	the functions:
 * 		isDate(), formatDate(), _isInteger(), _getInt(), and getDateFromFormat()
 * 	are based on ones courtesy of Matt Kruse (mkruse@netexpress.net) http://www.mattkruse.com/javascript/
 * 	with some modifications by myself and Michael Brydon
 *
 */

function spiffyCalManager() {

	this.showHelpAlerts = false;
	this.defaultDateFormat='dd-MMM-yyyy';
	this.lastSelectedDate=new Date();
	this.calendars=new Array();
	this.matchedFormat="";
	this.DefBtnImgPath=scImgPath; //'./js/common/calendar/';

	// methods	 ----------------------------------------------------------------------
	this.getCount= new Function("return this.calendars.length;");

	function addCalendar(objWhatCal) {
		var intIndex = this.calendars.length;
		this.calendars[intIndex] = objWhatCal;
	}
	this.addCalendar=addCalendar;


	function hideAllCalendars(objExceptThisOne) {
		var i=0;
		for (i=0;i<this.calendars.length;i++) {
			if (objExceptThisOne!=this.calendars[i]) {
				this.calendars[i].hide();
			}
		}

	}
	this.hideAllCalendars=hideAllCalendars;

	function swapImg(objWhatCal, strToWhat, blnStick) {
		if (document.images) {
			// this makes it so that the button sticks down when the cal is visible
			if ((!(objWhatCal.visible) || (blnStick))&& (objWhatCal.enabled)) {
				document.images[objWhatCal.btnName].src = eval(objWhatCal.varName+strToWhat + ".src");
			}
		}
		window.status=' ';
	//	return true;
	}
	this.swapImg=swapImg;

	// *** HOLIDAYS ***************************
	
	this.Holidays = new Array("Dec-25","Jul-4", "Feb-14","Mar-17","Oct-31");
	this.HolidaysDesc = new Array("Christmas Day","Independance Day","Valentine's Day","St. Patrick's Day","Halloween");

	//*****************************************
	
	function isHoliday(whatDate) {
		var i=0;var found=-1;
		for (i=0;i<this.Holidays.length;i++) {
			if (whatDate==this.Holidays[i]) {
				found=i;
				break;
			}
		}
		return found;
	}
	this.isHoliday=isHoliday;


	this.AllowedFormats = new Array(
// Days first list
'd.M',
'd-M',
'd/M',

'd.MMM',
'd-MMM',
'd/MMM',

'd.M.yy',
'd-M-yy',
'd/M/yy',

'd.M.yyyy',
'd-M-yyyy',
'd/M/yyyy',

'd.MM.yyyy',
'd-MM-yyyy',
'd/MM/yyyy',

'd.MMM.yy',
'd-MMM-yy',
'd/MMM/yy',

'd.MMM.yyyy',
'd-MMM-yyyy',
'd/MMM/yyyy',

'd.MM.yy',
'd-MM-yy',
'd/MM/yy',

'dd.MM.yy',
'dd-MM-yy',
'dd/MM/yy',

'dd.M.yy',
'dd-M-yy',
'dd/M/yy',

'dd.MM.yyyy',
'dd-MM-yyyy',
'dd/MM/yyyy',

'dd.MMM.yy',
'dd-MMM-yy',
'dd/MMM/yy',

'dd.MMM.yyyy',
'dd-MMM-yyyy',
'dd/MMM/yyyy',

'M.d',
'M-d',
'M/d',

// Months first list

'MMM.d',
'MMM-d',
'MMM/d',

'M.d.yy',
'M-d-yy',
'M/d/yy',

'MM.d.yyyy',
'MM-d-yyyy',
'MM/d/yyyy',

'MMM.d.yy',
'MMM-d-yy',
'MMM/d/yy',

'MMM.d.yyyy',
'MMM-d-yyyy',
'MMM/d/yyyy',

'MM.d.yy',
'MM-d-yy',
'MM/d/yy',

'MM.dd.yy',
'MM-dd-yy',
'MM/dd/yy',

'M.dd.yy',
'M-dd-yy',
'M/dd/yy',

'MM.dd.yyyy',
'MM-dd-yyyy',
'MM/dd/yyyy',

'MMM.dd.yy',
'MMM-dd-yy',
'MMM/dd/yy',

'MMM.dd.yyyy',
'MMM-dd-yyyy',
'MMM/dd/yyyy'

);
	var MONTH_NAMES = new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

	this.lastBoxValidated=null;


	function validateDate(eInput, bRequired, dStartDate, dEndDate){
		var i = 0; var strTemp=''; var formatMatchCount=0; var firstMatchAt=0;var secondMatchAt=0;
		var bOK = false; var bIsEmpty=false;
		var strStart=MONTH_NAMES[dStartDate.getMonth()]+'-'+dStartDate.getDate()+'-'+dStartDate.getFullYear();
		var strEnd=MONTH_NAMES[dEndDate.getMonth()]+'-'+dEndDate.getDate()+'-'+dEndDate.getFullYear();
		var rangeMsg = 'This input box is set up to accept dates between:\n\n   '+
					strStart+'\n\nand\n\n   '+strEnd+'\n\nPlease enter a date no ';

		this.lastBoxValidated=eInput;
		this.matchedFormat="";
		bIsEmpty=(eInput.value=='' || eInput.value==null);
		if (!(bRequired && bIsEmpty)) {
			for(i=0;i<this.AllowedFormats.length;i++){
//alert('checking=eInput.value='+eInput.value+'  this.AllowedFormats[i]='+this.AllowedFormats[i]+'\nisDate='+isDate(eInput.value, this.AllowedFormats[i]));
				if (isDate(eInput.value, this.AllowedFormats[i])==true){
					bOK = true;
					formatMatchCount+=1;
					if (formatMatchCount==1) {firstMatchAt=i;}
					if (formatMatchCount>1) {

						if (this.AllowedFormats[i].substr(0,1)!=this.AllowedFormats[firstMatchAt].substr(0,1)) {
							secondMatchAt=i; break;
						}
						else { // don't count same format with padded zeros as a different format
							formatMatchCount=1;
						}
					}
				}
			}
		}
alert('formatMatchCount='+formatMatchCount);
		if (formatMatchCount>1) {

			if (this.showHelpAlerts) {

				var date1=getDateFromFormat(eInput.value,this.AllowedFormats[firstMatchAt]);
				var choice1 = MONTH_NAMES[date1.getMonth()]+'-'+date1.getDate()+'-'+date1.getFullYear();
				var date2=getDateFromFormat(eInput.value,this.AllowedFormats[secondMatchAt]);
				var choice2 = MONTH_NAMES[date2.getMonth()]+'-'+date2.getDate()+'-'+date2.getFullYear();
				if (date1.getTime()!=date2.getTime()) {
					var Msg='You have entered an ambiguous date.\n\n Click OK for:\n'+ choice1 +'\n\nor Click Cancel for:\n'+choice2;
					if (confirm(Msg)) {
						bOK=true;
					}
					else {
						firstMatchAt=secondMatchAt;
						bOK=true;
						//return false;
					}
					eInput.focus();
					eInput.select();
				}
			}
			else {
				// continue and take first match in list
				bOK=true;
			}
		}
alert('TEST    '+dThis.getDate()+"-"+dThis.getMonth());

		if (bOK==true) {
			eInput.className = "cal-TextBox";
			//Check for Start/End Dates

			if (dStartDate!=null) {
				var dThis = getDateFromFormat(eInput.value,this.AllowedFormats[i]);
				if (dStartDate>dThis){
					eInput.className = "cal-TextBoxInvalid";
					if (this.showHelpAlerts) { alert(rangeMsg + 'earlier than  '+ strStart + '.');}
					eInput.focus();
					eInput.select();
					return false;
				}
			}
			if (dEndDate!=null) {
				var dThis = getDateFromFormat(eInput.value,this.AllowedFormats[i]);
				if (dEndDate<dThis) {
					eInput.className = "cal-TextBoxInvalid";
					if (this.showHelpAlerts) {  alert(rangeMsg +'later than  '+ strEnd + '.');}
					eInput.focus();
					eInput.select();
					return false;
				}
			}
			this.matchedFormat=this.AllowedFormats[firstMatchAt];

			this.lastBoxValidated = null;
		}
		else {

			if (bRequired && bIsEmpty) {
				eInput.className = "cal-TextBoxInvalid";
				if (this.showHelpAlerts) {
					alert('This date field is required.\n\nPlease enter a valid date before proceeding.');
				}
			}
			else {
				if (!bRequired && bIsEmpty) {
					eInput.className = "cal-TextBox";
				}
				else {
					eInput.className = "cal-TextBoxInvalid";
					if (this.showHelpAlerts) {
						for(i=0;i<this.AllowedFormats.length;i++){
							strTemp+=this.AllowedFormats[i]+'\t';
						}
						alert('Please enter a valid date.\n\nExample 01-Jan-2002\n\nValid formats are:\n\n'+strTemp);
					}
				}
			}
			eInput.focus();
			eInput.select();
			focusHack=eInput;

			setTimeout('focusHack.focus();focusHack.select();');
			return false;
		}
	}
	this.validateDate=validateDate;


	function formatDate(eInput, strFormat) {
		//Always called directly following validateDate  - put validate in onchange and format in onblur.
		if(this.matchedFormat!="") {
			var d = getDateFromFormat(eInput.value,this.matchedFormat);
			if(d!=0){
				eInput.value = scFormatDate(d, strFormat);
			}
		}
	}
	this.formatDate=formatDate;

	function isDate(val,format) {
		var date = getDateFromFormat(val,format);
		if (date == 0) { return false; }
		return true;
	}
	this.isDate=isDate;


	function scFormatDate(date,format) {
		format = format+"";
		var result = "";
		var i_format = 0;
		var c = "";
		var token = "";
		var y = date.getFullYear()+"";
		var M = date.getMonth()+1;
		var d = date.getDate();
		var h = date.getHours();
		var m = date.getMinutes();
		var s = date.getSeconds();
		var yyyy,yy,MMM,MM,dd;
		// Convert real date parts into formatted versions
		// Year
		if (y.length < 4) {
			y = y-0+1900;
			}
		y = ""+y;
		yyyy = y;
		yy = y.substring(2,4);
		// Month
		if (M < 10) { MM = "0"+M; }
			else { MM = M; }
		MMM = MONTH_NAMES[M-1+12];
		// Date
		if (d < 10) { dd = "0"+d; }
			else { dd = d; }
		// Now put them all into an object!
		var value = new Object();
		value["yyyy"] = yyyy;
		value["yy"] = yy;
		value["y"] = y;
		value["MMM"] = MMM;
		value["MM"] = MM;
		value["M"] = M;
		value["dd"] = dd;
		value["d"] = d;

		while (i_format < format.length) {
			// Get next token from format string
			c = format.charAt(i_format);
			token = "";
			while ((format.charAt(i_format) == c) && (i_format < format.length)) {
				token += format.charAt(i_format);
				i_format++;
				}
			if (value[token] != null) {
				result = result + value[token];
				}
			else {
				result = result + token;
				}
			}
		return result;
	}
	this.scFormatDate=scFormatDate;

	function _isInteger(val) {
		var digits = "1234567890";
		for (var i=0; i < val.length; i++) {
			if (digits.indexOf(val.charAt(i)) == -1) { return false; }
			}
		return true;
	}

	function _getInt(str,i,minlength,maxlength) {
		for (x=maxlength; x>=minlength; x--) {
			var token = str.substring(i,i+x);
			if (_isInteger(token)) {
				return token;
				}
			}
		return null;
	}

	function getDateFromFormat(val,format) {
		val = val+"";
		format = format+"";
		var i_val = 0;
		var i_format = 0;
		var c = "";
		var token = "";
		var token2= "";
		var x,y;
		var year  = 0;
		var month = 0;
		var date  = 0;
		var bYearProvided = false;
		while (i_format < format.length) {
			// Get next token from format string
			c = format.charAt(i_format);
			token = "";

			while ((format.charAt(i_format) == c) && (i_format < format.length)) {
				token += format.charAt(i_format);
				i_format++;
			}

			// Extract contents of value based on format token
			if (token=="yyyy" || token=="yy" || token=="y") {
				if (token=="yyyy") { x=4;y=4; }// 4-digit year
				if (token=="yy")   { x=2;y=2; }// 2-digit year
				if (token=="y")    { x=2;y=4; }// 2-or-4-digit year
				year = _getInt(val,i_val,x,y);
				bYearProvided = true;
				if (year == null) {
					return 0;
					//Default to current year
				}
				if (year.length != token.length){
					return 0;
				}

				i_val += year.length;
			}
			else if (token=="MMM") { // Month name
				month = 0;
				for (var i=0; i<MONTH_NAMES.length; i++) {
					var month_name = MONTH_NAMES[i];
					if (val.substring(i_val,i_val+month_name.length).toLowerCase() == month_name.toLowerCase()) {
						month = i+1;
						if (month>12) { month -= 12; }
						i_val += month_name.length;
						break;
					}
				}

				if (month == 0) { return 0; }
				if ((month < 1) || (month>12)) {
					return 0
				}
			}
			else if (token=="MM" || token=="M") {
				x=token.length; y=2;
				month = _getInt(val,i_val,x,y);
				if (month == null) { return 0; }
				if ((month < 1) || (month > 12)) { return 0; }
				i_val += month.length;
			}
			else if (token=="dd" || token=="d") {
				x=token.length; y=2;
				date = _getInt(val,i_val,x,y);
				if (date == null) { return 0; }
				if ((date < 1) || (date>31)) { return 0; }
				i_val += date.length;
			}
			else {
				if (val.substring(i_val,i_val+token.length) != token) {
					return 0;
				}
				else {
					i_val += token.length;
				}
			}
		}
		// If there are any trailing characters left in the value, it doesn't match
		if (i_val != val.length) {
			return 0;
		}
		// Is date valid for month?

		if (month == 2) {
			// Check for leap year
			if ( ( (year%4 == 0)&&(year%100 != 0) ) || (year%400 == 0) ) { // leap year
				if (date > 29){ return false; }
			}
			else {
				if (date > 28) { return false; }
			}
		}
		if ((month==4)||(month==6)||(month==9)||(month==11)) {
			if (date > 30) { return false; }
		}

		//JS dates uses 0 based months.
		month = month - 1;

		if (bYearProvided==false) {
			//Default to current
			var dCurrent = new Date();
			year = dCurrent.getFullYear();
		}

		var lYear = parseInt(year);
		if (lYear<=20) {
			year = 2000 + lYear;
		}
		else if (lYear >=21 && lYear<=99) {
			year = 1900 + lYear;
		}

		var newdate = new Date(year,month,date,0,0,0);

		return newdate;
	}
	this.getDateFromFormat=getDateFromFormat;


}



var calMgr = new spiffyCalManager();



//================================================================================
// Calendar Object

function ctlSpiffyCalendarBox(strVarName, strFormName, strTextBoxName, strBtnName, strDefaultValue, intBtnMode) {

	var msNames     = new makeArray0('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	var msDays      = new makeArray0(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	var msDOW       = new makeArray0('S','M','T','W','T','F','S');


	var blnInConstructor=true;
	var img_DateBtn_UP=new Image();
	var img_DateBtn_OVER=new Image();
	var img_DateBtn_DOWN=new Image();
	var img_DateBtn_DISABLED=new Image();

	var strBtnW;
	var strBtnH;
	var strBtnImg;

	var dteToday=new Date;
	var dteCur=new Date;

	var dteMin=new Date;
	var dteMax=new Date;

	var scX=4; // default where to display calendar
	var scY=4;

	// Defaults
	var strDefDateFmt='dd-MMM-yyyy';

	var intDefBtnMode=0;
	var strDefBtnImgPath=calMgr.DefBtnImgPath;
	/* PROPERTIES =============================================================
	 *
	 */
	// Generic Properties
	this.varName=strVarName;
	this.enabled=true;
	this.readonly=false;
	this.focusClick=false;
	this.hideButton=false;
	this.visible=false;
	this.displayLeft=false;
	this.displayTop=false;
	// Name Properties
	this.formName=strFormName;
	this.textBoxName=strTextBoxName;
	this.btnName=strBtnName;
	this.required=false;
	this.x=scX;
	this.y=scY;

	this.imgUp=img_DateBtn_UP;
	this.imgOver=img_DateBtn_OVER;
	this.imgDown=img_DateBtn_DOWN;
	this.imgDisabled=img_DateBtn_DISABLED;

	// look
	this.showWeekends=true;
	this.showHolidays=true;
	this.disableWeekends=false;
	this.disableHolidays=false;

	this.textBoxWidth=160;
	this.textBoxHeight=20;
	this.btnImgWidth=strBtnW;
	this.btnImgHeight=strBtnH;
	if ((intBtnMode==null)||(intBtnMode<0 && intBtnMode>2)) {
		intBtnMode=intDefBtnMode
	}
	switch (intBtnMode) {
		case 0 :
			strBtnImg=strDefBtnImgPath+'btn_date_up.gif';
			img_DateBtn_UP.src=strDefBtnImgPath+'btn_date_up.gif';
			img_DateBtn_OVER.src=strDefBtnImgPath+'btn_date_over.gif';
			img_DateBtn_DOWN.src=strDefBtnImgPath+'btn_date_down.gif';
			img_DateBtn_DISABLED.src=strDefBtnImgPath+'btn_date_disabled.gif';
			strBtnW = '18';
			strBtnH = '20';
			break;
		case 1 :
			strBtnImg=strDefBtnImgPath+'btn_date1_up.gif';
			img_DateBtn_UP.src=strDefBtnImgPath+'btn_date1_up.gif';
			img_DateBtn_OVER.src=strDefBtnImgPath+'btn_date1_over.gif';
			img_DateBtn_DOWN.src=strDefBtnImgPath+'btn_date1_down.gif';
			img_DateBtn_DISABLED.src=strDefBtnImgPath+'btn_date1_disabled.gif';
			strBtnW = '22';
			strBtnH = '17';
			break;
		case 2 :
			strBtnImg=strDefBtnImgPath+'btn_date2_up.gif';
			img_DateBtn_UP.src=strDefBtnImgPath+'btn_date2_up.gif';
			img_DateBtn_OVER.src=strDefBtnImgPath+'btn_date2_over.gif';
			img_DateBtn_DOWN.src=strDefBtnImgPath+'btn_date2_down.gif';
			img_DateBtn_DISABLED.src=strDefBtnImgPath+'btn_date2_disabled.gif';
			strBtnW = '34';
			strBtnH = '21';
			break;
	}
	// Date Properties
	this.dateFormat=strDefDateFmt;
	this.useDateRange=false;

	this.minDate=new Date;
	this.maxDate=new Date(dteToday.getFullYear()+1, dteToday.getMonth(), dteToday.getDate());

	this.minDay = function() {
		return this.minDate.getDate();
	}
	this.minMonth = function() {
		return this.minDate.getMonth();
	}
	this.minYear = function() {
		return this.minDate.getFullYear();
	}

	this.maxDay = function() {
		return this.maxDate.getDate();
	}
	this.maxMonth = function() {
		return this.maxDate.getMonth();
	}
	this.maxYear = function() {
		return this.maxYear.getFullYear();
	}

	function setMinDate(intYear, intMonth, intDay) {
		this.minDate = new Date(intYear, intMonth-1, intDay);
	}
	this.setMinDate=setMinDate;


	function setMaxDate(intYear, intMonth, intDay) {
		this.maxDate = new Date(intYear, intMonth-1, intDay);
	}
	this.setMaxDate=setMaxDate;

	this.minYearChoice=dteToday.getFullYear()-10;
	this.maxYearChoice=dteToday.getFullYear()+10;
	this.textBox= function() {
		if (!blnInConstructor) {
			return eval('document.'+this.formName+'.'+this.textBoxName);
		}
	}

	this.getSelectedDate = function () {
		var strTempVal=''; var objEle;
		if ((typeof this.formName !='undefined') && (typeof this.textBoxName!='undefined')) {
			objEle=eval('document.'+this.formName+'.'+this.textBoxName);
			if (objEle && !blnInConstructor) {
				strTempVal=eval('document.'+this.formName+'.'+this.textBoxName+'.value');
			}
			else {
				strTempVal=strDefaultValue;
			}
		}
		else {
			strTempVal=strDefaultValue;
		}
		return strTempVal;
	}

	function setSelectedDate(strWhat) {
		var strTempVal=''; var objEle;
		eval('document.'+this.formName+'.'+this.textBoxName).value=strWhat;

		if (!calMgr.isDate(quote(strWhat),quote(this.dateFormat))) {
			eval('document.'+this.formName+'.'+this.textBoxName).className = "cal-TextBoxInvalid";
		}
		else {
			eval('document.'+this.formName+'.'+this.textBoxName).className = "cal-TextBox";
		}
	}
	this.setSelectedDate=setSelectedDate;


	function disable() {
		this.hide();
		calMgr.swapImg(this,'.imgDisabled',false);
		this.enabled=false;
		eval('document.'+this.formName+'.'+this.textBoxName).disabled=true;
        eval('document.'+this.formName+'.'+this.textBoxName).className = "cal-TextBoxDisabled";
		if (scNN) {
			eval('document.'+this.formName+'.'+this.textBoxName).onFocus= function() {this.blur();};
		}
	}
	this.disable=disable;

	function enable() {
		this.enabled=true;
		calMgr.swapImg(this,'.imgUp',false);
		eval('document.'+this.formName+'.'+this.textBoxName).disabled=false;
        eval('document.'+this.formName+'.'+this.textBoxName).className = "cal-TextBox";
		if (scNN) {
			eval('document.'+this.formName+'.'+this.textBoxName).onFocus= null;
		}

		if (!calMgr.isDate(quote(this.getSelectedDate()),quote(this.dateFormat))) {
			eval('document.'+this.formName+'.'+this.textBoxName).className = "cal-TextBoxInvalid";
		}
	}
	this.enable=enable;



	// behavior Properties
	this.JStoRunOnSelect='';
	this.JStoRunOnClear='';
	this.JStoRunOnCancel='';
	this.hideCombos=true;


	/* METHODS ===============================================================
	 *
	 */

	function makeCalendar(intWhatMonth,intWhatYear,bViewOnly) {
		if (bViewOnly) {intWhatMonth-=1;}
		var strOutput = '';
		var intStartMonth=intWhatMonth;
		var intStartYear=intWhatYear;
		var intLoop;
		var strTemp='';
		var strDateColWidth;
		var isWE = false;

		dteCur.setMonth(intWhatMonth);
		dteCur.setFullYear(intWhatYear);
		dteCur.setDate(dteToday.getDate());
		dteCur.setHours(0);dteCur.setMinutes(0);dteCur.setSeconds(0);dteCur.setMilliseconds(0);
		if (!(bViewOnly)) {
			strTemp='<form name="spiffyCal">';
		}
		// special case for form not to be inside table in Netscape 6
		if (scNN6) {
			strOutput += strTemp +'<table width="185" border="3" class="cal-Table" cellspacing="0" cellpadding="0"><tr>';
		}
		else {
			strOutput += '<table width="185" border="3" class="cal-Table" cellspacing="0" cellpadding="0">'+strTemp+'<tr>';
		}

		if (!(bViewOnly)) {
			strOutput += '<td class="cal-HeadCell" align="center" width="100%"><a href="javascript:'+this.varName+'.clearDay();"><img name="calbtn1" src="'+strDefBtnImgPath+'btn_del_small.gif" border="0" width="12" height="10"></a>&nbsp;&nbsp;<a href="javascript:'+this.varName+'.scrollMonth(-1);" class="cal-DayLink">&lt;</a>&nbsp;<SELECT class="cal-ComboBox" NAME="cboMonth" onChange="'+this.varName+'.changeMonth();">';


			for (intLoop=0; intLoop<12; intLoop++) {
				if (intLoop == intWhatMonth) strOutput += '<OPTION VALUE="' + intLoop + '" SELECTED>' + msNames[intLoop] + '<\/OPTION>';
				else  strOutput += '<OPTION VALUE="' + intLoop + '">' + msNames[intLoop] + '<\/OPTION>';
			}


			strOutput += '<\/SELECT><SELECT class="cal-ComboBox" NAME="cboYear" onChange="'+this.varName+'.changeYear();">';

			for (intLoop=this.minYearChoice; intLoop<this.maxYearChoice; intLoop++) {
				if (intLoop == intWhatYear) strOutput += '<OPTION VALUE="' + intLoop + '" SELECTED>' + intLoop + '<\/OPTION>';
				else strOutput += '<OPTION VALUE="' + intLoop + '">' + intLoop + '<\/OPTION>';
			}

			strOutput += '<\/SELECT>&nbsp;<a href="javascript:'+this.varName+'.scrollMonth(1);" class="cal-DayLink">&gt;</a>&nbsp;&nbsp;<a href="javascript:'+this.varName+'.hide();"><img name="calbtn2" src="'+strDefBtnImgPath+'btn_close_small.gif" border="0" width="12" height="10"></a><\/td><\/tr><tr><td width="100%" align="center">';
		}
		else {
			strOutput += '<td class="cal-HeadCell" align="center" width="100%">'+msNames[intWhatMonth]+'-'+intWhatYear+'<\/td><\/tr><tr><td width="100%" align="center">';
		}


		firstDay = new Date(intWhatYear,intWhatMonth,1);
		startDay = firstDay.getDay();

		if (((intWhatYear % 4 == 0) && (intWhatYear % 100 != 0)) || (intWhatYear % 400 == 0))
			msDays[1] = 29;
		else
			msDays[1] = 28;

		strOutput += '<table width="185" cellspacing="1" cellpadding="2" border="0"><tr>';
		// Header ROW showing days of week here
		for (intLoop=0; intLoop<7; intLoop++) {
			if (intLoop==0 || intLoop==6) {
				strDateColWidth="15%"
			}
			else
			{
				strDateColWidth="14%"
			}
			strOutput += '<td class="cal-HeadCell" width="' + strDateColWidth + '" align="center" valign="middle">'+ msDOW[intLoop] +'<\/td>';
		}

		strOutput += '<\/tr><tr>';

		var intColumn = 0;
		var intLastMonth = intWhatMonth - 1;
		var intLastYear = intWhatYear;

		if (intLastMonth == -1) { intLastMonth = 11; intLastYear=intLastYear-1;}
		// Show last month's days in first row
		for (intLoop=0; intLoop<startDay; intLoop++, intColumn++) {
			strOutput += this.getDayLink(true,(msDays[intLastMonth]-startDay+intLoop+1),intLastMonth,intLastYear,bViewOnly,isWE);
		}
		// Show this month's days
		for (intLoop=1; intLoop<=msDays[intWhatMonth]; intLoop++, intColumn++) {
			if ((intColumn % 6)==0) {isWE=true } else {isWE=false}
			strOutput += this.getDayLink(false,intLoop,intWhatMonth,intWhatYear,bViewOnly,isWE);
			if (intColumn == 6) {
				strOutput += '<\/tr><tr>';
				intColumn = -1;
			}
		}

		var intNextMonth = intWhatMonth+1;
		var intNextYear = intWhatYear;

		if (intNextMonth==12) { intNextMonth=0; intNextYear=intNextYear+1;}
		// Show next month's days in last row
		if (intColumn > 0) {
			for (intLoop=1; intColumn<7; intLoop++, intColumn++) {
				strOutput +=  this.getDayLink(true,intLoop,intNextMonth,intNextYear,bViewOnly);
			}
			strOutput += '<\/tr><\/table><\/td><\/tr>';
		}
		else {
			strOutput = strOutput.substr(0,strOutput.length-4); // remove the <tr> from the end if there's no last row
			strOutput += '<\/table><\/td><\/tr>';
		}

		if (scNN6) {
			strOutput += '<\/table><\/form>';
		}
		else {
			strOutput += '<\/form><\/table>';
		}
		dteCur.setDate(1);
		dteCur.setHours(0);dteCur.setMinutes(0);dteCur.setSeconds(0);dteCur.setMilliseconds(0);

		dteCur.setMonth(intStartMonth);
		dteCur.setFullYear(intStartYear);

		return strOutput;
	}
	this.makeCalendar=makeCalendar;


	// writeControl -------------------------------------
	//
	function writeControl() {
		var strHold='';
		var strTemp='';
		var strTempMinDate='';
		var strTempMaxDate='';

		// specify whether you can type in the date box and validate them as well
		// or whether you must use the calendar only to select a date
		if (this.readonly) {
			strTemp=' onFocus="this.blur();" readonly ';
		}
		if (this.focusClick) {
			strTemp=' onFocus="'+this.varName+'.show();" ';
		}

		if (!(this.useDateRange)) {
			strTemp+=' onChange="calMgr.validateDate(document.'+this.formName+'.'+this.textBoxName+','+this.varName+'.required);" onBlur="calMgr.formatDate(document.'+this.formName+'.'+this.textBoxName+','+this.varName+'.dateFormat);" ';
		}
		else {
			strTempMinDate=this.minDate.getDate()+'-'+msNames[this.minDate.getMonth()]+'-'+this.minDate.getFullYear();
			strTempMaxDate=this.maxDate.getDate()+'-'+msNames[this.maxDate.getMonth()]+'-'+this.maxDate.getFullYear();
			strTemp+=' onChange="calMgr.validateDate('+'document.'+this.formName+'.'+this.textBoxName+','+this.varName+'.required,'+this.varName+'.minDate,'+this.varName+'.maxDate);" onBlur="calMgr.formatDate(document.'+this.formName+'.'+this.textBoxName+','+this.varName+'.dateFormat);" ';
		}

		strHold='<input class="cal-TextBox" type="text" name="' + this.textBoxName + '"' + strTemp + 'size="12" value="' + this.getSelectedDate() + '">';
		if (!scIE) {
			strTemp=' href="javascript:calClick();return false;" ';
		}
		else {
			strTemp='';
		}
		if ((this.focusClick==false) || (this.focusClick==true && this.hideButton==false))  {
			strHold+='<a class="so-BtnLink"'+strTemp;

			strHold+=' onmouseover="calMgr.swapImg(' + this.varName + ',\'.imgOver\',false);" ';

			strHold+='onmouseout="calMgr.swapImg(' + this.varName + ',\'.imgUp\',false);" ';

			strHold+='onclick="calMgr.swapImg(' + this.varName + ',\'.imgDown\',true);';

	//		strHold+=this.varName+'.show();return false;">';
			strHold+=this.varName+'.show();">';

			strHold+='<img align="absmiddle" border="0" name="' + this.btnName + '" src="' + strBtnImg +'" width="'+ strBtnW +'" height="'+ strBtnH +'"></a>';
		}
		document.write(strHold);
	}
	this.writeControl=writeControl;


	// show -------------------------------------
	//
	function show() {
		var strCurSelDate = calMgr.lastSelectedDate;

		if (!this.enabled) { return }
		calMgr.hideAllCalendars(this);
		if (this.visible) {
			this.hide();
		}
		else {
// put these next 2 lines in when the tiny cal btns seem to randomly disappear
 			if (document.images['calbtn1']!=null ) document.images['calbtn1'].src=img_Del.src;
 			if (document.images['calbtn2']!=null ) document.images['calbtn2'].src=img_Close.src;

			if (this.focusClick==true && this.hideButton==true) {
				//if no dropdown button then use user-provided location for it
				scX=this.x;
				scY=this.y;
			}
			else {
				// get correct position of date btn
				if ( scIE ) {
					if (this.displayLeft) {
						scX = getOffsetLeft(document.images[this.btnName])-192+ document.images[this.btnName].width ;
					}
					else {
						scX = getOffsetLeft(document.images[this.btnName]);
					}
					if (this.displayTop) {
						scY = getOffsetTop(document.images[this.btnName]) -138 ;
					}
					else {
						scY = getOffsetTop(document.images[this.btnName]) + document.images[this.btnName].height + 2;
					}
				}
				else if (scNN){
					if (this.displayLeft) {
						scX = document.images[this.btnName].x - 192+  document.images[this.btnName].width;
					}
					else {
						scX = document.images[this.btnName].x;
					}
					if (this.displayTop) {
						scY = document.images[this.btnName].y -134;
					}
					else {
						scY = document.images[this.btnName].y + document.images[this.btnName].height + 2;
					}
				}
			}
			// hide all combos underneath it
			if (this.hideCombos) {toggleCombos('hidden');}

			// pop calendar up to the correct month and year if there's a date there
			// otherwise pop it up using today's month and year
			if (this.getSelectedDate()==''){
				if (!(dteCur)) {
					domlay('spiffycalendar',1,scX,scY,this.makeCalendar(dteToday.getMonth(),dteToday.getFullYear()));
				}
				else {
					domlay('spiffycalendar',1,scX,scY,this.makeCalendar(dteCur.getMonth(),dteCur.getFullYear()));
				}
			}
			else {
				if (calMgr.isDate(quote(this.getSelectedDate()),quote(this.dateFormat))) {
				    dteCur = calMgr.getDateFromFormat(quote(this.getSelectedDate()),quote(this.dateFormat));
					dteCur.setHours(0);dteCur.setMinutes(0);dteCur.setSeconds(0);dteCur.setMilliseconds(0);

				}
				else {
					dteCur=calMgr.lastSelectedDate;
				}
				domlay('spiffycalendar',1,scX,scY,this.makeCalendar(dteCur.getMonth(),dteCur.getFullYear()));
			}

			this.visible=true;
		}

	}
	this.show=show;


	// hide -------------------------------------
	//
	function hide() {

		domlay('spiffycalendar',0,scX,scY);
		this.visible = false;
		calMgr.swapImg(this,'.imgUp',false);
		if (this.hideCombos) {toggleCombos('visible');}
	}
	this.hide=hide;


	// clearDay -------------------------------------
	//
	function clearDay() {
		eval('document.' + this.formName + '.' + this.textBoxName + '.value = \'\'');
		this.hide();
		if (this.JStoRunOnClear!=null)
			eval(unescape(this.JStoRunOnClear));

		eval('document.'+this.formName+'.'+this.textBoxName).className = "cal-TextBox";
		if (this.required) {
			eval('document.'+this.formName+'.'+this.textBoxName).className = "cal-TextBoxInvalid";
		}
	}
	this.clearDay=clearDay;


	// changeDay -------------------------------------
	//
	function changeDay(intWhatDay) {
		dteCur.setDate(intWhatDay);
		dteCur.setHours(0);dteCur.setMinutes(0);dteCur.setSeconds(0);dteCur.setMilliseconds(0);

		this.textBox().value=calMgr.scFormatDate(dteCur,this.dateFormat);
		this.hide();
		if (this.JStoRunOnSelect!=null)
			eval(unescape(this.JStoRunOnSelect));

		eval('document.'+this.formName+'.'+this.textBoxName).className = "cal-TextBox";

	}
	this.changeDay=changeDay;

	// scrollMonth -------------------------------------
	//
	function scrollMonth(intAmount) {
		var intMonthCheck;
		var intYearCheck;

		if (scIE) {
			intMonthCheck = document.forms["spiffyCal"].cboMonth.selectedIndex + intAmount;
		}
		else if (scNN) {
			intMonthCheck = document.spiffycalendar.document.forms["spiffyCal"].cboMonth.selectedIndex + intAmount;
		}
		if (intMonthCheck < 0) {
			intYearCheck = dteCur.getFullYear() - 1;
			if ( intYearCheck < this.minYearChoice ) {
				intYearCheck = this.minYearChoice;
				intMonthCheck = 0;
			}
			else {
				intMonthCheck = 11;
			}
			dteCur.setFullYear(intYearCheck);
		}
		else if (intMonthCheck >11) {
			intYearCheck = dteCur.getFullYear() + 1;
			if ( intYearCheck > this.maxYearChoice-1 ) {
				intYearCheck = this.maxYearChoice-1;
				intMonthCheck = 11;
			}
			else {
				intMonthCheck = 0;
			}
			dteCur.setFullYear(intYearCheck);
		}

		if (scIE) {
			dteCur.setMonth(document.forms["spiffyCal"].cboMonth.options[intMonthCheck].value);
		}
		else if (scNN) {
			dteCur.setMonth(document.spiffycalendar.document.forms["spiffyCal"].cboMonth.options[intMonthCheck].value );
		}
		domlay('spiffycalendar',1,scX,scY,this.makeCalendar(dteCur.getMonth(),dteCur.getFullYear()));
	}
	this.scrollMonth=scrollMonth;


	// changeMonth -------------------------------------
	//
	function changeMonth() {
		if (scIE) {
			dteCur.setMonth(document.forms["spiffyCal"].cboMonth.options[document.forms["spiffyCal"].cboMonth.selectedIndex].value);
			domlay('spiffycalendar',1,scX,scY,this.makeCalendar(dteCur.getMonth(),dteCur.getFullYear()));
		}
		else if (scNN) {
			dteCur.setMonth(document.spiffycalendar.document.forms["spiffyCal"].cboMonth.options[document.spiffycalendar.document.forms["spiffyCal"].cboMonth.selectedIndex].value);
			domlay('spiffycalendar',1,scX,scY,this.makeCalendar(dteCur.getMonth(),dteCur.getFullYear()));
		}
	}
	this.changeMonth=changeMonth;


	// changeYear -------------------------------------
	//
	function changeYear() {
		if (scIE) {
			dteCur.setFullYear(document.forms["spiffyCal"].cboYear.options[document.forms["spiffyCal"].cboYear.selectedIndex].value);
			domlay('spiffycalendar',1,scX,scY,this.makeCalendar(dteCur.getMonth(),dteCur.getFullYear()));
		}
		else if (scNN) {
			dteCur.setFullYear(document.spiffycalendar.document.forms["spiffyCal"].cboYear.options[document.spiffycalendar.document.forms["spiffyCal"].cboYear.selectedIndex].value);
			domlay('spiffycalendar',1,scX,scY,this.makeCalendar(dteCur.getMonth(),dteCur.getFullYear()));
		}
	}
	this.changeYear=changeYear;

	function getDayLink(blnIsGreyDate,intLinkDay,intLinkMonth,intLinkYear,bViewOnly,isWE) {
		var templink; var tempLinkClass='calDay-Link';
		var tempClass='cal-DayCell';
		var tempDt=''; var isHol=-1; var holTxt='';
		if (isWE==true && this.showWeekends==true) {tempClass='cal-WeekendCell';}
		tempDt=msNames[intLinkMonth]+'-'+intLinkDay;
		if (this.showHolidays) {isHol=calMgr.isHoliday(tempDt); if (isHol!=-1) {holTxt=' title="'+calMgr.HolidaysDesc[isHol]+'"'; tempClass='cal-HolidayCell';}}
		if (!(this.useDateRange)) {
			if (blnIsGreyDate) {
				templink='<td align="center" class="cal-GreyDate">' + intLinkDay + '<\/td>';
			}
			else {
				if (isDayToday(intLinkDay)) {
					if (!(bViewOnly)) {
						templink='<td align="center" class="'+tempClass+'">' + '<a class="cal-TodayLink" '+holTxt+' onmouseover="self.status=\' \';return true" href="javascript:'+this.varName+'.changeDay(' + intLinkDay + ');">' + intLinkDay + '<\/a><\/td>';
					}
					else {
						templink='<td align="center" class="'+tempClass+'"><span class="cal-Today">' + intLinkDay +'<\/span><\/td>';
					}
				}
				else {
					if (!(bViewOnly)) {
						templink='<td align="center" class="'+tempClass+'">' + '<a class="cal-DayLink" '+holTxt+' onmouseover="self.status=\' \';return true" href="javascript:'+this.varName+'.changeDay(' + intLinkDay + ');">' + intLinkDay + '<\/a>' +'<\/td>';
					}
					else {
						templink='<td align="center" class="'+tempClass+'"><span class="cal-Day">' + intLinkDay + '<\/span><\/td>';
					}
				}
			}
		}
		else {
			if (this.isDayValid(intLinkDay,intLinkMonth,intLinkYear)) {

				if (blnIsGreyDate){
					templink='<td align="center" class="cal-GreyDate">' + intLinkDay + '<\/td>';
				}
				else {
					if (isDayToday(intLinkDay)) {
						if (!(bViewOnly)) {
							templink='<td align="center" class="'+tempClass+'">' + '<a class="cal-TodayLink" '+holTxt+' onmouseover="self.status=\' \';return true" href="javascript:'+this.varName+'.changeDay(' + intLinkDay + ');">' + intLinkDay + '<\/a>' +'<\/td>';
						}
						else {
							templink='<td align="center" class="'+tempClass+'"><span class="cal-Today">' + intLinkDay + '<\/span><\/td>';
						}
					}
					else {
						if (!(bViewOnly)) {
							templink='<td align="center" class="'+tempClass+'">' + '<a class="cal-DayLink" '+holTxt+' onmouseover="self.status=\' \';return true" href="javascript:'+this.varName+'.changeDay(' + intLinkDay + ');">' + intLinkDay + '<\/a>' +'<\/td>';
						}
						else {
							templink='<td align="center" class="'+tempClass+'"><span class="cal-Day">' +  intLinkDay  +'<\/span><\/td>';
						}
					}
				}
			}
			else {
				templink='<td align="center" class="cal-GreyInvalidDate">'+ intLinkDay + '<\/td>';
			}
		}
		return templink;
	}
	this.getDayLink=getDayLink;


	// EXTRA Private FUNCTIONS ===============================================================

	function toggleCombos(showHow){
		var i; var j;
		var cboX; var cboY;
		for (i=0;i<document.forms.length;i++) {
			for (j=0;j<document.forms[i].elements.length;j++) {
				if (document.forms[i].elements[j].tagName == "SELECT") {
					if (document.forms[i].name != "spiffyCal") {
						cboX = getOffsetLeft(document.forms[i].elements[j]);
						cboY = getOffsetTop(document.forms[i].elements[j]);
							if ( ((cboX>=scX-15) && (cboX<=scX+200)) && ((cboY>=scY-15) && (cboY<=scY+145)) )
								document.forms[i].elements[j].style.visibility=showHow;
							//Check for right hand side overlapping.
							cboX = cboX + parseInt(document.forms[i].elements[j].style.width);
							cboY=cboY+15;//cbo height (default)
							if ( ((cboX>=scX+15) && (cboX<=scX+200)) && ((cboY>=scY-15) && (cboY<=scY+145)) )
								document.forms[i].elements[j].style.visibility=showHow;
					}
				}
			}
		}
	}



	function isDayToday(intWhatDay) {
		if ((dteCur.getFullYear() == dteToday.getFullYear()) && (dteCur.getMonth() == dteToday.getMonth()) && (intWhatDay == dteToday.getDate())) {
			return true;
		}
		else {
			return false;
		}
	}


	function isDayValid(intWhatDay, intWhatMonth, intWhatYear){
		dteCur.setDate(intWhatDay);
		dteCur.setMonth(intWhatMonth);
		dteCur.setFullYear(intWhatYear);
		dteCur.setHours(0);dteCur.setMinutes(0);dteCur.setSeconds(0);dteCur.setMilliseconds(0);
		if ((dteCur>=this.minDate) && (dteCur<=this.maxDate)) {
			return true;
		}
		else {
			return false;
		}
	}
	this.isDayValid=isDayValid;

	calMgr.addCalendar(this);

	blnInConstructor=false;
}



// Utility functions----------------------------------


function quote(sWhat) {
	return '\''+sWhat+'\'';
}


function getOffsetLeft (el) {
	var ol = el.offsetLeft;
	while ((el = el.offsetParent) != null)
		ol += el.offsetLeft;
	return ol;
}


function getOffsetTop (el) {
	var ot = el.offsetTop;
	while((el = el.offsetParent) != null)
		ot += el.offsetTop;
	return ot;
}

function calClick() {
	window.focus();
}

function domlay(id,trigger,lax,lay,content) {
	/*
	 * Cross browser Layer visibility / Placement Routine
	 * Done by Chris Heilmann (mail@ichwill.net)
	 * http://www.ichwill.net/mom/domlay/
	 * Feel free to use with these lines included!
	 * Created with help from Scott Andrews.
	 * The marked part of the content change routine is taken
	 * from a script by Reyn posted in the DHTML
	 * Forum at Website Attraction and changed to work with
	 * any layername. Cheers to that!
	 * Welcome DOM-1, about time you got included... :)
	 */
	// Layer visible
	if (trigger=="1"){
		if (document.layers) document.layers[''+id+''].visibility = "show"
		else if (document.all) document.all[''+id+''].style.visibility = "visible"
		else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"
		}
	// Layer hidden
	else if (trigger=="0"){
		if (document.layers) document.layers[''+id+''].visibility = "hide"
		else if (document.all) document.all[''+id+''].style.visibility = "hidden"
		else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"
		}
	// Set horizontal position
	if (lax){
		if (document.layers){document.layers[''+id+''].left = lax}
		else if (document.all){document.all[''+id+''].style.left=lax}
		else if (document.getElementById){document.getElementById(''+id+'').style.left=lax+"px"}
		}
	// Set vertical position
	if (lay){
		if (document.layers){document.layers[''+id+''].top = lay}
		else if (document.all){document.all[''+id+''].style.top=lay}
		else if (document.getElementById){document.getElementById(''+id+'').style.top=lay+"px"}
		}
	// change content

	if (content){
	if (document.layers){
		sprite=document.layers[''+id+''].document;
		// add father layers if needed! document.layers[''+father+'']...
		sprite.open();
		sprite.write(content);
		sprite.close();
		}
	else if (document.all) document.all[''+id+''].innerHTML = content;
	else if (document.getElementById){
		//Thanx Reyn!
		rng = document.createRange();
		el = document.getElementById(''+id+'');
		rng.setStartBefore(el);
		htmlFrag = rng.createContextualFragment(content)
		while(el.hasChildNodes()) el.removeChild(el.lastChild);
		el.appendChild(htmlFrag);
		// end of Reyn ;)
		}
	}
}


function makeArray0() {
	for (i = 0; i<makeArray0.arguments.length; i++)
		this[i] = makeArray0.arguments[i];
}

//---------------------------------------


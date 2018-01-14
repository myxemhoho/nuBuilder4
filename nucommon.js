
window.nuDialog 				= new nuCreateDialog('');
window.nuFORM					= new nuFormObject();
window.nuNEW					= '';
window.nuDragID					= 1000;
window.nuColor					= '';
window.nuImage					= '';
window.nuImages					= [];
window.nuHideMessage 			= true;
window.nuOPENER					= [];
window.nuSUBFORMROW				= [];
window.nuSUBFORMJSON			= [];
window.nuSCHEMA					= [];
window.nuLANGUAGE				= [];
window.nuFIELD					= [];
window.nuHASH					= [];
window.nuBEFORE					= [];
window.nuAFTER					= [];
window.nuSESSION				= '';
window.nuDRAGLINEVSTART			= '';
window.nuDRAGLINEVID			= '';
window.nuLASTRECORD				= '';
window.nuBROWSERESIZE 			= {
									x_position				: 0, 
									mouse_down				: false, 
									moving_element			: '', 
									pointer					: '', 
									current_cell_width		: 0, 
									next_cell_left			: 0, 
									array_current_cell_left	: '', 
									last_moved_element		: ''
								};

function nuOpener(t, f, r, filter, parameters){
	
	nuSetSuffix();
	
	this.id					= String(Date.now()) + String(window.nuSuffix);
	this.form_id			= f;
	this.record_id			= r;
	this.type				= t;
	
	if(arguments.length 	= 3){
		this.filter			= filter;
	}else{
		this.filter			= '';
	}
	
	if(arguments.length 	= 4){
		this.parameters		= parameters;
	}else{
		this.parameters		= '';
	}
	
}

function nuOpenerAppend(t, k) {
	window.nuOPENER[window.nuOPENER.length - 1][t] = k;
}

function nuGetOpenerById(pOPENER, pid) {
	
	for (var i = 0; i < pOPENER.length; i++) {
		if(pOPENER[i].id == pid) {
			return pOPENER[i];
		}
	}
	
	return;
}


function nuRemoveOpenerById(o, pid) {

	for (var i = 0; i < o.length; i++) {
		
		if(o[i].id == pid) {
			o.splice(i,1);
		}
		
	}

}


function nuGetBreadcrumb(bc){
	
	var a			= arguments.length;
	var e			= nuFORM.edited;
	
	if(a == 0){
		var b		= nuFORM.breadcrumbs.length -1;
	}else{
		var b		= bc;
	}
	
	if(e && nuFORM.getCurrent().form_type != 'launch'){
		
		if(!confirm(nuTranslate('Leave this form without saving?'))){
			return;
		}
		
	}

	window.nuFORM.removeAfter(b);
	
	var c				= window.nuFORM.getCurrent();
	
	if(c === undefined){
		$('#nuDragDialog iframe').remove();
	}else{
		nuForm(c.form_id, c.record_id, c.filter, c.search, 1);
	}

	
}


function nuDisplayError(e){

	if(e.errors === undefined || e.errors.length == 0){			//-- no error messages
		return false;
	}

	var im	= ['<img src="graphics/nuerror.png" width="30px" height="30px" style="position:absolute;left:10px;top:10px"><br>'];

	im.concat(e.errors);

	nuMessage(e.errors);

	return true;
	
}


function nuFormatAjaxErrorMessage(jqXHR, exception) {

    if (jqXHR.status === 0) {
        return ('Not connected.\nPlease verify your network connection.');
    } else if (jqXHR.status == 404) {
        return ('The requested page not found. [404]');
    } else if (jqXHR.status == 500) {
        return ('Internal Server Error [500].');
    } else if (exception === 'parsererror') {
        return ('Requested JSON parse failed.');
    } else if (exception === 'timeout') {
        return ('Time out error.');
    } else if (exception === 'abort') {
        return ('Ajax request aborted.');
    } else {
        return ('Uncaught Error.\n' + jqXHR.responseText);
    }
}

String.prototype.replaceAll = function(str1, str2, ignore){

   return this.replace(new RegExp(str1.replace(/([\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, function(c){return "\\" + c;}), "g"+(ignore?"i":"")), str2);

};

String.prototype.ltrim = function() {
	return this.replace(/^\s+/,"");
}
String.prototype.rtrim = function() {
	return this.replace(/\s+$/,"");
}

function loginInputKeyup(event){
    if(event.keyCode == 13){
        $('input#submit').click();
    }
}

function nuLogin(nuconfigNuWelcomeBodyInnerHTML){
	
	var HTML			= String(nuconfigNuWelcomeBodyInnerHTML).trim();
	window.nuSESSION 	= '';
	window.nuFORM 		= new nuFormObject();
	
	$('body').html('');
	
	var h 	= `	

				<div id='login' class='nuLogin' style='background-color:#d8e4ff; width:330;position:absolute;top:50px;height:300px;left:50px;border-style:solid;border-width:1px;border-color: rgba(0, 0, 0, 0.08);'>
					<div id='nulogo' style='background-size:100% 100%;background-image:url(\"graphics/logo.png\");position:absolute;width:200px;height:80px;top:45px;left:65px;'></div>
					<br>
						<div style='position:absolute;top:170px;left:20px;text-align:right;width:70px;display:inline-block;'>Username</div>
						<input id='nuusername' style='position:absolute;top:170px;left:100px;'/>
					<br>
					<br>
						<div style='position:absolute;top:200px;left:20px;text-align:right;width:70px;display:inline-block;'>Password</div>
						<input id='nupassword' style='position:absolute;top:200px;left:100px;' type='password'  onkeypress='nuSubmit(event)'//>
					<br>
					<br>
						<input id='submit' type='button' class='nuButton'  style='position:absolute;width:90px;height:30px;top:240px;left:130px;' onclick='nuLoginRequest()' value='Log in'/>
					<br>
					<br>
				</div>

	`;
	
	var H	= HTML == '' ? h : HTML
	
	var e 	= document.createElement('div');
	
	e.setAttribute('id', 'loginbg');
	
	window.nuLoginU	= window.nuLoginU===undefined?'':window.nuLoginU;
	window.nuLoginP	= window.nuLoginP===undefined?'':window.nuLoginP;

	$('body').html(H);
	
	if(window.nuLoginU == '' && window.nuLoginP == ''){
		$('#nuusername').focus();
	}
	
	if(window.nuLoginU != '' && window.nuLoginP == ''){
		
		$('#nuusername').val(window.nuLoginU);
		$('#nupassword').focus();
		
	}

	if(window.nuLoginU != '' && window.nuLoginP != ''){
		
		$('#nuusername').val(window.nuLoginU);
		$('#nupassword').val(window.nuLoginP);
		
		nuLoginRequest();
		
	}

	if(sessionStorage.logout == 'true'){
		nuMessage(['You have been logged out']);
	}
	
	sessionStorage.logout	= '';
		
}


function nuSubmit(e){
	
	if(e.keyCode == 13){
		$('#submit').click();
	}
	
}


function nuBuildLookup(t, s, like){

	var f			= $('#' + t.id).attr('data-nu-form-id');
	var tar			= $('#' + t.id).attr('data-nu-target');
	
	if(arguments.length < 3){
		like 		= '';
	}
	
	window.nuOPENER.push(new nuOpener('F', f, ''));
	
	var open 		= window.nuOPENER[window.nuOPENER.length - 1];
	
	if(parent.window == window){
		window.nuDialog.createDialog(50, 50, 50, 50, '');
	}else{
		window.nuDialog.createDialog(0, 30, 50, 50, '');
	}
	
	$('#nuDragDialog')
	.css('visibility', 'hidden')
	.append('<iframe style="right:5px;top:35px;width:400px;height:400px;position:absolute" id="nuWindow" src="index.php?&opener=' +open.id + '&target=' + tar + '&search=' + s + '&like=' + like + '&browsefunction=lookup&iframe=1"></iframe>');

}

function nuPopup(f, r, filter){

	$('#nuCalendar').remove();
	
	window.nuOPENER.push(new nuOpener('F', f, r, filter));

	var id 	= window.nuOPENER[window.nuOPENER.length - 1].id;
	
	if(parent.window==window){
		window.nuDialog.createDialog(50, 50, 50, 50, '');
	}else{
		window.nuDialog.createDialog(0, 30, 50, 50, '');
	}
	
	$('#nuDragDialog')
	.css('visibility', 'hidden')
	.append('<iframe style="right:5px;top:35px;width:400px;height:400px;position:absolute" id="nuWindow" src="index.php?opener=' + id + '&browsefunction=browse&iframe=1"></iframe>')
	.prepend('<div id="nuDraggingBox" style="position:absolute; bottom:0px; right:0px; width:20px; height:20px; z-index:200"></div>');
	
}

//-- object for dragging dialog --//

function nuCreateDialog(t){

	this.startX     = 0;
	this.startY     = 0;
	this.moveX      = 0;
	this.moveY      = 0;
	this.title      = t;
	this.pos		= {};
	
	this.move = function(event) {
	
		this.moveX  = event.clientX - this.startX ;
		this.moveY  = event.clientY - this.startY;
		this.startX = event.clientX;
		this.startY = event.clientY;
		
		if(event.buttons == 1 && event.target.id == 'dialogTitleWords'){
			this.moveDialog();
		}
		
		if(event.target.id == 'dialogClose'){
			$('#dialogClose').css('background-color','lightgrey');
		}else{
			$('#dialogClose').css('background-color','');
		}
		
	}
	
	this.click = function(event) {
	
		if(event.target.id == 'dialogClose'){
			
			$('#nuDragDialog').remove();
			$('#nuModal').remove();
			
		}
		
	}

	this.moveDialog = function() {

		var s 	= document.getElementById('nuDragDialog');
		var o 	= s.style;
		var l 	= parseInt(o.left) + this.moveX;
		var t 	= parseInt(o.top)  + this.moveY;
		
		o.left  = l + 'px';
		o.top   = t + 'px';

	}

	this.createDialog = function(l, t, w, h, title) {

		nuDialog.dialog = this.createDialog.caller.name;
		
		var e = document.createElement('div');
		
		var translation	= nuTranslate(title);

//		if(opener != null){
//			translation	= opener.nuTranslate(title);
//		}

		e.setAttribute('id', 'nuDragDialog');

		$('body').append('<div id="nuModal"></div>')
		.append(e);

		$('#nuDragDialog').addClass('nuDragDialog nuDragNoSelect')
		.css({
			'left'				: l, 
			'top'				: t, 
			'width'				: w, 
			'height'			: h, 
			'background-color'	: '#E0E0E0', 
			'z-index'			: 3000, 
			'position'			: 'absolute'
		})
		.on('mousemove', 	function(event){nuDialog.move(event);})
		.on('mouseout', 	function(event){$('#dialogClose').css('background-color','');})
		.on('click',     	function(event){nuDialog.click(event);})
		.html('<div id="dialogTitle" ondblclick="nuResizeWindow(event)" style="background-color:#CCCCCC ;position:absolute;width:100%;height:35px;font-size:16px;font-family:Helvetica"><div id="dialogTitleWords" style="padding-top: 9px;height:30px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+translation+'</div><img id="dialogClose" src="graphics/close.png" style="position:absolute; top:2px; left:0px"></div>')

		this.startX = l;
		this.startY = t;

	}
	
}

function nuReformat(t){

	var o		= $('#' + t.id);
	var f		= o.attr('data-nu-format');
	var v		= o.val();
	
	if(f == '' || v == ''){
		return v;
	}
	
	if(f[0] == 'D'){
			
		var r		= nuFORM.removeFormatting(v, f);
		var a		= nuFORM.addFormatting(r, f);
		
		if(v != a){
			o.val('');
		}

	}
	
	if(f[0] == 'N'){
			
		var a		= nuFORM.addFormatting(v, f);
		o.val(a);

	}
	
}


function nuOpenAce(lang, obj){

	var ts			= new Date().getTime();
	window.nuAce	= [lang, obj];
	
	window.open('nuace.html?' + ts);

}
/*
function nuGetSFArrays(){

	var s 	= window.nuSUBFORMJSON;
	var j	= [];
	
	for(var i = 0 ; i < s.length ; i++){
		j.push(nuSubformToArray(s[i], 1));
	}
	
	return j;
}
*/


function nuRunIt(t, email, type){

	var r   = $('#' + t.id).attr('data-nu-row');
	var c   = '000';
	var p   = $('#' + r + c).html();
	
	if(arguments.length < 3){										//-- set type
		
		var type	= $('#' + r + '001').html();					//-- report - PDF,or procedure - PHP
		
	}
	
	if(arguments.length == 1){										//-- set email
		
		var email	= 0;
		
	}
	
	var f	= $('#' + t.id).attr('data-nu-primary-key');
	var i	= window.nuFORM.getProperty('record_id');

	if(email == 1){
		
		if(type == 'php'){
			nuEmailPHP(i);
		}
		
		if(type == 'pdf'){
			nuEmailPDF(i);
		}
		
	}else{
		
		if(type == 'php'){
			nuGetPHP(f, p);
		}
		
		if(type == 'pdf'){
			nuGetReport(f, p);
		}
		
	}
		
}

function nuBindCtrlEvents(){

	var nuCtrlKeydownListener = function(e){	
	
		if(e.keyCode == 17) { //Ctrl
			window.nuNEW = 1;
		}
		
	}
	
	$(document).keydown(function(e) {
		
        if (e.ctrlKey && e.shiftKey) {
			
			window.nuNEW = 0;
			
			e.preventDefault();
			
			if(nuFormType() == 'browse') {
			
				if(e.keyCode == 67 && window.global_access) {						//-- c		Searchable Columns
					nuPopup(window.nuFORM.getCurrent().form_id, "-2");
				} else if(e.keyCode == 70 && window.global_access) {				//-- f		Form Properties
					nuPopup("nuform", window.nuFORM.getCurrent().form_id);
				} else if(e.keyCode == 79 && window.global_access) {				//-- O		Object List
					nuPopup("nuobject", "", window.nuFORM.getCurrent().form_id);
				} else if(e.keyCode == 68 && window.global_access) {				//-- d		nuDebug Results
					nuPopup("nudebug", "");
				} else if(e.keyCode == 83) {										//-- s		Search
					nuGetSearchList();
				} else if(e.keyCode == 65 && window.global_access) {				//-- a		Add
					nuCloneAction();
				} else if(e.keyCode == 80 && window.global_access) {				//-- p		Print
					nuDeleteAction();
				}

			}


			if(nuFormType() == 'edit') {
			
				if(e.keyCode == 65 && window.global_access) {						//-- a		Arrange
					nuPopup(window.nuFORM.getCurrent().form_id, "-2");
				} else if(e.keyCode == 70 && window.global_access) {				//-- f		Form Properties
					nuPopup("nuform", window.nuFORM.getCurrent().form_id);
				} else if(e.keyCode == 79 && window.global_access) {				//-- O		Object List
					nuPopup("nuobject", "", window.nuFORM.getCurrent().form_id);
				} else if(e.keyCode == 68 && window.global_access) {				//-- d		nuDebug Results
					nuPopup("nudebug", "");
				} else if (e.keyCode == 82) {										//-- r		Refresh
					nuGetBreadcrumb();
				} else if(e.keyCode == 83) {										//-- s		Save
					nuSaveAction();
				} else if(e.keyCode == 67) {										//-- c		Clone
					nuCloneAction();
				} else if(e.keyCode == 98) {										//-- y		Delete
					nuDeleteAction();
				}

			}


			var nosearch = window.nuFORM.getProperty('nosearch_columns');
			var searchIndex = -1;
			
			//Numbers
			if(e.keyCode >= 49 && e.keyCode <= 57) {
				searchIndex = Math.abs(49 - e.keyCode);
			}
				
			if(searchIndex != -1){
				
				if($.inArray(searchIndex,nosearch) != '-1'){
					
					nosearch.pop(searchIndex);
					$('#nusort_' + searchIndex).removeClass('nuNoSearch');					
					
				}else{
					
					nosearch.push(searchIndex);
					$('#nusort_' + searchIndex).addClass('nuNoSearch');
					
				}
				
			}
			
			window.nuFORM.setProperty('nosearch_columns', nosearch);
        }
    });
	
	var nuCtrlKeyupListener = function(e){	
		
		window.nuNEW = 0;
	}
	
    $(document).on('keydown.nubindctrl', nuCtrlKeydownListener);
	
	$(document).on('keyup.nubindctrl', nuCtrlKeyupListener);

}

function nuUnbindDragEvents(){
    $(document).off('.nubindctrl');
}


function nuTranslate(s){
	
	for(var i = 0 ; i < nuLANGUAGE.length ; i ++){
		
		if(nuLANGUAGE[i].english == s){
			return nuLANGUAGE[i].translation;
		}
		
	}
	
	return s;
	
}



function nuIsOpener() {
	
	if(window.opener != null) {
		return true;
	}
	
	return false;
}

/*
function nuFormValues(){  //-- list of changed fields and values

    var list   = {};
    
    $("[data-nu-data]").each(function() {
        
        list[$(this).attr('id')] = $(this).val();
        
    });
    
    var f = {};
    
    for (var fld in list) {
		
        f[fld] = $('#' + fld).val();
		
    }

	return f;
    
}


function nuEditPHP(ev){

	var r	= window.nuFORM.getProperty('record_id');
	var i	= r + '_' + ev;
	
	if(r == '-1'){
	
		alert('Must Save Record Before Adding Procedures');
		return;
		
	}
	
	c	= $('#sfo_code').val();
	d	= $('#sfo_description').val();
	
	nuSetHash('the_form', d + ' (' + c + ')');
	nuSetHash('nuSystemPHP', 1);
	nuPopup("nuphp", i);

}
*/

function nuPreview(a){

	var	t	= String($('#sfo_type').val());
	var b	= t.indexOf('browse') != -1;
    var f   = nuFORM.getProperty('redirect_form_id');
    var r   = nuFORM.getProperty('record_id');
    
    if(r == '-1'){
        
        alert('Form must be saved first..');
        return;
        
    }
    
    if(arguments.length == 1){
        nuPopup(r, '');
    }else{
        nuPopup(r, '-3');
	}
    
}


function nuPopPHP(e, nuE){			//-- used in database

    var i   = nuFORM.getProperty('record_id');

    if(i == ''){
        
        alert('Cannot create Event Until This Form Has Been Saved..')
        return;
		
    }
	
    nuPopup('nuphp', i + '_' + nuE, 'justphp');

}


function nuPopSQL(e, nuE){			//-- used in database

    var i   = nuFORM.getProperty('record_id');

    if(i == ''){
        
        alert('Cannot create SQL Until This Form Has Been Saved..')
        return;
		
    }
	
    nuPopup('nuselect', i + '_' + nuE, 'justsql');

}

    

function nuPopJS(){				//-- used in database

	var i  = $('#sob_all_zzzzsys_form_id').val();
	
	if(i == ''){
		
		alert('Cannot Create Event Until This Form Has Been Saved..')
		return;
		
	}
	
	nuPopup('nuform', i, 'justjs');
	
}

function  nuGetLookupFields(id){

	var i	= id.substr(0, id.length - 4);
	var o	= $('#' + id);
	var a	= [];
	
	if(o.length == 1){
		
		if(o.attr('data-nu-type') == 'subform'){
			
			a.push(i);
			a.push(id);
			a.push(i + 'description');

		}else{
			a.push('nunosuchfield');
			a.push(id);
			a.push('nunosuchfield');
		}

	}

	return a;
	
}

function nuEnable(i){                 //-- Enable Edit Form Object

	var o	= [i, i + 'code', i + 'button', i + 'description'];
	
	for(var c = 0 ; c < o.length ; c++){
			
		$('#' + o[c])
		.removeClass('nuReadonly')
		.prop('readonly', false)
		.prop('disabled', false);
		
	}

}

function nuReadonly(i){  			               //-- set Edit Form Object to readonly

	var o	= [i, i + 'code', i + 'button', i + 'description'];
	
	for(var c = 0 ; c < o.length ; c++){
			
		$('#' + o[c])
		.addClass('nuReadonly')
		.attr('onclick','')
		.prop('readonly', true);
		
	}

}


function nuDisable(i){                 //-- Disable Edit Form Object

	var o	= [i, i + 'code', i + 'button', i + 'description'];
	
	for(var c = 0 ; c < o.length ; c++){
			
		$('#' + o[c])
		.addClass('nuReadonly')
		.prop('readonly', true)
		.prop('disabled', true);
		
	}

}


function nuShow(i){                 //-- Show Edit Form Object

	var o	= [i, i + 'code', i + 'button', i + 'description', 'label_' + i];
	
	for(var c = 0 ; c < o.length ; c++){

		var t	=	String($('#' + o[c]).attr('data-nu-tab'));
		
		if(t[0] == 'x'){
				
			$('#' + o[c])
			.attr('data-nu-tab', t.substr(1))
			.show();
			
		}else{
				
			$('#' + o[c])
			.show();
			
		}
		
		
	}
	
}


function nuHide(i){                 //-- Hide Edit Form Object

	var o	= [i, i + 'code', i + 'button', i + 'description', 'label_' + i];
	
	for(var c = 0 ; c < o.length ; c++){

		var t	=	String($('#' + o[c]).attr('data-nu-tab'));
		
		if(t[0] == 'x'){
				
			$('#' + o[c])
			.hide();
			
		}else{
				
			$('#' + o[c])
			.attr('data-nu-tab', 'x' + t)
			.hide();
			
		}
		
		
	}
	

}

function nuAddThousandSpaces(s, c){

	var a	= String(s).split('');
	var r	= [];

	r		= a.reverse();
		
	if(r.length > 3){r.splice(3, 0, c);}
	if(r.length > 7){r.splice(7, 0, c);}
	if(r.length > 11){r.splice(11, 0, c);}
	if(r.length > 15){r.splice(15, 0, c);}
	if(r.length > 19){r.splice(19, 0, c);}
	if(r.length > 23){return 'toobig';}

	r		= r.reverse();
	
	return r.join('');
	
}

function nuDuplicates(arr){

	var s	= arr.slice().sort();
	var d	= [];
	
	for (var i = 0; i < arr.length - 1; i++) {
		
		if (s[i + 1] == s[i]) {
			d.push(s[i]);
		}
		
	}
	
	return d;

}


function nuResizeWindow(e){

	var d	= $('#nuDragDialog');
	var D	= $('.nuDragOptionsBox');
	var W	= 0;
	var w	= $('#nuWindow');
	var f	= $('#nuDragDialog iframe')[0].contentWindow;
	var l	= parseInt(d.css('left'));

	if(D.length != 0){
		W	= parseInt(D.css('width'));
	}
	
	if(l == 2){

		if(D.length == 0){
			
			d.css(f.nuDialogSize);
			w.css(f.nuWindowSize);
			
		}
		
	}else{

		d.css({top:0, left:2, width:window.innerWidth - 30, height:window.innerHeight});
		
		var dh	= parseInt(d.css('height')) - 50;
		var dw	= parseInt(d.css('width')) - W - 10;
		
		w.css({top:30, width:dw, height:dh});
		
	}
		
}


function nuSubformObject(id){
	return nuFORM.subform(id);
}


function nuGetFunctionList(){

	var f				= '';

	for (var k in window) {

		if (window.hasOwnProperty(k)){
			
			if(String(k).substr(0,2) === 'nu'){
				f += k + "\n";
			}
		
		}

	}

	return f;

}



function nuID(){

	nuSetSuffix();
	
	window.nuUniqueID		= 'c' + String(Date.now());
	
	return window.nuUniqueID + String(window.nuSuffix);

}


function nuSetSuffix(a){
	
	if(arguments.length == 1){
		window.nuSuffix		= a;
	}
		
	if(window.nuSuffix == 9999){
		window.nuSuffix		= 0
	}else{
		window.nuSuffix	++;
	}
	
	
}



function nuWhen(w){

	var nunow   = Date.now();
	var numax   = (Date.now()/1000) - Number(w);
	var numin   = numax;
	var nusec	= String(Math.ceil(numin));
	var nuhtm   = nusec 			+ (nusec==1?' second ago':' seconds ago');

	return nuhtm;

}



function nuSpaces(s){
	return String('&nbsp;').repeat(s);
}

function nuAddEditFieldsToHash(w){
	
	var d	= nuFORM.data()[0];
	var f	= d.fields;
	var r	= d.rows[0];
	
	for(i = 2 ; i < f.length ; i++){
		w[f[i]] = r[i];
	}
	
	return w;
	
}

function nuClick(e){
	
	if(!$(e.target).hasClass('nuOptionsItem') && !$(e.target).hasClass('nuSearchCheckbox')){
		$('#nuSearchList').remove();
	}
	
	if(!$(e.target).hasClass('nuIcon')){
		$('#nuOptionsListBox').remove();
	}
	
	if(e.target.id != 'nuMessageDiv' && $(e.target).attr('data-nu-option-title')!= 'Help' ){

		if(window.nuHideMessage){
			$('#nuMessageDiv').remove();
		}
		
		window.nuHideMessage	= true;
		
	}
	
	if($(e.target).attr('type') != 'nuDate' && !$(e.target).hasClass('nuCalendar')){
		$('#nuCalendar').remove();
	}
	
}

function nuAddSlashes(s){
    return (s + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function nuRemoveTabs(t){

	for(var i = 0 ; i < arguments.length ; i++){
		$('#nuTab' + arguments[i]).remove();
	}
	
}

function nuOpenTab(i){
	$('#nuTab' + i).click();
}


function nuRemoveHolders(h){
	
	for(var i = 0 ; i < arguments.length ; i++){
		
		if(arguments[i] == 0){$('#nuActionHolder').remove();}
		if(arguments[i] == 1){$('#nuBreadcrumbHolder').remove();}
		if(arguments[i] == 2){$('#nuTabHolder').remove();}
		
	}
	
}


function nuAttachFile(j, c){

	if(window.nuGraphics.indexOf(c + '.png') != -1){						//-- check filenames in graphics dir.

		$(j)
		.css('background-image', 'url("graphics/' + c + '.png')
		.css('background-repeat', 'no-repeat')
		.css('padding', '0px 0px 0px 0px')
		.css('text-align', 'left')

		return;
		
	}
	
	if(nuImages[c] !== undefined){
		
		var p				= JSON.parse(g);
		var b				= atob(p.file);
		
		$(j)
		.css('background-image', 'url("' + b + '")')
		.css('background-repeat', 'no-repeat')
		.css('padding', '0px 0px 0px 0px')
		.css('text-align', 'left')

		return;
		
	}
	
}



function nuButtonIcon(j){

	$(j)
	.css('text-align', 'left')
	.css('padding', '0px 0px 0px 35px')
	.css('background-size', '30px')
	.css('background-repeat', 'no-repeat')
	
}


function nuChart(d, t, a, h, x, y, st, is){

	a				= eval(a);
	
	if(typeof(google['charts']) == 'undefined'){
			
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawVisualization);
		
	}
	
	if(a == ''){return;}

	function drawVisualization() {
		
		if(a === undefined){return;}
		
		var data 	= google.visualization.arrayToDataTable(a);

		var options = {
			title 		: h,
			vAxis		: {title: y},
			hAxis		: {title: x},
			seriesType	: st,
			isStacked 	: is,
		};
		
		var chart 	= new google.visualization[t](document.getElementById(d));

		chart.draw(data, options);

	}

}


function nuSubformRowId(t){
	return $(t).parent().attr('data-nu-primary-key');
}


function nuSubformValue(t, id){

	var p	= $(t).attr('data-nu-prefix');
	
	return $('#' + p + id).val();

}

function nuEncode(s){
	return window.btoa(unescape(encodeURIComponent(s)))
}


function nuDecode(s){
	return decodeURIComponent(escape(window.atob(s)))
}

function nuAddRow(s){

	var o 	= nuSubformObject(s);
	
	var i	= s + nuPad3(o.rows.length - 1) + o.fields[1];
	
	$('#' + i).change();

	i		= s + nuPad3(o.rows.length) + o.fields[1];
	
	$('#' + i).focus();
	
}

function nuAccessLevelCode(){
	return nuSERVERRESPONSE.access_level_code;
}


//=============================================================
//========== nuAddBrowseListeners() added by Fike =============
//=============================================================


function nuAddBrowseListeners(w){
    
    if(nuFormType() != 'browse'){return;}
	
    nu_set_title_divs(); 														//this function adds the listeners and additional data to title divs in order to make them draggable
	
	if(w != 0){
		nu_set_column_widths(w);
	}
    
    nu_browse_add_listeners(); 													//this function binds cursormove/touchmove event listeners to nubody
    
}




function nu_get_column_widths(){
	
	var a										= [];

	$("div[id^='nuBrowseTitle']").each(function( index ) {
		a.push(parseInt($(this).css('width')));
	});
	
	return a;

}



function nu_browse_add_listeners(){

    $('#nubody').on('mouseup.nuresizecolumn', function(event) {nu_end_resize();});
	
    $('#nubody').on('mousemove.nuresizecolumn', function(event) {
                                                                    event.preventDefault();
                                                                    
                                                                    if (window.nuBROWSERESIZE.mouse_down){
                                                                        nu_resize_title_div(event,window.nuBROWSERESIZE.moving_element);
                                                                    } 
                                                                });
																
}

/*
function while_moving(event){

    event.preventDefault();
    
    if (window.nuBROWSERESIZE.mouse_down){
        resize_div_diam(event,window.nuBROWSERESIZE.moving_element);
    } 
	
}
*/

function nu_set_column_widths(array_col_widths){

    if (array_col_widths){
		
        if (nu_array_matches_columns(array_col_widths)){
			
            nu_set_left_pos_array();
        
            for (var z = 0; z < array_col_widths.length; z++){
                nu_modify_column_width(z, array_col_widths[z]);
            }
			
        }else{
            console.log('Unable to resize columns. The number of columns provided for the array do not match with the number of columns in the browse form');
        }
		
    }
	
}

function nu_modify_column_width(col_number, column_width){
	
    var titles 									= $("div[id^='nuBrowseTitle']").toArray();
    var title_id 								= titles[col_number].id;
    var title_current_width 					= $('#'+title_id).width();
    var title_dispaly_prop 						= $('#'+title_id).css('display');
    var title_offset 							= title_current_width - column_width;
    var offset_value 							= Math.abs(title_offset);
    offset_value				 				= Math.round(offset_value * 100) / 100;
    
    window.nuBROWSERESIZE.current_cell_width 	= '0';
    window.nuBROWSERESIZE.next_cell_left 		= '0';
    window.nuBROWSERESIZE.moving_element 		= title_id;
    
    if (title_offset > 0){
        var direction 							= 'left';
    }else{
        var direction 							= 'right';
    }

    if (title_current_width !== 0 && title_dispaly_prop != 'none'){
        nu_resize_div(title_id, direction, offset_value, 119);
    }else{
		
        var div_number 							= title_id.replace('nuBrowseTitle','');
        div_number 								= Number(div_number);
        offset_value 							= 0;

        nu_move_headers(direction,div_number,offset_value);
    }
    
    nu_end_resize();
        
}



function nu_array_matches_columns(col_array){

    var cols_received 							= col_array.length;
    var browse_cols_array 						= $("div[id^='nuBrowseTitle']").toArray();
    
    if (cols_received == browse_cols_array.length){
        return true;
    }else{
        return false;
    }
	
}

function nu_set_title_divs(){
	
    var hdrs 									= $("div[id^='nuBrowseTitle']").toArray();
    
    for (var i = 0; i < hdrs.length; i++ ){

        var div_id 								= hdrs[i].id;
        var left_side_elem 						= hdrs[i].id;
        
        if (i+1 < hdrs.length){
            var right_side_elem 				= hdrs[i+1].id;
        }else{
            right_side_elem 					= 'last_element'; 
        }
        
        nu_add_title_props(div_id, left_side_elem, right_side_elem);
        
    }
    
}


function nu_add_title_props(div_id, l_text, r_text){

    $("#"+div_id).attr({"data-left_side" : l_text,"data-right_side" : r_text});

    $("#"+div_id).on('mousedown.nuresizecolumn', function(event) {   
                                                            event.preventDefault();
                                                            window.nuBROWSERESIZE.mouse_down = true;
                                                            window.nuBROWSERESIZE.pointer = 'pointer';
                                                            window.nuBROWSERESIZE.moving_element = this.id;
															$('#' + this.id).css('cursor', 'ew-resize');
                                                            nu_get_start_pos(event);
                                                        });
    
    $("#"+div_id).on('mouseup.nuresizecolumn', function(event) {   
															$('#' + this.id).css('cursor', '');
                                                        });
    
    
    $("#"+div_id).on('touchstart.nuresizecolumn', function(event) {   
                                                            event.preventDefault();
                                                            window.nuBROWSERESIZE.mouse_down = true;
                                                            window.nuBROWSERESIZE.pointer = 'finger_touch';
                                                            window.nuBROWSERESIZE.moving_element = this.id;
                                                            nu_get_start_pos(event);
                                                        });
                                                        
    $("#"+div_id).on('touchmove.nuresizecolumn', function(event) { 
                                                            if (window.nuBROWSERESIZE.mouse_down){ nu_resize_title_div(event,window.nuBROWSERESIZE.moving_element);} 
                                                        });
                                                        
    $("#"+div_id).on('touchend.nuresizecolumn', function(event) { nu_end_resize(); window.nuBROWSERESIZE.pointer = 'mouse_cursor'; });
    
    $("#"+div_id).on('touchcancel.nuresizecolumn', function(event) { nu_end_resize(); window.nuBROWSERESIZE.pointer ='mouse_cursor'; });
    
}

function nu_get_start_pos(event){

    window.nuBROWSERESIZE.x_position 				= event.pageX;
    
    if (window.nuBROWSERESIZE.pointer == "finger_touch"){
        window.nuBROWSERESIZE.x_position 			= event.changedTouches[0].clientX;
    }
    
    window.nuBROWSERESIZE.array_current_cell_left 	= '';
    
    nu_set_left_pos_array();
    
}


function nu_set_left_pos_array(){
	
    var hdrs 										= $("div[id^='nuBrowseTitle']").toArray();
    var left_pos_array 								= [];
    
    for (var i = 0; i < hdrs.length; i++){
		
        var hdr_id 									= hdrs[i].id;
        
        //var left_pos = $('#'+hdr_id).offset().left; when CSS display property is none, offset().left throws CERO
        var left_pos 								= parseInt($("#"+hdr_id).css('left'));
        
        left_pos_array.push(left_pos);
		
    }
    
    var left_pos_json 								= JSON.stringify(left_pos_array);
    
    window.nuBROWSERESIZE.array_current_cell_left 	= left_pos_json;
	
}

function nu_resize_title_div(event,elem_id){

    var offset_limit 								= 100000000;
    var min_offset 									= 20;
    var x 											= event.pageX;
    
    if (window.nuBROWSERESIZE.pointer == "finger_touch"){
        x 											= event.changedTouches[0].clientX;
    }
    
    var x_offset 									= x - window.nuBROWSERESIZE.x_position;
    
    if (x !== 0 && Math.abs(x_offset) > min_offset){
		
        if (x_offset > 0){
            var direction 							= 'right';
        }else{
            var direction							= 'left';
        }
        
        x_offset 									= Math.abs(x_offset);
        
        if (x_offset < offset_limit){
            nu_resize_div(elem_id, direction, x_offset, 261);
        }else{
            console.log('Offset size exceeds limit');
        }
        
    }
}


function nu_resize_div(elem_id, direction, offset_value, row){

    window.nuBROWSERESIZE.last_moved_element 		= elem_id;
    var div_id 										= elem_id;
    var min_col_val 								= 20;
    var div_number 									= div_id.replace('nuBrowseTitle','');
    div_number 										= Number(div_number);

    var l_side_id 									= $("#"+div_id).attr("data-left_side");
    var r_side_id 									= $("#"+div_id).attr("data-right_side");

    if (window.nuBROWSERESIZE.current_cell_width == '0'){
		
		if($("#"+l_side_id).length != 0){
			window.nuBROWSERESIZE.current_cell_width 	= $("#"+l_side_id).width()+'';
		}
    }
    current_l_width 								= Number(window.nuBROWSERESIZE.current_cell_width);


    if ( window.nuBROWSERESIZE.next_cell_left == '0' && r_side_id != 'last_element'){
        window.nuBROWSERESIZE.next_cell_left 		= parseInt($("#"+r_side_id).css('left'));
    }
    
    if (r_side_id == 'last_element'){
        var current_r_left_pos = 0;
    }else{
        current_r_left_pos = Number(window.nuBROWSERESIZE.next_cell_left);
    }
    
    
    if (direction == "right"){
        var new_l_width 							= current_l_width + offset_value;
    }
    
    if (direction == "left"){
        var new_l_width 							= current_l_width - offset_value;
    }
	
    if (new_l_width >= min_col_val){
		
        var new_width_auth 							= new_l_width;

        nu_set_title_width(l_side_id, new_width_auth, div_number, div_id, current_r_left_pos, direction, offset_value);
		
    }else{
		
        console.log('Column must be at least '+min_col_val+'px width. Ending resize function');
        nu_end_resize();
        nu_adjust_col_min_width(min_col_val);
		
    }
	
}

function nu_adjust_col_min_width(min_col_val){
	
    var div_id 										= window.nuBROWSERESIZE.last_moved_element;
    var div_width 									= $('#'+div_id).width();
    
    if (div_width < min_col_val){
        var direction = 'right';
    }else if (div_width > min_col_val){
        var direction = 'left';
    }else{
		
        nu_end_resize();
        return false;
		
    }
    
    var offset_value 								= div_width - min_col_val;
    offset_value 									= Math.abs(offset_value);
    
    nu_resize_div(div_id, direction, offset_value, 344);
    nu_end_resize();
	
}

function nu_set_title_width(l_side_id, new_l_width, div_number, div_id, current_r_left_pos, direction, offset_value){

    $("#"+l_side_id)
	.css("background-color", "#b1dbad")
    
    $("#"+l_side_id).width(new_l_width);
    
    var div_left_offset 							= parseInt($("#"+l_side_id).css('left'));      //var div_left_offset = $("#"+l_side_id).offset().left; when CSS display property is none, offset().left throws CERO
    var d_offset_left 								= div_left_offset + new_l_width - 12;
    var col_number 									= div_number;

    nu_resize_column(col_number, new_l_width);

    if (current_r_left_pos != 0){
        nu_move_headers(direction,div_number,offset_value);
    }else{
        nu_resize_footer();
    }
	
}

function nu_resize_column(col_number, col_width){
	
    var txt_col_number 								= '_'+col_number ;
    var cell_width 									= col_width - 8;
    var cells 										= $("div[id$='"+txt_col_number+"']").toArray();
    
    for (i = 0; i < cells.length; i++){
		
        var cell_id 								= cells[i].id;
        
        $("#"+cell_id).width(cell_width);
		
    }
	
}

function nu_move_headers(direction,div_number,offset_value){

    var hdrs 										= $("div[id^='nuBrowseTitle']").toArray();
    var arr_current_cell_left_arr 					= JSON.parse(window.nuBROWSERESIZE.array_current_cell_left);

    for (i = div_number + 1 ; i < hdrs.length; i++){
		
        var hdr_id 									= hdrs[i].id;
        var cur_hdr_left 							= arr_current_cell_left_arr[i];

        if (direction == "right"){
            var new_hdr_left 						= cur_hdr_left + offset_value;
        }else if (direction == "left"){
            new_hdr_left 							= cur_hdr_left - offset_value;
        }else{
            new_hdr_left 							= cur_hdr_left;
        }

        $("#"+hdr_id).css({ left: new_hdr_left });

        var hdr_width 								= $("#"+hdr_id).width();
        var new_d_left 								= new_hdr_left + hdr_width - 12;

        nu_move_cells(i, new_hdr_left);
		
    }
    
    nu_resize_footer();

}


function nu_move_cells(col_number, left_value){

    var txt_col_number 								= '_'+col_number ;
    var cells 										= $("div[id$='"+txt_col_number+"']").toArray();
    
    for (j = 0; j < cells.length; j++){
		
        var cell_id 								= cells[j].id;

        $("#"+cell_id).css({ left: left_value });
		
    }    
	
}

function nu_resize_footer(){
    
    var hdrs 										= $("div[id^='nuBrowseTitle']").toArray();
    var k 											= hdrs.length - 1;
    var hdr_id 										= hdrs[k].id;
	var hdr_left 									= $("#"+hdr_id).offset().left;
    var hdr_width 									= $("#"+hdr_id).width();
    var footer_width 								= hdr_left + hdr_width - 11;
    
    $('#nuBrowseFooter').width(footer_width);
    
}

function nu_end_resize(){

    window.nuBROWSERESIZE.x_position 				= 0,
    window.nuBROWSERESIZE.mouse_down 				= false;
    window.nuBROWSERESIZE.pointer 					= '';
    window.nuBROWSERESIZE.current_cell_width 		= '0';
    window.nuBROWSERESIZE.next_cell_left 			= '0';

    if (window.nuBROWSERESIZE.moving_element != ''){
		
        $("#"+window.nuBROWSERESIZE.moving_element).css("background-color", "#CCCCCC");
        window.nuBROWSERESIZE.moving_element 		= '';
		
    }
    
    if (window.nuBROWSERESIZE.last_moved_element != ''){
        $("#"+window.nuBROWSERESIZE.last_moved_element).css("background-color", "#CCCCCC");
    }
    
    nu_set_left_pos_array();
	
	var e											= nuFORM.breadcrumbs.length-1;

	nuFORM.breadcrumbs[e].column_widths				= nu_get_column_widths();
	
}




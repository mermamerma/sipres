/* 
 * Funciones Javascript diversas
 * 
 */


function mensaje(msj) {
	$('#dialog').dialog
	({
		autoOpen: true, modal:true, title: 'Atención',
		buttons: {	Aceptar: function() { $( this ).dialog( 'close' );	} }
	
	});	
	$('#dialog').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>"+msj+"</p>");
}

function block_redirect(msj,url) {
$(function() {
	$.blockUI({ 
		theme:     true, 
		title:    'Atención', 
		message:  "<p>"+msj+"</p><span class='ui-icon ui-icon-circle-check'></span>", 
		timeout: 20000 
	}); 
	
	$(location).attr('href',url);
});
}

function mensaje_redirect(msj,url) {
	$('#dialog').dialog
	({
		autoOpen: true, modal:true, title: 'Atención',
		buttons: {	Aceptar: function() { 
				$( this ).dialog( 'close' );	
				$(location).attr('href',url);
		} }
	
	});	
	$('#dialog').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>"+msj+"</p>");
}

function msj_invalido () {
	$('#dialog').dialog
	({
		autoOpen: true, modal:true, title: 'Atención',
		buttons: {	Aceptar: function() { $( this ).dialog( 'close' );	} }
	
	});
	$('#dialog').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>¡Error, verifique, hay campos invalidos!</p>");
}

function confirmar() {
	//alert('dentro de confirmar') ;
	$(function() {
		$( "#dialog" ).dialog({			
		resizable: true,
		title: 'Atencicón',
		height: 170,
		modal: true,
		buttons: {
			"Aceptar": function() {
				$( this ).dialog( "close" );
				alert('TRUE');
				//eval( funcName + '('+param+')' );  // Hello World				

			},
		"Cancelelar": function() {
			$( this ).dialog( "close" );			
			alert('FALSE');
		}
		}
		});
		$('#dialog').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>¿Esta seguro de Proceder con la acción?</p>");		
		
	});
}


//Validacion para Montos
var amountformat = true;
function enterDecimal1(e){
var kcode; 
var elem;

if(e.which)//Netscape    
{ 
kcode=e.which; 
elem = e.target;
}  
else
if(e.keyCode)//Internet Explorer 
{ 
kcode=e.keyCode; 
elem = e.srcElement;
}

var amountMaxLen = 20;
if(elem.value.length >= amountMaxLen)
{    
return;
}

var val;
var newVal=""; 
switch (kcode){
case 8:
{
if(e.keyCode)//Internet Explorer           
e.returnValue = false;
break;          
}     
default: 
{
if(elem)//Internet Explorer                  
if (amountformat) 
elem.value = replaceAll(elem.value, "," );                     

if (amountformat) {
if ((kcode < 48 || kcode > 57) && kcode != 13)
{
if(e.which)//Netscape 
e.preventDefault();
e.returnValue = false;

if(elem)
formatValor1(elem,true);
}
else if (kcode != 13) formatValor1(elem,false)
else formatValor1(elem,true); 
} else {
if ((kcode < 48 || kcode > 57) && kcode != 46 && kcode != 13)
{
if(e.which)//Netscape 
e.preventDefault();
e.returnValue = false;}
else if (kcode == 46 && elem.value.indexOf(',')!==-1) 
{ 
if(e.which)//Netscape 
e.preventDefault();
e.returnValue = false;
}
}
}
}

}

function replaceAll(value,char){

var result = value;
var posi = value.indexOf(char);
if(posi > -1){
while(posi > -1){
result = value.substring(0,posi);
result = result + value.substring(posi+1);
posi = result.indexOf(char);
value = result;
}    
}

return(result);

}

function formatValor1(campo,preformat) {
var	vr = campo.value;
//vr = vr.replace( ".", "" );
vr = replaceAll( vr, "." );
vr = replaceAll( vr, "," );
campo.value = "";
var sign = "";
if (vr.indexOf('-') != -1) {
vr = replaceAll( vr, "-" );
sign = "-";
}	
var	tam = (preformat) ? vr.length : vr.length + 1;

campo.maxLength = 15;
if ( tam <= 2 ){ 
campo.value = vr ; }
if ( (tam > 2) && (tam <= 5) ){
campo.maxLength = 16;
campo.value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ) ; }
if ( (tam >= 6) && (tam <= 8) ){
campo.maxLength = 17;
campo.value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
if ( (tam >= 9) && (tam <= 11) ){
campo.maxLength = 18;
campo.value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
if ( (tam >= 12) && (tam <= 14) ){
campo.maxLength = 19;
campo.value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
if ( (tam >= 15) && (tam <= 17) ){
campo.maxLength = 20;
campo.value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ;}
var pos = campo.value.indexOf(',');
if (pos != -1) {
vr = campo.value.substr( 0, pos );
if (vr == "00" || (vr.length == 2 && vr.substr( 0, 1) == "0")) campo.value =  campo.value.substr(1, tam);
}
campo.value = sign + campo.value;	
}

//Montos
function completarDecimalesMonto(campo)
{
var monto = campo.value;
var vectorMonto;

vectorMonto = monto.split(","); 
if(vectorMonto.length==1 && monto!="")  	  
{
campo.value = campo.value + ",00";  	  
} 
else
if(vectorMonto.length==2)
{
if(vectorMonto[1].length==0)
campo.value = campo.value + "00";
else	
if(vectorMonto[1].length==1)
campo.value = campo.value + "0";
} 
}

//Impreion de Resumen
function doPrint(){
if (!window.print) {
var msg =       "Dear Customer:\n";
msg = msg + "to use the print boton,\n";
msg = msg + "please upgrade your browser.";
alert(msg);

return;
}

if(document.forms[0] != null)
{
var tabla780 = document.forms[0].getElementsByTagName('table');
for(var i=0; i < tabla780.length; i++)
{
if (tabla780[i].width == '780')
tabla780[i].width = '620';
}
}
window.focus();
window.print();

if(document.forms[0] != null)
{
for(var i=0; i < tabla780.length; i++)
{
if (tabla780[i].width == '620')
tabla780[i].width = '780';
}
}
return;
}

//Valida formato Integer
function enterInteger(e) {

var kcode; 
var elem;

if(e.which)//Netscape    
{ 
kcode=e.which; 
elem = e.target;
}  
else
if(e.keyCode)//Internet Explorer 
{ 
kcode=e.keyCode; 
elem = e.srcElement;
}

switch (kcode){
case 8:
{
if(e.keyCode)//Internet Explorer           
e.returnValue = false;
break;          
}   
default: {
if ((kcode < 48 || kcode > 57) && kcode != 13)
{ 
if(e.which)//Netscape 
e.preventDefault();
e.returnValue = false;
}

}
}
}

function setval(valor,frm) {
pinIntroducido = "";
asteriscos = "";
teclasPresionadas = 0;
vpinIntroducido = "";	
if(valor == 'OPASSWORD'){
document.forms[frm].campo.value='OPASSWORD';
document.forms[frm].OPASSWORD.value='';
document.forms[frm].VOPASSWORD.value='';
}
else if (valor == 'NPASSWORD'){
document.forms[frm].campo.value='NPASSWORD';
document.forms[frm].NPASSWORD.value='';
document.forms[frm].VNPASSWORD.value='';
}
else if (valor == 'CPASSWORD'){
document.forms[frm].campo.value='CPASSWORD';
document.forms[frm].CPASSWORD.value='';
document.forms[frm].VCPASSWORD.value='';
}
}

//Funciones para cerrar
function cerrarIB()
{
setTimeout("window.top.location='login_logout.jsp';",100);
}

function goToIndex()
{
setTimeout("parent.window.location.href='" + webapp + "/';",100);
}

function cerrarIBFromPopUp()
{
setTimeout("opener.parent.window.location.href='" + webapp + "/login_logout.jsp';",100);
}

function goToIndexFromPopUp()
{
setTimeout("opener.parent.window.location.href='" + webapp + "/';",100);
}

function goToMainPage()
{
setTimeout("window.location.href='" + webapp + "/body_inimessages.jsp';",100);
}

//ErroresHTML
function monstrarErroresHTML (mensaje){

document.getElementById("transerrorSpan").innerHTML = mensaje;
document.getElementById('transerror').style.display='';

}

function ocultarErroresHTML (){

if(document.getElementById("transerror"))
document.getElementById("transerror").style.display="none"; 

}
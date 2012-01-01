var affichage_courant;
var menu_courant ="menu_1" ;
var iterateur=1;
var id_selected=null;

/***********************************/
/***********************************/
//Nombre de fonds ?charger al閍toirement
var nb_themes_total = 6;
/***********************************/
/***********************************/

function ChangeDisplay(id){
if(affichage_courant)
	document.getElementById(affichage_courant).style.display='none';
affichage_courant='detail_'+id;
id_selected = id;
document.getElementById(affichage_courant).style.display='block';

//On rends opaque les autres liens en parcourant les liens de la page et en testant l'id de chacun
var liste_liens = document.getElementsByTagName('a');
for(var i=0;i<liste_liens.length;i++)
{
	if(document.getElementsByTagName('a')[i].id.indexOf('a_')!=-1 && document.getElementsByTagName('a')[i].id!='a_'+id)
	{
		if(ie5) document.getElementsByTagName('a')[i].style.filter="alpha(opacity:70)"; 
		else if(ns6) document.getElementsByTagName('a')[i].style.MozOpacity = 70/100; 
	}
}
//Selection du lien clique
if(ie5) document.getElementById('a_'+id).style.filter="alpha(opacity:100)"; 
else if(ns6) document.getElementById('a_'+id).style.MozOpacity = 1; 
opac=0;
fadeIns(affichage_courant);	
}

function ChangeMenu(id){
if(menu_courant)
document.getElementById(menu_courant).style.display='none';
menu_courant=id;
document.getElementById(menu_courant).style.display='block';
//fadeIns(menu_courant);	
}

function Fade(id){
	var elt = document.getElementById('detail_'+id);
	new Effect.Fade(elt);
/*
	if(elt.style.display=='none' || elt.style.display=='')
		new Effect.Fade(elt);
	else
		new Effect.Appear(elt);*/
}
function next(){
if(iterateur==5)
iterateur = 1;
else
iterateur++;

ChangeMenu("menu_"+iterateur);
}
function previous(){
if(iterateur==1)
iterateur = 5;
else
iterateur--;

ChangeMenu("menu_"+iterateur);
}




function validForm()
{
	formulaire = document.getElementById("contactForm");
	if(trim(formulaire.nom.value) == '')
	{
		alert('Merci de saisir votre nom.');
		formulaire.nom.focus();
		return false;
	}
	if(trim(formulaire.mail.value) == '')
	{
		alert('Merci de saisir une adresse mail.');
		formulaire.mail.focus();
		return false;
	}
	if(trim(document.getElementById('verif').value) == '')
	{
		alert('Merci de recopier la combinaison apparaissant sur l\'image.');
		document.getElementById('verif').focus();
		return false;
	}

	if(trim(formulaire.message.value) == '')
	{
		alert('Merci de saisir votre message.');
		formulaire.message.focus();
		return false;
	}
	else//Validation de l'arobase dans l'adresse
	{
		var a=trim(formulaire.mail.value);
		var test="" + a;
		for(var k = 0; k < test.length;k++)
		{
			var c = test.substring(k,k+1);
			if(c == "@")
			{
				return true;
			}
		}
		alert("Merci de saisr une adresse mail valide.");
		formulaire.mail.focus();
		return false;
	}
}

function trim(value) {
   var temp = value;
   var obj = /^(\s*)([\W\w]*)(\b\s*$)/;
   if (obj.test(temp)) { temp = temp.replace(obj, '$2'); }
   var obj = / +/g;
   temp = temp.replace(obj, " ");
   if (temp == " ") { temp = ""; }
   return temp;
}

function verif_mail(mail) 
{
	var arobase = mail.indexOf("@");
	var point = mail.lastIndexOf(".");
	if((arobase < 3)||(point + 2 > mail.length)||(point < arobase+3))
		return false;
	else
		return true
}



function largeur_fenetre()
{
 if (window.innerWidth) return window.innerWidth;
 else if (document.body && document.body.offsetWidth) return document.body.offsetWidth;
 else return 0;
}

function hauteur_fenetre()
{
	var retour1=0;
	var retour2=0;
	if (window.innerHeight)//Firefox
	{
		if(document.getElementById('footer'))
			retour1 = document.getElementById('footer').offsetHeight;
		return ((window.innerHeight-retour1)+'px');
	}
	else if (document.body && document.body.offsetHeight) //IE
	{
		if(document.getElementById('footer'))
			retour1 = document.getElementById('footer').offsetHeight;

		return (document.body.offsetHeight-retour1);	
	}
	else return 0;
}

//var largeur=0;
//var hauteur=0;
function reconstruction()
{
	if (largeur != largeur_fenetre() || hauteur != hauteur_fenetre())
	{
		//if(document.getElementById('content'))
//			document.getElementById('content').style.height=hauteur_fenetre();
//		alert(document.body.offsetHeight);
	}
}


ie5 = (document.all && document.getElementById); 
ns6 = (!document.all && document.getElementById); 
opac = 0; 
sens=0;
timerIn=null;
timerOut=null;


function fadeIn(elmt) { 
	if(opac<=100){ 
//		alert('IN='+opac);
		opac+=5;
		if(ie5) document.getElementById(elmt).style.filter="alpha(opacity:"+opac+")"; 
		else if(ns6) document.getElementById(elmt).style.MozOpacity = opac/100; 
		timerIn=setTimeout('fadeIn(\''+elmt+'\')', 10); 
		if(timerOut)
			clearTimeout(timerOut);
	}
	else
		clearTimeout(timerIn);
} 

function fade_over(id,opac)
{
	if(ie5 && 'a_'+id_selected!=id) document.getElementById(id).style.filter="alpha(opacity:"+opac+")"; 
	else if(ns6 && 'a_'+id_selected!=id) document.getElementById(id).style.MozOpacity = opac/100; 
}

function fadeOut(elmt) { 
	if(opac>=0){ 
//		alert('OUT='+opac);
		opac-=5;
		if(ie5) document.getElementById(elmt).style.filter="alpha(opacity:"+opac+")"; 
		else if(ns6) document.getElementById(elmt).style.MozOpacity = opac/100; 
		timerOut=setTimeout('fadeOut(\''+elmt+'\' )', 10); 
		if(timerIn)
			clearTimeout(timerIn);
	} 
	else
		clearTimeout(timerOut);
} 

function fadeIns(id) { 
	if(opac<=100){ 
		opac+=1;
		if(ie5) 
		{
/*			document.getElementById(id).style.filter="alpha(opacity:"+opac+")" ; */
/*			document.getElementsByTagName('h1')[1].style.background="url(images/pxl_blank.gif)" ;*/
		}
		else if(ns6) document.getElementById(id).style.MozOpacity = opac/100; 
		setTimeout('fadeIns(\''+id+'\')', 10); 
		if(timerOut)
			clearTimeout(timerOut);
	}
	else
		clearTimeout(timerIn);
} 

function fadeOuts(id) { 
	if(opac>=0){ 
		opac-=10;
		if(ie5) document.getElementById(id).style.filter="alpha(opacity:"+opac+")"; 
		else if(ns6) document.getElementById(id).style.MozOpacity = opac/100; 
	setTimeout('fadeOuts(\''+id+'\')', 10); 
	} 
} 

//Fonction pour masquer une image en fondu, charger une nouvelle image et la faire apparaitre en fondu
function fadeOutsInImage(id,new_img,legende) { 
	//changement de sens
	if(opac<=0 && sens==0)
	{
		sens=1;
		//Chargement de la nouvelle image
		document.getElementById(id).src=new_img;
		document.getElementById('legende_texte').innerHTML=legende;
	}

	if(opac>=0 && sens==0)
	{ 
		opac-=10;
		if(ie5) document.getElementById(id).style.filter="alpha(opacity:"+opac+")"; 
		else if(ns6) document.getElementById(id).style.MozOpacity = opac/100; 
		setTimeout('fadeOutsInImage(\''+id+'\',\''+new_img+'\',\''+legende+'\')', 10); 
	}
	//Apparition
	if(opac<=100 && sens==1)
	{
		opac+=2;
		if(ie5) document.getElementById(id).style.filter="alpha(opacity:"+opac+")"; 
		else if(ns6) document.getElementById(id).style.MozOpacity = opac/100; 
		setTimeout('fadeOutsInImage(\''+id+'\',\''+new_img+'\')', 10); 
	}
} 


	function getElementsByClassNameforAllElements(className){
		var AllElements = document.getElementsByTagName('*');		//On r閏up鑢e tous les 閘閙ents de la page web
		for (var ii = 0; ii < AllElements.length; ++ii) { //On les scanne tous un par un
			AllElements[ii].getElementsByClassName = function(className) { //Pour chaque 閘閙ent on rajoute la fonction getElementsByClassName
				var MyClassArray = getElementsByClassName(className, this);
				return MyClassArray;
			}
		}
		
		//Tous les 閘閙ents on 閠?trait閟 sauf l'objet document, donc on lui rajoute aussi la m閠hode
		document.getElementsByClassName = function(className){
			var MyClassArray = getElementsByClassName(className, this);
			return MyClassArray;
		}
	}
	
	function getElementsByClassName (className, theElement){
		var elts = theElement.getElementsByTagName('*');
		var classArray = new Array();
		for (var j = 0; j < elts.length; ++j) {
		if (elts[j].className.indexOf(className) != -1) {
				classArray.push(elts[j]);
			}
		}
		return classArray;
	}



function opacity() { 
/*
		if(ie5) document.getElementById('date').style.filter="alpha(opacity:20)"; 
		if(ns6) document.getElementById('date').style.MozOpacity = 0.2; 
		
		tab = getElementsByClassName('opacity',document);
		for(var i=0;i<tab.length;i++)
		{
		tab[i].style.MozOpacity = 0.2;
		}
*/

	tabLink = getElementsByClassName('linkOpacity',document);
		for(var i=0;i<tabLink.length;i++)
		{
			tabLink[i].onmouseover = function () {
					this.style.MozOpacity = 0.8;
			}
			tabLink[i].onmouseout = function () {
					this.style.MozOpacity = 1;
			}
		tabLink[i].style.MozOpacity = 1;
		}
} 



if(!window.largeur && window.innerWidth)
{
   window.onresize = reconstruction;
   largeur = largeur_fenetre();
   hauteur = hauteur_fenetre();
}

function change_theme(num_theme)
{
	//Suppression du cookie
	cre_cook("id_fond","",-1);
	document.body.className=num_theme;
	setCook('id_fond',num_theme);
}

/*COOKIES*/
  function setCook(nom,valeur) {
        document.cookie = nom + "=" + escape(valeur)
        }

   function cre_cook(nom,contenu,jour) {
      var expireDate = new Date();
      expireDate.setTime(expireDate.getTime() + jour*24*3600*1000);
      document.cookie = nom + "=" + escape(contenu)
         + ";expires=" + expireDate.toGMTString();
      }
     
   function lit_cook(nom) {
      var deb,fin
      deb = document.cookie.indexOf(nom + "=")
      if (deb >= 0) {
         deb += nom.length + 1
         fin = document.cookie.indexOf(";",deb)
         if (fin < 0) fin = document.cookie.length
         return unescape(document.cookie.substring(deb,fin))
         }
      return ""
      }
     
   function tue_cook(nom) { cre_cook(nom,"",-1) }

function getCookie(nameCookie) {
var cookieTrouve=false;
var debut=0;
var fin=0;
var ch=document.cookie;
var i=0;
while (i<=ch.length) {
debut=i;
fin=debut+nameCookie.length;
if (ch.substring(debut,fin)==nameCookie) {
cookieTrouve=true;
break;
}
i++;
}
if (cookieTrouve) {
debut=fin+1;
fin=document.cookie.indexOf(";",debut);
if(fin<debut)
fin=document.cookie.length;
return document.cookie.substring(debut,fin);
}
return "";
}


function aleatoire(N) {
      return (Math.floor((N)*Math.random()+1));
   }

//Test existence cookie
if(getCookie('id_fond')=='')
{
	setCook('id_fond','theme'+aleatoire(nb_themes_total),1);
}

c=lit_cook('id_fond');
/*COOKIES EOF*/

//Validation du formulaire de contact
function valid_contact_form()
{
	var erreur = false;
	var msg_erreur="Merci de saisir les informations suivantes : \n";
	
	if(document.getElementById('nom').value=='' || document.getElementById('nom').value=='nom')
	{
		erreur=true;
		msg_erreur += "* Votre nom\n";
		document.getElementById('nom').className+=' non_saisi';
	}

	if(document.getElementById('mail').value=='' || document.getElementById('mail').value=='email')
	{
		erreur=true;
		msg_erreur += "* Votre adresse mail\n";
		document.getElementById('mail').className+=' non_saisi';
	}
	else//Validation de l'arobase dans l'adresse
	{
		var a=trim(document.getElementById('mail').value);
		var test="" + a;
		for(var k = 0; k < test.length;k++)
		{
			var c = test.substring(k,k+1);
			if(c == "@")
			{
				return true;
			}
		}
		erreur=true;
		msg_erreur += "* Votre adresse mail est incorrecte\n";
		document.getElementById('mail').className+=' non_saisi';
	}

	if(erreur==true)
	{
			alert(msg_erreur);
			return false;
	}
	else
			return true;
}

/*
var pageInit

window.onload = function() 
{
	if(pageInit) {
		pageInit();
	}
	var aList = document.getElementsByTagName('a');
	for(var i=0;i<aList.length;i++) 
	{
			aList[i].onfocus = function() 
			{
				this.blur();
			}
		}
}
*/



<!--- Hide from non-JavaScript browsers 日期
var date=new Date();
function mois() {
argnr = mois.arguments.length
for (var i = 0; i < argnr; i++)
this[i+1] = mois.arguments[i]
}
var isnMonths= new mois("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");
var jours= new mois("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
browserName = navigator.appName;
browserVer = parseInt(navigator.appVersion);
if (browserName == "Netscape" && browserVer >= 4 || browserName == "Microsoft Internet Explorer" && browserVer >=4) version = "nsie4";
else version = "x";
if (version == "nsie4"){
document.write ("<span id='day'>&nbsp;" + (date.getDate()<10?"0"+date.getDate():date.getDate()) + "<\/span><span id='month'>" + isnMonths[date.getMonth() + 1] + "<\/span><span id='year'>&nbsp;" +date.getFullYear() + "<\/span>");
}
opacity();
// stop hiding-->
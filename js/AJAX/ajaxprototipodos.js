//domuneto de java scrip para la carga de las capas sin recargar la pagina
var LoginVisible = true;

function nuevoAjax(){//funcion fundamental apar agenrar el ajax
var xmlhttp=false;
 try {
  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 } catch (e) {
  try {
   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (E) {
   xmlhttp = false;
  }
 }

if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
  xmlhttp = new XMLHttpRequest();
}
return xmlhttp;
}

function cargarcapa()
{//muestar la capa donde se encuentra la informacion de login 
  if (!enabled) return;
  
  var d, m, e, a, i;
  
  if (LoginVisible) {
      d = 'visible';    
  }
  
  else {
	   d = 'hidden';
  }
  e = document.getElementById('capa_login_usario');
  e.style.visibility=d;

  i = document.getElementById('ingreso');
  i.style.visibility=d;

  LoginVisible=!LoginVisible;
}

function cargarcapalogin()
{//carga la capa que muestra la informacion del usuario 

var capa,pa,lo;

capa = document.getElementById('capa_configuracionalt');
    
	
	ajax=nuevoAjax();

	lo = document.getElementById('user').value;
    pa = document.getElementById('pass').value;

	ajax.open( "POST" , "../../indexlog.php?user="+lo+"&pass="+pa+"&LOGIN=TRUE", true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }
	
	ajax.send(null);
	
	window.location.reload()
}

function cargarcapaToDo()
{//carga la capa que muestra la informacion del usuario 

var capa;

capa = document.getElementById('capaparaToDo');
    
	ajax=nuevoAjax();
	
	ajax.open( "GET" , "../../ToDo.php", true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }
	
	ajax.send(null);
}




function salidadeUsuario()
{
var love,location;//capa,love;

location = 'indice.php';

	ajax = nuevoAjax();

    love = "Logout";
	
	ajax.open( "POST" , "../indexPie.php?LOGOUT="+love , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }
	
	ajax.send(null);
	
	window.location.reload()
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*function cargarcapaAplicacion(capadestino,direccionaplicacion)
{//carga la capa que dependiendo de las variables que se envien 

var capa;

capa	=	document.getElementById(capadestino);
    
	ajax = nuevoAjax();
	
	ajax.open( "POST" , direccionaplicacion,true);
    
	ajax.onreadystatechange=function() 
	    {
		  // if (ajax.readyState==4) 
		    //  {
		      //  capa.innerHTML=ajax.responseText
	 	      //}
			  
		 if (ajax.readyState == 4) {
        if (ajax.status == 200) {
            capa.innerHTML = ajax.responseText;
        }
    } else {
		
        capa.innerHTML = "<div align='center'><img src='imagenes/iconos/indicator.gif' /></div>";
    }	  
			  
			  
			  
			  
	    }
	
	ajax.send(null);
}*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function cargarcapaAplicacion(id_contenedor,url)
{
    var pagina_requerida = false;
    if (window.XMLHttpRequest)
    {
        // Si es Mozilla, Safari etc
        pagina_requerida = new XMLHttpRequest ();
    } else if (window.ActiveXObject)
    {
        // pero si es IE
        try 
        {
            pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            // en caso que sea una versión antigua
            try
            {
                pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
            }
            catch (e)
            {
            }
        }
    } 
    else
    return false;
    pagina_requerida.onreadystatechange = function ()
    {
        // función de respuesta
        cargarpagina (pagina_requerida, id_contenedor);
    }
    pagina_requerida.open ('GET', url, true); // asignamos los métodos open y send
    pagina_requerida.send (null);
}

// todo es correcto y ha llegado el momento de poner la información requerida
// en su sitio en la pagina xhtml
function cargarpagina (pagina_requerida, id_contenedor)
{
    if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
    document.getElementById (id_contenedor).innerHTML = pagina_requerida.responseText;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function generarbusqueda()
{//carga la capa que dependiendo de las variables que se envien 

var capa,busqueda,tab,nodo;

capa	=	document.getElementById('capa_Contenido_Aplicacion');
busqueda=	document.getElementById('busqueda').value;
tab		=	document.getElementById('tab').value;
nodo	=	document.getElementById('nodo').value;


	ajax=nuevoAjax();
	
	ajax.open( "POST", "modulos/documentos/index.php?busqueda = " +  busqueda + "&&tab=" + tab + "&&nodo=" + nodo , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }
	
	ajax.send(null);
}

function cargarAreasyNodos(area,nodo)
{/////para recargar pagina y generar la informacion de las diferentes areas y nodos
var capa,areavariable,nodovariable;

capa = document.getElementById('capa_Contenido_Aplicacion');

areavariable = area;
nodovariable = nodo;
	
	ajax = nuevoAjax();

	ajax.open( "POST" , "modulos/documentos/index.php?tab="+areavariable+"&nodo="+nodovariable,true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }
	
	ajax.send(null);
}


function mostrardocumentos(nodo,tab,sig,rut)
{//con este ajax creamos es empleaado par el area de documentos y para el modificacion de datos de area de documentos

    capa = document.getElementById('capa_Contenido_Aplicacion');

    ajax = nuevoAjax();

ajax.open( "POST" , "modulos/documentos/index.php?nodo=" + nodo + "&&tab=" + tab +"&&sig=" + sig + "&&rut=" + rut + "&&ind=1" , true);
  
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////
function crearAreasyNodos()
{
var capa,nombre,sel,selAcc,pub,arb,a,b;

nombre	= document.getElementById('nombreArea').value;
sel		= document.getElementById('seleccionado').value;
selAcc	= document.getElementById('seleccionadoAcc').value;
var uSelA;
var uSelAcc;
a=0;
b=0;

    for (var intLoop=0; intLoop < document.getElementById('userSelectAdm').length; intLoop++) {
         if (document.getElementById('userSelectAdm').options[intLoop].selected) 
		    {
		      if(a==0){
			  uSelA=document.getElementById('userSelectAdm').options[intLoop].value; 
			  a++;}
			  else{uSelA+="-"+document.getElementById('userSelectAdm').options[intLoop].value;
			      }
             }
	     }
  
	  for (var intLoop=0; intLoop < document.getElementById('userSelectAcc').length; intLoop++) {
         if (document.getElementById('userSelectAcc').options[intLoop].selected) 
		    {
             if(b==0){
			 uSelAcc=document.getElementById('userSelectAcc').options[intLoop].value;
			 b++;}
			 else{uSelAcc+="-"+document.getElementById('userSelectAcc').options[intLoop].value;}
            }
      }


  capa = document.getElementById('capa_Contenido_Aplicacion');


  ajax = nuevoAjax();

        if(document.getElementById('Boton').value=="Crear")
		  {
		     if(document.getElementById('publico').checked==true){pub=1;} else{pub=0;}
		     
			 if(document.getElementById('arbol').checked==true){arb=1;} else{arb=0;}
		   
		   /*pub = document.getElementById('publico').value;
           arb = document.getElementById('arbol').value;*/
		    
		   ajax.open("POST" , "modulos/documentos/crearAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=" + selAcc + "&userSelectAdmtemp=" + uSelA + "&userSelectAcctemp=" + uSelAcc + "&publico=" + pub + "&arbol=" + arb + "&Boton=True" , true);


           }
         else{
			  
			  var colorsel 	= document.getElementById('color').value;
		      nodoenv 		= document.getElementById('nodo').value;
              idarea  		= document.getElementById('id_area').value;  
 
			  ajax.open("POST" , "modulos/documentos/modificarAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=" + selAcc + "&userSelectAdmtemp=" + uSelA + "&userSelectAcctemp=" + uSelAcc + "&nodo=" + nodoenv + "&id_area=" + idarea + "&Boton=1&color=" + colorsel , true);
			 }

    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}


//////////////////////////////////////////////////////////////////////////////////////////////////
function borrarAreas()
{
var capa,codarea;

codarea	=	document.getElementById('areasSelectAdm').value;

capa	=	document.getElementById('capa_Contenido_Aplicacion');


  ajax=nuevoAjax();

ajax.open("POST" , "modulos/documentos/borrarAreaDocumentos.php?areasSel=" + codarea + "&Boton=True" , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////
function capacrearAreasContactos()
{////////////para la eliminacion de las areas de contacto
var capa,nombrearea;

nombrearea	=	document.getElementById('nombreArea').value;
capa		=	document.getElementById('capa_Contenido_Aplicacion');


  ajax = nuevoAjax();

ajax.open("POST" , "modulos/directorios/crearAreaContactos.php?nombreArea=" + nombrearea + "&Boton=True" , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}

function capaborrarAreasContactos()
{////////////para la eliminacion de las areas de contacto
var capa,nombrearea;

nombrearea	= document.getElementById('areasSelectAdm').value;
capa		= document.getElementById('capa_Contenido_Aplicacion');


  ajax=nuevoAjax();

ajax.open("POST" , "modulos/directorios/borrarAreaContactos.php?areasSelectAdm=" + nombrearea + "&Boton=True" , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}


function capaCargaDirectorio()
{////////////para la eliminacion de las areas de contacto
var capa,nombrearea;

nombrearea	=	document.getElementById('tipo').value;
capa		=	document.getElementById('capa_Contenido_Aplicacion');

  ajax=nuevoAjax();

ajax.open( "POST" , "modulos/directorios/index.php?tipo=" + nombrearea , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}

function capaCargaBusqueda()
{////////////para la eliminacion de las areas de contacto
var capa,buscar;

buscar	=	document.getElementById('search_string').value;
capa	=	document.getElementById('capa_Contenido_Aplicacion');


  ajax=nuevoAjax();

ajax.open( "POST" , "modulos/directorios/index.php?search_string=" + buscar + "&m='contacts'&tipo=0" , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}

function capaInsertarTexto()
{////////////para la eliminacion de las areas de contacto
var capa,titulo,tipo,men,autor;

capa	= document.getElementById('capa_Contenido_Aplicacion');
titulo	= document.getElementById('titulo');
tipo	= document.getElementById('tipo');
men		= document.getElementById('men');
autor	= document.getElementById('autor');

  ajax=nuevoAjax();

ajax.open( "POST" , "modulos/directorios/index.php?titulo='" + titulo + "'&tipo='" + tipo + "'&men='" + men + "'&autor='" + autor + "'" , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}


function crearAuditorios()
{
var capa;

capa=document.getElementById('capa_Contenido_Aplicacion');


  ajax=nuevoAjax();

var vabot=document.getElementById('Boton').value;


if(vabot=="Crear Auditorio")
   {
    var nombre=document.getElementById('nombreArea').value;

ajax.open("POST","modulos/auditorio/crearAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=0&seleccionadoAcc=0&Boton=TRUE",true);
   }

if(vabot=="Actualizar")
   {
	var nombre	=document.getElementById('nombreArea').value;
	var id_area	=document.getElementById('id_area').value;
	   
	 ajax.open("POST","modulos/auditorio/modificarAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=0&seleccionadoAcc=0&id_area=" + id_area + "&Boton=TRUE",true);
   }

if(vabot=="Borrar")
   {
	 var area=document.getElementById('areasSelectAdm').value;
     
	 ajax.open("POST","modulos/auditorio/borrarAreaDocumentos.php?areasSelectAdm=" + area + "&Boton=TRUE",true);
   }


	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}
////////////////////////////////////////////////////////////////////////////////////////////////
function capaSolictudHelpdesk()
{
var capa,area,user,naturaleza,texto,admin,id_area;

capa		=	document.getElementById('capa_Contenido_Aplicacion');
area		=	document.getElementById('areaSelect').value;
user		=	document.getElementById('userSelect').value;
naturaleza	=	document.getElementById('naturaleza').value;
texto		=	document.getElementById('textodescripcion').value;
admin		=	document.getElementById('administrador').value;
id_area		=	document.getElementById('id_area').value;

 
  ajax=nuevoAjax();
 

ajax.open( "POST" , "modulos/helpdesk/formaSoporte.php?areaSelect=" + area + "&userSelect=" + user + "&naturaleza=" + naturaleza + "&textodescripcion=" + texto + "&administrador=" + admin + "&id_area=" + id_area + "&Boton=TRUE" , true);
  

	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
  	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function cargarcapaEstadoHelpdesk(valor)
{
var capa,observaciones,id_solucion,identificador,email,email3,email4,id_pendiente,textarea,textarea3,identificador4,prueba;

capa		=	document.getElementById('capa_Contenido_Aplicacion');

ajax=nuevoAjax();



if(valor==1)
   {
     observaciones	=	document.getElementById('observaciones').value;
     id_solucion	=	document.getElementById('id_solucion').value;
     identificador	=	document.getElementById('identificador').value;
     email			=	document.getElementById('email').value;

     ajax.open("POST","modulos/helpdesk/requerimientosSoporte.php?id_solucion=" + id_solucion + "&identificador=" + identificador + "&observaciones=" + observaciones + "&email=" + email ,true);
   }

if(valor==2)
   {
    observaciones	=	document.getElementById('textarea3').value;
	id_pendiente	=	document.getElementById('id_pendiente').value;
	identificador	=	document.getElementById('identificador').value;
    email			=	document.getElementById('email').value;
	
	ajax.open("POST","modulos/helpdesk/requerimientosSoporte.php?id_pendiente=" + id_pendiente + "&identificador=" + identificador + "&observaciones=" + observaciones + "&email=" + email ,true);
   }

if(valor==3)
   {
    id_solucion		=	document.getElementById('id_solucion').value;
    identificador	=	document.getElementById('identificador').value;
    email			=	document.getElementById('email3').value;
    //observaciones	=	document.getElementById('observaciones').value;
	observaciones	=	document.getElementById('textarea3').value;
    ajax.open("POST","modulos/helpdesk/requerimientosSoporte.php?id_solucion=" + id_solucion + "&identificador=" + identificador + "&observaciones=" + observaciones + "&email=" + email ,true);
   }
   
if(valor==4)
   {
    observaciones	=document.getElementById('textarea3').value;
    email			=document.getElementById('email4').value;
	id_pendiente	=document.getElementById('id_pendiente').value;
    identificador	=document.getElementById('identificador4').value;

	ajax.open("POST","modulos/helpdesk/requerimientosSoporte.php?id_pendiente=" + id_pendiente + "&identificador=" + identificador + "&observaciones=" + observaciones + "&email=" + email ,true);
   }
	

	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
  	
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function crearymodoficarNoticias(accion)
{
var capa,selAcc,pub,arb,a,b;

capa = document.getElementById('capa_Contenido_Aplicacion');


ajax = nuevoAjax();


if(accion==1)
   {
    var nombre	= document.getElementById('nombreArea').value;
    var sel		= document.getElementById('seleccionado').value;
    var colorsel=	0;
    var uSelA;
    a=0;
    b=0;

       for (var intLoop=0; intLoop < document.getElementById('userSelectAdm').length; intLoop++) {
            if (document.getElementById('userSelectAdm').options[intLoop].selected) 
		       {
		        if(a==0){
			             uSelA=document.getElementById('userSelectAdm').options[intLoop].value; 
			             a++;}
			        else{uSelA+="-"+document.getElementById('userSelectAdm').options[intLoop].value;
			            }
                }
	        }  

		      var nodoenv 		= document.getElementById('nodo').value;
              var idarea  		= document.getElementById('id_area').value;  
 
			  ajax.open("POST" , "modulos/noticias/modificarAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=" + selAcc + "&userSelectAdmtemp=" + uSelA + "&userSelectAcc=0" + "&nodo=" + nodoenv + "&id_area=" + idarea + "&Boton=1&color=" + colorsel , true);

////////////////////////////////////////////////////////////////
}


if(accion==2)
   {
    var nombre	= document.getElementById('nombreArea').value;
    var sel		= document.getElementById('seleccionado').value;
    var colorsel=	0;
    var uSelA;
    a=0;
    b=0;

       for (var intLoop=0; intLoop < document.getElementById('userSelectAdm').length; intLoop++) {
            if (document.getElementById('userSelectAdm').options[intLoop].selected) 
		       {
		        if(a==0){
			             uSelA=document.getElementById('userSelectAdm').options[intLoop].value; 
			             a++;}
			        else{uSelA+="-"+document.getElementById('userSelectAdm').options[intLoop].value;
			            }
                }
	        }  
 
			  ajax.open("POST" , "modulos/noticias/crearAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=" + selAcc + "&userSelectAdmtemp=" + uSelA + "&userSelectAcc=0" + "&Boton=1", true);

////////////////////////////////////////////////////////////////
}

    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}




function borrarAreasNoticias()
{
var capa,codarea;

codarea	=	document.getElementById('areasSelectAdm').value;

capa	=	document.getElementById('capa_Contenido_Aplicacion');


  ajax=nuevoAjax();

ajax.open("POST" , "modulos/noticias/borrarAreaDocumentos.php?areasSelectAdm=" + codarea + "&Boton=True" , true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}


function capaInsertarNoticia(accion)
{

var capa;
capa	=	document.getElementById('capa_Contenido_Aplicacion');


  ajax=nuevoAjax();


if(accion==1)
  {
   var titulo 			=	document.getElementById('titulo').value;
   var textodescripcion = 	document.getElementById('textodescripcion').value;
   var autor 			=	document.getElementById('autor').value;
   var id_area 			= 	document.getElementById('id_area').value;
   var men 				= 	document.getElementById('men').value;	
   ajax.open("POST","modulos/noticias/insertarNoticia.php?titulo=" + titulo + "&textodescripcion=" + textodescripcion + "&men=" + men + "&autor=" + autor + "&id_area=" + id_area, true);

  }
    
if(accion==3)
  {
	var titulo 				= 	document.getElementById('titulo').value;
    var textodescripcion 	= 	document.getElementById('textodescripcion').value;
    var autor 				=	document.getElementById('autor').value;
    var men 				= 	document.getElementById('men').value;
    var id_noticias			=	document.getElementById('id_noticias').value;
    ajax.open("POST" , "modulos/noticias/editarNoticia.php?titulo=" + titulo + "&textodescripcion=" + textodescripcion + "&men=" + men + "&autor=" + autor +  "&id_area=" + id_area + "&id_noticias=" + id_noticias, true);

  }


if(accion==4)
  {
    var confirmacion		= 	document.getElementById('confirmacion').value;
	//var confirmaciondos		= 	document.getElementById('confirmaciondos').value;
    var id_noticias			=	document.getElementById('id_noticias').value;
	ajax.open("POST" , "modulos/noticias/borrarNoticia.php?id_noticias=" + id_noticias + "&confirmacion=" + confirmacion, true);
  }


    ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }

	ajax.send(null);
}





//////////////////////////////////////////////////////////////////////////////////////////////////

function cargarCapaEdicion(posx,posy)
{//muestra la capa donde se encuentra la informacion de login 
  
  //if (!enabled) return;
  
  var d,m,e,a,i,pospix,pospiy;
  
  if (LoginVisible) { d = 'visible';  }
  
  else { d = 'hidden'; }
    
  e = document.getElementById('capa_herramientaedicion');

  posx=posx+32;
  posy=posy-15;

  pospix=posx+'px';
  pospiy=posy+'px';
  
    
  e.style.left=pospix;
  e.style.top=pospiy;
  e.style.visibility=d;


  LoginVisible=!LoginVisible;
}

function ocultaresconderCapaEdicion()
{ 
 var d,e;
  
  e = document.getElementById('capa_herramientaedicion');

  if(e.style.visibility=='visible') 
     {  
       d = 'hidden';
       e.style.visibility=d;
       LoginVisible=!LoginVisible;
     }

}



function cargarcapaHerramientaEdicion(accion,sig,rut,nodeName,nodeId,nodo,tabla,tab,vinculo,funcion,textodescripcion,posx,posy)
{


var capa;

capa=document.getElementById("capa_herramientaedicion");


cargarCapaEdicion(posx,posy);

ajax = nuevoAjax();

switch(funcion)
{
case 0:
       
	   
	   ajax.open("POST", "modulos/documentos/herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&textodescripcion=" + textodescripcion + "&funcion=0"  , true);
       break;

case 1:
       ajax.open("POST", "modulos/documentos/herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=1"  , true);
       break;

case 2:
       ajax.open("POST", "modulos/documentos/herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=2"  , true);
        break;


case 3:
      ajax.open("POST", "modulos/documentos/herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=3"  , true);
       break;
	  
case 4:
       var enlace = 	document.getElementById('enlace').value;
	
	   ajax.open("POST", "modulos/documentos/herramientasEdicion.php?accion=" + accion + "&nodeName=" +  nodeName + "&nodo=" + nodo + "&tab=" + tab + "&enlace=" + enlace + "&funcion=4"  , true);
      break;

case 5:
       ajax.open("POST", "modulos/documentos/herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&textodescripcion=" + textodescripcion + "&funcion=5"  , true);
       break;

}



      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ejecutarFuncionEdicion()
{

var funcion = document.getElementById('funcion').value;



var  capa	=	document.getElementById("capa_Contenido_Aplicacion");
    			
ajax = nuevoAjax();


switch(funcion)
{

case "0":
     var accion = 	document.getElementById('accion').value;
     var sig 	= 	document.getElementById('sig').value;
     var rut 	= 	document.getElementById('rut').value;
     var nuevoNombre = 	document.getElementById('nuevoNombre').value;//
	 var nuevaDescripcion = document.getElementById('nuevaDescripcion').value;//
     var nodeId	= 	document.getElementById('nodeId').value;
     var nodo 	= 	document.getElementById('nodo').value;
     var tabla 	= 	document.getElementById('tabla').value;
     var tab 	=	document.getElementById('tab').value;
     var vinculo= 	document.getElementById('link').value;

     ajax.open("POST", accion + "?sig=" + sig + "&rut=" + rut + "&nuevoNombre=" +  nuevoNombre + "&nuevaDescripcion=" + nuevaDescripcion + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=0",true);
     break;


case "1":  
  
	   var accion	=	document.getElementById('accion').value;
       var sig		=	document.getElementById('sig').value;
       var rut		=	document.getElementById('rut').value;
       var nombre	=	document.getElementById('nombre').value;
       var nodeId	=	document.getElementById('nodeId').value;
       var nodo		=	document.getElementById('nodo').value;
       var tabla	=	document.getElementById('tabla').value;
       var tab		=	document.getElementById('tab').value;
       var vinculo	=	document.getElementById('link').value;

       ajax.open("POST",accion + "?sig=" + sig + "&rut=" + rut + "&nombre=" +  nombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=1",true);
     break;


case "2":
   	   var accion = 	document.getElementById('accion').value;
       var sig 	= 	document.getElementById('sig').value;
       var rut 	= 	document.getElementById('rut').value;
       var image= 	document.getElementById('image').value;
	   var descripcion= 	document.getElementById('descripcion').value;
       var nodeId	= 	document.getElementById('nodeId').value;
       var nodo 	= 	document.getElementById('nodo').value;
       var tabla 	= 	document.getElementById('tabla').value;
       var tab 	=	document.getElementById('tab').value;
       var vinculo= 	document.getElementById('link').value;

       ajax.open("POST", accion + "?sig=" + sig + "&rut=" + rut + "&image=" +  image + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&descripcion=" + descripcion + "&MAX_FILE_SIZE=20000000&funcion=2"  , true);
     break;



case "3":
   	 var accion = 	document.getElementById('accion').value;
     var sig 	= 	document.getElementById('sig').value;
     var rut 	= 	document.getElementById('rut').value;
     var nodeName= 	document.getElementById('nodeName').value;
     var nodeId	= 	document.getElementById('nodeId').value;
     var nodo 	= 	document.getElementById('nodo').value;
     var tabla 	= 	document.getElementById('tabla').value;
     var tab 	=	document.getElementById('tab').value;
     var vinculo= 	document.getElementById('link').value;

     ajax.open("POST", accion + "?sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=3"  , true);
     break;


case "4":
     var accion = 	document.getElementById('accion').value;
     var nuevoNombre= 	document.getElementById('nuevoNombre').value;
     var nodeId	= 	document.getElementById('nodeId').value;
     var nodo 	= 	document.getElementById('nodo').value;
     var tab 	=	document.getElementById('tab').value;
     var vinculo= 	document.getElementById('link').value;
     var enlace= 	document.getElementById('enlace').value;
	 
     ajax.open("POST", accion + "?nuevoNombre=" +  nuevoNombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tab=" + tab + "&link=" + vinculo + "&enlace=" + enlace +  "&funcion=4"  , true);
     break;



case "5":
     var accion = 	document.getElementById('accion').value;
     var sig 	= 	document.getElementById('sig').value;
     var rut 	= 	document.getElementById('rut').value;
     var nuevoNombre= 	document.getElementById('nuevoNombre').value;
	 var nuevaDescripcion= 	document.getElementById('nuevaDescripcion').value;
     var nodeId	= 	document.getElementById('nodeId').value;
     var nodo 	= 	document.getElementById('nodo').value;
     var tabla 	= 	document.getElementById('tabla').value;
     var tab 	=	document.getElementById('tab').value;
     var vinculo= 	document.getElementById('link').value;

     ajax.open("POST", accion + "?sig=" + sig + "&rut=" + rut + "&nuevoNombre=" +  nuevoNombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&nuevaDescripcion=" + nuevaDescripcion + "&funcion=5"  , true);
      
//	 ajax.open("POST", accion + "?rut=" + rut + "&nuevoNombre=" +  nuevoNombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&nuevaDescripcion=" + nuevaDescripcion + "&funcion=5"  , true);
  
  
     break;
}


cargarCapaEdicion();

	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }
	
	ajax.send(null);
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cargarHerramientaDirectorio(funcion,tab,accion,contac_owner,arr,textolink,posx,posy)
{

cargarCapaEdicion(posx,posy);

switch (funcion)
 {
  case 0: cargarcapaAplicacion("capa_herramientaedicion","modulos/directorios/herramientas.php?funcion=0&accion=" + accion + "&tab=" + tab + "&contac_owner=" + contac_owner);
  break;

  case 1: cargarcapaAplicacion("capa_herramientaedicion","modulos/directorios/herramientas.php?funcion=1&accion=" + accion + "&tab=" + tab + "&arr=" + arr);
  break;

  case 2: cargarcapaAplicacion("capa_herramientaedicion","modulos/directorios/herramientas.php?funcion=2&accion=" + accion + "&tab=" + tab + "&textolink=" + textolink + "&arr=" + arr);
  break;
 }


}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ejecutarEdicionDiectorio()
{

var funcion = document.getElementById('funcion').value;

switch (funcion)
{

case "0":
     var accion 			= 	document.getElementById('accion').value;
     var contact_first_name = 	document.getElementById('contact_first_name').value;
     var contact_last_name 	= 	document.getElementById('contact_last_name').value;
     var contact_company	= 	document.getElementById('contact_company').value;//
	 var contact_phone 		= 	document.getElementById('contact_phone').value;//
     var contact_phone2		= 	document.getElementById('contact_phone2').value;
     var contact_mobile 	= 	document.getElementById('contact_mobile').value;
     var contact_email 		= 	document.getElementById('contact_email').value;
     
	 
  for(var intLoop=0; intLoop < document.getElementById('directipo').length; intLoop++)
     {
	  if (document.getElementById('directipo').options[intLoop].selected) 
		 { 
		   var tipo=document.getElementById('directipo').options[intLoop].value;
		   intLoop=document.getElementById('directipo').length;
         }
      }

	 if(document.getElementById('contact_private').checked==true) { var contact_private	= 1;}
	 else{var contact_private = 0;}

     var contact_owner		= 	document.getElementById('contact_owner').value;

	 var direccionvars=accion + "?contact_first_name=" + contact_first_name + "&contact_last_name=" + contact_last_name + "&contact_company=" + contact_company + "&contact_phone=" + contact_phone + "&contact_phone2=" + contact_phone2 + "&contact_mobile=" + contact_mobile + "&contact_email=" + contact_email + "&tipo=" + tipo + "&contact_private=" + contact_private + "&contact_owner=" + contact_owner + "&funcion=0";
	 
	 cargarcapaAplicacion("capa_Contenido_Aplicacion",direccionvars);
	 
break;
   


case "1":
     var accion 			= 	document.getElementById('accion').value;
     var contact_first_name = 	document.getElementById('contact_first_name').value;
     var contact_last_name 	= 	document.getElementById('contact_last_name').value;
     var contact_company	= 	document.getElementById('contact_company').value;//
	 var contact_phone 		= 	document.getElementById('contact_phone').value;//
     var contact_phone2		= 	document.getElementById('contact_phone2').value;
     var contact_mobile 	= 	document.getElementById('contact_mobile').value;
     var contact_email 		= 	document.getElementById('contact_email').value;
     var tab 				=	document.getElementById('tab').value;
     var contact_id			= 	document.getElementById('contact_id').value;
    	 

	 var direccionvars=accion + "?contact_first_name=" + contact_first_name + "&contact_last_name=" + contact_last_name + "&contact_company=" + contact_company + "&contact_phone=" + contact_phone + "&contact_phone2=" + contact_phone2 + "&contact_mobile=" + contact_mobile + "&contact_email=" + contact_email + "&tab=" + tab + "&contact_id=" + contact_id + "&funcion=1";
 
     cargarcapaAplicacion("capa_Contenido_Aplicacion",direccionvars);
break;


case "2":
     var accion 			= 	document.getElementById('accion').value;
     var tab 				=	document.getElementById('tab').value;
	 var contact_id			= 	document.getElementById('contact_id').value;
	 var tabla 				=	document.getElementById('tabla').value;
	 var vinculo			= 	document.getElementById('link').value;

	 var direccionvars=accion + "?tab=" + tab + "&contact_id=" + contact_id + "&tabla=" + tabla + "&vinculo=" + vinculo + "&funcion=2";
 
	 cargarcapaAplicacion("capa_Contenido_Aplicacion",direccionvars);
break;
}
	 
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function ingresareliminarEvento()
{

//var capa=document.getElementById('capa_herramientaedicion');


var funcion=document.getElementById('ingreelim').value;



      //ajax=nuevoAjax();

switch(funcion)
{

case "1":
    var nombreevento=document.getElementById('nombreevento').value;
	var descripcion=document.getElementById('descripcion').value;
    var hora=document.getElementById('hora').value;
    var minutos=document.getElementById('minutos').value;
    var horaFinal=document.getElementById('horaFinal').value;
    var minutosFinal=document.getElementById('minutosFinal').value;
    var fecha=document.getElementById('fecha').value;
    var sala=document.getElementById('sala').value;

    cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/index.php?tipfuncion=1&nombreevento=" + nombreevento + "&descripcion=" + descripcion + "&hora=" + hora + "&minutos=" + minutos + "&horaFinal=" + horaFinal + "&minutosFinal=" + minutosFinal + "&fecha=" + fecha + "&sala=" + sala + "&Boton=True");

	/*cargarcapaAplicacion("capa_herramientaedicion","modulos/auditorio/insertarEvento.php?nombreevento=" + nombreevento + "&descripcion=" + descripcion + "&hora=" + hora + "&minutos=" + minutos + "&horaFinal=" + horaFinal + "&minutosFinal=" + minutosFinal + "&fecha=" + fecha + "&sala=" + sala + "&Boton=True");*/
   
   ocultaresconderCapaEdicion();

/*    cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/index.php?fechaingreso="+fecha);
	
	  //ajax.open("POST" , "modulos/auditorio/insertarEvento.php?nombreevento=" + nombreevento + "&descripcion=" + descripcion + "&hora=" + hora + "&minutos=" + minutos + "&horaFinal=" + horaFinal + "&minutosFinal=" + minutosFinal + "&fecha=" + fecha + "&sala=" + sala + "&Boton=True" , true);*/
  
  break;
  


case "2":
         
         var id=document.getElementById('id').value;
		 var fecha=document.getElementById('fecha').value;
   
       
         cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/index.php?tipfuncion=2&id="+id+"&confirmacion=si&Boton=True&fechaingreso="+fecha);
   
         /*cargarcapaAplicacion("capa_herramientaedicion","modulos/auditorio/borrarEvento.php?id=" + id + "&confirmacion=si&Boton=True");*/

         ocultaresconderCapaEdicion();
         
         /*cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/index.php?fechaingreso="+fecha);
	     //ajax.open("POST" , "modulos/auditorio/borrarEvento.php?id=" + id + "&confirmacion=si&Boton=True" , true);*/
   break;
  
}
/*	  ajax.onreadystatechange=function() 
	      {
		    if (ajax.readyState==4) 
		       {
		        capa.innerHTML=ajax.responseText
	 	       }
	      }

	 ajax.send(null);*/
 
  
}



function cargarHerramientaElearning(funcion,nodeName,accion,cat,nodeId,posx,posy)
{

cargarCapaEdicion(posx,posy);

switch(funcion)
{
 case 0:
	cargarcapaAplicacion("capa_herramientaedicion","modulos/elearning/herramientas.php?funcion=0&accion=" + accion + "&nodeName=" + nodeName + "&cat=" + cat + "&nodeId=" + nodeId);
  break;	
   
 case 1:
cargarcapaAplicacion("capa_herramientaedicion","modulos/elearning/herramientas.php?funcion=1&accion=" + accion + "&nodeName=" + nodeName + "&cat=" + cat + "&nodeId=" + nodeId);
  break;
   
 case 2:
	cargarcapaAplicacion("capa_herramientaedicion","modulos/elearning/upload.php?cat=" + cat + "&nodeId=" + nodeId);
  break;
   
 case 3:
	cargarcapaAplicacion("capa_herramientaedicion","modulos/elearning/herramientas.php?funcion=3&accion=" + accion + "&nodeName=" + nodeName + "&cat=" + cat + "&nodeId=" + nodeId);
  break;
   
 case 4:
	cargarcapaAplicacion("capa_herramientaedicion","modulos/elearning/herramientas.php?funcion=4&accion=" + accion + "&nodeName=" + nodeName + "&cat=" + cat + "&nodeId=" + nodeId);
  break;
  
 case 5:
	cargarcapaAplicacion("capa_herramientaedicion","modulos/elearning/herramientas.php?funcion=5&accion=" + accion + "&nodeName=" + nodeName + "&cat=" + cat);
  break;   
}

}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ejecutarEdicionElearning()
{

var funcion = document.getElementById('funcion').value;

switch(funcion)
{

case "0":
     	var accion 				= 	document.getElementById('accion').value;
     	var nuevoNombre			= 	document.getElementById('nuevoNombre').value;
     	var nuevaDescripcion	= 	document.getElementById('nuevaDescripcion').value;
     	var nodeId				= 	document.getElementById('nodeId').value;//
	 	var cat 				= 	document.getElementById('cat').value;//
     
	 	var direccionvars=accion + "?nuevoNombre=" + nuevoNombre + "&nuevaDescripcion=" + nuevaDescripcion + "&nodeId=" + nodeId + "&cat=" + cat + "&funcion=0";
	 
	 	cargarcapaAplicacion("temas",direccionvars);
     	ocultaresconderCapaEdicion();
   break;


case "1":
     	var accion 				= 	document.getElementById('accion').value;
     	var nuevoNombre			= 	document.getElementById('nuevoNombre').value;
     	var nuevaDescripcion	= 	document.getElementById('nuevaDescripcion').value;
     	var nodeId				= 	document.getElementById('nodeId').value;//
	 	var cat 				= 	document.getElementById('cat').value;//
	 
	 	var direccionvars=accion + "?nuevoNombre=" + nuevoNombre + "&nuevaDescripcion=" + nuevaDescripcion + "&nodeId=" + nodeId + "&cat=" + cat + "&funcion=1";
	 
	 	cargarcapaAplicacion("capa_Contenido_Aplicacion",direccionvars);
	 	ocultaresconderCapaEdicion();
   break;

case "2"://///////////
	 capa=document.getElementById("temas");
	 
     var accion 			= 	document.getElementById('accion').value;
     var nombre				= 	document.getElementById('nombre').value;
	 var imagea				=	document.getElementsByTagName('image')['name'].value;
	 var descripcion		= 	document.getElementById('descripcion').value;
	 var cat 				= 	document.getElementById('cat').value;//
	 
 
	 //var direccionvars=accion + "?nombre=" + nombre + "&descripcion=" + descripcion + "&image=" + image + "&cat=" + cat +  "&MAX_FILE_SIZE=20000000&funcion=2";
	 
	 //var direccionvars=accion + "?nombre=" + nombre + "&descripcion=" + descripcion + "&cat=" + cat + "&MAX_FILE_SIZE=20000000&funcion=2";
	 
	 ajax.open("POST", direccionvars, true);
   break;



case "3": 
     	var accion 		= 	document.getElementById('accion').value;
     	var nodeId		= 	document.getElementById('nodeId').value;//
	 	var cat 		= 	document.getElementById('cat').value;//
     
	 	var direccionvars=accion + "?nodeId=" + nodeId + "&cat=" + cat + "&funcion=3";
	 
	 	cargarcapaAplicacion("temas",direccionvars);
	 	ocultaresconderCapaEdicion();
   break;


case "4":
     	var accion 			= 	document.getElementById('accion').value;
     	var nodeId			= 	document.getElementById('nodeId').value;//
	 	var cat 			= 	document.getElementById('cat').value;//
 
	 	var direccionvars=accion + "?nodeId=" + nodeId + "&cat=" + cat + "&funcion=4";
	 
	 	cargarcapaAplicacion("capa_Contenido_Aplicacion",direccionvars);
	 	ocultaresconderCapaEdicion();
   break;


case "5":
     	var accion 			= 	document.getElementById('accion').value;
     	var nombre			= 	document.getElementById('nombre').value;
     	var descripcion	 	= 	document.getElementById('descripcion').value;
     	var nodeId			= 	document.getElementById('nodeId').value;//
	 	var cat 			= 	document.getElementById('cat').value;//

     	var direccionvars=accion + "?nombre=" + nombre + "&descripcion=" + descripcion + "&nodeId=" + nodeId + "&cat=" + cat + "&funcion=5";
	 	 
	 	cargarcapaAplicacion("capa_Contenido_Aplicacion",direccionvars);
	 	ocultaresconderCapaEdicion();
   break;

}
	
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ejecutarEdicionNaturaleza(id_area)
{

 var  capa	=	document.getElementById("capa_Contenido_Aplicacion");

 ajax = nuevoAjax();

    var nombreActivo=document.getElementById('nombreActivo').value;
	var tiemposolucion=document.getElementById('tiemposolucion').value;
    var direccionvars="modulos/helpdesk/crearNaturaleza.php?nombreActivo=" + nombreActivo + "&tiemposolucion=" + tiemposolucion + "&id_area=" + id_area + "&Botoncrenat=TRUE";


     ajax.open("POST", direccionvars, true);

      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
}

function EdicionNaturaleza(id_area)
{

var  capa	=	document.getElementById("capa_Contenido_Aplicacion");

ajax = nuevoAjax();
 
//alert(id_activo+"----"+nombreActivo+"-----"+tiemposolucion);
var idnaturaleza,nombre_opcion,tiemposolucion;

idnaturaleza=document.getElementById("idnaturaleza").value;
nombre_opcion=document.getElementById("nombre_opcion").value;
tiemposolucion=document.getElementById("tiemposolucion").value;

//alert(idnaturaleza+"----"+nombre_opcion+"-----"+tiemposolucion);


var direccionvars="modulos/helpdesk/EditarNaturaleza.php?idnaturaleza=" + idnaturaleza + "&nombre_opcion=" + nombre_opcion + "&tiemposolucion=" + tiemposolucion + "&id_area=" + id_area + "&Botonactu=TRUE";


     ajax.open("POST", direccionvars, true);

      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
}


//////////////////////////////////////////funciones de calendario///////////////////////////////////////////////////////////////////////////////////////////

function cargarcapaInformacionevento(nombre,hora,descripcion,duracion,lugar,fecha)
{//carga la capa que dependiendo de las variables que se envien 

var capa;

capa	=	document.getElementById("descripcionevento");
    
	ajax = nuevoAjax();
	
	ajax.open("POST","modulos/calendario/evento.php?nombre="+nombre+"&hora="+hora+"&descripcion="+descripcion+"&duracion="+duracion+"&lugar="+lugar+"&fecha="+fecha,true);
    
	ajax.onreadystatechange=function() 
	    {
		   if (ajax.readyState==4) 
		      {
		        capa.innerHTML=ajax.responseText
	 	      }
	    }
	
	ajax.send(null);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////week planner///////////////////////////////////////////////////////////


/* www.twilightuniverse.com */
/* Software licenced under a modified X11 licence,
   see documentation or authors website for more details */

function sack(file) {
	this.xmlhttp = null;

	this.resetData = function() {
		this.method = "POST";
  		this.queryStringSeparator = "?";
		this.argumentSeparator = "&";
		this.URLString = "";
		this.encodeURIString = true;
  		this.execute = false;
  		this.element = null;
		this.elementObj = null;
		this.requestFile = file;
		this.vars = new Object();
		this.responseStatus = new Array(2);
  	};

	this.resetFunctions = function() {
  		this.onLoading = function() { };
  		this.onLoaded = function() { };
  		this.onInteractive = function() { };
  		this.onCompletion = function() { };
  		this.onError = function() { };
		this.onFail = function() { };
	};

	this.reset = function() {
		this.resetFunctions();
		this.resetData();
	};

	this.createAJAX = function() {
		try {
			this.xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e1) {
			try {
				this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e2) {
				this.xmlhttp = null;
			}
		}

		if (! this.xmlhttp) {
			if (typeof XMLHttpRequest != "undefined") {
				this.xmlhttp = new XMLHttpRequest();
			} else {
				this.failed = true;
			}
		}
	};

	this.setVar = function(name, value){
		this.vars[name] = Array(value, false);
	};

	this.encVar = function(name, value, returnvars) {
		if (true == returnvars) {
			return Array(encodeURIComponent(name), encodeURIComponent(value));
		} else {
			this.vars[encodeURIComponent(name)] = Array(encodeURIComponent(value), true);
		}
	}

	this.processURLString = function(string, encode) {
		encoded = encodeURIComponent(this.argumentSeparator);
		regexp = new RegExp(this.argumentSeparator + "|" + encoded);
		varArray = string.split(regexp);
		for (i = 0; i < varArray.length; i++){
			urlVars = varArray[i].split("=");
			if (true == encode){
				this.encVar(urlVars[0], urlVars[1]);
			} else {
				this.setVar(urlVars[0], urlVars[1]);
			}
		}
	}

	this.createURLString = function(urlstring) {
		if (this.encodeURIString && this.URLString.length) {
			this.processURLString(this.URLString, true);
		}

		if (urlstring) {
			if (this.URLString.length) {
				this.URLString += this.argumentSeparator + urlstring;
			} else {
				this.URLString = urlstring;
			}
		}

		// prevents caching of URLString
		this.setVar("rndval", new Date().getTime());

		urlstringtemp = new Array();
		for (key in this.vars) {
			if (false == this.vars[key][1] && true == this.encodeURIString) {
				encoded = this.encVar(key, this.vars[key][0], true);
				delete this.vars[key];
				this.vars[encoded[0]] = Array(encoded[1], true);
				key = encoded[0];
			}

			urlstringtemp[urlstringtemp.length] = key + "=" + this.vars[key][0];
		}
		if (urlstring){
			this.URLString += this.argumentSeparator + urlstringtemp.join(this.argumentSeparator);
		} else {
			this.URLString += urlstringtemp.join(this.argumentSeparator);
		}
	}

	this.runResponse = function() {
		eval(this.response);
	}

	this.runAJAX = function(urlstring) {
		if (this.failed) {
			this.onFail();
		} else {
			this.createURLString(urlstring);
			if (this.element) {
				this.elementObj = document.getElementById(this.element);
			}
			if (this.xmlhttp) {
				var self = this;
				if (this.method == "GET") {
					totalurlstring = this.requestFile + this.queryStringSeparator + this.URLString;
					this.xmlhttp.open(this.method, totalurlstring, true);
				} else {
					this.xmlhttp.open(this.method, this.requestFile, true);
					try {
						this.xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
					} catch (e) { }
				}

				this.xmlhttp.onreadystatechange = function() {
					switch (self.xmlhttp.readyState) {
						case 1:
							self.onLoading();
							break;
						case 2:
							self.onLoaded();
							break;
						case 3:
							self.onInteractive();
							break;
						case 4:
							self.response = self.xmlhttp.responseText;
							self.responseXML = self.xmlhttp.responseXML;
							self.responseStatus[0] = self.xmlhttp.status;
							self.responseStatus[1] = self.xmlhttp.statusText;

							if (self.execute) {
								self.runResponse();
							}

							if (self.elementObj) {
								elemNodeName = self.elementObj.nodeName;
								elemNodeName.toLowerCase();
								if (elemNodeName == "input"
								|| elemNodeName == "select"
								|| elemNodeName == "option"
								|| elemNodeName == "textarea") {
									self.elementObj.value = self.response;
								} else {
									self.elementObj.innerHTML = self.response;
								}
							}
							if (self.responseStatus[0] == "200") {
								self.onCompletion();
							} else {
								self.onError();
							}

							self.URLString = "";
							break;
					}
				};

				this.xmlhttp.send(this.URLString);
			}
		}
	};

	this.reset();
	this.createAJAX();
}




//////////////////////////////////////////////funciones de poscicion////////////////////////////////////////////////////////////////////
	    function checkSX(e)
		   { // capture the mouse position 
			 var posx = 0; 

			 if (!e) var e = window.event; 
			 
			 if (e.pageX) { posx = e.pageX; } 
			 
			 else if (e.clientX) { posx = e.clientX; } 
		 
			 return posx;
		   } 


	    function checkSY(e)
		   { // capture the mouse position 
			 var posy = 0; 

			 if (!e) var e = window.event; 
			 
			 if (e.pageY) { posy = e.pageY; } 
			 
			 else if (e.clientY) { posy = e.clientY; } 
			 
			 
			 return posy;
		   } 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function agregareliminarTodos(funcion,id)
{


switch(funcion)
{
     case 0:

            var  capa	=	document.getElementById("capa_Contenido_Aplicacion");

            ajax = nuevoAjax();

	        var asignaciones,descripciontarea,prioridad,a; 
			a=0;
			
			descripciontarea=document.getElementById('descripciontarea').value;
			prioridad=document.getElementById('prioridad').value;


	        for (var intLoop=0; intLoop < document.getElementById('asignaciones').length; intLoop++) {
				 if (document.getElementById('asignaciones').options[intLoop].selected) 
				     {
					   if(a==0){asignaciones=document.getElementById('asignaciones').options[intLoop].value; 
								 a++;}
			           else{asignaciones+="-"+document.getElementById('asignaciones').options[intLoop].value;
			               }
                      }
	            }

              ajax.open("POST","modulos/ToDo/ToDogrupos.php?asignaciones="+asignaciones+"&descripciontarea="+descripciontarea+"&prioridad="+prioridad+"&botonToDo=TRUE",true);
       break;	

     case 1:
            var  capa	=	document.getElementById("mostrarToDo");

            ajax = nuevoAjax();

            //alert('prueba ingreso');
	        var descripciontarea,prioridad; 
					
			descripciontarea=document.getElementById('descripciontarea').value;
			prioridad=document.getElementById('prioridad').value;

            ajax.open("POST","modulos/ToDo/index.php?descripciontarea="+descripciontarea+"&prioridad="+prioridad+"&funcion=1",true);
       break;	

     case 2:
            var  capa	=	document.getElementById("mostrarToDo");

            ajax = nuevoAjax();

            ajax.open("POST","modulos/ToDo/index.php?id="+id+"&funcion=2",true);
       break;	


}

      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
}


function cargarHerramientaToDo(funcion,posx,posy)
{
var capa=document.getElementById("capa_herramientaedicion");

cargarCapaEdicion(posx,posy);

ajax = nuevoAjax();

    ajax.open("POST", "modulos/ToDo/ToDousuario.php?funcion=1", true);


      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function cargarHerramientaEventosCal(funcion,posx,posy)
{
var capa=document.getElementById("capa_herramientaedicion");

cargarCapaEdicion(posx,posy);

ajax = nuevoAjax();
switch(funcion)
{
     case 0:
            ajax.open("POST", "modulos/calendario/insertarEvento.php", true);
	 break;
}


      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
}



function ingreliminEventoCalendario(funcion)
{
switch(funcion)
{
     case 0:

            var  capa	=	document.getElementById("capa_Contenido_Aplicacion");

            ajax = nuevoAjax();

	        var nombreevento,descripcion,lugar,hora,minutos,horaFinal,minutosFinal,fechaevento;

			nombreevento=document.getElementById('nombreevento').value;
			descripcion=document.getElementById('descripcion').value;
			lugar=document.getElementById('lugar').value;
			hora=document.getElementById('hora').value;
			minutos=document.getElementById('minutos').value;
			horaFinal=document.getElementById('horaFinal').value;
			minutosFinal=document.getElementById('minutosFinal').value;
			fechaevento=document.getElementById('fechaevento').value;

            ajax.open("POST","modulos/calendario/admineventos.php?nombreevento="+nombreevento+"&descripcion="+descripcion+"&lugar="+lugar+"&hora="+hora+"&minutos="+minutos+"&horaFinal="+horaFinal+"&minutosFinal="+minutosFinal+"&fechaevento="+fechaevento+"&funcion=2",true);
	 break;




}

      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ingresaractualizarEquipo(funcion)
{

switch(funcion)
{
     case 0:

            var  capa	=	document.getElementById("capa_Contenido_Aplicacion");

            ajax = nuevoAjax();

	        var tipo_equipo,descripcion_equipo,id_sala,serial,estado;
			
			tipo_equipo=document.getElementById('tipo_equipo').value;
			descripcion_equipo=document.getElementById('descripcion_equipo').value;
			id_sala=document.getElementById('id_sala').value;
			serial=document.getElementById('serial').value;
			estado=document.getElementById('estado').value;

ajax.open("POST","modulos/auditorio/equipos.php?tipo_equipo="+tipo_equipo+"&descripcion_equipo="+descripcion_equipo+"&id_sala="+id_sala+"&serial="+serial+"&estado="+estado+"&funcion=2",true);
	 break;

     case 1:

            var  capa	=	document.getElementById("capa_Contenido_Aplicacion");

            ajax = nuevoAjax();

	        var id_equipo,tipo_equipo,descripcion_equipo,id_sala,serial,id_tipo_sala;
			
			id_equipo=document.getElementById('id_equipo').value;
			id_tipo_sala=document.getElementById('id_tipo_sala').value;
			tipo_equipo=document.getElementById('tipo_equipo').value;
			descripcion_equipo=document.getElementById('descripcion_equipo').value;
			id_sala=document.getElementById('id_sala').value;
			serial=document.getElementById('serial').value;
			estado=document.getElementById('estado').value;

ajax.open("POST","modulos/auditorio/equipos.php?id_equipo="+id_equipo+"&tipo_equipo="+tipo_equipo+"&descripcion_equipo="+descripcion_equipo+"&id_sala="+id_sala+"&serial="+serial+"&id_tipo_sala="+id_tipo_sala+"&funcion=3",true);
	 break;



}

      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
	
	
}


function cargarHerramientaEquiposAuditorios(funcion,posx,posy,idelementos)
{
var capa=document.getElementById("capa_herramientaedicion");

cargarCapaEdicion(posx,posy);

ajax = nuevoAjax();
switch(funcion)
{
     case 0:
            ajax.open("POST", "modulos/auditorio/herramientasequipos.php?id="+idelementos+"&funcion=1", true);
	 break;
	 
	 case 1:
            ajax.open("POST", "modulos/auditorio/herramientasequipos.php?id="+idelementos+"&funcion=2", true);
	 break;
	 
	case 2:
            ajax.open("POST", "modulos/auditorio/herramientasequipos.php?id=0&funcion=3", true);
	 break;


}


      ajax.onreadystatechange=function() 
	       {
		     if (ajax.readyState==4) 
		        {
		          capa.innerHTML=ajax.responseText
	 	        }
	       }
	
	ajax.send(null);
}

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
 cargarcapaAplicacion("capaparaToDo", "../../ToDo.php")
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

var busqueda,tab,nodo;

busqueda=	document.getElementById('busqueda').value;
tab		=	document.getElementById('tab').value;
nodo	=	document.getElementById('nodo').value;

cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/documentos/index.php?busqueda = " +  busqueda + "&tab=" + tab + "&nodo=" + nodo);
    
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

function capacrearborrarAreasContactos(funcion)
{////////////para la crear y eliminar areas de contacto

switch(funcion)
   {
	case 1:
	        var nombrearea =	document.getElementById('nombreArea').value;

            cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/directorios/crearAreaContactos.php?nombreArea=" + nombrearea + "&Boton=True");
            cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/directorios/index.php");
	break;
  
	case 2:
	        var nombrearea	= document.getElementById('areasSelectAdm').value;

            cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/directorios/borrarAreaContactos.php?areasSelectAdm=" + nombrearea + "&Boton=True");
            cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/directorios/index.php");
	break;
   }

}

function capaCargaDirectorio()
{////////////carga el directorio
var nombrearea;

nombrearea	=	document.getElementById('tipo').value;

cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/directorios/index.php?tipo=" + nombrearea);
}

function capaCargaBusqueda()
{////////////para la busqueda de contactos
var buscar;

buscar	=	document.getElementById('search_string').value;

cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/directorios/index.php?search_string=" + buscar + "&m='contacts'&tipo=0");
}


////////////////////////////////////////////revisar esta funcion//////////////////////////////////////////
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
var vabot=document.getElementById('Boton').value;

switch(vabot)
{
 case "Crear Auditorio":
 
    var nombre=document.getElementById('nombreArea').value;

 cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/crearAreaDocumentos.php?nombreArea="+nombre+"&seleccionado=0&seleccionadoAcc=0&Boton=TRUE");
  break;

 case "Actualizar":
	var nombre	=document.getElementById('nombreArea').value;
	var id_area	=document.getElementById('id_area').value;
	   
	 cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/modificarAreaDocumentos.php?nombreArea="+nombre+"&seleccionado=0&seleccionadoAcc=0&id_area="+id_area+"&Boton=TRUE");
	 
   break;

 case "Borrar":

	 var area=document.getElementById('areasSelectAdm').value;
     
	 cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/borrarAreaDocumentos.php?areasSelectAdm="+area+"&Boton=TRUE");
	 cargarcapaAplicacion('capa_Contenido_Aplicacion','modulos/auditorio/index.php');
	 break;
}

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

switch(accion)
{
case 1:
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
 	  
			  cargarcapaAplicacion("areadePublicacionesNoticias","modulos/noticias/modificarAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=0&userSelectAdmtemp=" + uSelA + "&userSelectAcc=0" + "&nodo=" + nodoenv + "&id_area=" + idarea + "&Boton=True");
			  
			  cargarcapaAplicacion('capa_Publicaciones','modulos/noticias/index.php');

////////////////////////////////////////////////////////////////
break;


case 2:
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

              cargarcapaAplicacion("areadePublicacionesNoticias","modulos/noticias/crearAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=" + selAcc + "&userSelectAdmtemp=" + uSelA + "&userSelectAcc=0" + "&Boton=1");
			  
			  cargarcapaAplicacion('capa_Publicaciones','modulos/noticias/index.php');
 
break;

////////////////////////////////////////////////////////////////
}

    
}




function borrarAreasNoticias()
{
var capa,codarea;

codarea	=	document.getElementById('areasSelectAdm').value;

cargarcapaAplicacion("areadePublicacionesNoticias","modulos/noticias/borrarAreaDocumentos.php?areasSelectAdm=" + codarea + "&Boton=True");

cargarcapaAplicacion('capa_Publicaciones','modulos/noticias/index.php');
}


function capaInsertarNoticia(accion,permisos,num_titulares,nombre_area)
{

switch(accion)
{
 case 1:
   var titulo 			=	document.getElementById('titulo').value;
   var textodescripcion = 	document.getElementById('textodescripcion').value;
   var autor 			=	document.getElementById('autor').value;
   var id_area 			= 	document.getElementById('id_area').value;
   var men 				= 	document.getElementById('men').value;	
   
   cargarcapaAplicacion("areadePublicacionesNoticias","modulos/noticias/insertarNoticia.php?titulo=" + titulo + "&textodescripcion=" + textodescripcion + "&men=" + men + "&autor=" + autor + "&id_area=" + id_area);
   
   cargarcapaAplicacion('capa_Publicaciones','modulos/noticias/index.php');
break;
    
case 3:
	var titulo 				= 	document.getElementById('titulo').value;
    var textodescripcion 	= 	document.getElementById('textodescripcion').value;
    var autor 				=	document.getElementById('autor').value;
    var men 				= 	document.getElementById('men').value;
    var id_noticias			=	document.getElementById('id_noticias').value;
	
	cargarcapaAplicacion("areadePublicacionesNoticias","modulos/noticias/editarNoticia.php?titulo=" + titulo + "&textodescripcion=" + textodescripcion + "&men=" + men + "&autor=" + autor +  "&id_area=" + id_area + "&id_noticias=" + id_noticias);
    
	cargarcapaAplicacion('capa_Publicaciones','modulos/noticias/index.php');
break;

case 4:
    var confirmacion		= 	document.getElementById('confirmacion').value;
    var id_noticias			=	document.getElementById('id_noticias').value;
		
	cargarcapaAplicacion("areadePublicacionesNoticias","modulos/noticias/borrarNoticia.php?id_noticias=" + id_noticias + "&confirmacion=" + confirmacion);
	
	cargarcapaAplicacion('capa_Publicaciones','modulos/noticias/index.php');
break;	
  }


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

var funcion=document.getElementById('ingreelim').value;

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

ocultaresconderCapaEdicion();

cargarcapaAplicacion("areadeEventosAuditorios","modulos/auditorio/Detalleauditorio.php?fecha=" + fecha + "&id_area=" + sala);

break;
  
case "2":       
         var id=document.getElementById('id').value;
		 var fecha=document.getElementById('fecha').value; 
         var id_area=document.getElementById('id_area').value;
		 
         cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/index.php?tipfuncion=2&id="+id+"&confirmacion=si&Boton=True");  
         ocultaresconderCapaEdicion();   
		 cargarcapaAplicacion("areadeEventosAuditorios","modulos/auditorio/Detalleauditorio.php?fecha="+fecha+"&id_area="+id_area);
   break; 
}
  
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
 
var idnaturaleza,nombre_opcion,tiemposolucion;

idnaturaleza=document.getElementById("idnaturaleza").value;
nombre_opcion=document.getElementById("nombre_opcion").value;
tiemposolucion=document.getElementById("tiemposolucion").value;

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
cargarcapaAplicacion("descripcionevento","modulos/calendario/evento.php?nombre="+nombre+"&hora="+hora+"&descripcion="+descripcion+"&duracion="+duracion+"&lugar="+lugar+"&fecha="+fecha);
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
	        var asignaciones,descripciontarea,prioridad,a,todo,fechafin; 
			a=0;
			
			todo=document.getElementById('tododat').value;
			fechafin=document.getElementById('fechafin').value;
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
              
              cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/ToDo/ToDogrupos.php?asignaciones="+asignaciones+"&descripciontarea="+descripciontarea+"&prioridad="+prioridad+"&todo="+todo+"&fechafin="+fechafin+"&botonToDo=TRUE")
     break;	

     case 1:
	        var descripciontarea,prioridad,todo,fechafin; 
			
			todo=document.getElementById('tododat').value;
			fechafin=document.getElementById('fechafin').value;
			descripciontarea=document.getElementById('descripciontarea').value;
			prioridad=document.getElementById('prioridad').value;

			cargarcapaAplicacion("mostrarToDo","modulos/ToDo/index.php?descripciontarea="+descripciontarea+"&prioridad="+prioridad+"&todo="+todo+"&fechafin="+fechafin+"&funcion=1");
    break;	

     case 2:cargarcapaAplicacion("mostrarToDo","modulos/ToDo/index.php?id="+id+"&funcion=2");
            break;	


}

}


function cargarHerramientaToDo(funcion,posx,posy)
{
cargarCapaEdicion(posx,posy);
cargarcapaAplicacion("capa_herramientaedicion","modulos/ToDo/ToDousuario.php?funcion=1");
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function cargarHerramientaEventosCal(funcion,posx,posy)
{
cargarCapaEdicion(posx,posy);

switch(funcion)
{
     case 0:cargarcapaAplicacion("capa_herramientaedicion","modulos/calendario/insertarEvento.php");
	        break;
}

}



function ingreliminEventoCalendario(funcion)
{
switch(funcion)
{
     case 0:
	        var nombreevento,descripcion,lugar,hora,minutos,horaFinal,minutosFinal,fechaevento;

			nombreevento=document.getElementById('nombreevento').value;
			descripcion=document.getElementById('descripcion').value;
			lugar=document.getElementById('lugar').value;
			hora=document.getElementById('hora').value;
			minutos=document.getElementById('minutos').value;
			horaFinal=document.getElementById('horaFinal').value;
			minutosFinal=document.getElementById('minutosFinal').value;
			fechaevento=document.getElementById('fechaevento').value;
 			cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/calendario/admineventos.php?nombreevento="+nombreevento+"&descripcion="+descripcion+"&lugar="+lugar+"&hora="+hora+"&minutos="+minutos+"&horaFinal="+horaFinal+"&minutosFinal="+minutosFinal+"&fechaevento="+fechaevento+"&funcion=2");
	 break;
}

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ingresaractualizarEquipo(funcion)
{

switch(funcion)
{
     case 0:
	        var tipo_equipo,descripcion_equipo,id_sala,serial,estado;
			
			tipo_equipo=document.getElementById('tipo_equipo').value;
			descripcion_equipo=document.getElementById('descripcion_equipo').value;
			id_sala=document.getElementById('id_sala').value;
			serial=document.getElementById('serial').value;
			estado=document.getElementById('estado').value;

            cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/equipos.php?tipo_equipo="+tipo_equipo+"&descripcion_equipo="+descripcion_equipo+"&id_sala="+id_sala+"&serial="+serial+"&estado="+estado+"&funcion=2")
	 break;

     case 1:
	        var id_equipo,tipo_equipo,descripcion_equipo,id_sala,serial,id_tipo_sala;
			
			id_equipo=document.getElementById('id_equipo').value;
			id_tipo_sala=document.getElementById('id_tipo_sala').value;
			tipo_equipo=document.getElementById('tipo_equipo').value;
			descripcion_equipo=document.getElementById('descripcion_equipo').value;
			id_sala=document.getElementById('id_sala').value;
			serial=document.getElementById('serial').value;
			estado=document.getElementById('estado').value;

cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/auditorio/equipos.php?id_equipo="+id_equipo+"&tipo_equipo="+tipo_equipo+"&descripcion_equipo="+descripcion_equipo+"&id_sala="+id_sala+"&serial="+serial+"&id_tipo_sala="+id_tipo_sala+"&funcion=3");
	 break;
}

}


function cargarHerramientaEquiposAuditorios(funcion,posx,posy,idelementos)
{
cargarCapaEdicion(posx,posy);

switch(funcion)
{
     case 0:cargarcapaAplicacion("capa_herramientaedicion", "modulos/auditorio/herramientasequipos.php?id="+idelementos+"&funcion=1");
	        break;
	 
	 case 1:cargarcapaAplicacion("capa_herramientaedicion", "modulos/auditorio/herramientasequipos.php?id="+idelementos+"&funcion=2");			
	        break;
	 
	 case 2:cargarcapaAplicacion("capa_herramientaedicion", "modulos/auditorio/herramientasequipos.php?id=0&funcion=3");			
	        break;
}

}


function cambiar_color_tab_click(celda)
{

 var colorfondo = document.getElementById(celda);

 colorfondo.style.backgroundColor="#dddddd";

}
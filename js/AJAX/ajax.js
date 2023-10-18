//domuneto de java scrip para la carga de las capas sin recargar la pagina
var LoginVisible = true;

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
	 if (pagina_requerida.readyState == 4) {
	
        if (pagina_requerida.status == 200) {
            //id_contenedor.innerHTML = pagina_requerida.responseText;			
			 cargarpagina (pagina_requerida, id_contenedor);			
        }
    
	
	} 
	
	else {  id_contenedor.innerHTML = "<div align='center'><img src='/imagenes/loading.gif' /></div>";  }
	
	}
	
	
	
    pagina_requerida.open ('POST', url, true); // asignamos los métodos open y send
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
 var areavariable,nodovariable;

 areavariable = area;
 nodovariable = nodo;
	
 cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/documentos/index.php?tab="+areavariable+"&nodo="+nodovariable)

}


function mostrardocumentos(nodo,tab,sig,rut)
{//con este ajax creamos es empleaado par el area de documentos y para el modificacion de datos de area de documentos

 cargarcapaAplicacion("capa_Contenido_Aplicacion","modulos/documentos/index.php?nodo=" + nodo + "&tab=" + tab +"&sig=" + sig + "&rut=" + rut + "&ind=1");
  
}

//////////////////////////////////////////////////////////////////////////////////////////////////////
function crearAreasyNodos()
{

var capa,nombre,sel,selAcc,pub,arb,a,b;

nombre	= document.getElementById('nombreArea').value;
sel		= document.getElementById('seleccionado').value;
selAcc	= document.getElementById('seleccionadoAcc').value;

alert(document.getElementById('Boton').value);

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





        if(document.getElementById('Boton').value=="Crear")
		  {
			 var pac	= document.getElementById('paciente').value;
			  
		     if(document.getElementById('publico').checked==true){pub=1;} else{pub=0;}
		     
			 if(document.getElementById('arbol').checked==true){arb=1;} else{arb=0;}
		   
               cargarcapaAplicacion("capa_Contenido_Aplicacion", "modulos/documentos/index.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=" + selAcc + "&userSelectAdmtemp=" + uSelA + "&userSelectAcctemp=" + uSelAcc + "&publico=" + pub + "&arbol=" + arb+ "&paciente=" + pac + "&funcion=7");
 
           }
       
	   if(document.getElementById('Boton').value=="Actualizar")
	   {
			  alert("entro")
			  var colorsel 	= document.getElementById('color').value;
		      nodoenv 		= document.getElementById('nodo').value;
              idarea  		= document.getElementById('id_area').value;  
 
			  //cargarcapaAplicacion("capa_Contenido_Aplicacion" , "modulos/documentos/modificarAreaDocumentos.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=" + selAcc + "&userSelectAdmtemp=" + uSelA + "&userSelectAcctemp=" + uSelAcc + "&nodo=" + nodoenv + "&id_area=" + idarea + "&Boton=1&color=" + colorsel);
					  
			  cargarcapaAplicacion("capa_Contenido_Aplicacion" , "modulos/documentos/index.php?nombreArea=" + nombre + "&seleccionado=" + sel + "&seleccionadoAcc=" + selAcc + "&userSelectAdmtemp=" + uSelA + "&userSelectAcctemp=" + uSelAcc + "&nodo=" + nodoenv + "&id_area=" + idarea + "&funcion=8&color=" + colorsel);
			  
			 }

 
}


//////////////////////////////////////////////////////////////////////////////////////////////////
function borrarAreas()
{
 var codarea;

 codarea	=	document.getElementById('areasSelectAdm').value;

 //cargarcapaAplicacion("capa_Contenido_Aplicacion" , "modulos/documentos/borrarAreaDocumentos.php?areasSel=" + codarea + "&Boton=True");
 
  cargarcapaAplicacion("capa_Contenido_Aplicacion" , "modulos/documentos/index.php?areasSel=" + codarea + "&funcion=6");


}






function cargarCapaEdicion(posx,posy)
{//muestra la capa donde se encuentra la informacion de login 
  
  //if (!enabled) return;
    
  /**/var d,m,e,a,i,pospix,pospiy;

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

  LoginVisible=!LoginVisible;/**/
}

function cargarCapaBusqueda(posx,posy)
{  
	var d,m,e,a,i,pospix,pospiy;

  	if (LoginVisible) { d = 'visible';  }
  
  	else { d = 'hidden'; }
    
  	e = document.getElementById('capa_resultadosbusqueda');

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

/******************************************************************************************************/
/*function ocultaresconderCapaEdicion()
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


/*****************************************************************************************************/

function cargarcapaHerramientaEdicion(accion,sig,rut,nodeName,nodeId,nodo,tabla,tab,vinculo,funcion,textodescripcion,posx,posy)
{

cargarCapaEdicion(posx,posy);

switch(funcion)
{
case 0:
		cargarcapaAplicacion("capa_herramientaedicion", "herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&textodescripcion=" + textodescripcion + "&funcion=0");
       	break;
case 1:
       	cargarcapaAplicacion("capa_herramientaedicion","herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=1");
       	break;
case 2:
       	cargarcapaAplicacion("capa_herramientaedicion","herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=2");
        break;
case 3:
      	cargarcapaAplicacion("capa_herramientaedicion", "herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=3");
       	break;	  
case 4:
       	var enlace =document.getElementById('enlace').value;	
	   	cargarcapaAplicacion("capa_herramientaedicion","herramientasEdicion.php?accion=" + accion + "&nodeName=" +  nodeName + "&nodo=" + nodo + "&tab=" + tab + "&enlace=" + enlace + "&funcion=4");
      	break;
case 5:  
       	cargarcapaAplicacion("capa_herramientaedicion","herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&textodescripcion=" + textodescripcion + "&funcion=5");
       	break;
case 6:
       	cargarcapaAplicacion("capa_herramientaedicion","herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&textodescripcion=" + textodescripcion + "&funcion=6");
       	break;
case 7:
       	cargarcapaAplicacion("capa_herramientaedicion","herramientasEdicion.php?accion=" + accion + "&sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&textodescripcion=" + textodescripcion + "&funcion=7");
       	break;
}

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function formularioCheck()
{

var funcion = document.getElementById('funcion').value;
var subfuncion = document.getElementById('subfuncion').value;

switch(funcion)
{

case "0":	var fieldRequired = Array("nuevoNombre");
	     	// Enter field description to appear in the dialog box
	     	var fieldDescription = Array("Nombre");
	     	// dialog message
     		break;

case "1": 
          	switch(subfuncion)
                {
                 	case "1":	// Enter name of mandatory fields
	                       		var fieldRequired = Array("nuevoNombre");
	                       		// Enter field description to appear in the dialog box
	                       		var fieldDescription = Array("Nombre");
	                       		// dialog message
                          		break;                          
                 	case "2":
                 	       		// Enter name of mandatory fields
	                       		var fieldRequired = Array("fechaseleccionada ");
	                       		// Enter field description to appear in the dialog box
	                       		var fieldDescription = Array("Fecha");
	                       		// dialog message                 
                          		break;
                 	case "3":
                 	       		// Enter name of mandatory fields
	                       		//var fieldRequired = Array("consecutivo","nombre","cedula");
	                       		var fieldRequired = Array("cedula");
	                       		// Enter field description to appear in the dialog box
	                       		//var fieldDescription = Array("Consecutivo","Nombre","Cedula");
	                       		var fieldDescription = Array("Cedula");
	                       		// dialog message
                          		break;
                          
                }
			break;

case "2":	var fieldRequired = Array("nombre","image");
			// Enter field description to appear in the dialog box
			var fieldDescription = Array("Nombre","Archivos");
			// dialog message
     		break;

case "3":	ocultaresconderCapaEdicion(); 
           	return true;	
     		break;

case "4":	var fieldRequired = Array("nuevoNombre");
			// Enter field description to appear in the dialog box
			var fieldDescription = Array("Nombre");
			// dialog message
     		break;

case "5":	ocultaresconderCapaEdicion(); 
           	return true;
     break;
	 
case "6":	ocultaresconderCapaEdicion(); 
           	return true;
     break;
  	  
case "7":  ocultaresconderCapaEdicion(); 
           return true;
     break; 
	 
}

     	
	var alertMsg = "Por favor completar los siguentes campos:\n";
	
	var l_Msg = alertMsg.length;  
	
	for (var i = 0; i < fieldRequired.length; i++){  

		if (document.getElementById(fieldRequired[i])){  
			switch(document.getElementById(fieldRequired[i]).type){
			case "select-one": 
				if (document.getElementById(fieldRequired[i]).selectedIndex==-1||document.getElementById(fieldRequired[i]).options[document.getElementById(fieldRequired[i]).selectedIndex].value==""){    alertMsg += " - " + fieldDescription[i] + "\n"; 
				      
				}
				break;
			case "select-multiple": 
				if (document.getElementById(fieldRequired[i]).selectedIndex == -1){
					alertMsg += " - " + fieldDescription[i] + "\n";  
				}
				break;
			case "text": 
			case "textarea": 
				if (document.getElementById(fieldRequired[i]).value==""||document.getElementById(fieldRequired[i])==null){
					alertMsg += " - " + fieldDescription[i] + "\n";  
				}
				break;
			default:
			}
			if (document.getElementById(fieldRequired[i]).type == undefined){
				var blnchecked = false;
				for (var j = 0; j < obj.length; j++){
					if (obj[j].checked){
						blnchecked = true;
					}
				}
				if (!blnchecked){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
			}
		}
	}
       
	if (alertMsg.length == l_Msg){    ocultaresconderCapaEdicion();  
		                              return true; }
	else{  alert(alertMsg);  return false;  	}


}


/*function ejecutarFuncionEdicion()
{

var funcion = document.getElementById('funcion').value;

alert(funcion+"Prueba de ingreso")

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
    
     if(nuevoNombre!="")
      {
        cargarcapaAplicacion("capa_Contenido_Aplicacion",accion + "?sig=" + sig + "&rut=" + rut + "&nuevoNombre=" +  nuevoNombre + "&nuevaDescripcion=" + nuevaDescripcion + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=0");
      }
      else { alert("Debe de Ingresar Nombre de la Carpeta");   }  
        
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
	   
	  
	   
	   

       cargarcapaAplicacion("capa_Contenido_Aplicacion",accion + "?sig=" + sig + "&rut=" + rut + "&nombre=" +  nombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=1",true);
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

       cargarcapaAplicacion("capa_Contenido_Aplicacion", accion + "?sig=" + sig + "&rut=" + rut + "&image=" +  image + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&descripcion=" + descripcion + "&MAX_FILE_SIZE=20000000&funcion=2");
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

     cargarcapaAplicacion("capa_Contenido_Aplicacion",accion + "?sig=" + sig + "&rut=" + rut + "&nodeName=" +  nodeName + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=3");
     break;

case "4":
     var accion = 	document.getElementById('accion').value;
     var nuevoNombre= 	document.getElementById('nuevoNombre').value;
     var nodeId	= 	document.getElementById('nodeId').value;
     var nodo 	= 	document.getElementById('nodo').value;
     var tab 	=	document.getElementById('tab').value;
     var vinculo= 	document.getElementById('link').value;
     var enlace= 	document.getElementById('enlace').value;
	 
     cargarcapaAplicacion("capa_Contenido_Aplicacion",accion + "?nuevoNombre=" +  nuevoNombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tab=" + tab + "&link=" + vinculo + "&enlace=" + enlace +  "&funcion=4");
     break;

case "5":
     var accion = 	document.getElementById('accion').value;
     var sig 	= 	document.getElementById('sig').value;
     var rut 	= 	document.getElementById('rut').value;
     var nuevoNombre= 	document.getElementById('nuevoNombre').value;
     var nodeName= 		document.getElementById('nombreAnterior').value;
	 var nuevaDescripcion= 	document.getElementById('nuevaDescripcion').value;
     var nodeId	= 	document.getElementById('nodeId').value;
     var nodo 	= 	document.getElementById('nodo').value;
     var tabla 	= 	document.getElementById('tabla').value;
     var tab 	=	document.getElementById('tab').value;
     var vinculo= 	document.getElementById('link').value;
     alert(nodeName);
     cargarcapaAplicacion("capa_Contenido_Aplicacion",accion + "?sig=" + sig + "&rut=" + rut + "&nuevoNombre=" +  nuevoNombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&nuevaDescripcion=" + nuevaDescripcion +"&nodeName=" + nodeName + "&funcion=5");    
     break;
	 
case "6":

       alert("buena prueba de control");
       var accion	=	document.getElementById('accion').value;
       var sig		=	document.getElementById('sig').value;
       var rut		=	document.getElementById('rut').value;
      
       var nodeId	=	document.getElementById('nodeId').value;
       var nodo		=	document.getElementById('nodo').value;
       var tabla	=	document.getElementById('tabla').value;
       var tab		=	document.getElementById('tab').value;
       var vinculo	=	document.getElementById('link').value;

	 
	
	 var ano = 	document.getElementById('ano').value;
	 var dia = 	document.getElementById('dia').value;
	 var mes = 	document.getElementById('mes').value;
	 var medico = document.getElementById('medico').value;
	 var procedimiento = document.getElementById('procedimiento').value;
	 
	 alert(medico+"-"+procedimiento);
	 
var nombre =ano + '-' + mes + '-' + dia;

 
       //cargarcapaAplicacion("capa_Contenido_Aplicacion",accion + "?sig=" + sig + "&rut=" + rut + "&nombre=" +  nombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=1");
       
     break;
	  
	  
	case "7":  
  
	   var accion	=	document.getElementById('accion').value;
       var sig		=	document.getElementById('sig').value;
       var rut		=	document.getElementById('rut').value;
       var nombre	=	document.getElementById('nombre').value;
       var nodeId	=	document.getElementById('nodeId').value;
       var nodo		=	document.getElementById('nodo').value;
       var tabla	=	document.getElementById('tabla').value;
       var tab		=	document.getElementById('tab').value;
       var vinculo	=	document.getElementById('link').value;
	   
	    var cedula = 	document.getElementById('cedula').value;
	
	 
	 if (nombre.length == 0)
	 	{  
			alert ('Nombre inválido');return;
			
		}
	 
var nombre =cedula + '-' + nombre ;

 
	   
	   

       cargarcapaAplicacion("capa_Contenido_Aplicacion",accion + "?sig=" + sig + "&rut=" + rut + "&nombre=" +  nombre + "&nodeId=" + nodeId + "&nodo=" + nodo + "&tabla=" + tabla + "&tab=" + tab + "&link=" + vinculo + "&funcion=1",true);
     break; 
	 
}


cargarCapaEdicion();

}*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//////////////////////////////////////////////funciones de poscicion//////////////////////////////
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
		   
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////		   

function ejecutarFuncionEdicion()
{
var pais = document.getElementById('paissel').value;

cargarcapaAplicacion("listaciudades","listaciudades.php?coPais="+pais);
	 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function comprobarExConsecutivo()
{
var consecutivo = document.getElementById('consecutivo').value;

cargarcapaAplicacion("resultadoComprobacion","CompConsec.php?consecutivo="+consecutivo);
	 
}

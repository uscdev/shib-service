<html>
<head>
  <title>Shibboleth Attributes - <% out.println( request.getHeader("host") ); %></title>
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <META HTTP-EQUIV="Expires" CONTENT="-1">
<script language"JavaScript" type="text/JavaScript">
<!--
  function decodeAttributeResponse() {
 	var textarea = document.getElementById("attributeResponseArea");
  	var base64str = textarea.value;
	var decodedMessage = decode64(base64str);
	textarea.value = tidyXml(decodedMessage);
	textarea.rows = 15;
	document.getElementById("decodeButtonBlock").style.display='none';
  }

  function tidyXml(xmlMessage) {
	//put newline before closing tags of values inside xml blocks
	xmlMessage = xmlMessage.replace(/([^>])</g,"$1\n<");
	//put newline after every tag
	xmlMessage = xmlMessage.replace(/>/g,">\n");
	var xmlMessageArray = xmlMessage.split("\n");
	xmlMessage="";
	var nestedLevel=0;
	for (var n=0; n < xmlMessageArray.length; n++) {
		if ( xmlMessageArray[n].search(/<\//) > -1 ) {
			nestedLevel--;
		}
		for (i=0; i<nestedLevel; i++) {
			xmlMessage+="  ";
		}
		xmlMessage+=xmlMessageArray[n]+"\n";
		if ( xmlMessageArray[n].search(/\/>/) > -1 ) {
			//level status the same
		}
		else if ( ( xmlMessageArray[n].search(/<\//) < 0 ) && (xmlMessageArray[n].search(/</) > -1) ) {
			//only increment if this was a tag, not if it is a value
			nestedLevel++;
		}
	}
  	return xmlMessage;
  }

  var base64Key = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
  function decode64(encodedString) {
    var decodedMessage = "";
    var char1, char2, char3;
    var enc1, enc2, enc3, enc4;
    var i = 0;
  
    //remove all characters that are not A-Z, a-z, 0-9, +, /, or =
    encodedString = encodedString.replace(/[^A-Za-z0-9\+\/\=]/g, "");
    do {
	enc1 = base64Key.indexOf(encodedString.charAt(i++));
	enc2 = base64Key.indexOf(encodedString.charAt(i++));
	enc3 = base64Key.indexOf(encodedString.charAt(i++));
	enc4 = base64Key.indexOf(encodedString.charAt(i++));

	char1 = (enc1 << 2) | (enc2 >> 4);
	char2 = ((enc2 & 15) << 4) | (enc3 >> 2);
	char3 = ((enc3 & 3) << 6) | enc4;

	decodedMessage = decodedMessage + String.fromCharCode(char1);
	if (enc3 != 64) {
		decodedMessage = decodedMessage + String.fromCharCode(char2);
	}
	if (enc4 != 64) {
		decodedMessage = decodedMessage + String.fromCharCode(char3);
	}
    } while (i < encodedString.length);
    return decodedMessage;
  }
// -->
</script>
</head>


<body>


<u><b>-all SHIB headers-</b></u> (<code>HTTP_SHIB_ATTRIBUTES</code> and <code>Shib-Attributes</code> are not shown in this list)<br/>
<table>
<%
java.util.Enumeration eHeaders = request.getHeaderNames();
while(eHeaders.hasMoreElements()) {
     String name = (String) eHeaders.nextElement();
     if (  ( name.matches(".*Shib.*") || name.matches(".*shib.*")  ) && !name.equals("HTTP_SHIB_ATTRIBUTES") && !name.equals("Shib-Attributes")) {
	     Object object = request.getHeader(name);
	     String value = object.toString();
	     out.println("<tr><td>" + name + "</td><td>" + value+"</td></tr>");
     }
}
%>
</table>

<br/>

attribute response from the IdP (<code>Shib-Attributes</code> or <code>HTTP_SHIB_ATTRIBUTES</code>):<br/>
<textarea id="attributeResponseArea" onclick="select()" rows="1" cols="130"><% 
	String attributesString=null;
	if ( request.getHeader("Shib-Attributes")!=null ) attributesString=request.getHeader("Shib-Attributes");
	else if ( request.getHeader("HTTP_SHIB_ATTRIBUTES")!=null ) attributesString=request.getHeader("HTTP_SHIB_ATTRIBUTES");
	out.println( attributesString ); 
%></textarea><br/>
<span id="decodeButtonBlock"><input type="button" id="decodeButton" value="decode base64 encoded attribute response using JavaScript" onClick="decodeAttributeResponse();"><br/></span>

<br/>
<hr/>
<br/>


<%
	out.print("request.getRemoteUser: "+request.getRemoteUser()+"<br/>");
	out.print("REMOTE_USER: "+request.getHeader("REMOTE_USER")+"<br/>" );
	out.print("HTTP_REMOTE_USER: "+request.getHeader("HTTP_REMOTE_USER")+"<br/>" );	
%>


<br/>
<hr/>
<br/>


<u>REQUEST PARAMETERS (GET/POST)</u><br/>
<table>
<%
java.util.Enumeration eParameters = request.getParameterNames();
while(eParameters.hasMoreElements()) {
     String name = (String) eParameters.nextElement();
     Object object = request.getParameter(name);
     String value = object.toString();
     out.println("<tr><td>" + name + "</td><td>" + value+"</td></tr>");
}
%>
</table>


<br/>
<hr/>
<br/>


<u>ALL HEADERS</u><br/>
<table>
<%
// already initiated at top of script
// java.util.Enumeration eHeaders = request.getHeaderNames();
// reset to beginning of Enumeration
eHeaders = request.getHeaderNames();
while( eHeaders.hasMoreElements() ) {
     String name = (String) eHeaders.nextElement();
     Object object = request.getHeader(name);
     String value = object.toString();
     out.println("<tr><td>" + name + "</td><td>" + value+"</td></tr>");
}
%>
</table>



<br/>
<hr/>
<br/>



<u>SESSION</u><br/>
<table>
<%
out.println("SESSION_ID: "+session.getId()+"<br/>");

java.util.Enumeration eSession = session.getAttributeNames() ;
while(eSession.hasMoreElements()) {
     String name = (String) eSession.nextElement();     
     Object object = session.getAttribute(name);
     String value = object.toString();     
     out.println("<tr><td>" + name + "</td><td>" + value+"</td></tr>");
}
%>
</table>


<br/>
<hr/>
<br/>


</body>
</html>

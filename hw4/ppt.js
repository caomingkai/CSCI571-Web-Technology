<h1>View the Commercial Aircrafts </h1>
Enter XML file
<form name="myform" method="POST" id="location">
<input type="text" name="URL" maxlength="255" size="100" value="airbus.xml" />
<br />
<input type="button" name="submit" value="Submit Query" onClick="viewXML(this.form)" />
</form>



function viewXML(what)
{
  var URL = what.URL.value;
  function loadXML(url) {
      if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
       xmlhttp=new XMLHttpRequest();   }
 else {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");  }
  xmlhttp.open("GET",url,false);
  xmlhttp.send();
  xmlDoc=xmlhttp.responseXML;
  return xmlDoc;   }
  xmlDoc = loadXML(URL);
 if (window.ActiveXObject) //if IE, simply execute script (due to async prop).
 {  if (xmlDoc.parseError.errorCode != 0) {
    var myErr = xmlDoc.parseError;
    generateError(xmlDoc);
    hWin = window.open("", "Error", "height=300,width=340");
    hWin.document.write(html_text);
  } else {  generateHTML(xmlDoc);
            hWin = window.open("", "Assignment4", "height=800,width=600");
            hWin.document.write(html_text);   }
 } else //else if FF, execute script once XML object has loaded
 {  xmlDoc.onload=generateHTML(xmlDoc);
    hWin = window.open("", "Assignment4", "height=800,width=600");
    hWin.document.write(html_text);  }
 hWin.document.close();  }

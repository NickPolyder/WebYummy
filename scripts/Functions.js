
//η επόμενη συνάρτηση επιστρέφει true αν το str μοιάζει με email (δεν
//μπορούμε να ξέρουμε σίγουρα αν πράγματι είναι υπαρκτή διεύθυνση email!)
/*str Το value του element που ελέγχουμε το e-mail και res 
 * το αντικείμενο που ελέγχουμε το e-mail έτσι
 *  ώστε να μπορούμε να το τροποποιήσουμε αν δεν είναι έγκυρο */
function looks_like_email(str,res) {
  var result=true; //έστω ότι όλα είναι καλά - θα κάνουμε διάφορους ελέγχους και
                   //εφόσον κάποιος βγάζει πρόβλημα, θα βάλουμε result=false.
  var ampersatPos = str.indexOf("@");   //η θέση του @ στο αλφαριθμητικό
  var dotPos = str.indexOf(".");        //η θέση του . στο αλφαριθμητικό
  //η θέση του . στο αλφαριθμητικό μετά τη θέση του @
  var dotPosAfterAmpersat = str.indexOf(".", ampersatPos);	 
  // αν το @ δεν βρεθεί, η indexOf επιστρέφει -1 ενώ αν είναι πρώτος
  // χαρακτήρας επιστρέφει 0. Σε κάθε περίτπωση δεν είναι αποδεκτό email.
  if (ampersatPos<=0) result = false; 
  // αν δεν υπάρχει καθόλου τελεία δεν είναι email
  if (dotPos<0) result = false; 
  // αν δεν υπάρχει . μετά το @ αλλά όχι αμέσως μετά, τότε δεν είναι email
  if (dotPosAfterAmpersat-ampersatPos==1) result = false; 
  // αν ο πρώτος ή ο τελευταίος χαρακτήρας είναι . τότε δεν είναι email
  if ( str.indexOf(".")==0  ||  str.lastIndexOf(".")==str.length-1 )
    result = false;

//Αρχικοποίηση τον εντολών μορφοποίησης του στοιχείου

	res.style.backgroundColor="";
       res.style.border="";
document.getElementById("Mailerr").innerHTML = "";
	if(result == false)
	{
     res.style.backgroundColor="yellow";
       res.style.border="thin solid red";
document.getElementById("Mailerr").innerHTML = "→ Please type a correct e-mail";
	}

  // πιθανώς να απαιτούνται επιπλέον έλεγχοι - ας αρκεστούμε σε αυτούς
  return result;
}
function username(str) // Ελέγχει το username όπου str μεταβλητή κειμένου για error message
{
    var result = true;
    // Αρχικοποίηση τον εντολών μορφοποίησης του στοιχείου

    document.getElementById("UserName").style.backgroundColor="";
       document.getElementById("UserName").style.border="";
 document.getElementById("Nameerr").innerHTML ="";
	// λήψη τιμής του υπό εξέταση στοιχείου
	var username=document.getElementById("UserName").value;

  // Ακολουθεί regular expression που περιγράφει τους μη επιτρεπτούς χαρακτήρες.
  // Συγκεκριμένα, μη επιτρεπτοί είναι όλα εκτός από 0-9, A-Z, a-z, _ (κάτω παύλα)
	var illegalChars = /\W/;

  // αν υπάρχει στο username μη επιτρεπτός χαρακτήρας ή το μήκος δεν είναι 3
  if (illegalChars.test(username) || username.length < 3) {
    //σημείωσε ότι υπάρχει πρόβλημα
		result=false;
                document.getElementById("UserName").style.backgroundColor="yellow";
       document.getElementById("UserName").style.border="thin solid red";
 document.getElementById("Nameerr").innerHTML =str;
  }
  return result;
}


/* Ελέγχει το password όπου str μεταβλητή κειμένου για error message
 * Το element είναι το στοιχείο που θέτουμε ως password για να ελέγχουμε  την εγκυρότητα του
 * Το error είναι το στοιχείο όπου θα στείλουμε το λάθος εάν υπάρχει */
function password(str,element,error) 
{
var result = true;
     //Αρχικοποίηση τον εντολών μορφοποίησης του στοιχείου

element.style.backgroundColor="";
      element.style.border="";
error.innerHTML ="";
  var password = element.value; 
  var illegalpass = /^[a-zA-Z0-9_!@]+$/; // Ελέγχει αν υπάρχουν οι παρακάτω χαρακτήρες A-Z a-z 0-9 _ ! @
  if(!illegalpass.test(password) || (password.length < 8))
  {
  result = false;
  
element.style.backgroundColor="yellow";
      element.style.border="thin solid red";
error.innerHTML =str;
  
  
  }
  
  return result;
}

function ActivationCo() //Ελέγχει εάν το Activation code υπάρχει (απλός έλεγχος πιο πολύπλοκος στο php file)
{
    var result = true;
    //Αρχικοποίηση τον εντολών μορφοποίησης του στοιχείου

    document.getElementById("ActivationCode").style.backgroundColor="";
       document.getElementById("ActivationCode").style.border="";   
    document.getElementById("Activeerr").innerHTML ="";

    result = username("→ Wrong Username please put a valid username");
    
    var activecode1 = document.getElementById("ActivationCode").value;
    if(activecode1 == "")
        {
            result = false;
            document.getElementById("ActivationCode").style.backgroundColor="yellow";
       document.getElementById("ActivationCode").style.border="thin solid red";
            document.getElementById("Activeerr").innerHTML = "→ Please put your Activation Code!";
        }
        
        var recaptcha = document.getElementById("security_code").value;
if(recaptcha.length <= 0) // Απλός έλεγχος για το αν το Re-Captcha είναι πάνω από το 0 ή όχι
    {
        document.getElementById("security_code").style.backgroundColor="yellow";
       document.getElementById("security_code").style.border="thin solid red";
    result = false;
            
            document.getElementById("Secerr").innerHTML = "→ Type the ReCaptcha";
    }

    
    return result;
    
}
function valid_login() //Ελέγχει το Log In του χρηστη
{
    var result = true;
    result = username("→ Wrong Username please put a valid username");
    result = password("→ Wrong password please put a valid password",document.getElementById('PassWord'),document.getElementById("Passerr"));
    return result;
}
function validate_form() //Ελέγχει το registration form του χρηστη
{
	// αρχικοποιούμε το αποτέλεσμα σε true και θα κάνουμε
	// ελέγχους για να δούμε αν υπάρχει λόγος αλλαγής σε false
	var result = true;
 result = looks_like_email(document.getElementById("Email").value,document.getElementById("Email"));
	// δημιουργούμε κάθε φορά πρόσβαση στο επιθυμητό html στοιχείο
	// ή στο περιεχόμενό του και κάνουμε τους απαραίτητους ελέγχους
 result = username("→ Wrong username. Use Letters,Numbers or underscore! And the username must be above 3 letters");
 result = password("→ Wrong Password. Please follow the Rules!",document.getElementById('PassWord'),document.getElementById('Passerr'));
 var pass = document.getElementById("PassWord").value;

 //Αρχικοποίηση τον εντολών μορφοποίησης του στοιχείου

  document.getElementById("RePassword").style.backgroundColor="";
       document.getElementById("RePassword").style.border="";
document.getElementById("Repasserr").innerHTML ="";
var repass = document.getElementById("RePassword").value;
if(pass != repass) // Έλεγχος αν το password είναι ίδιο με το retyped password
    {
        document.getElementById("RePassword").style.backgroundColor="yellow";
       document.getElementById("RePassword").style.border="thin solid red";
document.getElementById("Repasserr").innerHTML ="→ The Passwords does not match";
  
        
    }
//Αρχικοποίηση τον εντολών μορφοποίησης του στοιχείου

document.getElementById("Country").style.backgroundColor="";
       document.getElementById("Country").style.border="";
document.getElementById("Countryerr").innerHTML ="";

var Country = document.getElementById("Country").value;
if(Country == -1) // Έλεγχος εάν το στοιχείο είναι διαφορετικό από την default επιλογή
{
result = false;
document.getElementById("Country").style.backgroundColor="yellow";
       document.getElementById("Country").style.border="thin solid red";
document.getElementById("Countryerr").innerHTML ="→ Choose a Country!";
}

 document.getElementById("Sexerr").innerHTML = "";
var sex1 = document.getElementById("sex1").checked;
var sex2 = document.getElementById("sex2").checked;
if(sex1 == false && sex2 == false) // Έλεγχος εάν το στοιχείο είναι τσεκαρισμένο
{
result = false;

document.getElementById("Sexerr").innerHTML = "→ Choose gender";
}

  
   //Αρχικοποίηση τον εντολών μορφοποίησης του στοιχείου
   document.getElementById("Age").style.backgroundColor="";
       document.getElementById("Age").style.border="";
        document.getElementById("Ageerr").innerHTML = "";
var age = document.getElementById("Age").value;

if(age == -1) // Έλεγχος εάν το στοιχείο είναι διαφορετικό από την default επιλογή
{
    
result = false;
document.getElementById("Age").style.backgroundColor="yellow";
       document.getElementById("Age").style.border="thin solid red";
    
            
            document.getElementById("Ageerr").innerHTML = "→ Select your Age";
     
}
//Αρχικοποίηση τον εντολών μορφοποίησης του στοιχείου
document.getElementById("security_code").style.backgroundColor="";
       document.getElementById("security_code").style.border="";
            
        document.getElementById("Secerr").innerHTML = "";
    
var recaptcha = document.getElementById("security_code").value;
if(recaptcha.length <= 0) // Απλός έλεγχος για το αν το Re-Captcha είναι πάνω από το 0 ή όχι
    {
        document.getElementById("security_code").style.backgroundColor="yellow";
       document.getElementById("security_code").style.border="thin solid red";
    result = false;
            
            document.getElementById("Secerr").innerHTML = "→ Type the ReCaptcha";
    }

  // επέστρεψε το αποτέλεσμα
	return result;  
}
function loadDesc() //Φορτώνει το default description
{
 
    document.getElementById('Description').style.color = "#666666";
    document.getElementById('Description').style.textAlign = "center";
    document.getElementById('Description').value = "Your Description here";
    
  
}
function focusDesc() //Σβήνει το default description
{
    if(document.getElementById('Description').value == "Your Description here")
        {
    document.getElementById('Description').style.color = "#000000";
    document.getElementById('Description').style.textAlign = "left";
    document.getElementById('Description').value = "";
        }else{
            document.getElementById('Description').style.color = "#000000";
    document.getElementById('Description').style.textAlign = "left";
        }
}
function addbusvalid() // Ελέγχει την δημιουργία νέας επιχειρήσεις
{
    var result = true;
     var textar = document.getElementById('Description').value;
    if(textar == "Your Description here")
        {
            result = true;
        }else{
            result = true;
        }
    var BuisnessTitle = document.getElementById('BusName').value;
    var illegalchars = /^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/; /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως <
> @ ! $ % ^ & *  */
    document.getElementById('buserr').innerHTML = "";
   document.getElementById('BusName').style.border = "";
   document.getElementById('BusName').style.backgroundColor = "";
    
    if(!illegalchars.test(BuisnessTitle) || BuisnessTitle.length < 5)
    {
        result = false;
    document.getElementById('buserr').innerHTML = "→ The Business Title is not correct please follow the rules!";
   document.getElementById('BusName').style.border = "solid 1px red";
   document.getElementById('BusName').style.backgroundColor = "yellow";
        
    }
    
    var Address = document.getElementById('Address').value;
    document.getElementById('addrerr').innerHTML = "";
    document.getElementById('Address').style.backgroundColor = "";
    document.getElementById('Address').style.border = "";
    if(!illegalchars.test(Address) || Address.length < 5)
        {
            result = false;
    document.getElementById('addrerr').innerHTML = "→ The Business Address is not correct please follow the rules!";
   document.getElementById('Address').style.border = "solid 1px red";
   document.getElementById('Address').style.backgroundColor = "yellow";
        }
        var illegalphone = /^[\+0-9]{10,14}$/; /* Ψάχνει να βρει έναν αποδεκτό αριθμό μεταξύ 10 - 14 ψηφίων
Όπου επιτρέπονται μόνο αριθμοί και το + */
        var phone = document.getElementById('Phone').value;
        document.getElementById('phoneerr').innerHTML = "";
    document.getElementById('Phone').style.backgroundColor = "";
    document.getElementById('Phone').style.border = "";
    if(!illegalphone.test(phone) || phone.length <= 0)
        {
            result = false;
    document.getElementById('phoneerr').innerHTML = "→ The Phone is not correct please follow the rules!";
   document.getElementById('Phone').style.border = "solid 1px red";
   document.getElementById('Phone').style.backgroundColor = "yellow";
        }
        var buissID = document.getElementById('BusinessID').value;
         document.getElementById('BuissIDerr').innerHTML = "";
    document.getElementById('BusinessID').style.backgroundColor = "";
    document.getElementById('BusinessID').style.border = "";
        if(buissID == -1) // Ελέγχει εάν είναι επιλεγμένη η default επιλογή
            {
                result = false;
                 document.getElementById('BuissIDerr').innerHTML = "→ Please choose Business Type!";
   document.getElementById('BusinessID').style.border = "solid 1px red";
   document.getElementById('BusinessID').style.backgroundColor = "yellow";
            }
            
            
            var GeoX = document.getElementById('GeoX').value;
            var GeoY = document.getElementById('GeoY').value;
            var illegalmap = /^[0-9 \. \-]+$/; /* Ψάχνει να βρει έναν αποδεκτό αριθμό  που να μοιάζει με συντεταγμένες */
            document.getElementById('MapError').innerHTML = "";
            document.getElementById('MapError').style.border = "";
            document.getElementById('MapError').style.backgroundColor = "";
            if(!illegalmap.test(GeoX) && !illegalmap.test(GeoY))
                {
                    result = false;
                   document.getElementById('MapError').innerHTML = "→ Please Put the location of your Business!";
            document.getElementById('MapError').style.border = "solid 1px red";
            document.getElementById('MapError').style.backgroundColor = "yellow"; 
                }
   
    
  return result;  
}

function Bus_Name() //Παίρνει το όνομα της επιχειρήσεις προς προσωρινή αποθήκευση
{
    // Ελέγχει εάν ο Browser του χρήστη είναι συμβατός με τις αποθηκευτικές μεθόδους του html 5
    if(typeof(Storage)!=="undefined") 
  {
 sessionStorage.BuSNm =document.getElementById('BusName').value;
    return sessionStorage.BuSNm;
  }
else
  {
    var BuSNm =document.getElementById('BusName').value;
    return BuSNm;
  }
}
function Address_lol() // Παίρνει την διεύθυνση της επιχειρήσεις προς προσωρινή αποθήκευση
{
    // Ελέγχει εάν ο Browser του χρήστη είναι συμβατός με τις αποθηκευτικές μεθόδους του html 5
     if(typeof(Storage)!=="undefined")
  {
    sessionStorage.addr = document.getElementById('Address').value;
    return sessionStorage.addr;
  }else{
       var addr = document.getElementById('Address').value;
    return addr;
  }
}
function Phonein() // Παίρνει το τηλέφωνο της επιχειρήσεις προς προσωρινή αποθήκευση
{
    // Ελέγχει εάν ο Browser του χρήστη είναι συμβατός με τις αποθηκευτικές μεθόδους του html 5
     if(typeof(Storage)!=="undefined")
  {
  
    sessionStorage.Ph = document.getElementById('Phone').value;
    return sessionStorage.Ph;
  }else{
      var Ph = document.getElementById('Phone').value;
    return Ph;  
    }
}
function BusID() // Παίρνει τον τύπο της επιχειρήσεις προς προσωρινή αποθήκευση
{
    // Ελέγχει εάν ο Browser του χρήστη είναι συμβατός με τις αποθηκευτικές μεθόδους του html 5
     if(typeof(Storage)!=="undefined")
  {
    sessionStorage.BusId = document.getElementById('BusinessID').value;
return  sessionStorage.BusId;
  }else{
       var BusId = document.getElementById('BusinessID').value;
return BusId;
  }
}
function Des() // Παίρνει την περιγραφή της επιχειρήσεις προς προσωρινή αποθήκευση
{
    // Ελέγχει εάν ο Browser του χρήστη είναι συμβατός με τις αποθηκευτικές μεθόδους του html 5
     if(typeof(Storage)!=="undefined")
  {
    sessionStorage.Desc = document.getElementById('Description').value;
  return sessionStorage.Desc;
  }else{
  var Desc = document.getElementById('Description').value;
  return Desc;
  }
}
function passelmslocal()
{
    // Ελέγχει εάν ο Browser του χρήστη είναι συμβατός με τις αποθηκευτικές μεθόδους του html 5
      if(typeof(Storage)!=="undefined")
  {
      // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
      if(sessionStorage.BuSNm)
          {
     document.getElementById('BusName').value = sessionStorage.BuSNm; // Εμφανίσει της μεταβλητής 
   
          }
 else
     document.getElementById('BusName').value ="";
 // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
        if(sessionStorage.addr)
            {
       document.getElementById('Address').value = sessionStorage.addr; // Εμφανίσει της μεταβλητής
      
            }
   else
       document.getElementById('Address').value = "";
    // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
   if(sessionStorage.Ph)
       {
    document.getElementById('Phone').value =  sessionStorage.Ph; // Εμφανίσει της μεταβλητής
       
        }
else
    document.getElementById('Phone').value = "";
 // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
if(sessionStorage.BusId)
    {
       document.getElementById('BusinessID').value = sessionStorage.BusId; // Εμφανίσει της μεταβλητής
   
        }
   else
       document.getElementById('BusinessID').value = "";
    // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
   if(sessionStorage.Desc)
       {
   document.getElementById('Description').value = sessionStorage.Desc; // Εμφανίσει της μεταβλητής
    
        }
   else
        document.getElementById('Description').value = "";
  }else{
      Passelms();
  }
}
function resetlocal() // Διαγραφή-επαναφέρει τις μεταβλητές που αποθηκεύτηκαν στον browser του χρήστη
{
    // Ελέγχει εάν ο Browser του χρήστη είναι συμβατός με τις αποθηκευτικές μεθόδους του html 5
    if(typeof(Storage)!=="undefined")
  {
   if(sessionStorage.Desc) // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
       {
        sessionStorage.Desc= "";
       }
       if(sessionStorage.BusId) // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
    {
    sessionStorage.BusId = "";
    }
    if(sessionStorage.Ph) // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
       {
         sessionStorage.Ph="";  
       }
       if(sessionStorage.addr) // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
            {
              sessionStorage.addr="";  
            }
              
      if(sessionStorage.BuSNm) // Ελέγχει εάν είναι αποθηκευμένο στον Browser του χρήστη η μεταβλητή αυτή
          {
              sessionStorage.BuSNm= "";
          }
}
       
}

 function Passelms() // Στέλνει τα δεδομένα προς προσωρινή αποθήκευση
{
    var BuisnessTitle;
      var Address;
       var phone;
        var buissID;
        var textar;
         // Ελέγχει εάν ο Browser του χρήστη είναι συμβατός με τις αποθηκευτικές μεθόδους του html 5
     if(typeof(Storage)!=="undefined")
  {
       return ;
     
  }else{
    BuisnessTitle = new String(""+Bus_Name()+"");
      Address =  new String(""+Address_lol()+"");
       phone =  new String(""+Phonein()+"");
        buissID =  new String(""+BusID()+"");
        textar =  new String(""+Des()+"");   
  }
 var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  
	//-----Αποφυγή caching σελίδας-----
  //Για να μην καλούμε πάντα το getmovies.php και ο browser 
  //διαβάζει την αποθηκευμένη σελίδα από το δίσκο, κολλάμε 
  //και μια παράμετρο με βάση την ημερομηνία-ώρα ώστε να 
  //έχουμε πάντα διαφορετικό URL (προφανώς δεν θα χρησιμοποιήσουμε
  //κάπου αυτή την παράμετρο!)  
  var d = new Date();    // βάλε στη μεταβλητή d την τρέχουσα ημ/νία-ώρα
	var url= "Inc/storedata.php?foo"+d;  
	
  //------- αρχικοποίηση bussy indicator -----------
  // βάζουμε μέσα στο δεξί div την εικόνα spinner.gif, μέχρι να έρθουν 
  // οι απαντήσεις της AJAX κλίσης - η class spinner κεντράρει την εικόνα 
  // μέσα στο div (για το πώς γίνεται δείτε στη δήλωση του CSS κανόνα παραπάνω) 
  
  
  //-----υποβολή ερωτήματος στον server-----
  xmlhttp.open("POST",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("BusName="+BuisnessTitle+"&Address="+Address+"&Phone="+phone+"&BusinessID="+buissID+"&Description="+textar+"");  
  
  //-----ορισμός της callback συνάρτησης-----
  //τρέχει αυτόματα κάθε φορά που αλλάζει η παράμετρος readyState
  //του AJAX - εδώ λέμε τι θα κάνουμε με τις απαντήσεις 
  xmlhttp.onreadystatechange=function() {
     
    //δείτε τα slide θεωρίας για τις διάφορες παραμέτρους
    //αν ο server απάντησε (AJAX readyState 4) και απάντησε επιτυχώς (server http status 200)
		if(xmlhttp.status == 200 && xmlhttp.readyState == 4   ) {
      //η απάντηση του server βρίσκεται στο xmlhttp.responseText
      //την τοποθετούμε μέσα στο δεξιό div
		
                        
		} else if (xmlhttp.status == 403)
                {
       alert("FORBIDDEN");
                }else if (xmlhttp.status == 404)
                    {
                        alert("File Does Not Exist");
                    }
      };


}

// Παίρνει τα δεδομένα των επιχειρήσεων για προβολή όπου str δείχνει τι είδους προβολή να κάνει (Επεξεργασίας, Διαγραφής)
function getbusData(str) 
{
    // Εικόνα loading για να μπορεί ο χρήστης να κατανοήσει ότι γίνετε δουλειά στο παρασκήνιο
   document.getElementById('List').innerHTML = '<img style="margin:0 auto;" src="Images/loading.gif" alt="loading" title="loading" />';
     var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  
	//-----Αποφυγή caching σελίδας-----
  //Για να μην καλούμε πάντα το getmovies.php και ο browser 
  //διαβάζει την αποθηκευμένη σελίδα από το δίσκο, κολλάμε 
  //και μια παράμετρο με βάση την ημερομηνία-ώρα ώστε να 
  //έχουμε πάντα διαφορετικό URL (προφανώς δεν θα χρησιμοποιήσουμε
  //κάπου αυτή την παράμετρο!)  
  var d = new Date();    // βάλε στη μεταβλητή d την τρέχουσα ημ/νία-ώρα
	var url= "Inc/takeBusData.php?foo"+d;  
	
  //------- αρχικοποίηση bussy indicator -----------
  // βάζουμε μέσα στο δεξί div την εικόνα spinner.gif, μέχρι να έρθουν 
  // οι απαντήσεις της AJAX κλίσης - η class spinner κεντράρει την εικόνα 
  // μέσα στο div (για το πώς γίνεται δείτε στη δήλωση του CSS κανόνα παραπάνω) 
  
  
  //-----υποβολή ερωτήματος στον server-----
  xmlhttp.open("POST",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("Title="+str+"");  
  
  //-----ορισμός της callback συνάρτησης-----
  //τρέχει αυτόματα κάθε φορά που αλλάζει η παράμετρος readyState
  //του AJAX - εδώ λέμε τι θα κάνουμε με τις απαντήσεις 
  xmlhttp.onreadystatechange=function() {
     
    //δείτε τα slide θεωρίας για τις διάφορες παραμέτρους
    //αν ο server απάντησε (AJAX readyState 4) και απάντησε επιτυχώς (server http status 200)
		if(xmlhttp.status == 200 && xmlhttp.readyState == 4   ) {
      //η απάντηση του server βρίσκεται στο xmlhttp.responseText
      //την τοποθετούμε μέσα στο δεξιό div
		document.getElementById('List').innerHTML = xmlhttp.responseText;
                        
		} else if (xmlhttp.status == 403)
                {
                 alert("FORBIDDEN");
                }else if (xmlhttp.status == 404)
                    {
                        alert("File Does Not Exist");
                    }
      };

}

/* Αλλάζει την εικόνα profile. Στο element είναι το στοιχείο που κοιτάμε αν είναι τσεκαρισμένο.
Το bid είναι το ID της Επιχειρήσεις  */
function ChangeProfPic(element,bid)
{
    // Εικόνα loading για να μπορεί ο χρήστης να κατανοήσει ότι γίνετε δουλειά στο παρασκήνιο
    document.getElementById('ProfChanged').innerHTML = '<img style="margin:0 auto;" src="Images/loading.gif" alt="loading" title="loading" />' ;
   var PiciD = element.value;
   var IsProfPic = element.checked;

   var xmlhttp;
   if(IsProfPic)
       {
  if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  
  var d = new Date();    // βάλε στη μεταβλητή d την τρέχουσα ημ/νία-ώρα
	var url= "Inc/changeprofpic.php?foo"+d;  
	
  //------- αρχικοποίηση bussy indicator -----------
  // βάζουμε μέσα στο δεξί div την εικόνα spinner.gif, μέχρι να έρθουν 
  // οι απαντήσεις της AJAX κλίσης - η class spinner κεντράρει την εικόνα 
  // μέσα στο div (για το πώς γίνεται δείτε στη δήλωση του CSS κανόνα παραπάνω) 
  
  
  //-----υποβολή ερωτήματος στον server-----
  if(bid == null)
      {
  xmlhttp.open("POST",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("PiciD="+PiciD+"");  
      }else{
          xmlhttp.open("POST",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("PiciD="+PiciD+"&BiD="+bid+"");  
      }
  //-----ορισμός της callback συνάρτησης-----
  //τρέχει αυτόματα κάθε φορά που αλλάζει η παράμετρος readyState
  //του AJAX - εδώ λέμε τι θα κάνουμε με τις απαντήσεις 
  xmlhttp.onreadystatechange=function() {
     
    
		if(xmlhttp.status == 200 && xmlhttp.readyState == 4   ) {
    
		document.getElementById('ProfChanged').innerHTML = xmlhttp.responseText;
                        
		} else if (xmlhttp.status == 403)
                {
                 alert("FORBIDDEN");
                }else if (xmlhttp.status == 404)
                    {
                        alert("File Does Not Exist");
                    }
      };

       }else{
         alert("Problem Try Again later");
       }
}

function DeletePic() // Διαγραφή την εικόνα που επιλεκτικέ
{
    // Εικόνα loading για να μπορεί ο χρήστης να κατανοήσει ότι γίνετε δουλειά στο παρασκήνιο
    document.getElementById('ProfChanged').innerHTML = '<img style="margin:0 auto;" src="Images/loading.gif" alt="loading" title="loading" />';
   var BiD = document.getElementById('PicID').value;
   var xmlhttp;
  
  if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  
  var d = new Date();    // βάλε στη μεταβλητή d την τρέχουσα ημ/νία-ώρα
	var url= "Inc/DeletePic.php?foo"+d;  
	
  //------- αρχικοποίηση bussy indicator -----------
  // βάζουμε μέσα στο δεξί div την εικόνα spinner.gif, μέχρι να έρθουν 
  // οι απαντήσεις της AJAX κλίσης - η class spinner κεντράρει την εικόνα 
  // μέσα στο div (για το πώς γίνεται δείτε στη δήλωση του CSS κανόνα παραπάνω) 
  
  
  //-----υποβολή ερωτήματος στον server-----
  xmlhttp.open("POST",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("PicID="+BiD+"");  
  
  //-----ορισμός της callback συνάρτησης-----
  //τρέχει αυτόματα κάθε φορά που αλλάζει η παράμετρος readyState
  //του AJAX - εδώ λέμε τι θα κάνουμε με τις απαντήσεις 
  xmlhttp.onreadystatechange=function() {
     
    
		if(xmlhttp.status == 200 && xmlhttp.readyState == 4   ) {
    
		document.getElementById('ProfChanged').innerHTML = xmlhttp.responseText;
                        
		} else if (xmlhttp.status == 403)
                {
                 alert("FORBIDDEN");
                }else if (xmlhttp.status == 404)
                    {
                        alert("File Does Not Exist");
                    }
      };

   
}

/* Συλλέξει στοιχείων αναζήτησης.
Η page είναι ο αριθμός της σελίδας που βρίσκεται η σελίδα (αν υπάρχει σελιδοποίηση).
Το trans είναι ο αριθμός των εγγραφών που θα φαίνονται σε κάθε σελίδα.
Το Search είναι ένα αλφαριθμητικό το οποίο αναζητούμε.
Το id είναι ο τύπος της επιχειρήσεις. */
function getSearchResults(page,trans,search,id)
{
    // Εικόνα loading για να μπορεί ο χρήστης να κατανοήσει ότι γίνετε δουλειά στο παρασκήνιο
document.getElementById('loadingstate').innerHTML = '<img style="margin:0 auto;" src="Images/loading.gif" alt="loading" title="loading" />';
    if(id == null)
        {
            id="-1";
        }
    if(search == null)
        {
            search="";
        }
    var searchtext;
     var BusType;
         var searchtype;

    if(search.length > 0)
        {
            searchtext = ""+search+"";
            BusType= "-1";
            searchtype = "1";
          
        }else{
            searchtext = ""+document.getElementById('Searchtext').value+"";
        
        
   
    if(document.getElementById('TypeBusiness').value == null)
        {
                 BusType= "-1";
        }else{
       
            BusType = ""+document.getElementById('TypeBusiness').value+"";
        }
        
        // Έλεγχος αν κάποιος από τους τύπους αναζήτησης είναι τσεκαρισμένος
    if(document.getElementById('Searchtype0').checked == true)
        {
            searchtype= "0";
        }else if(document.getElementById('Searchtype1').checked == true)
            {
               searchtype= "1"; 
            }else if(document.getElementById('Searchtype2').checked == true)
            {
               searchtype= "2"; 
            }else if(document.getElementById('Searchtype3').checked == true)
            {
               searchtype= "3"; 
            }else{
                searchtype= "1";
            }
            }
            
     var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  

  var d = new Date();    // βάλε στη μεταβλητή d την τρέχουσα ημ/νία-ώρα
	var url= "Inc/SearchAnalyzer.php?BusinessType="+id+"&trans="+trans+"&page="+page+"&foo="+d;  
	
  //------- αρχικοποίηση bussy indicator -----------
  // βάζουμε μέσα στο δεξί div την εικόνα spinner.gif, μέχρι να έρθουν 
  // οι απαντήσεις της AJAX κλίσης - η class spinner κεντράρει την εικόνα 
  // μέσα στο div (για το πώς γίνεται δείτε στη δήλωση του CSS κανόνα παραπάνω) 
  
  
  //-----υποβολή ερωτήματος στον server-----
  xmlhttp.open("POST",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("Searchlike="+searchtext+"&BusinessType="+BusType+"&SearchType="+searchtype+"");  
  
  //-----ορισμός της callback συνάρτησης-----
  //τρέχει αυτόματα κάθε φορά που αλλάζει η παράμετρος readyState
  //του AJAX - εδώ λέμε τι θα κάνουμε με τις απαντήσεις 
  xmlhttp.onreadystatechange=function() {
     
    //δείτε τα slide θεωρίας για τις διάφορες παραμέτρους
    //αν ο server απάντησε (AJAX readyState 4) και απάντησε επιτυχώς (server http status 200)
		if(xmlhttp.status == 200 && xmlhttp.readyState == 4   ) {
      //η απάντηση του server βρίσκεται στο xmlhttp.responseText
      //την τοποθετούμε μέσα στο δεξιό div
      document.getElementById('loadingstate').innerHTML = "";
		document.getElementById('results').innerHTML = xmlhttp.responseText;
                        
		} else if (xmlhttp.status == 403)
                {
                 alert("FORBIDDEN");
                }else if (xmlhttp.status == 404)
                    {
                        alert("File Does Not Exist");
                    }
      };
   
}

function getWebService() // Παροχή αποτελεσμάτων υπηρεσίας
{
    // Εικόνα loading για να μπορεί ο χρήστης να κατανοήσει ότι γίνετε δουλειά στο παρασκήνιο
   document.getElementById('loadingstate').innerHTML = '<img style="margin:0 auto;" src="Images/loading.gif" alt="loading" title="loading" />';
 
    var searchtext =  ""+document.getElementById('Searchtext').value+"";
     var BusType;
         var searchtype
        var typeofexport;
        
        if(document.getElementById('Typeofexport').value == null) /* Τύπος εξαγωγής δεδομένων 
     * Αν είναι 1 βγάζει html αποτελέσματα
     * Aν είναι 0 βγάζει xml αποτελέσματα */
            {
                typeofexport = "1";
            }else{
                 typeofexport = ""+document.getElementById('Typeofexport').value+"";
            }
   
    if(document.getElementById('TypeBusiness').value == null)
        {
                 BusType= "-1";
        }else{
       
            BusType = ""+document.getElementById('TypeBusiness').value+"";
        }
        
           // Έλεγχος αν κάποιος από τους τύπους αναζήτησης είναι τσεκαρισμένος
    if(document.getElementById('Searchtype0').checked == true)
        {
            searchtype= "0";
        }else if(document.getElementById('Searchtype1').checked == true)
            {
               searchtype= "1"; 
            }else if(document.getElementById('Searchtype2').checked == true)
            {
               searchtype= "2"; 
            }else if(document.getElementById('Searchtype3').checked == true)
            {
               searchtype= "3"; 
            }else{
                searchtype= "1";
            }
            
            
     var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  

  var d = new Date();    // βάλε στη μεταβλητή d την τρέχουσα ημ/νία-ώρα
	var url= "Inc/WebServices.php?Searchlike="+searchtext+"&BusinessType="+BusType+"&SearchType="+searchtype+"&Typeofexport="+typeofexport+"&foo="+d;  
	var stringurl = ""+location.href+"";
        var theurl = stringurl.slice(0,stringurl.search("WebService.php"));
       var end;
    if(typeofexport == "0")
           {
    end = ""+theurl+""+url+"";
           }else{
                end = ""+theurl+""+url+"&output=1";
           }
  //------- αρχικοποίηση bussy indicator -----------
  // βάζουμε μέσα στο δεξί div την εικόνα spinner.gif, μέχρι να έρθουν 
  // οι απαντήσεις της AJAX κλίσης - η class spinner κεντράρει την εικόνα 
  // μέσα στο div (για το πώς γίνεται δείτε στη δήλωση του CSS κανόνα παραπάνω) 
  
  
  //-----υποβολή ερωτήματος στον server-----
  xmlhttp.open("GET",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send(null);  
  
  //-----ορισμός της callback συνάρτησης-----
  //τρέχει αυτόματα κάθε φορά που αλλάζει η παράμετρος readyState
  //του AJAX - εδώ λέμε τι θα κάνουμε με τις απαντήσεις 
  xmlhttp.onreadystatechange=function() {
     
    //δείτε τα slide θεωρίας για τις διάφορες παραμέτρους
    //αν ο server απάντησε (AJAX readyState 4) και απάντησε επιτυχώς (server http status 200)
		if(xmlhttp.status == 200 && xmlhttp.readyState == 4   ) {
      //η απάντηση του server βρίσκεται στο xmlhttp.responseText
      //την τοποθετούμε μέσα στο δεξιό div
      document.getElementById('Stringexport').innerHTML = '<iframe  src="'+end+'" > <p>Your browser does not support iframes.</p> </iframe>'.toString();
      document.getElementById('loadingstate').innerHTML = "";
           if(typeofexport == "0")
               {
                   
                    document.getElementById('results').innerHTML = '<iframe  src="'+end+'" style="margin:4em; width:90%; height:25em;"> <p>Your browser does not support iframes.</p> </iframe>';
               }else{
            document.getElementById('results').innerHTML = xmlhttp.responseText;
               }
		} else if (xmlhttp.status == 403)
                {
                 alert("FORBIDDEN");
                }else if (xmlhttp.status == 404)
                    {
                        alert("File Does Not Exist");
                    }
      };
   
}

function valid_change() // Ελέγχει εάν το νέο password που πληκτρολόγησε ο χρήστης είναι σωστό ή όχι
{
    var result = true;
    result = password("→ Wrong password please put a valid password",document.getElementById('PassWord'),document.getElementById('Passerr'));
    result = password("→ Wrong Password. Please follow the Rules!",document.getElementById('NewPassword'),document.getElementById('NewPasserr'));
    document.getElementById("RetypPassword").style.backgroundColor="";
       document.getElementById("RetypPassword").style.border="";
document.getElementById("RetypPasserr").innerHTML ="";
    var isnewpassword = document.getElementById('NewPassword').value;
    var retypedpassword= document.getElementById('RetypPassword').value;
    if(isnewpassword != retypedpassword)
        {
              document.getElementById("RetypPassword").style.backgroundColor="yellow";
       document.getElementById("RetypPassword").style.border="thin solid red";
document.getElementById("RetypPasserr").innerHTML ="→ The Passwords does not match";
            result=false;
            document.getElementById('RetypPassword')
        }
    return result;
}

function getimage(busID)
{
     document.getElementById('Profile_Pic').innerHTML = '<img id="profpic" style="margin:0 auto;" src="Images/loading.gif" alt="loading" title="loading" />'; ;
    
     var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  

  var d = new Date();    // βάλε στη μεταβλητή d την τρέχουσα ημ/νία-ώρα
	var url= "Inc/getImage.php?BUSID="+busID+"&foo="+d;  
	
  //------- αρχικοποίηση bussy indicator -----------
  // βάζουμε μέσα στο δεξί div την εικόνα spinner.gif, μέχρι να έρθουν 
  // οι απαντήσεις της AJAX κλίσης - η class spinner κεντράρει την εικόνα 
  // μέσα στο div (για το πώς γίνεται δείτε στη δήλωση του CSS κανόνα παραπάνω) 
  
  
  //-----υποβολή ερωτήματος στον server-----
  xmlhttp.open("GET",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send(null);  
  
  //-----ορισμός της callback συνάρτησης-----
  //τρέχει αυτόματα κάθε φορά που αλλάζει η παράμετρος readyState
  //του AJAX - εδώ λέμε τι θα κάνουμε με τις απαντήσεις 
  xmlhttp.onreadystatechange=function() {
     
    //δείτε τα slide θεωρίας για τις διάφορες παραμέτρους
    //αν ο server απάντησε (AJAX readyState 4) και απάντησε επιτυχώς (server http status 200)
		if(xmlhttp.status == 200 && xmlhttp.readyState == 4   ) {
      //η απάντηση του server βρίσκεται στο xmlhttp.responseText
      //την τοποθετούμε μέσα στο δεξιό div
  
      
        
            document.getElementById('Profile_Pic').innerHTML = xmlhttp.responseText;
               
		} else if (xmlhttp.status == 403)
                {
                 alert("FORBIDDEN");
                }else if (xmlhttp.status == 404)
                    {
                        alert("File Does Not Exist");
                    }
      };
}
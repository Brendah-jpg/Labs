function validateForm(){
	var fname = document.forms["user_details"]["first_name"].value;
	var lname = document.forms["user_details"]["last_name"].value;
	var city = document.forms["user_details"]["city_name"].value;
	var uname = document.forms["user_details"]["username"].value;
	var psw = document.forms["user_details"]["password"].value;
	var img = document.getElementById("fileToUpload");

	if(fname == null || lname == "" || city == "" || uname == "" || psw = "" || img = ""){
		alert("All details that are required were not given");
		return false;
	}
	return true;
}
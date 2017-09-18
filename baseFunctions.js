

function imagePop(x)
{
	if ($("#pop").css("visibility")  == "visible" )
		{
			$("#pop").css("visibility","hidden")  ;
			$("#popImg").css("visibility","hidden")  ;
		}else
		{
			$("#pop").css("visibility","visible")  ;
			$("#popImg").css("visibility","visible")  ;
			$("#popImg").attr("src" , x.src ) ;
		}

}


function jsWorks()
{
	document.getElementById("jtest").innerHTML  = "js działa" ;
}

function jqWorks()
{
	$("#jqtest").text("jquery też działa");
}

function loadin()
{
	jsWorks();
    jqWorks();
    imagePop();
}



function dropDowns(x)
{
	$(x).next().fadeToggle();
}

function LoadDropDowns()
{
	$("ul.goalList").fadeOut(0);
}

function check(postID , checkboxNr, checkbox)
{
            if(window.XMLHttpRequest)
            {
                xhr = new XMLHttpRequest();
            }else
            {
                xhr = new ActiveObject('Microsoft.XMLHTTP');
            }        
            
                xhr.open("POST", 'ajaxGoal.php', true);

                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
                xhr.send("id="+postID+"&checkboxID="+checkboxNr+"&boxDestiny="+checkbox.checked);
}

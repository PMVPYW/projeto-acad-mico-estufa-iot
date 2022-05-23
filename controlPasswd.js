var pass0 = document.getElementById("pass0");
var pass1 = document.getElementById("pass1");

function check()
{
    if (pass0.value != pass1.value)
    {
        pass1.style.backgroundColor = "red";
    }
    else
    {
        pass1.style.backgroundColor = "white";
    }
    
}

setInterval(check, 10);
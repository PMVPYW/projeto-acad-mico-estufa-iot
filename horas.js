var element = document.getElementById("horas");

function time()
{
    var date = new Date();
    var date = date.toLocaleString("pt", {timeZone: "Europe/Lisbon"});

    
    element.textContent = date;
}

setInterval(time, 1000);
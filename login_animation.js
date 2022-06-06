text = document.getElementById("login_h1")

function delay(time)
{
    console.log("delay");
    var now = new Date().getSeconds();
    var next = now+time;
    if (next >= 60)
    {
        next = next - 60;
    }
    while (new Date().getSeconds() <= next);
}

var ptos = ".";

setInterval(function run()
{
    ptos+=".";
    if (ptos.length > 3)
    {
        ptos = "";
    }
    text.innerHTML = "<h1>A fazer login. Por favor Espere" + ptos + "</h1>";
    console.log(text.innerHTML);
}, 500);


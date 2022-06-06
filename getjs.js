var ip = "localhost"



function set(url, nome, symbol, id)
{
    var x = document.getElementById(id)
    var HTTP = new XMLHttpRequest();
    HTTP.open( "GET", url); // false for synchronous request
    HTTP.send();
    HTTP.onload =function()
    {
        if(HTTP.status == 200)
        {
            var vars = HTTP.responseText.split(";");
            x.innerHTML = nome +": " + vars[0] + symbol;
            document.getElementById(id.concat("_label")).innerHTML = vars[0].concat(symbol);
            if (id == "solar")
            {
                nome = "seguidor_Solar";
            }
            else if (id == "pulverizador")
            {
                nome = "Pulverizador_Fertilizante";
            }
            document.getElementById(id.concat("_hora")).innerHTML = "<b>Atualização: </b>" + vars[1] + ' - <a href=\"historico.php?nome='+nome+'\">Histórico</a>';
            document.getElementById(id.concat("_hora_label")).innerHTML = vars[1];
            console.log("response: " + HTTP.responseText);

            switch (id) {
                case 'iluminação':
                case 'pulverizador':
                case 'irrigação':
                    if( vars[0] =="Ligado")
                {
                    document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-success">Ligado</span></td>';
                }
                else
                {
                    document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-danger">Desligado</span></td>';
                }
                break;

                case 'AC':
                    if (vars[0] >= 25)
                    {
                        document.getElementById("AC_badge").innerHTML = '<span class="badge rounded-pill bg-danger">Alto</span></td>';
                    }
                    else if(vars[0]>=15)
                    {
                        document.getElementById("AC_badge").innerHTML = '<span class="badge rounded-pill bg-success">Ideal</span></td>'
                    }
                    else
                    {
                        document.getElementById("AC_badge").innerHTML = '<span class="badge rounded-pill bg-danger">Baixo</span></td>'
                    }
                    break;
                case 'solar':

                    document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-success">' + vars[0] + '</span></td>';

                    break;

            }
        }
        else
        {
            console.log("status");
            console.log(HTTP.status);
            console.log("response: " + vars[0]);
        }

    }
}

function handle()
{
    var hum = document.getElementById("humidade").innerHTML.replace("Luminosidade: ", "").replace("%", )
}

setInterval(function()
{
    var url = "http://localhost/projeto_ti%20-%20SQL/api/api.php?nome=iluminação"
    set(url, "iluminação", "", "iluminação");
    var url = "http://localhost/projeto_ti%20-%20SQL/api/api.php?nome=AC"
    set(url, "AC", "º", "AC");
    var url = "http://localhost/projeto_ti%20-%20SQL/api/api.php?nome=irrigação"
    set(url, "irrigação", "", "irrigação");
    var url = "http://localhost/projeto_ti%20-%20SQL/api/api.php?nome=Pulverizador_Fertilizante"
    set(url, "Pulverizador Fertilizante", "", "pulverizador");
    var url = "http://localhost/projeto_ti%20-%20SQL/api/api.php?nome=seguidor_Solar"
    set(url, "Seguidor Solar", "º", "solar");

}, 1000);
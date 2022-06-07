from ast import arg
from concurrent.futures import thread
from distutils.cmd import Command
from time import strftime, gmtime
import os 
import tkinter as tk
from tkinter import font
from tkinter import messagebox
from tkinter import ttk
from turtle import back
try:
    import requests
except:
    os.system("pip install requests")

import threading
from PIL import ImageTk, Image

background = "#2B2B2B"

irrigacao = ""
seguidorSolar = ""
pulverizador = ""
screen_width = 0
screen_height = 0
x = 0
y = 0
root1 = tk.Tk()
def GUI_init():
    global screen_width, screen_height, x, y
    
    root1.title("Projeto TI")
    screen_width = root1.winfo_screenwidth()
    screen_height = root1.winfo_screenheight()

    width = 125
    height = 145

    x = int(screen_width/2 - width/2)
    y = int(screen_height/2 - height/2)

    root1.geometry(f"{width}x{height}+{x}+{y}")
    root1.resizable(False, False)

    root1.overrideredirect(1)   # Remove a barra de título
    bg = ImageTk.PhotoImage(Image.open("icon.ico"))
    canvas = tk.Canvas(root1, width=325, height=125, bg=background)
    canvas.pack(fill = "both", expand = True)
    canvas.create_image(0, 0, image=bg, anchor="nw")

    pb = ttk.Progressbar(root1, orient="horizontal", length=width-5, mode="indeterminate")
    pb.place(x=2.5, y=125)
    pb.start(20)
    t1 = threading.Thread(target=init)
    t1.start()
    root1.mainloop()

def manageColors(estado, btn_ativo, btn_desligado):
    begin = (25, 105, 192)
    end = (12, 182, 232)
    if estado == "Ligado":
        btn_ativo.config(bg=_from_rgb(end))
        btn_desligado.config(bg="gray")
    elif estado == "Desligado":
        btn_ativo.config(bg="gray")
        btn_desligado.config(bg=_from_rgb(end))
    else:
        btn_ativo.config(bg="gray")
        btn_desligado.config(bg="gray")

def getFromServer():
    print("i")
    global irrigacao, pulverizador, seguidorSolar
    try:
        pulverizador = requests.get("http://localhost/projeto_ti%20-%20SQL/api/api.php?nome=Pulverizador_Fertilizante")
        irrigacao = requests.get("http://localhost/projeto_ti%20-%20SQL/api/api.php?nome=irrigação")
        seguidorSolar = requests.get("http://localhost/projeto_ti%20-%20SQL/api/api.php?nome=seguidor_solar")

        if pulverizador.status_code != 200:
            print("Erro ao obter Pulverizador de Fertilizante")
            pulverizador = "None"
        else:
            pulverizador = pulverizador.text.split(";")[0]
        if irrigacao.status_code != 200:
            print("Erro ao obter irrigação")
            irrigacao = "None"
        else:
            irrigacao = irrigacao.text.split(";")[0]
        if seguidorSolar.status_code != 200:
            print("Erro ao obter seguidor solar")
            seguidorSolar = "None"
        else:
            seguidorSolar = float(seguidorSolar.text.split(";")[0])
    except:
        pulverizador = "Não conectado"
        irrigacao = "Não conectado"
        seguidorSolar = "Não conectado"
    try:
        manageColors(irrigacao, btn_ativo, btn_desligado)
        manageColors(pulverizador, btn_pulverizador_ativo, btn_pulverizador_desligado)
        root.after(5000, lambda: thread_(getFromServer))
    except:
        pass

def init():
    global irrigacao, pulverizador, seguidorSolar, root1
    getFromServer()
    root1.destroy()


GUI_init()

def datahora():
    return strftime("%d/%m/%Y %H:%M:%S", gmtime())


def _from_rgb(rgb):
    """translates an rgb tuple of int to a tkinter friendly color code
    """
    r, g, b = rgb
    return f'#{r:02x}{g:02x}{b:02x}'

def ERROR():
    try:
        tk.Tk().withdraw()
        msg = messagebox.showwarning("Erro no servidor", "Por favor verifique o servidor")
        del msg
    except Exception as e:
        print(e)


def ligaPulverizador():
    global btn_ativo, btn_desligado, pulverizador, root
    data = {"nome": "Pulverizador_Fertilizante", "valor": "Ligado", "hora": datahora(), "username": "admin", "password": "root"}
    try:
        r = requests.post("http://localhost/projeto_ti%20-%20SQL/api/api.php", data) 
        if r.status_code != 200:
            print("Erro ao ligar pulverizador")
        else:
            pulverizador = "Ligado"
            manageColors("Ligado", btn_pulverizador_ativo, btn_pulverizador_desligado)
    except:
        ERROR()

def desligaPulverizador():
    global btn_ativo, btn_desligado, pulverizador
    data = {"nome": "Pulverizador_Fertilizante", "valor": "Desligado", "hora": datahora(), "username": "admin", "password": "root"}
    try:
        r = requests.post("http://localhost/projeto_ti%20-%20SQL/api/api.php", data) 
        if r.status_code != 200:
            print("Erro ao desligar pulverizador")
        else:
            pulverizador = "Desligado"
            manageColors("Desligado", btn_pulverizador_ativo, btn_pulverizador_desligado)
    except:
        ERROR()

def ligaIrrigacao():
    global btn_ativo, btn_desligado, irrigacao
    data = {"nome": "irrigação", "valor": "Ligado", "hora": datahora(), "username": "admin", "password": "root"}
    try:
        r = requests.post("http://localhost/projeto_ti%20-%20SQL/api/api.php", data) 
        if r.status_code != 200:
            print("Erro ao ligar irrigação")
        else:
            irrigacao = "Ligado"
            manageColors("Ligado", btn_ativo, btn_desligado)
    except:
        ERROR()

def desligaIrrigacao():
    global btn_ativo, btn_desligado, irrigacao
    data = {"nome": "irrigação", "valor": "Desligado", "hora": datahora(), "username": "admin", "password": "root"}
    try:
        r = requests.post("http://localhost/projeto_ti%20-%20SQL/api/api.php", data) 
        if r.status_code != 200:
            print("Erro ao ligar irrigação")
        else:
            irrigacao = "Desligado"
            manageColors("Desligado", btn_ativo, btn_desligado)
    except:
        ERROR()

def enviaSeguidorSolar():
    global seguidorSolar, label_seguidorSolar, text_seguidorSolar 
    data = {"nome": "Seguidor_Solar", "valor": text_seguidorSolar.get(), "hora": datahora(), "username": "admin", "password": "root"}
    try:
        r = requests.post("http://localhost/projeto_ti%20-%20SQL/api/api.php", data) 
        if r.status_code != 200:
            print("Erro ao enviar posição do seguidor solar")
        else:
            seguidorSolar = text_seguidorSolar.get()
            label_seguidorSolar.config(text=f"Seguidor Solar: {seguidorSolar}º")
    except:
        ERROR("Erro", f"Não foi possivel enviar o valor {text_seguidorSolar.get()} para o servidor.")

'''
    Funções de threads
'''

def thread_(function):
    t1 = threading.Thread(target=function)
    t1.start()

btn_width = 8
root = tk.Tk()
root.iconbitmap("icon.ico")
width = 700
height = 400
x = screen_width / 2 - width / 2
y = screen_height / 2 - height / 2
root.geometry(f"{width}x{height}+{int(x)}+{int(y)}")
root.config(background=background)
root.title("Projeto TI")

label_ac = tk.Label(root, text="Pulverizador de Fertilizante", font=("Arial", 14), background=background, foreground="gray")
label_ac.place(relx=0.35, rely=0.05)

btn_pulverizador_ativo = tk.Button(root, text="Ligado", width=btn_width, font=("Arial", 14), command=lambda: thread_(ligaPulverizador))
btn_pulverizador_ativo.place(relx=0.3, rely=0.15)
btn_pulverizador_desligado = tk.Button(root, text="Desligado", width=btn_width, font=("Arial", 14), command=lambda: thread_(desligaPulverizador))
btn_pulverizador_desligado.place(relx=0.6, rely=0.15)

manageColors(pulverizador, btn_pulverizador_ativo, btn_pulverizador_desligado)

label_irrigacao = tk.Label(root, text="Irrigação", font=("Arial", 14), foreground="gray")
label_irrigacao.config(background=background)
label_irrigacao.place(relx=0.475, rely=0.30)
btn_ativo = tk.Button(root, text="Ligado", width=btn_width, font=("Arial", 14), command=lambda: thread_(ligaIrrigacao))
btn_ativo.place(relx=0.3, rely=0.40)
btn_desligado = tk.Button(root, text="Desligado", width=btn_width, font=("Arial", 14), command=lambda: thread_(desligaIrrigacao))
btn_desligado.place(relx=0.6, rely=0.40)
manageColors(irrigacao, btn_ativo, btn_desligado)

text_seguidorSolar = tk.Scale(root,from_=0,to=360, orient='horizontal')
text_seguidorSolar.config(bg = "gray")
#text_seguidorSolar.insert(tk.END, seguidorSolar)
text_seguidorSolar.place(relx=0.45, rely=0.65)

label_seguidorSolar = tk.Label(root, text=f"Seguidor Solar: {seguidorSolar}º", font=("Arial", 14), foreground="gray")
label_seguidorSolar.config(background=background)
label_seguidorSolar.place(relx=0.40, rely=0.6)

seguidorSolar_btn = tk.Button(root, text="Enviar", width=btn_width, font=("Arial", 14), command=lambda: thread_(enviaSeguidorSolar), bg=_from_rgb((25, 105, 192)))
seguidorSolar_btn.place(relx=0.45, rely=0.8)
root.after(5000, lambda: thread_(getFromServer))
root.mainloop()
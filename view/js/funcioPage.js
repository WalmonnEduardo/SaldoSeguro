function alterar() {
    const tipo = document.getElementById("senha");
    if (!tipo) {
        console.log("Elemento com id 'senha' não encontrado!");
        return;
    }
    tipo.type = tipo.type === "password" ? "text" : "password";
}

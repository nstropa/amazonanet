const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const port = process.env.PORT || 3000;

// Middleware para interpretar o corpo da requisição
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Endpoint para criar um usuário temporário
app.post('/create-temp-user', (req, res) => {
    const { mac } = req.body;

    // Aqui você pode chamar a API do MikroTik para criar o usuário temporário
    // Exemplo:
    // const result = await createMikrotikUser(mac);
    // res.send(result);

    res.send(`Usuário temporário criado para MAC: ${mac}`);
});

app.listen(port, () => {
    console.log(`Servidor rodando na porta ${port}`);
});

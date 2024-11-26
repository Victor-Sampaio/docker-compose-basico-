<?php
// URL base da API
$apiUrl = "http://app:8080/api/"; // Altere conforme necessário

// Função para realizar requisições cURL
function apiRequest($method, $url, $data = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Erro: ' . curl_error($ch);
    }
    curl_close($ch);
    return json_decode($response, true);
}

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    

    switch ($action) {
        case 'add':
            $clienteData = [
                "nome" => $_POST['nome'],
                "sobrenome" => $_POST['sobrenome'],
                "idade" => $_POST['idade'],
                "cpf" => $_POST['cpf']
            ];
            $result = apiRequest('POST', $apiUrl, $clienteData);
            echo "Cliente adicionado com sucesso!";
            break;
        case 'edit':
            $clienteData = [
                "nome" => $_POST['nome'],
                "sobrenome" => $_POST['sobrenome'],
                "idade" => $_POST['idade'],
                "cpf" => $_POST['cpf']
            ];
            $id = $_POST['id'];
            $result = apiRequest('PUT', "$apiUrl/$id", $clienteData);
            echo "Cliente atualizado com sucesso!";
            break;
        case 'delete':
            $id = $_POST['id'];
            $result = apiRequest('DELETE', "$apiUrl/$id");
            echo "Cliente excluído com sucesso!";
            break;
    }
}

// Listar clientes
$clientes = apiRequest('GET', $apiUrl);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Clientes</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1>Cadastro de Clientes</h1>

    <!-- Formulário para adicionar/editar cliente -->
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="id" id="cliente-id">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <br>
        <label for="sobrenome">Sobrenome:</label>
        <input type="text" name="sobrenome" id="sobrenome" required>
        <br>
        <label for="idade">Idade:</label>
        <input type="number" name="idade" id="idade" required>
        <br>
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" required>
        <br>
        <button type="submit">Salvar</button>
    </form>

    <h2>Lista de Clientes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>Idade</th>
                <th>CPF</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($clientes && is_array($clientes)): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['id']) ?></td>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                        <td><?= htmlspecialchars($cliente['sobrenome']) ?></td>
                        <td><?= htmlspecialchars($cliente['idade']) ?></td>
                        <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                        <td>
                            <button  class="action-button-edit" onclick="editarCliente(<?= htmlspecialchars(json_encode($cliente)) ?>)">Editar</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id']) ?>">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum cliente encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function editarCliente(cliente) {
            document.getElementById('cliente-id').value = cliente.id;
            document.getElementById('nome').value = cliente.nome;
            document.getElementById('sobrenome').value = cliente.sobrenome;
            document.getElementById('idade').value = cliente.idade;
            document.getElementById('cpf').value = cliente.cpf;
            document.querySelector('[name="action"]').value = 'edit';
        }
    </script>
</body>
</html>

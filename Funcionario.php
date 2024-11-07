<?php
// Simulação de uma consulta ao banco de dados. Substitua pelo seu código de conexão.
$usuarios = [
    ['funcionario_cod' => 1, 'funcionario_nome' => 'João', 'funcionario_cargo' => 'Gerente'],
    ['funcionario_cod' => 2, 'funcionario_nome' => 'Maria', 'funcionario_cargo' => 'Analista'],
];

// Variável de mensagem de sucesso ou erro
$message = "";

// Verificando se foi enviado o formulário de cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    // Aqui você deveria incluir o código de inserção do funcionário no banco de dados
    // Por exemplo:
    // $funcionario_cod = $_POST['funcionario_cod'];
    // $funcionario_nome = $_POST['funcionario_nome'];
    // $funcionario_cargo = $_POST['funcionario_cargo'];

    $message = "Funcionário cadastrado com sucesso!";
}

// Verificando se foi enviado o formulário de exclusão
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    // Aqui você deveria incluir o código para excluir o funcionário do banco de dados
    // Exemplo:
    // $usu_cod = $_POST['usu_cod'];
    
    $message = "Funcionário excluído com sucesso!";
}

// Verificando se foi enviado o formulário de edição
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    // Aqui você deve tratar a atualização dos dados do funcionário
    // Por exemplo:
    // $usu_cod = $_POST['usu_cod'];
    // $nome = $_POST['nome'];
    // $cargo = $_POST['cargo'];

    $message = "Funcionário editado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionários</title>
    <style>
        /* Resetando estilos padrões */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Fundo leve */
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        h2 {
            color: #FF6347; /* Vermelho tomate */
            text-align: center;
            margin-bottom: 20px;
        }

        .buttoninicial {
            display: inline-block;
            padding: 12px 20px;
            background-color: #FF4500; /* Laranja avermelhado */
            color: #fff;
            text-align: center;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .buttoninicial:hover {
            background-color: #FF6347; /* Laranja mais suave */
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #FFFF00; /* Amarelo */
            color: #333;
            border-radius: 5px;
            border: 1px solid #FFD700; /* Dourado */
        }

        form {
            display: flex;
            flex-direction: column;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        button {
            padding: 10px 15px;
            background-color: #32CD32; /* Verde limão */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #228B22; /* Verde floresta */
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1E90FF; /* Azul dodger */
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .actions button {
            padding: 6px 12px;
            background-color: #8A2BE2; /* Azul violeta */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            color: white;
            transition: background-color 0.3s;
        }

        .actions button:hover {
            background-color: #7A3E93; /* Roxo mais escuro */
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-content span.close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        /* Responsividade */
        @media (max-width: 600px) {
            form {
                width: 90%;
            }

            .buttoninicial {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<h2>Cadastro de Funcionários</h2>
<a href="index.html" class="buttoninicial">Tela inicial</a>

<?php if (!empty($message)): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST">
    <label for="funcionario_cod">Código:</label>
    <input type="number" id="funcionario_cod" name="funcionario_cod" required>

    <label for="funcionario_nome">Nome:</label>
    <input type="text" id="funcionario_nome" name="funcionario_nome" required>

    <label for="funcionario_cargo">Cargo:</label>
    <input type="text" id="funcionario_cargo" name="funcionario_cargo" required>

    <button type="submit" name="add_user">Cadastrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cargo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['funcionario_cod']) ?></td>
                <td><?= htmlspecialchars($usuario['funcionario_nome']) ?></td>
                <td><?= htmlspecialchars($usuario['funcionario_cargo']) ?></td>
                <td class="actions">
                    <button onclick="openModal(<?= htmlspecialchars($usuario['funcionario_cod']) ?>, '<?= htmlspecialchars($usuario['funcionario_nome']) ?>', '<?= htmlspecialchars($usuario['funcionario_cargo']) ?>')">Editar</button>

                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="usu_cod" value="<?= htmlspecialchars($usuario['funcionario_cod']) ?>">
                        <button type="submit" name="delete_user">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal para editar funcionário -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Editar Funcionário</h3>
        <form method="POST">
            <input type="hidden" id="usu_cod" name="usu_cod">
            <label for="edit_nome">Nome:</label>
            <input type="text" id="edit_nome" name="nome" required>

            <label for="edit_cargo">Cargo:</label>
            <input type="text" id="edit_cargo" name="cargo" required>

            <button type="submit" name="edit_user">Salvar Alterações</button>
        </form>
    </div>
</div>

<script>
// Funções para o modal
function openModal(cod, nome, cargo) {
    document.getElementById('usu_cod').value = cod;
    document.getElementById('edit_nome').value = nome;
    document.getElementById('edit_cargo').value = cargo;
    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Fechar o modal se o usuário clicar fora dele
window.onclick = function(event) {
    if (event.target == document.getElementById('editModal')) {
        closeModal();
    }
}
</script>

</body>
</html>

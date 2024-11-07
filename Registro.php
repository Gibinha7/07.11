<?php
include("conecta.php");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$message = ""; 

if (isset($_POST["add_registro"])) {
    $registro_cod = trim($_POST["registro_cod"]);
    $registro_data = trim($_POST["registro_data"]);
    $funcionario_cod = trim($_POST["funcionario_cod"]);
    $registro_hora = trim($_POST["registro_hora"]);

    if (!empty($registro_cod) && !empty($registro_data) && !empty($funcionario_cod) && !empty($registro_hora)) {
        $sql = "INSERT INTO registro (registro_cod, registro_data, funcionario_cod, registro_hora) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $registro_cod, $registro_data, $funcionario_cod, $registro_hora);

        if ($stmt->execute()) {
            $message = "Registro cadastrado com sucesso!";
        } else {
            $message = "Erro ao cadastrar o registro.";
        }
        $stmt->close();
    }
}

// Editar registro
if (isset($_POST["edit_registro"])) {
    $registro_cod = trim($_POST["registro_cod"]);
    $registro_data = trim($_POST["registro_data"]);
    $funcionario_cod = trim($_POST["funcionario_cod"]);
    $registro_hora = trim($_POST["registro_hora"]);

    if (!empty($registro_cod) && !empty($registro_data) && !empty($funcionario_cod) && !empty($registro_hora)) {
        $sql = "UPDATE registro SET registro_data = ?, funcionario_cod = ?, registro_hora = ? WHERE registro_cod = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $registro_data, $funcionario_cod, $registro_hora, $registro_cod);

        if ($stmt->execute()) {
            $message = "Registro editado com sucesso!";
        } else {
            $message = "Erro ao editar o registro.";
        }
        $stmt->close();
    }
}

// Excluir registro
if (isset($_POST["delete_registro"])) {
    $registro_cod = trim($_POST["registro_cod"]);

    if (!empty($registro_cod)) {
        $sql = "DELETE FROM registro WHERE registro_cod = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $registro_cod);

        if ($stmt->execute()) {
            $message = "Registro excluído com sucesso!";
        } else {
            $message = "Erro ao excluir o registro.";
        }
        $stmt->close();
    }
}

// Selecionar registros para exibição
$sql = "SELECT * FROM registro";
$usuarios = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <style>
        /* Resetando estilos padrões */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2E8B57; /* Verde forte */
            margin-bottom: 20px;
        }

        .buttoninicial {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FF6347; /* Tomate */
            color: #fff;
            text-align: center;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .buttoninicial:hover {
            background-color: #FF4500; /* Laranja escuro */
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #ffffe0; /* Amarelo claro */
            color: #333;
            border: 1px solid #FFD700; /* Dourado */
            border-radius: 5px;
            text-align: center;
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
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1E90FF; /* Azul Dodger */
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
            background-color: #7A3E93; /* Roxo escuro */
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

<h2>Cadastro de Registros</h2>
<a href="index.html" class="buttoninicial">Tela inicial</a>

<?php if (!empty($message)): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST">
    <label for="registro_cod">Código:</label>
    <input type="number" id="registro_cod" name="registro_cod" required>

    <label for="registro_data">Data:</label>
    <input type="date" id="registro_data" name="registro_data" required>

    <label for="funcionario_cod">Código Funcionário:</label>
    <input type="number" id="funcionario_cod" name="funcionario_cod" required>

    <label for="registro_hora">Horário:</label>
    <input type="time" id="registro_hora" name="registro_hora" required>

    <button type="submit" name="add_registro">Cadastrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Código Funcionário</th>
            <th>Horário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($usuario = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['registro_cod']) ?></td>
                <td><?= htmlspecialchars($usuario['registro_data']) ?></td>
                <td><?= htmlspecialchars($usuario['funcionario_cod']) ?></td>
                <td><?= htmlspecialchars($usuario['registro_hora']) ?></td>
                <td class="actions">
                    <button onclick="openModal(<?= htmlspecialchars($usuario['registro_cod']) ?>, '<?= htmlspecialchars($usuario['registro_data']) ?>', '<?= htmlspecialchars($usuario['funcionario_cod']) ?>', '<?= htmlspecialchars($usuario['registro_hora']) ?>')">Editar</button>

                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="registro_cod" value="<?= htmlspecialchars($usuario['registro_cod']) ?>">
                        <button type="submit" name="delete_registro">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div id="editModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Editar Registro</h3>
        <form method="POST">
            <input type="hidden" id="edit_registro_cod" name="registro_cod">
            <label for="edit_registro_data">Data:</label>
            <input type="date" id="edit_registro_data" name="registro_data" required>

            <label for="edit_funcionario_cod">Código Funcionário:</label>
            <input type="number" id="edit_funcionario_cod" name="funcionario_cod" required>

            <label for="edit_registro_hora">Horário:</label>
            <input type="time" id="edit_registro_hora" name="registro_hora" required>

            <button type="submit" name="edit_registro">Salvar Alterações</button>
        </form>
    </div>
</div>

<script>
function openModal(cod, data, funcionario_cod, hora) {
    document.getElementById('edit_registro_cod').value = cod;
    document.getElementById('edit_registro_data').value = data;
    document.getElementById('edit_funcionario_cod').value = funcionario_cod;
    document.getElementById('edit_registro_hora').value = hora;
    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == document.getElementById('editModal')) {
        closeModal();
    }
}
</script>

</body>
</html>

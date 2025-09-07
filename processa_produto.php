<?php
session_start();
include_once('config.php');

if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // Coleta e limpa os dados comuns para ambas as ações
    $nome = trim($_POST['nome'] ?? '');
    $especificacao = trim($_POST['especificacao'] ?? '');
    $quantidade_estoque = filter_var($_POST['quantidade_estoque'] ?? 0, FILTER_VALIDATE_INT);
    $quantidade_minima = filter_var($_POST['quantidade_minima'] ?? 5, FILTER_VALIDATE_INT);
    $valor_compra = str_replace(['.', ','], ['', '.'], $_POST['valor_compra'] ?? '0');
    $valor_venda = str_replace(['.', ','], ['', '.'], $_POST['valor_venda'] ?? '0');
    $categoria_id = !empty($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
    $fornecedor_id = !empty($_POST['fornecedor_id']) ? (int)$_POST['fornecedor_id'] : null;

    // Validação
    if (empty($nome) || $valor_venda <= 0) {
        $_SESSION['msg_erro'] = "O nome do produto e o valor de venda são obrigatórios.";
        header('Location: estoque.php');
        exit;
    }

    // --- LÓGICA PARA CADASTRAR UM NOVO PRODUTO ---
    if ($acao === 'cadastrar') {
        try {
            $sql = "INSERT INTO produtos (nome, especificacao, quantidade_estoque, quantidade_minima, valor_compra, valor_venda, categoria_id, fornecedor_id) VALUES (:nome, :especificacao, :quantidade_estoque, :quantidade_minima, :valor_compra, :valor_venda, :categoria_id, :fornecedor_id)";
            $stmt = $pdo->prepare($sql);
            // (Associação de parâmetros é a mesma para INSERT e UPDATE, então colocamos fora do if)

        } catch (PDOException $e) {
            $_SESSION['msg_erro'] = "Erro de banco de dados ao cadastrar: " . $e->getMessage();
            header('Location: estoque.php');
            exit;
        }
    } 
    // --- NOVA LÓGICA PARA EDITAR UM PRODUTO EXISTENTE ---
    elseif ($acao === 'editar') {
        $produto_id = filter_var($_POST['produto_id'] ?? null, FILTER_VALIDATE_INT);
        if (!$produto_id) {
            $_SESSION['msg_erro'] = "ID do produto inválido.";
            header('Location: estoque.php');
            exit;
        }
        try {
            $sql = "UPDATE produtos SET 
                        nome = :nome, 
                        especificacao = :especificacao, 
                        quantidade_estoque = :quantidade_estoque, 
                        quantidade_minima = :quantidade_minima, 
                        valor_compra = :valor_compra, 
                        valor_venda = :valor_venda, 
                        categoria_id = :categoria_id, 
                        fornecedor_id = :fornecedor_id 
                    WHERE id = :produto_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);

        } catch (PDOException $e) {
            $_SESSION['msg_erro'] = "Erro de banco de dados ao editar: " . $e->getMessage();
            header('Location: estoque.php');
            exit;
        }
    }

    // Parâmetros comuns para INSERT e UPDATE
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':especificacao', $especificacao, PDO::PARAM_STR);
    $stmt->bindParam(':quantidade_estoque', $quantidade_estoque, PDO::PARAM_INT);
    $stmt->bindParam(':quantidade_minima', $quantidade_minima, PDO::PARAM_INT);
    $stmt->bindParam(':valor_compra', $valor_compra);
    $stmt->bindParam(':valor_venda', $valor_venda);
    $stmt->bindParam(':categoria_id', $categoria_id, $categoria_id === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $stmt->bindParam(':fornecedor_id', $fornecedor_id, $fornecedor_id === null ? PDO::PARAM_NULL : PDO::PARAM_INT);

    // Executa e define a mensagem de sucesso
    if ($stmt->execute()) {
        $_SESSION['msg_sucesso'] = ($acao === 'cadastrar') ? "Produto cadastrado com sucesso!" : "Produto atualizado com sucesso!";
    } else {
        $_SESSION['msg_erro'] = ($acao === 'cadastrar') ? "Erro ao cadastrar o produto." : "Erro ao atualizar o produto.";
    }
}

header('Location: estoque.php');
exit;
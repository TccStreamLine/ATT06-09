<?php
session_start();
include_once('config.php');

// Segurança: Apenas usuários logados podem processar
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // Coleta e limpa os dados do formulário
    $razao_social = trim($_POST['razao_social'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    // Validação básica
    if (empty($razao_social) || empty($cnpj)) {
        $_SESSION['msg_erro'] = "Razão Social e CNPJ são obrigatórios.";
        header('Location: fornecedores.php');
        exit;
    }

    // --- LÓGICA DE CADASTRO ---
    if ($acao === 'cadastrar') {
        try {
            // Verifica se o CNPJ já existe
            $check_sql = "SELECT id FROM fornecedores WHERE cnpj = :cnpj";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->execute([':cnpj' => $cnpj]);
            if ($check_stmt->fetch()) {
                $_SESSION['msg_erro'] = "Este CNPJ já está cadastrado.";
            } else {
                // Se não existe, insere
                $sql = "INSERT INTO fornecedores (razao_social, cnpj, email, telefone) VALUES (:razao_social, :cnpj, :email, :telefone)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':razao_social' => $razao_social, ':cnpj' => $cnpj, ':email' => $email, ':telefone' => $telefone]);
                $_SESSION['msg_sucesso'] = "Fornecedor cadastrado com sucesso!";
            }
        } catch (PDOException $e) {
            $_SESSION['msg_erro'] = "Erro ao cadastrar fornecedor.";
        }
    } 
    // --- LÓGICA DE EDIÇÃO ---
    elseif ($acao === 'editar') {
        $id = filter_var($_POST['fornecedor_id'] ?? 0, FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['msg_erro'] = "ID do fornecedor inválido.";
        } else {
            try {
                // Verifica se outro fornecedor já usa o CNPJ que está sendo salvo
                $check_sql = "SELECT id FROM fornecedores WHERE cnpj = :cnpj AND id != :id";
                $check_stmt = $pdo->prepare($check_sql);
                $check_stmt->execute([':cnpj' => $cnpj, ':id' => $id]);
                if ($check_stmt->fetch()) {
                    $_SESSION['msg_erro'] = "Este CNPJ já pertence a outro fornecedor.";
                } else {
                    // Se estiver livre, atualiza
                    $sql = "UPDATE fornecedores SET razao_social = :razao_social, cnpj = :cnpj, email = :email, telefone = :telefone WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':razao_social' => $razao_social, ':cnpj' => $cnpj, ':email' => $email, ':telefone' => $telefone, ':id' => $id]);
                    $_SESSION['msg_sucesso'] = "Fornecedor atualizado com sucesso!";
                }
            } catch (PDOException $e) {
                $_SESSION['msg_erro'] = "Erro ao atualizar fornecedor.";
            }
        }
    }
}

// Redireciona de volta para a lista
header('Location: fornecedores.php');
exit;
?>
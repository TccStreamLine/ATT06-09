<?php
session_start();
include_once('config.php');

if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT * FROM categorias ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nome_empresa = $_SESSION['nome_empresa'] ?? 'Empresa';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categorias - Sistema de Gerenciamento</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/sistema.css">
    <link rel="stylesheet" href="css/estoque.css"> 
</head>

<body>
    <nav class="sidebar">
        <div class="sidebar-logo"><img class="logo" src="img/relplogo.png" alt="Relp! Logo" style="width: 100px;"></div>
        <div class="menu-section">
            <h6>MENU</h6>
            <ul class="menu-list">
                <li><a href="sistema.php"><i class="fas fa-home"></i> Início</a></li>
                <li><a href="estoque.php"><i class="fas fa-box"></i> Estoque</a></li>
                <li><a href="#"><i class="fas fa-calendar-alt"></i> Agenda</a></li>
                <li><a href="categorias.php" class="active"><i class="fas fa-tags"></i> Categorias</a></li>
                <li><a href="fornecedores.php"><i class="fas fa-truck"></i> Fornecimento</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Vendas</a></li>
                <li><a href="#"><i class="fas fa-cash-register"></i> Caixa</a></li>
                <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-file-invoice-dollar"></i> Nota Fiscal</a></li>
                <li><a href="#"><i class="fas fa-concierge-bell"></i> Serviços</a></li>
            </ul>
        </div>
        <div class="menu-section outros">
            <h6>OUTROS</h6>
            <ul class="menu-list">
                <li><a href="#"><i class="fas fa-store"></i> Loja de Planos</a></li>
                <li><a href="sair.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <header class="main-header">
            <h2>Gerenciamento de Categorias</h2>
            <div class="user-profile"><span><?= htmlspecialchars($nome_empresa) ?></span>
                <div class="avatar"><i class="fas fa-user"></i></div>
            </div>
        </header>

        <div class="message-container">
            <?php if (isset($_SESSION['msg_sucesso'])): ?><div class="alert alert-success"><?= $_SESSION['msg_sucesso'];
                                                                                            unset($_SESSION['msg_sucesso']); ?></div><?php endif; ?>
            <?php if (isset($_SESSION['msg_erro'])): ?><div class="alert alert-danger"><?= $_SESSION['msg_erro'];
                                                                                        unset($_SESSION['msg_erro']); ?></div><?php endif; ?>
        </div>

        <div class="actions-container">
            <div class="search-bar"><i class="fas fa-search"></i><input type="text" placeholder="Pesquisar Categoria..."></div>
            <a href="#" class="btn-primary" id="btnCadastrar"><i class="fas fa-plus"></i> Cadastrar Categoria</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categorias)): ?>
                        <tr>
                            <td colspan="3" class="text-center">Nenhuma categoria cadastrada.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?= htmlspecialchars($categoria['id']) ?></td>
                                <td><?= htmlspecialchars($categoria['nome']) ?></td>
                                <td class="actions">
                                    <a href="#" class="btn-action btn-edit" data-id="<?= $categoria['id'] ?>" data-nome="<?= htmlspecialchars($categoria['nome']) ?>"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="excluir_categoria.php?id=<?= $categoria['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Tem certeza?');"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="modal" class="modal-container">
        <div class="modal">
            <header class="modal-header">
                <h3 id="modalTitle">Cadastrar Categoria</h3><button class="close-btn" id="closeModalBtn">&times;</button>
            </header>
            <form action="processa_categoria.php" method="POST" class="modal-form">
                <input type="hidden" name="acao" id="formAcao" value="cadastrar">
                <input type="hidden" name="categoria_id" id="categoria_id">
                <div class="form-group"><label for="nome">Nome da Categoria*</label><input type="text" id="nome" name="nome" required></div>
                <footer class="modal-footer">
                    <button type="button" class="btn-secondary" id="cancelModalBtn">Cancelar</button>
                    <button type="submit" class="btn-primary">Salvar</button>
                </footer>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal');
        const openBtn = document.getElementById('btnCadastrar');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelModalBtn');

        const openModal = () => modal.style.display = 'flex';
        const closeModal = () => modal.style.display = 'none';

        openBtn.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('.modal-form').reset();
            document.getElementById('modalTitle').innerText = 'Cadastrar Categoria';
            document.getElementById('formAcao').value = 'cadastrar';
            openModal();
        });

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => e.target === modal ? closeModal() : null);

        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', e => {
                e.preventDefault();
                document.getElementById('modalTitle').innerText = 'Editar Categoria';
                document.getElementById('formAcao').value = 'editar';
                document.getElementById('categoria_id').value = button.dataset.id;
                document.getElementById('nome').value = button.dataset.nome;
                openModal();
            });
        });
    </script>
</body>

</html>
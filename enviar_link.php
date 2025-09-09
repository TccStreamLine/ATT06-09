<?php
// Inicia a sessão para podermos usar $_SESSION para mensagens de feedback.
session_start();

// Inclui os arquivos necessários.
require 'config.php'; // Sua conexão PDO com o banco.
require './phpmailer/src/Exception.php';
require './phpmailer/src/SMTP.php';
require './phpmailer/src/PHPMailer.php';

// Usa as classes do PHPMailer.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verifica se o formulário foi enviado (se a requisição é do tipo POST).
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Limpa e pega o e-mail do formulário.
    $email = trim($_POST["email"]);

    // Prepara a consulta para verificar se o e-mail existe na tabela 'usuarios'.
    $stmt = $pdo->prepare("SELECT id, email FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se um usuário com esse e-mail foi encontrado...
    if ($usuario) {
        // Gera um token de segurança aleatório e único.
        $token = bin2hex(random_bytes(50));

        // Define a data de expiração para 1 hora a partir de agora.
        $expira = date("Y-m-d H:i:s", time() + 3600); // 3600 segundos = 1 hora

        // ===================================================================
        // PASSO CRUCIAL: Salva o token e a data de expiração no banco de dados.
        // É isso que permite ao 'resetar_senha.php' validar o link.
        // ===================================================================
        $stmt_update = $pdo->prepare("UPDATE usuarios SET reset_token = ?, reset_token_expire = ? WHERE id = ?");
        $stmt_update->execute([$token, $expira, $usuario["id"]]);

        // Inicia o processo de envio de e-mail.
        $mail = new PHPMailer(true);
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2; // Adicione esta linha para ativar o log

        try {
            // Novas Configurações (Brevo)
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';
            $mail->SMTPAuth = true;
            $mail->Username = '9691c1001@smtp-brevo.com'; // O seu login Brevo
            $mail->Password = 'g3BDXcCKG8zWtZRL'; // A sua senha/chave SMTP Brevo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // Define o remetente (pode ser um e-mail de suporte)
            $mail->setFrom('tccstreamline@gmail.com', 'Streamline - Recuperação de Senha');

            // Define o remetente e o destinatário.
            $mail->setFrom('tccstreamline@gmail.com', 'Sistema de Login');
            $mail->addAddress($usuario['email']); // Usa o e-mail vindo do banco.

            // Conteúdo do e-mail.
            $mail->isHTML(true);
            $mail->Subject = 'Redefinicao de Senha';

            // ===================================================================
            // ATENÇÃO: Verifique se este caminho está correto para o seu projeto!
            // Se seus arquivos estão em uma pasta como 'htdocs/meu_projeto/',
            // o link deve ser "http://localhost/meu_projeto/resetar_senha.php...".
            // ===================================================================
            $link = "http://localhost/ESQUECEUSENHA_LOGIN/resetar_senha.php?token=" . $token;

            // Corpo do e-mail em HTML.
            $mail->Body = "
                <h2>Você solicitou uma redefinição de senha?</h2>
                <p>Recebemos uma solicitação para redefinir a senha da sua conta. Se foi você, clique no link abaixo para criar uma nova senha:</p>
                <p>
                    <a href='$link' style='background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>
                        Redefinir Minha Senha
                    </a>
                </p>
                <p>Este link de redefinição de senha expirará em 1 hora.</p>
                <p>Se você não solicitou uma redefinição de senha, nenhuma ação é necessária.</p>
            ";

            // Envia o e-mail.
            $mail->send();

            // Define uma mensagem de sucesso para o usuário.
            $_SESSION['msg_recuperar'] = "Sucesso! Um link de redefinição foi enviado para o seu e-mail.";

        } catch (Exception $e) {
            // Em caso de erro no envio, define uma mensagem de erro.
            $_SESSION['msg_recuperar'] = "Erro: O e-mail não pôde ser enviado. Tente novamente. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Se o e-mail não for encontrado no banco, informa o usuário.
        // Damos uma mensagem genérica para não confirmar se um e-mail existe ou não (prática de segurança).
        $_SESSION['msg_recuperar'] = "Se o e-mail fornecido estiver em nosso sistema, um link de recuperação será enviado.";
    }

    // Redireciona o usuário de volta para a página de recuperação de senha, onde a mensagem de feedback será exibida.
    header("Location: recuperar_senha.php");
    exit; // Termina o script para garantir que o redirecionamento ocorra.
}
?>
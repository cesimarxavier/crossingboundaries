<?php

/**
 * ========================================================================
 * CORE SECURITY: HARDENING DO WORDPRESS
 * Bloqueios de API, Cabeçalhos de Segurança e Prevenção de Vazamentos
 * ========================================================================
 * bloqueio dos seguintes pontos de segurança
 * - Enumeradores de utilizadores (Scrapers).
 * - Ataques de força bruta via XML-RPC.
 * - Injeção de código via painel (File Edit).
 * - Clickjacking e roubo de sessão via XSS (Security Headers).
 * 
 */
class ModularPress_Security
{
    public function __construct()
    {
        // 1. Remover a versão do WordPress (Evita ataques direcionados a versões antigas)
        add_filter('the_generator', '__return_empty_string');
        remove_action('wp_head', 'wp_generator');

        // 2. Desativar o XML-RPC (Bloqueia ataques de força bruta e DDoS)
        add_filter('xmlrpc_enabled', '__return_false');

        // 3. Bloquear o vazamento de nomes de utilizador (User Enumeration) via /?author=1
        add_action('template_redirect', [$this, 'block_user_enumeration']);

        // 4. Injetar Cabeçalhos de Segurança HTTP (Security Headers)
        add_action('send_headers', [$this, 'add_security_headers']);

        // 5. Ocultar erros de Login genéricos
        add_filter('login_errors', [$this, 'obscure_login_errors']);

        // 6. Bloqueio do REST API para Utilizadores Anónimos
        add_filter('rest_authentication_errors', [$this, 'restrict_rest_api']);
    }

    /**
     * Se um bot tentar descobrir os utilizadores acessando /?author=1, redireciona para a Home.
     */
    public function block_user_enumeration()
    {
        if (is_author() || (isset($_GET['author']) && preg_match('/^\d+$/', $_GET['author']))) {
            wp_redirect(home_url(), 301);
            exit;
        }
    }

    /**
     * Adiciona cabeçalhos de segurança para proteger contra XSS e Clickjacking.
     */
    public function add_security_headers()
    {
        if (!is_admin()) {
            // Impede que o site seja aberto dentro de um iframe em outro domínio (Clickjacking)
            header('X-Frame-Options: SAMEORIGIN');
            // Força o navegador a respeitar o MIME type (XSS)
            header('X-Content-Type-Options: nosniff');
            // Ativa a proteção XSS nativa dos navegadores
            header('X-XSS-Protection: 1; mode=block');
            // Garante que o site só seja acedido via HTTPS (HSTS)
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }

    /**
     * Remove o aviso "A senha está incorreta para o utilizador X" (que confirma que o utilizador existe).
     */
    public function obscure_login_errors()
    {
        return '<strong>Erro:</strong> As credenciais fornecidas são inválidas.';
    }

    public function restrict_rest_api($result)
    {
        if (!empty($result)) return $result;
        if (!is_user_logged_in()) {
            return new WP_Error('rest_not_logged_in', 'Acesso à API restrito apenas a utilizadores autenticados.', ['status' => 401]);
        }
        return $result;
    }
}

new ModularPress_Security();

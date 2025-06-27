<?php
class Token
{
    private string $sessionKey = "security";
    public function gerarToken(int $id)
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        $token = bin2hex(random_bytes(32));
        $_SESSION[$this->sessionKey][$token] = $id;
        return $token;
    }
    public function verificarToken(string $token)
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        if (!isset($_SESSION[$this->sessionKey][$token]))
        {
            return false;
        }
        $id = $_SESSION[$this->sessionKey][$token];
        unset($_SESSION[$this->sessionKey][$token]);
        return $id;
    }
    public function limparTokens()
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        unset($_SESSION[$this->sessionKey]);
    }
}
?>
<?php

/*
 * Classe utilizada para conexão ao libVirt
 * @author Antonio Carlos (acdiasjunior@gmail.com)
 * @copyright GPL
 * @version 1.0 (15/08/2012)
 */

namespace LibvirtAdmin;

class Libvirt
{
    /*
     * Classe utilizada para conexão ao libvirt
     * @author Antonio Carlos (acdiasjunior@gmail.com)
     * @copyright GPL
     * @version 1.0 (15/08/2012)
     */

    /*
     * Declaração das variáveis (propriedades) da classe
     */

    private $_uri = "qemu:///system"; // Caminhao para conexao libvirt
    private $_conn; // Resource de conexao libvirt

    /*
     * Função para conexão ao libvirt
     * @author Junior Dias (acdiasjunior@gmail.com)
     * @return Boolean Retorna true (conectado) ou false (nao conectado)
     */

    private function connect()
    {
        $debug = false;

        $logfile = LIBVIRT_DIR . '/libvirt.log';

        if ($debug == true && !libvirt_logfile_set($logfile)) {
            throw new \Exception('Erro ao abrir arquivo de log!');
        }

        $this->_conn = libvirt_connect($this->_uri, false);
        if (!$this->isConnected()) {
            throw new \Exception("Erro ao conectar: " . libvirt_get_last_error());
        }
    }

    private function isConnected()
    {
        return is_resource($this->_conn);
    }

    public function getConnection()
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        if ($this->isConnected()) {
            return $this->_conn;
        }

        throw new \Exception('Sem conexão ao libvirt');
    }

}

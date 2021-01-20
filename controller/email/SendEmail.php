<?php
require '../../models/RecordatorioServicio.php';

class SendEmail
{

    private $email_destino;
    private $asunto;
    private $web;

    /**
     * SendEmail constructor.
     */
    public function __construct()
    {
    }

    function enviarRecordatoriosPagos()
    {
        $recordatorio = new RecordatorioServicio();
        $a_pendientes = $recordatorio->verPendientes();
        $contar = 0;
        foreach ($a_pendientes as $fila) {
            $contar++;
        }
        if ($contar > 0) {
            $this->asunto = "RECORDATORIO DE PAGOS DE SERVICIO";
            $this->email_destino = "majumf04@gmail.com"; //majumf04@gmail.com
            $this->web = 'http://lunasystemsperu.com/clientes/ssoma/controller/email/email_recordatorio.php';
            $this->enviarEmail();
        }
    }

    private function enviarEmail()
    {
        $email_from = "info@lunasystemsperu.com";
        $email_to = $this->email_destino;
        $email_subject = $this->asunto;

        // Cabecera que especifica que es un HMTL
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Cabeceras adicionales
        //$headers .= 'From: Atencion al Usuario -  <ventas@conmetal.pe>' . "\r\n";
        //$headers .= 'Cc: archivotarifas@example.com' . "\r\n";
        //$headers .= 'Bcc: copiaoculta@example.com' . "\r\n";
        $headers .= 'From: Atencion al Usuario - LSP <info@lunasystemsperu.com>' . "\r\n" .
            'Reply-To: ' . $email_from . "\r\n" .
            'Cc: leog.1992@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();


        $email_message = file_get_contents($this->web);
        @mail($email_to, $email_subject, $email_message, $headers);
        echo "email enviado a " . $email_to . " por " . $email_subject;
    }

    function enviarRecordatoriosCobros()
    {
        $this->asunto = "RESUMEN DE CUENTAS POR COBRAR";
        $this->email_destino = "jorgevilca@gmail.com, majumf04@gmail.com"; //jorgevilca@gmail.com
        $this->web = 'http://lunasystemsperu.com/clientes/ssoma/controller/email/email_resumen_cobros.php';
        $this->enviarEmail();
    }
}
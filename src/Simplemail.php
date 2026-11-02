<?php

/**
 * Simplemail.php
 * @Auteur : Christophe Dufour
 * 
 * Simplifie l'utilisation et l'envoie d'un mail avec PHPMailer
 */

namespace Blackfox\Simplemail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use ValueError;

class Simplemail{
    
	// Instance de PHPMailer
	protected static PHPMailer|null $mail = null;

    /**
     * Initialise un objet PHPMailer et le retourne
     * 
     * @param string $smtpHost
     * Nom suserveur smtp
     * @param string $smtpUser
     * Nom d'utilisateur pour le serveur smtp
     * @param string $smtpPassword
     * Mot de passe de l'utilisateur
     * @param bool $exceptions
     * True pour activer les exceptions
     * @param bool $debug
     * True pour afficher debug stmp
     * @return PHPMailer
     */
    public static function get(string $smtpHost, string $smtpUser, string $smtpPassword, bool $exceptions = false, bool $debug = false): PHPMailer
    {
        if(empty($smtpHost) || empty($smtpUser) || empty($smtpPassword)) {
			throw new ValueError("Les arguments ne peuvent pas être des chaines de caractères vide !");
		}

        if(is_null(self::$mail)) {
            self::$mail = new PHPMailer($exceptions);

            // Server settings
            if($debug) {
                self::$mail->SMTPDebug = SMTP::DEBUG_SERVER;			// Enable verbose debug output
            }

            self::$mail->IsSMTP();									    // Set mailer to use SMTP
            self::$mail->Host = $smtpHost;							    // Adresse IP ou DNS du serveur SMTP
            self::$mail->SMTPAuth = true;								// Utiliser l'identification
            self::$mail->Username = $smtpUser;						    // Adresse email à utiliser
            self::$mail->Password = $smtpPassword;					    // Mot de passe de l'adresse email à utiliser
            //self::$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;	// Enable implicit TLS encryption
            self::$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;	// Enable implicit TLS encryption
            //self::$mail->SMTPSecure = 'tls';						    // Enable implicit TLS encryption
            self::$mail->Port = 587;									// Port TCP du serveur SMTP
            self::$mail->CharSet = PHPMailer::CHARSET_UTF8;			    // Format d'encodage à utiliser pour les caractères
        }

        return self::$mail;
    }
}

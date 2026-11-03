<?php

/**
 * Simplemail.php
 * @Auteur : Christophe Dufour
 * 
 * Initialise l'envoi d'un message avec PHPMailer
 */

namespace Blackfox\Simplemail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Simplemail{
	// Instance de PHPMailer
	protected static PHPMailer|null $mail = null;

    /**
     * Initialise un objet PHPMailer et le retourne
     * 
     * @param string $Host
     * Nom du serveur
     * @param string $Username
     * Nom d'utilisateur pour la connexion au serveur
     * @param string $Password
     * Mot de passe de l'utilisateur
     * @param bool $exceptions
     * True pour activer les exceptions
     * @param bool $SMTPDebug
     * True pour afficher debug stmp
     * @return PHPMailer
     */
    public static function getMailer(string $Host, string $Username, string $Password, bool $exceptions = false, bool $SMTPDebug = false): PHPMailer
    {
        if(empty($Host) || empty($Username) || empty($Password)) {
			throw new \ValueError("Les arguments ne peuvent pas être des chaines de caractères vide !");
		}

        if(is_null(self::$mail)) {
            self::$mail = new PHPMailer($exceptions);

            // Server settings
            if($SMTPDebug) {
                self::$mail->SMTPDebug = SMTP::DEBUG_SERVER;			// Enable verbose debug output
            }

            self::$mail->IsSMTP();									    // Set mailer to use SMTP
            self::$mail->Host = $Host;							        // Adresse IP ou DNS du serveur SMTP
            self::$mail->SMTPAuth = true;								// Utiliser l'identification
            self::$mail->Username = $Username;						    // Adresse email à utiliser
            self::$mail->Password = $Password;					        // Mot de passe de l'adresse email à utiliser
            //self::$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;	// Enable implicit TLS encryption
            self::$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;	// Enable implicit TLS encryption
            //self::$mail->SMTPSecure = 'tls';						    // Enable implicit TLS encryption
            self::$mail->Port = 587;									// Port TCP du serveur SMTP
            self::$mail->CharSet = PHPMailer::CHARSET_UTF8;			    // Format d'encodage à utiliser pour les caractères
        }

        return self::$mail;
    }
}

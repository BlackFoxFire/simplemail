<?php

/*
*
* Simplemail.php
* @Auteur : Christophe Dufour
*
* Simplifie l'utilisation et l'envoie d'un mail avec PHPMailer
*
*/

namespace Simplemail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SimpleMail
{
	/*
		Les constantes
		--------------
	*/

	// A modifier suivant votre configuration
	const SMTP_HOST = "votre_serveur_smtp";
	const SMTP_USER = "nom_utilisateur_serveur_smtp";	
	const SMTP_PASSWORD = "mot_de_passe_du_serveur_smtp";

	/*
		Les attributs
		-------------
	*/

	// L'instance de PHPMailer
	protected PHPMailer $mail;

	/*
		Constructeur
		------------
	*/
	
	public function __construct(bool $debug = false)
	{
		$this->mail = new PHPMailer($debug);		// Passer true pour afficher les erreurs d'envoi
	}

	/*
		Les méthodes
		------------
	*/

	// Définit l'expéditeur du message
	public function setForm(string $from, string $name = ''): void
	{
		$this->mail->setFrom($from, $name);
	}

	// Ajout un destinateur
	public function addAddress(string $to, string $name = ''): void
	{
		$this->mail->addAddress($to, $name);
	}

	// Définit une addresse de réponce
	public function addReplyTo(string $to, string $name = ''): void
	{
		$this->mail->addReplyTo($to, $name);
	}

	// Définit une addresse de réponce
	public function addCC(string $to, string $name = ''): void
	{
		$this->mail->addCC($to, $name);
	}

	// Définit une addresse de réponce
	public function addBCC(string $to, string $name = ''): void
	{
		$this->mail->addBCC($to, $name);
	}

	// Ajoute une pièce jointe
	public function addAttachment(string $file, string $name = ''): void
	{
		$this->mail->addAttachment($file, $name);
	}

	// Envoi l'email
	public function send(string $subject = '', string $content = '', string $altBody = ''): void
	{
		try {
			// Server settings
			// $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;					// Enable verbose debug output
			$this->mail->IsSMTP();											// Set mailer to use SMTP
			$this->mail->Host = self::SMTP_HOST;							// Adresse IP ou DNS du serveur SMTP
			$this->mail->SMTPAuth = true;									// Utiliser l'identification
			$this->mail->Username = self::SMTP_USER;						// Adresse email à utiliser
			$this->mail->Password = self::SMTP_PASSWORD;					// Mot de passe de l'adresse email à utiliser
			// $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;		// Enable implicit TLS encryption
			$this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;		// Enable implicit TLS encryption
			// $this->mail->SMTPSecure = 'tls';								// Enable implicit TLS encryption
			$this->mail->Port = 587;										// Port TCP du serveur SMTP
			$this->mail->CharSet = PHPMailer::CHARSET_UTF8;					// Format d'encodage à utiliser pour les caractères
			
			// Contenu du message
			$this->mail->isHTML(true);										// Format HTML
			$this->mail->Subject = $subject;								// Le sujet
			$this->mail->Body = $content;									// Le message
			$this->mail->AltBody = $altBody;								// Le message en text plein

			// Envoi ...
			$this->mail->send();

		} catch (Exception $e) {
			throw new \RuntimeException("Message could not be sent. Mailer Error: {" . $this->mail->ErrorInfo . "}");
		}
	}
}

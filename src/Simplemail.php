<?php

/*
*
* Simplemail.php
* @Auteur : Christophe Dufour
*
* Simplifie l'utilisation et l'envoie d'un mail avec PHPMailer
*
*/

namespace Blackfox\Simplemail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Simplemail
{
	/*
		Les attributs
		-------------
	*/

	// Serveur SMTP distant
	private string $smtpHost;
	// Nom d'utilisateur du serveur SMTP
	private string $smtpUser;
	// Mot de passe de l'utilisateur
	private string $smtpPassword;
	// L'instance de PHPMailer
	private PHPMailer $mail;

	/*
		Constructeur
		------------
	*/
	public function __construct(string $smtpHost, string $smtpUser, string $smtpPassword, bool $debug = false)
	{
		if(!empty($smtpHost) && !empty($smtpUser) && !empty($smtpPassword)) {
			$this->smtpHost = $smtpHost;
			$this->smtpUser = $smtpUser;
			$this->smtpPassword = $smtpPassword;
		}
		else {
			throw new \InvalidArgumentException("Les arguments ne peuvent pas être des chaines de caractères vide !");
		}

		$this->mail = new PHPMailer($debug); // Passer true pour afficher les erreurs d'envoi
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
			$this->mail->Host = $this->smtpHost;							// Adresse IP ou DNS du serveur SMTP
			$this->mail->SMTPAuth = true;									// Utiliser l'identification
			$this->mail->Username = $this->smtpUser;						// Adresse email à utiliser
			$this->mail->Password = $this->smtpPassword;					// Mot de passe de l'adresse email à utiliser
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {
	
	public function wyslij($data) {
		$config = array(
            'mailtype' => 'html',
            'protocol' => 'smtp',
            'charset' => 'utf-8',
            'priority' => 1,
            'smtp_crypto' => 'ssl',
            'smtp_host' => 'ipay24.pl',
            'smtp_port' => 465,
            'smtp_user' => 'wnioski@ipay24.pl',
            'smtp_pass' => '!01Wnioski123!'
		);
		$this->load->library('email',$config);
		$image = assets('gfx/email/iplatnosci.png');
        $all = assets('gfx/email/all.jpg');
		$this->email->attach($image, 'inline');
		$finansowa = assets('gfx/email/finansowa.png');
		//$this->email->attach($finansowa, 'inline');
		$ratalna = assets('gfx/email/ratalna.png');
		//$this->email->attach($ratalna, 'inline');
		if($data['dokument']) { $this->email->attach($data['dokument']); }
		$body .= '
			<html>
			<body>
			<div style="width:600px;height:auto;margin:0 auto 30px;display:block;font-family:Arial;border-bottom:1px solid #dbdbdb;font-size:13px;padding-bottom:30px;">
			<div style="width:100%;text-align:right;">
				<img style="margin:20px auto;max-width:130px;" src="' . $image . '" border="0">
				<br />
				<img src="'.$all.'" style="max-width:130px;height:auto;margin:0 auto;">
			</div>
				<h1 style="font-size:18px;">'.$data['temat'].'</h1>
				'.$data['tresc'].'
			</div>
			<div style="width:600px;height:auto;margin:0 auto;display:block;font-family:Arial;border-bottom:1px solid #dbdbdb;font-size:13px;padding-bottom:30px;">
			<div class="moz-signature">
			  <table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				  <tr>
					<td>
					  <table width="466" height="82" cellspacing="0" cellpadding="0"
						border="0">
						<tbody>
						  <tr>
							<td style="border-right: 1px solid #e5e5e5;
							  padding-right: 10px; padding-top: 10px;
							  padding-bottom: 10px; padding-right:20px;"><a
								href="https://iplatnosci.pl"><img
								  src="https://iplatnosci.pl/stopka/logoi.jpg"
								  moz-do-not-send="false" alt="" width="125"
								  height="60" border="0"></a></td>
							<td style="padding-left: 20px; padding-top: 10px;
							  padding-bottom: 10px;"><img
								src="https://iplatnosci.pl/stopka/marki.jpg"
								style="display: block;" moz-do-not-send="false"
								alt="" width="180" height="25"></td>
						  </tr>
						</tbody>
					  </table>
					</td>
				  </tr>
				  <!----> <tr>
					<td style="font-family: Arial, Helvetica, sans-serif; font-size:
					  11px; color: #a3a3a3; max-width: 468px; line-height:15px;
					  text-align: justify; padding-top:20px;"> Platforma sp. z o.o.<br>
					  NIP: 8513147669, KRS: 0000386890, REGON: 321004179 </td>
				  </tr>
				  <tr>
					<td style="font-family: Arial, Helvetica, sans-serif; font-size:
					  11px; color: #a3a3a3; max-width: 468px; line-height:15px;
					  text-align: justify; padding-top:20px;">Niniejsza wiadomość
					  zawiera informacje poufne oraz / lub prawnie chronione,
					  przeznaczone do wyłącznego użytku adresata. Jeśli nie są
					  Państwo adresatem przesyłki lub jeżeli otrzymaliście Państwo
					  ten dokument omyłkowo, prosimy o bezzwłoczne skontaktowanie
					  się z nadawcą i usunięcie otrzymanej wiadomości. </td>
				  </tr>
				</tbody>
			  </table>
			</div>
			</div>
			</body>
			</html>
		';
        $this->email->from('wnioski@ipay24.pl', 'iPay24.pl');
		$this->email->to($data['email']);
		$this->email->bcc(['archiwum@iplatnosci.pl']);
		$this->email->subject($data['temat']);
		$this->email->message($body);
		if($this->email->send()) { $this->email->clear(TRUE); return true; } else { return false; }
	}
	
	public function kontakt($data) {
		$body = '
		<p><strong>Imię i nazwisko/nazwa firmy:</strong> '.$data['nazwisko'].'</p>
		<p><strong>Adres e-mail:</strong> '.$data['email'].'</p>
		<p><strong>Telefon:</strong> '.$data['telefon'].'</p>
		<p><strong>Wiadomość:</strong><br>'.$data['wiadomosc'].'</p>
		';
		return $body;
	}
	
	public function wniosek_uslugowy($data) {
		$body = '
		<p><strong>Dzień dobry.</strong></p>
		<p>Poniżej przesyłamy dedykowany link do finalizacji Państwa wniosku.</p>
		<p style="padding:10px;color:#fff;font-size:16px;background-color:#db2200;"><a style="color:#FFF;" href="' . site_url('wniosek/finalizacja/' . $data['wniosek'].'/'.$data['pfwniosek'].'/'.$data['pfsklep']) . '">Finalizuj wniosek</a></p>
		<p>Po wypełnieniu formularza, decyzja w zakresie finansowania pojawi się w kilka chwil na ekranie urządzenia.</p>
		';
		return $body;
	}
	
}
?>

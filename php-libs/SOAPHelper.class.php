<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.0
 */
 
class SOAPHelper 
{
	private $SOAPClient;
	
	public function __construct($soapUsername, $soapPassword, $soapHost, $soapPort )
	{
		$this->SOAPClient = new SoapClient(NULL, array(
			'location' => "http://$soapHost:$soapPort/",
			'uri'      => 'urn:TC',
			'style'    => SOAP_RPC,
			'login'    => $soapUsername,
			'password' => $soapPassword,
			'trace'    => 1
		));
	}
	
	public function command($command)
	{
		try {
			$result = $this->SOAPClient->executeCommand(new SoapParam($command, 'command'));
			return $result;
		}
		catch (SoapFault $soapFault) {
			echo '<pre>'; var_dump($soapFault); echo '</pre>';
			echo "<pre>Request :<br>", htmlentities($this->SOAPClient->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($this->SOAPClient->__getLastResponse()), "<br></pre>";
		}
		return false;
	}
}

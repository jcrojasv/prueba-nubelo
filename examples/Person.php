<?php

/**
 * Clase que define el objeto Person.
 *
 * @author jcrojas
 * @descripcion: 
 */
class Person 
{
	
	public $document;
	public $documentType;
	public $firstName;
	public $lastName;
	public $company;
	public $emailAddress;
	public $address;
	public $city;
	public $province;
	public $country;
	public $phone;
	public $mobile;


	function __construct($arrayDatos)
	{
		//Esto es solo para ejemplo;
		$this->document      = $arrayDatos['document'];
		$this->documentType  = $arrayDatos['documentType'];
		$this->firstName     = $arrayDatos['firtsName'];
		$this->lastName      = $arrayDatos['lastName'];
		$this->emailAddress  = $arrayDatos['emailAddress'];
		$this->address       = $arrayDatos['address'];
		$this->city          = $arrayDatos['city'];
		$this->province      = $arrayDatos['province'];
		$this->country       = $arrayDatos['country']; 
		$this->phone         = $arrayDatos['phone'];
		$this->mobile        = $arrayDatos['mobile']; 
	}
        
        function getDocument() {
            return $this->document;
        }

        function getDocumentType() {
            return $this->documentType;
        }

        function getFirstName() {
            return $this->firstName;
        }

        function getLastName() {
            return $this->lastName;
        }

        function getCompany() {
            return $this->company;
        }

        function getEmailAddress() {
            return $this->emailAddress;
        }

        function getAddress() {
            return $this->address;
        }

        function getCity() {
            return $this->city;
        }

        function getProvince() {
            return $this->province;
        }

        function getCountry() {
            return $this->country;
        }

        function getPhone() {
            return $this->phone;
        }

        function getMobile() {
            return $this->mobile;
        }

}
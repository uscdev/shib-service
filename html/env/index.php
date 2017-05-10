<?php
// +--------------------------------------------------------
// | Check header variables
// +--------------------------------------------------------
// | K.U.Leuven - Nov 2007
// +--------------------------------------------------------
// | With this page users can check if all the required
// | or optional attributes are present. If an attribute is
// | required you can also check its value.
// | This script is made in a Shibboleth context.
// +--------------------------------------------------------
// | versie 2.0
// +--------------------------------------------------------
// | History:
// |  20130524: Added new attribute KULAssocMigrateID
// |  20130429: Added new attributes
// |  20100518: Added Environment variables support
// |  20080103: Added URN names for attributes 
// |  20071109: start of file
// +--------------------------------------------------------
// | Philip Brusten <philip.brusten@icts.kuleuven.be>
// +--------------------------------------------------------

define ("NONEED", "Not needed");
define ("OPTIONAL", "Optional");
define ("REQUIRED", "Required");

####START CONFIGURATION####

//Fill in the name of the application
$name = 'Test Service Provider';
//List of attributes that will be checked.
$header_attributes = array (
		#Name of the server header			=> array (NONEED|OPTIONAL|REQUIRED, "value or regex"),
		"HTTP_SHIB_IDENTITY_PROVIDER"		=> array (REQUIRED,""),
		"HTTP_SHIB_AUTHENTICATION_METHOD"	=> array (REQUIRED,""),
		"HTTP_SHIB_AUTHENTICATION_INSTANT"	=> array (REQUIRED,""),
		"HTTP_SHIB_AUTHNCONTEXT_CLASS"		=> array (REQUIRED,""),
		"HTTP_EPPN"							=> array (REQUIRED,""),
		"HTTP_AFFILIATION"					=> array (NONEED,""),
		"HTTP_UNSCOPED_AFFILIATION"			=> array (NONEED,""),
		"HTTP_ENTITLEMENT"					=> array (NONEED,""),
		"HTTP_PERSISTENT_ID"				=> array (NONEED,""),
		"HTTP_PRIMARY_AFFILIATION"			=> array (NONEED,""),
		"HTTP_NICKNAME"						=> array (NONEED,""),
		"HTTP_PRIMARY_ORGUNIT_DN"			=> array (NONEED,""),
		"HTTP_ORGUNIT_DN"					=> array (NONEED,""),
		"HTTP_ORG_DN"						=> array (NONEED,""),
		"HTTP_CN"							=> array (NONEED,""),
		"HTTP_SN"							=> array (NONEED,""),
		"HTTP_GIVENNAME"					=> array (NONEED,""),
		"HTTP_KULOFFICIALGIVENNAME"					=> array (NONEED,""),
		"HTTP_MAIL"							=> array (NONEED,""),
		"HTTP_UID"							=> array (NONEED,""),
		"HTTP_TELEPHONENUMBER"				=> array (NONEED,""),
		"HTTP_TITLE"						=> array (NONEED,""),
		"HTTP_INITIALS"						=> array (NONEED,""),
		"HTTP_DESCRIPTION"					=> array (NONEED,""),
		"HTTP_CARLICENSE"					=> array (NONEED,""),
		"HTTP_DEPARTMENTNUMBER"				=> array (NONEED,""),
		"HTTP_DISPLAYNAME"					=> array (NONEED,""),
		"HTTP_EMPLOYEENUMBER"				=> array (NONEED,""),
		"HTTP_EMPLOYEETYPE"					=> array (NONEED,""),
		"HTTP_PREFERREDLANGUAGE"			=> array (NONEED,""),
		"HTTP_MANAGER"						=> array (NONEED,""),
		"HTTP_SEEALSO"						=> array (NONEED,""),
		"HTTP_FACSIMILETELEPHONENUMBER"		=> array (NONEED,""),
		"HTTP_POSTALADDRESS"				=> array (NONEED,""),
		"HTTP_STREET"						=> array (NONEED,""),
		"HTTP_POSTOFFICEBOX"				=> array (NONEED,""),
		"HTTP_POSTALCODE"					=> array (NONEED,""),
		"HTTP_ST"							=> array (NONEED,""),
		"HTTP_L"							=> array (NONEED,""),
		"HTTP_O"							=> array (NONEED,""),
		"HTTP_OU"							=> array (NONEED,""),
		"HTTP_BUSINESSCATEGORY"				=> array (NONEED,""),
		"HTTP_PHYSICALDELIVERYOFFICENAME"	=> array (NONEED,""),
		"HTTP_ROOMNUMBER"					=> array (NONEED,""),
		"HTTP_KULLUDITSERVER"				=> array (NONEED,""),
		"HTTP_KULPRIMOUNUMBER"				=> array (NONEED,""),
		"HTTP_KULOUNUMBER"					=> array (NONEED,""),
		"HTTP_KULEMPLOYEETYPE"				=> array (NONEED,""),
		"HTTP_KULDIPL"						=> array (NONEED,""),
		"HTTP_KULOPL"						=> array (NONEED,""),
		"HTTP_KULSTAMNR"					=> array (NONEED,""),
		"HTTP_KULID"						=> array (NONEED,""),
		"HTTP_KULLIBISNR"					=> array (NONEED,""),
		"HTTP_KULSTUDENTTYPE"				=> array (NONEED,""),
		"HTTP_KULCAMPUS"					=> array (NONEED,""),
		"HTTP_USERAPPUSERID"				=> array (NONEED,""),
		"HTTP_SYNCORELOGONCODE"				=> array (NONEED,""),
		"HTTP_KULMOREUNIFIEDUID"			=> array (NONEED,""),
		"HTTP_KULCARDAPPLICATIONID"			=> array (NONEED,""),
		"HTTP_KULCARDSN"					=> array (NONEED,""),
		"HTTP_KULPREFERREDMAIL"				=> array (NONEED,""),
		"HTTP_KULMAINLOCATION"				=> array (NONEED,""),
		"HTTP_KULASSOCUCCTAG"				=> array (NONEED,""),
		"HTTP_LOGOUTURL"					=> array (NONEED,""),
		"HTTP_UIDTOLEDO"					=> array (NONEED,""),
		"HTTP_HOMEORGANIZATION"				=> array (NONEED,""),
		"HTTP_HOMEORGANIZATIONTYPE"			=> array (NONEED,""),
		"HTTP_KULASSOCSAPID"				=> array (NONEED,""),
		"HTTP_KULASSOCLIBISPID"				=> array (NONEED,""),
		"HTTP_KULASSOCLIBISNBR"				=> array (NONEED,""),
		"HTTP_KULASSOCMIGRATEID"			=> array (NONEED,"")
		);

$environment_attributes = array (
		#Name of the environment variable		=>array (NONEED|OPTIONAL|REQUIRED, "value or regex"),
		"Shib-Identity-Provider"		=>array (REQUIRED,""),
		"Shib-Authentication-Instant"	=>array (REQUIRED,""),
		"Shib-Authentication-Method"	=>array (REQUIRED,""),
		"Shib-AuthnContext-Class"		=>array (REQUIRED,""),
		"eppn"							=>array (REQUIRED,""),
		"affiliation"					=>array (NONEED,""),
		"unscoped-affiliation"			=>array (NONEED,""),
		"entitlement"					=>array (NONEED,""),
		"persistent-id"					=>array (NONEED,""),
		"primary-affiliation"			=>array (NONEED,""),
		"nickname"						=>array (NONEED,""),
		"primary-orgunit-dn"			=>array (NONEED,""),
		"orgunit-dn"					=>array (NONEED,""),
		"org-dn"						=>array (NONEED,""),
		"cn"							=>array (NONEED,""),
		"sn"							=>array (NONEED,""),
		"givenName"						=>array (NONEED,""),
		"KULOfficialGivenName"						=>array (NONEED,""),
		"mail"							=>array (NONEED,""),
		"uid"							=>array (NONEED,""),
		"telephoneNumber"				=>array (NONEED,""),
		"title"							=>array (NONEED,""),
		"initials"						=>array (NONEED,""),
		"description"					=>array (NONEED,""),
		"carLicense"					=>array (NONEED,""),
		"departmentNumber"				=>array (NONEED,""),
		"displayName"					=>array (NONEED,""),
		"employeeNumber"				=>array (NONEED,""),
		"employeeType"					=>array (NONEED,""),
		"preferredLanguage"				=>array (NONEED,""),
		"manager"						=>array (NONEED,""),
		"seeAlso"						=>array (NONEED,""),
		"facsimileTelephoneNumber"		=>array (NONEED,""),
		"postalAddress"					=>array (NONEED,""),
		"street"						=>array (NONEED,""),
		"postOfficeBox"					=>array (NONEED,""),
		"postalCode"					=>array (NONEED,""),
		"st"							=>array (NONEED,""),
		"l"								=>array (NONEED,""),
		"o"								=>array (NONEED,""),
		"ou"							=>array (NONEED,""),
		"businessCategory"				=>array (NONEED,""),
		"physicalDeliveryOfficeName"	=>array (NONEED,""),
		"roomNumber"					=>array (NONEED,""),
		"KULluditServer"				=>array (NONEED,""),
		"KULprimouNumber"				=>array (NONEED,""),
		"KULouNumber"					=>array (NONEED,""),
		"KULemployeeType"				=>array (NONEED,""),
		"KULdipl"						=>array (NONEED,""),
		"KULopl"						=>array (NONEED,""),
		"KULstamnr"						=>array (NONEED,""),
		"KULid"							=>array (NONEED,""),
		"KULlibisnr"					=>array (NONEED,""),
		"KULstudentType"				=>array (NONEED,""),
		"KULcampus"						=>array (NONEED,""),
		"userAppUserID"					=>array (NONEED,""),
		"syncoreLogonCode"				=>array (NONEED,""),
		"KULMoreUnifiedUID"				=>array (NONEED,""),
		"KULCardApplicationId"			=>array (NONEED,""),
		"KULCardSN"						=>array (NONEED,""),
		"KULPreferredMail"				=>array (NONEED,""),
		"KULMainLocation"				=>array (NONEED,""),
		"KULAssocUCCtag"				=>array (NONEED,""),
		"logoutURL"						=>array (NONEED,""),
		"uidToledo"						=>array (NONEED,""),
		"HomeOrganization"				=>array (NONEED,""),
		"HomeOrganizationType"			=>array (NONEED,""),
		"KULAssocSAPID"					=>array (NONEED,""),
		"KULAssocLibisPID"				=>array (NONEED,""),
		"KULAssocLibisNbr"				=>array (NONEED,""),
		"KULAssocMigrateID"				=>array (NONEED,"")
		);
####END CONFIGURATION####
$urn_attribute_map = array(
		"HTTP_SHIB_IDENTITY_PROVIDER"			=> "Default attribute",
		"HTTP_SHIB_AUTHENTICATION_METHOD"		=> "Default attribute",
		"HTTP_SHIB_AUTHENTICATION_INSTANT"		=> "Default attribute",
		"HTTP_SHIB_AUTHNCONTEXT_CLASS"			=> "Default attribute",
		"HTTP_EPPN"								=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.6",
		"HTTP_AFFILIATION"						=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.9",
		"HTTP_UNSCOPED_AFFILIATION"				=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.1",
		"HTTP_ENTITLEMENT"						=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.7",
		"HTTP_PERSISTENT_ID"					=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.10",
		"HTTP_PRIMARY_AFFILIATION"				=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.5",
		"HTTP_NICKNAME"							=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.2",
		"HTTP_PRIMARY_ORGUNIT_DN"				=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.8",
		"HTTP_ORGUNIT_DN"						=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.4",
		"HTTP_ORG_DN"							=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.3",
		"HTTP_CN"								=> "urn:oid:2.5.4.3",
		"HTTP_SN"								=> "urn:oid:2.5.4.4",
		"HTTP_GIVENNAME"						=> "urn:oid:2.5.4.42",
		"HTTP_KULOFFICIALGIVENNAME"						=> "urn:mace:kuleuven.be:dir:attribute-def:KULOfficialGivenName",
		"HTTP_MAIL"								=> "urn:oid:0.9.2342.19200300.100.1.3",
		"HTTP_UID"								=> "urn:oid:0.9.2342.19200300.100.1.1",
		"HTTP_TELEPHONENUMBER"					=> "urn:oid:2.5.4.20",
		"HTTP_TITLE"							=> "urn:oid:2.5.4.12",
		"HTTP_INITIALS"							=> "urn:oid:2.5.4.43",
		"HTTP_DESCRIPTION"						=> "urn:oid:2.5.4.13",
		"HTTP_CARLICENSE"						=> "urn:oid:2.16.840.1.113730.3.1.1",
		"HTTP_DEPARTMENTNUMBER"					=> "urn:oid:2.16.840.1.113730.3.1.2",
		"HTTP_DISPLAYNAME"						=> "urn:oid:2.16.840.1.113730.3.1.241",
		"HTTP_EMPLOYEENUMBER"					=> "urn:oid:2.16.840.1.113730.3.1.3",
		"HTTP_EMPLOYEETYPE"						=> "urn:oid:2.16.840.1.113730.3.1.4",
		"HTTP_PREFERREDLANGUAGE"				=> "urn:oid:2.16.840.1.113730.3.1.39",
		"HTTP_MANAGER"							=> "urn:oid:0.9.2342.19200300.100.1.10",
		"HTTP_SEEALSO"							=> "urn:oid:2.5.4.34",
		"HTTP_FACSIMILETELEPHONENUMBER"			=> "urn:oid:2.5.4.23",
		"HTTP_POSTALADDRESS"					=> "urn:oid:2.5.4.16",
		"HTTP_STREET"							=> "urn:oid:2.5.4.9",
		"HTTP_POSTOFFICEBOX"					=> "urn:oid:2.5.4.18",
		"HTTP_POSTALCODE"						=> "urn:oid:2.5.4.17",
		"HTTP_ST"								=> "urn:oid:2.5.4.8",
		"HTTP_L"								=> "urn:oid:2.5.4.7",
		"HTTP_O"								=> "urn:oid:2.5.4.10",
		"HTTP_OU"								=> "urn:oid:2.5.4.11",
		"HTTP_BUSINESSCATEGORY"					=> "urn:oid:2.5.4.15",
		"HTTP_PHYSICALDELIVERYOFFICENAME"		=> "urn:oid:2.5.4.19",
		"HTTP_ROOMNUMBER"						=> "urn:oid:0.9.2342.19200300.100.1.6",
		"HTTP_KULLUDITSERVER"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULluditServer",
		"HTTP_KULPRIMOUNUMBER"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULprimouNumber",
		"HTTP_KULOUNUMBER"						=> "urn:mace:kuleuven.be:dir:attribute-def:KULouNumber",
		"HTTP_KULEMPLOYEETYPE"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULemployeeType",
		"HTTP_KULDIPL"							=> "urn:mace:kuleuven.be:dir:attribute-def:KULdipl",
		"HTTP_KULOPL"							=> "urn:mace:kuleuven.be:dir:attribute-def:KULopl",
		"HTTP_KULSTAMNR"						=> "urn:mace:kuleuven.be:dir:attribute-def:KULstamnr",
		"HTTP_KULID"							=> "urn:mace:kuleuven.be:dir:attribute-def:KULid",
		"HTTP_KULLIBISNR"						=> "urn:mace:kuleuven.be:dir:attribute-def:KULlibisnr",
		"HTTP_KULSTUDENTTYPE"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULstudentType",
		"HTTP_KULCAMPUS"						=> "urn:mace:kuleuven.be:dir:attribute-def:KULcampus",
		"HTTP_USERAPPUSERID"					=> "urn:mace:kuleuven.be:dir:attribute-def:userAppUserID",
		"HTTP_SYNCORELOGONCODE"					=> "urn:mace:kuleuven.be:dir:attribute-def:syncoreLogonCode",
		"HTTP_KULMOREUNIFIEDUID"				=> "urn:mace:kuleuven.be:dir:attribute-def:KULMoreUnifiedUID",
		"HTTP_KULCARDAPPLICATIONID"				=> "urn:mace:kuleuven.be:dir:attribute-def:KULCardApplicationId",
		"HTTP_KULCARDSN"						=> "urn:mace:kuleuven.be:dir:attribute-def:KULCardSN",
		"HTTP_KULPREFERREDMAIL"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULPreferredMail",
		"HTTP_KULMAINLOCATION"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULMainLocation",
		"HTTP_KULASSOCUCCTAG"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocUCCtag",
		"HTTP_LOGOUTURL"						=> "urn:mace:kuleuven.be:dir:attribute-def:logoutURL",
		"HTTP_UIDTOLEDO"						=> "urn:mace:kuleuven.be:dir:attribute-def:uidToledo",
		"HTTP_HOMEORGANIZATION"					=> "urn:mace:kuleuven.be:dir:attribute-def:homeOrganization",
		"HTTP_HOMEORGANIZATIONTYPE"				=> "urn:mace:kuleuven.be:dir:attribute-def:homeOrganizationType",
		"HTTP_KULASSOCSAPID"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocSAPID",
		"HTTP_KULASSOCLIBISPID"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocLibisPID",
		"HTTP_KULASSOCLIBISNBR"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocLibisNbr",
		"HTTP_KULASSOCMIGRATEID"				=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocMigrateID",
		);

$urn_environment_attribute_map = array(
		"Shib-Identity-Provider"	=> "Default attribute",
		"Shib-Identity-Provider"	=> "Default attribute",
		"Shib-Authentication-Instant"=> "Default attribute",
		"Shib-Authentication-Method"=> "Default attribute",
		"Shib-AuthnContext-Class"	=> "Default attribute",
		"eppn"						=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.6",
		"affiliation"				=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.9",
		"unscoped-affiliation"		=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.1",
		"entitlement"				=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.7",
		"persistent-id"				=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.10",
		"primary-affiliation"		=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.5",
		"nickname"					=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.2",
		"primary-orgunit-dn"		=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.8",
		"orgunit-dn"				=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.4",
		"org-dn"					=> "urn:oid:1.3.6.1.4.1.5923.1.1.1.3",
		"cn"						=> "urn:oid:2.5.4.3",
		"sn"						=> "urn:oid:2.5.4.4",
		"givenName"					=> "urn:oid:2.5.4.42",
		"KULOfficialGivenName"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULOfficialGivenName",
		"mail"						=> "urn:oid:0.9.2342.19200300.100.1.3",
		"uid"						=> "urn:oid:0.9.2342.19200300.100.1.1",
		"telephoneNumber"			=> "urn:oid:2.5.4.20",
		"title"						=> "urn:oid:2.5.4.12",
		"initials"					=> "urn:oid:2.5.4.43",
		"description"				=> "urn:oid:2.5.4.13",
		"carLicense"				=> "urn:oid:2.16.840.1.113730.3.1.1",
		"departmentNumber"			=> "urn:oid:2.16.840.1.113730.3.1.2",
		"displayName"				=> "urn:oid:2.16.840.1.113730.3.1.241",
		"employeeNumber"			=> "urn:oid:2.16.840.1.113730.3.1.3",
		"employeeType"				=> "urn:oid:2.16.840.1.113730.3.1.4",
		"preferredLanguage"			=> "urn:oid:2.16.840.1.113730.3.1.39",
		"manager"					=> "urn:oid:0.9.2342.19200300.100.1.10",
		"seeAlso"					=> "urn:oid:2.5.4.34",
		"facsimileTelephoneNumber"	=> "urn:oid:2.5.4.23",
		"postalAddress"				=> "urn:oid:2.5.4.16",
		"street"					=> "urn:oid:2.5.4.9",
		"postOfficeBox"				=> "urn:oid:2.5.4.18",
		"postalCode"				=> "urn:oid:2.5.4.17",
		"st"						=> "urn:oid:2.5.4.8",
		"l"							=> "urn:oid:2.5.4.7",
		"o"							=> "urn:oid:2.5.4.10",
		"ou"						=> "urn:oid:2.5.4.11",
		"businessCategory"			=> "urn:oid:2.5.4.15",
		"physicalDeliveryOfficeName"=> "urn:oid:2.5.4.19",
		"roomNumber"				=> "urn:oid:0.9.2342.19200300.100.1.6",
		"KULluditServer"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULluditServer",
		"KULprimouNumber"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULprimouNumber",
		"KULouNumber"				=> "urn:mace:kuleuven.be:dir:attribute-def:KULouNumber",
		"KULemployeeType"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULemployeeType",
		"KULdipl"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULdipl",
		"KULopl"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULopl",
		"KULstamnr"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULstamnr",
		"KULid"						=> "urn:mace:kuleuven.be:dir:attribute-def:KULid",
		"KULlibisnr"				=> "urn:mace:kuleuven.be:dir:attribute-def:KULlibisnr",
		"KULstudentType"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULstudentType",
		"KULcampus"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULcampus",
		"userAppUserID"				=> "urn:mace:kuleuven.be:dir:attribute-def:userAppUserID",
		"syncoreLogonCode"			=> "urn:mace:kuleuven.be:dir:attribute-def:syncoreLogonCode",
		"KULMoreUnifiedUID"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULMoreUnifiedUID",
		"KULCardApplicationId"		=> "urn:mace:kuleuven.be:dir:attribute-def:KULCardApplicationId",
		"KULCardSN"					=> "urn:mace:kuleuven.be:dir:attribute-def:KULCardSN",
		"KULPreferredMail"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULPreferredMail",
		"KULMainLocation"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULMainLocation",
		"KULAssocUCCtag"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocUCCtag",
		"logoutURL"					=> "urn:mace:kuleuven.be:dir:attribute-def:logoutURL",
		"uidToledo"					=> "urn:mace:kuleuven.be:dir:attribute-def:uidToledo",
		"HomeOrganization"			=> "urn:mace:kuleuven.be:dir:attribute-def:homeOrganization",
		"HomeOrganizationType"		=> "urn:mace:kuleuven.be:dir:attribute-def:homeOrganizationType",
		"KULAssocSAPID"				=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocSAPID",
		"KULAssocLibisPID"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocLibisPID",
		"KULAssocLibisNbr"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocLibisNbr",
		"KULAssocMigrateID"			=> "urn:mace:kuleuven.be:dir:attribute-def:KULAssocMigrateID"
		);

?>
<html>
<head>
<title><?php echo $name ?></title>

<style type="text/css">
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 0.6em;
}
td { 
	font-size: 0.8em;
        
}
.theader {
	background-color: #FFA500;
}
tbody {
	background-color: #E5E5E5;
}

</style>
</head>

<body>
  <h1><?php echo $name ?></h1>
  <h2>REMOTE_USER: <?php echo( $_SERVER['REMOTE_USER'] ) ?></h2>
  <table cellpadding="5" align="center" border="2" frame="hsides" rules="groups">
    <colgroup align="center">
    <colgroup align="left">
    <colgroup align="left">
    <colgroup align="left">
    <colgroup align="left">

    <thead>
     <tr>
       <th colspan="6">Attributes required for this application</th>
     </tr>
    </thead>
    <thead class="theader">
     <tr>
       <th></th>
       <th></th>
       <th>Required value</th>
       <th>SAML2 attribute name</th>
<?php
  define ("STATE_EMPTY", "images/empty.png");
  define ("STATE_NOK", "images/nok.png");
  define ("STATE_OK", "images/ok.png");
  define ("STATE_OPTIONAL", "images/optional.png");
  
  $nok_counter = 0;
  $header_name = "Environment Variable"; 
 
  #check if Shib-Identity-Provider environment variable is set. If true, we can assume environment variables are enabled.
  if (! empty($_SERVER['Shib-Identity-Provider'])){
	$attributeArray = $environment_attributes;
	$attributeMap = $urn_environment_attribute_map; 
  } else {
	$attributeArray = $header_attributes;
	$attributeMap = $urn_attribute_map;
	$header_name = "Header Name"; 
  }

    echo "<th>".$header_name."</th>";
    echo "<th>Value</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

  foreach ($attributeArray as $attribute => $options) {
    
    $print = TRUE;
    $state = STATE_EMPTY;
    
    switch($options[0]) {
      case NONEED:	$print= FALSE;
      			break;
      
      case OPTIONAL:    if(! empty ($_SERVER[$attribute]) ) {
			  $state = STATE_OK;
      			} else {
			  $state = STATE_OPTIONAL;
			}
      			break; 
      
      case REQUIRED:    if(! empty ($_SERVER[$attribute]) ) {
			  if(! empty( $options[1] )) {
			    $values = explode(";", $_SERVER[$attribute]);
			    $state = STATE_NOK; 
			    foreach ( $values as $value ) {
				    if (preg_match('/'.$options[1].'/i', $value)) { 
				      $state = STATE_OK;
				    } 
			    }
			    if ($state == STATE_NOK) $nok_counter++;
			    
			  } else {
			    $state = STATE_OK;
			  }	
			} else {
      			  $state = STATE_EMPTY;
			  $nok_counter++;
			}
			break;
      			
    }

    if ($print) {
	    echo "\n\t".'<tr>';
	    echo "\n\t\t".'<td><img src="'.$state.'" alt="'.$state.'"/></td>';
	    echo "\n\t\t".'<td>'.$options[0].'</td>';
	    echo "\n\t\t".'<td>'.$options[1].'</td>';
	    echo "\n\t\t".'<td>'.$attributeMap[$attribute].'</td>';
	    echo "\n\t\t".'<td>'.$attribute.'</td>';
	    if ( isset ($_SERVER[$attribute]) ) { 
		    echo "\n\t\t".'<td>'.$_SERVER[$attribute].'</td>';
            } else {
		    echo "\n\t\t".'<td>&nbsp;</td>';
            }
		    
	    echo "\n\t".'</tr>';
    }
  }
?>

    <tbody>
    <caption>
    <?php 
      if ($nok_counter == 1) { 
        echo 'You have <strong>'.$nok_counter.'</strong> attribute that is required but isn&rsquo;t present or has the wrong value.</br>';
	echo 'Please check your <em>Attribute Release Policy</em> to release the specified attributes.<br/><br/>';
    } elseif ($nok_counter > 1)  {
        echo 'You have <strong>'.$nok_counter.'</strong> attributes that are required but aren&rsquo;t present or have the wrong value.</br>';
	echo 'Please check your <em>Attribute Release Policy</em> to release the specified attributes.<br/><br/>';
    } else {
        echo 'Congratulations, all the required attributes are present and have the correct values<br/><br/>';
    }
    ?>

    </caption>
  </table>

</body>
</html>


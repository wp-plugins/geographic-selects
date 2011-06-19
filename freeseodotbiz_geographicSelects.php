<?php
/*
Plugin Name: Geographic Selects
Plugin URI: http://www.free-seo.biz/wordpress-plugins/geographic-selects/
Description: Simple plugin to insert Country &lt;select&gt;'s into your website.
Author: Free-SEO.biz
Version: 1.1.4
Author URI: http://www.free-seo.biz

Usage:

Shortcode Format:
------------------
[geographicSelect-insertCountries includeselect="TRUE"]

To insert using PHP:
--------------------
$atts[includeselect]="TRUE";
echo geographicSelect_insertCountries($atts);

*/

/*  Copyright 2011  freeseodotbiz  (email : scott@free-seo.biz)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 $plugin_url = path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) ));

 wp_enqueue_script( 'geographicSelect_Javascript', $plugin_url.'/script.js');
 wp_enqueue_style( 'geographicSelect_Stylesheet', $plugin_url.'/style.css', FALSE, '', '');

 add_action('admin_menu', array('freeseodotbiz_geographicSelect','addOptionsPage'));
 add_shortcode('geographicSelect-insertCountries', 'geographicSelect_insertCountries');
 add_action('wp_ajax_geographicSelects_AJAX_handler', array('freeseodotbiz_geographicSelect','geographicSelects_AJAX_handler'));
 add_action('wp_ajax_nopriv_geographicSelects_AJAX_handler', array('freeseodotbiz_geographicSelect','geographicSelects_AJAX_handler'));
 
 $GLOBALS['freeseodotbiz_geographicSelect']=new freeseodotbiz_geographicSelect;
 $GLOBALS['freeseodotbiz_geographicSelect']->getOptions();
 
 function geographicSelect_insertCountries($atts){
  $countryCodes=array("AF" => "AFGHANISTAN", "AX" => "ALAND ISLANDS", "AL" => "ALBANIA", "DZ" => "ALGERIA", "AS" => "AMERICAN SAMOA", "AD" => "ANDORRA", "AO" => "ANGOLA", "AI" => "ANGUILLA", "AQ" => "ANTARCTICA", "AG" => "ANTIGUA AND BARBUDA", "AR" => "ARGENTINA", "AM" => "ARMENIA", "AW" => "ARUBA", "AU" => "AUSTRALIA", "AT" => "AUSTRIA", "AZ" => "AZERBAIJAN", "BS" => "BAHAMAS", "BH" => "BAHRAIN", "BD" => "BANGLADESH", "BB" => "BARBADOS", "BY" => "BELARUS", "BE" => "BELGIUM", "BZ" => "BELIZE", "BJ" => "BENIN", "BM" => "BERMUDA", "BT" => "BHUTAN", "BO" => "BOLIVIA, PLURINATIONAL STATE OF", "BQ" => "BONAIRE, SAINT EUSTATIUS AND SABA", "BA" => "BOSNIA AND HERZEGOVINA", "BW" => "BOTSWANA", "BV" => "BOUVET ISLAND", "BR" => "BRAZIL", "IO" => "BRITISH INDIAN OCEAN TERRITORY", "BN" => "BRUNEI DARUSSALAM", "BG" => "BULGARIA", "BF" => "BURKINA FASO", "BI" => "BURUNDI", "KH" => "CAMBODIA", "CM" => "CAMEROON", "CA" => "CANADA", "CV" => "CAPE VERDE", "KY" => "CAYMAN ISLANDS", "CF" => "CENTRAL AFRICAN REPUBLIC", "TD" => "CHAD", "CL" => "CHILE", "CN" => "CHINA", "CX" => "CHRISTMAS ISLAND", "CC" => "COCOS (KEELING) ISLANDS", "CO" => "COLOMBIA", "KM" => "COMOROS", "CG" => "CONGO", "CD" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE", "CK" => "COOK ISLANDS", "CR" => "COSTA RICA", "CI" => "COTE D'IVOIRE", "HR" => "CROATIA", "CU" => "CUBA", "CW" => "CURACAO", "CY" => "CYPRUS", "CZ" => "CZECH REPUBLIC", "DK" => "DENMARK", "DJ" => "DJIBOUTI", "DM" => "DOMINICA", "DO" => "DOMINICAN REPUBLIC", "EC" => "ECUADOR", "EG" => "EGYPT", "SV" => "EL SALVADOR", "GQ" => "EQUATORIAL GUINEA", "ER" => "ERITREA", "EE" => "ESTONIA", "ET" => "ETHIOPIA", "FK" => "FALKLAND ISLANDS (MALVINAS)", "FO" => "FAROE ISLANDS", "FJ" => "FIJI", "FI" => "FINLAND", "FR" => "FRANCE", "GF" => "FRENCH GUIANA", "PF" => "FRENCH POLYNESIA", "TF" => "FRENCH SOUTHERN TERRITORIES", "GA" => "GABON", "GM" => "GAMBIA", "GE" => "GEORGIA", "DE" => "GERMANY", "GH" => "GHANA", "GI" => "GIBRALTAR", "GR" => "GREECE", "GL" => "GREENLAND", "GD" => "GRENADA", "GP" => "GUADELOUPE", "GU" => "GUAM", "GT" => "GUATEMALA", "GG" => "GUERNSEY", "GN" => "GUINEA", "GW" => "GUINEA-BISSAU", "GY" => "GUYANA", "HT" => "HAITI", "HM" => "HEARD ISLAND AND MCDONALD ISLANDS", "VA" => "HOLY SEE (VATICAN CITY STATE)", "HN" => "HONDURAS", "HK" => "HONG KONG", "HU" => "HUNGARY", "IS" => "ICELAND", "IN" => "INDIA", "ID" => "INDONESIA", "IR" => "IRAN, ISLAMIC REPUBLIC OF", "IQ" => "IRAQ", "IE" => "IRELAND", "IM" => "ISLE OF MAN", "IL" => "ISRAEL", "IT" => "ITALY", "JM" => "JAMAICA", "JP" => "JAPAN", "JE" => "JERSEY", "JO" => "JORDAN", "KZ" => "KAZAKHSTAN", "KE" => "KENYA", "KI" => "KIRIBATI", "KP" => "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF", "KR" => "KOREA, REPUBLIC OF", "KW" => "KUWAIT", "KG" => "KYRGYZSTAN", "LA" => "LAO PEOPLE'S DEMOCRATIC REPUBLIC", "LV" => "LATVIA", "LB" => "LEBANON", "LS" => "LESOTHO", "LR" => "LIBERIA", "LY" => "LIBYAN ARAB JAMAHIRIYA", "LI" => "LIECHTENSTEIN", "LT" => "LITHUANIA", "LU" => "LUXEMBOURG", "MO" => "MACAO", "MK" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "MG" => "MADAGASCAR", "MW" => "MALAWI", "MY" => "MALAYSIA", "MV" => "MALDIVES", "ML" => "MALI", "MT" => "MALTA", "MH" => "MARSHALL ISLANDS", "MQ" => "MARTINIQUE", "MR" => "MAURITANIA", "MU" => "MAURITIUS", "YT" => "MAYOTTE", "MX" => "MEXICO", "FM" => "MICRONESIA, FEDERATED STATES OF", "MD" => "MOLDOVA, REPUBLIC OF", "MC" => "MONACO", "MN" => "MONGOLIA", "ME" => "MONTENEGRO", "MS" => "MONTSERRAT", "MA" => "MOROCCO", "MZ" => "MOZAMBIQUE", "MM" => "MYANMAR", "NA" => "NAMIBIA", "NR" => "NAURU", "NP" => "NEPAL", "NL" => "NETHERLANDS", "NC" => "NEW CALEDONIA", "NZ" => "NEW ZEALAND", "NI" => "NICARAGUA", "NE" => "NIGER", "NG" => "NIGERIA", "NU" => "NIUE", "NF" => "NORFOLK ISLAND", "MP" => "NORTHERN MARIANA ISLANDS", "NO" => "NORWAY", "OM" => "OMAN", "PK" => "PAKISTAN", "PW" => "PALAU", "PS" => "PALESTINIAN TERRITORY, OCCUPIED", "PA" => "PANAMA", "PG" => "PAPUA NEW GUINEA", "PY" => "PARAGUAY", "PE" => "PERU", "PH" => "PHILIPPINES", "PN" => "PITCAIRN", "PL" => "POLAND", "PT" => "PORTUGAL", "PR" => "PUERTO RICO", "QA" => "QATAR", "RE" => "REUNION", "RO" => "ROMANIA", "RU" => "RUSSIAN FEDERATION", "RW" => "RWANDA", "BL" => "SAINT BARTHELEMY", "SH" => "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA", "KN" => "SAINT KITTS AND NEVIS", "LC" => "SAINT LUCIA", "MF" => "SAINT MARTIN (FRENCH PART)", "PM" => "SAINT PIERRE AND MIQUELON", "VC" => "SAINT VINCENT AND THE GRENADINES", "WS" => "SAMOA", "SM" => "SAN MARINO", "ST" => "SAO TOME AND PRINCIPE", "SA" => "SAUDI ARABIA", "SN" => "SENEGAL", "RS" => "SERBIA", "SC" => "SEYCHELLES", "SL" => "SIERRA LEONE", "SG" => "SINGAPORE", "SX" => "SINT MAARTEN (DUTCH PART)", "SK" => "SLOVAKIA", "SI" => "SLOVENIA", "SB" => "SOLOMON ISLANDS", "SO" => "SOMALIA", "ZA" => "SOUTH AFRICA", "GS" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "ES" => "SPAIN", "LK" => "SRI LANKA", "SD" => "SUDAN", "SR" => "SURINAME", "SJ" => "SVALBARD AND JAN MAYEN", "SZ" => "SWAZILAND", "SE" => "SWEDEN", "CH" => "SWITZERLAND", "SY" => "SYRIAN ARAB REPUBLIC", "TW" => "TAIWAN, PROVINCE OF CHINA", "TJ" => "TAJIKISTAN", "TZ" => "TANZANIA, UNITED REPUBLIC OF", "TH" => "THAILAND", "TL" => "TIMOR-LESTE", "TG" => "TOGO", "TK" => "TOKELAU", "TO" => "TONGA", "TT" => "TRINIDAD AND TOBAGO", "TN" => "TUNISIA", "TR" => "TURKEY", "TM" => "TURKMENISTAN", "TC" => "TURKS AND CAICOS ISLANDS", "TV" => "TUVALU", "UG" => "UGANDA", "UA" => "UKRAINE", "AE" => "UNITED ARAB EMIRATES", "GB" => "UNITED KINGDOM", "US" => "UNITED STATES", "UM" => "UNITED STATES MINOR OUTLYING ISLANDS", "UY" => "URUGUAY", "UZ" => "UZBEKISTAN", "VU" => "VANUATU", "VE" => "VENEZUELA, BOLIVARIAN REPUBLIC OF", "VN" => "VIET NAM", "VG" => "VIRGIN ISLANDS, BRITISH", "VI" => "VIRGIN ISLANDS, U.S.", "WF" => "WALLIS AND FUTUNA", "EH" => "WESTERN SAHARA", "YE" => "YEMEN", "ZM" => "ZAMBIA", "ZW" => "ZIMBABWE");
  if ($atts['includeselect']) $build.="<select>";
  if (count($GLOBALS['freeseodotbiz_geographicSelect_vars'][optGroup])){
   $build.="<optgroup label=\"\">";
   foreach ($GLOBALS['freeseodotbiz_geographicSelect_vars'][optGroup] as $index=>$value) $build.="<option value=\"$index\">".$countryCodes[$index]."</option>";
   $build.="</optgroup>";
   $build.="<optgroup label=\"--------------------\">";
  }
  foreach ($countryCodes as $index=>$value) $build.="<option value=\"$index\">$value</option>";
  if (count($GLOBALS['freeseodotbiz_geographicSelect_vars'])) $build.="</optgroup>";
  if ($atts['includeselect']) $build.="</select>";
  return $build;
 }
 
 class freeseodotbiz_geographicSelect{
  
  function geographicSelects_AJAX_handler(){
   $GLOBALS['freeseodotbiz_geographicSelect']->confirmSignupNonce("geographicSelect_nonce");
   if ($_POST[formName]=="contriesOPTGroup"){
    $GLOBALS['freeseodotbiz_geographicSelect']->optionsPageActual_countriesOPTGroup();
    exit;
   } else {
    print_r($_POST);
    exit;
   }
  }
  function confirmSignupNonce($nonceName){
   $nonce=$_REQUEST[_wpnonce];
   if (!$nonce and $_POST[_wpnonce]) $nonce=$_POST[_wpnonce];
   if (!wp_verify_nonce($nonce,$nonceName)){
    die ("Authentication failed"); 
    exit; 
   }
  } 
  
  function addOptionsPage(){
   wp_enqueue_script('jquery');
   add_options_page('Geographic Selects', 'Geo-Selects Config', 8, __FILE__, array('freeseodotbiz_geographicSelect','optionsPageActual'));
  }
  function optionsPageActual(){
   echo "<div id=\"icon-options-general\" class=\"icon32\"><br></div>";
   echo "<div class=\"wrap\">";
   echo " <div id=\"geographicSelectsOptions\">";
   echo "  <h2>Geographic Selects by <i>free-seo.biz</i></h2>";
   echo "  <p>Geographic Selects makes the task of inserting countries into your <code>&lt;select&gt;</code> statements simple.</p>";
   echo "  <p></p>";
   echo "  <p style=\"margin-left: 50px;\">There are two ways you can use this:<br><br>As PHP Script:<br><code>&lt;?php \$atts[includeselect]=\"TRUE\"; echo geographicSelect_insertCountries(\$atts); ?&gt;</code><br><br>As Shortcode:<br><code>[geographicSelect-insertCountries includeselect=\"TRUE\"]</code><br><br>Currently the only attribute is <code>includeselect</code>. The default is <code>off</code> which means that you must supply your own opening and closing <code>&lt;select&gt;</code> statements.</p>";
   echo "  <h3>Settings</h3>";
   
   // COUNTRIES OPTGROUP
   echo "   <div id=\"contriesOPTGroup_div\" class=\"groupTogether\">"; 
   $GLOBALS['freeseodotbiz_geographicSelect']->optionsPageActual_countriesOPTGroup();
   echo "   </div>";

   echo " </div>";
   echo "</div>";
  }
  function optionsPageActual_countriesOPTGroup(){
   if ($_POST[formName]=="contriesOPTGroup" and wp_verify_nonce($_POST[_wpnonce],"geographicSelect_nonce")){
    $GLOBALS['freeseodotbiz_geographicSelect_vars'][useOptGroup]=$_POST[useOptGroup];
    if (!$_POST[useOptGroup]){
     unset($GLOBALS['freeseodotbiz_geographicSelect_vars'][optGroup]);
    } else {
     if ($_POST[addCountryToOptGroup]) $GLOBALS['freeseodotbiz_geographicSelect_vars'][optGroup][$_POST[addCountryToOptGroup]]=1;
    }
    $GLOBALS['freeseodotbiz_geographicSelect']->updateOption();
   }
   echo "    <form name=\"contriesOPTGroup\" ID=\"contriesOPTGroup\" method=post>";
   wp_nonce_field("geographicSelect_nonce");
   echo "     <input type=hidden id=\"adminAjaxLoc\" name=adminAjaxLoc value=\"".admin_url()."admin-ajax.php\">";
   echo "     <h3>COUNTRIES OPTGROUP</h3>";
   echo "     <p><code>&lt;optgroup&gt;</code> is an optional tag you can place inside of a <code>&lt;select&gt;</code> statement in order to group certain items together.  For instance, if you know that most of your customers will be choosing \"UNITED STATES\" as their choice, you'd want to set this in your OPTGROUP.</code></p>";
   $checked=""; if ($GLOBALS['freeseodotbiz_geographicSelect_vars'][useOptGroup]){
    echo "     <p><input type=\"radio\" checked data-whichDIV=\"#geographicSelectForm_countriesOPTGROUP\" name=\"useOptGroup\" value=\"1\">I would like certain countries to show up before all others</p>";
    echo "     <div style=\"margin-left: 35px;\">";
    echo "      <p>Add a country to the OPTGROUP:</p>";
    echo "      <select name=addCountryToOptGroup id=addCountryToOptGroup>";
    echo geographicSelect_insertCountries();
    echo "      </select>";
    echo "      <input type=submit class=\"button-primary\" value=\"Add to list\">";
    echo "      <p>Preview:</p>";
    echo "      <select style=\"height: 180px; margin-bottom: 50px;\" size=2 disabled=disabled>";
    echo geographicSelect_insertCountries();
    echo "      </select>";
    echo "     </div>";
    echo "     <p><input type=\"radio\" data-whichDIV=\"#geographicSelectForm_countriesOPTGROUP\" name=\"useOptGroup\" value=\"\">Display all countries in order (this will also delete your current OPTGROUP if you made a mistake)</p>";
   } else {
    echo "     <p><input type=\"radio\" data-whichDIV=\"#geographicSelectForm_countriesOPTGROUP\" name=\"useOptGroup\" value=\"1\">I would like certain countries to show up before all others</p>";
    echo "     <p><input type=\"radio\" checked data-whichDIV=\"#geographicSelectForm_countriesOPTGROUP\" name=\"useOptGroup\" value=\"\">Display all countries in order (this will also delete your current OPTGROUP if you made a mistake)</p>";
   }
   echo "    </form>";
  }
  
  function addOptions(){
   add_option('freeseodotbiz_geographicSelect_vars','');
  }
  function deleteOptions(){
   delete_option('freeseodotbiz_geographicSelect_vars');
  }
  function getOptions(){
   $temp=get_option('freeseodotbiz_geographicSelect_vars');
   if ($temp) $GLOBALS['freeseodotbiz_geographicSelect_vars']=unserialize($temp);
  }
  function updateOption(){
  $temp=serialize($GLOBALS['freeseodotbiz_geographicSelect_vars']);
  update_option('freeseodotbiz_geographicSelect_vars',$temp);
 }
 
  function setGlobals(){
   date_default_timezone_set('America/Los_Angeles');
   $GLOBALS[time]=time();
   $GLOBALS[beginningofday]=mktime(0,0,0,date("m"),date("d"),date("y"));
   $GLOBALS[beginningofyesterday]=mktime(0,0,0,date("m"),date("d")-1,date("y"));
   
   $this->getOptions();
   if ($GLOBALS[stearnsWebsite_vars][currentSite]=="freeseo"){
    $GLOBALS[aliasForAccountNumber]="accountNumber";
    $GLOBALS[aliasForOrderNumber]="orderNumber";
   }
   
   
   if ($GLOBALS[stearnsWebsite_vars][currentSite]=="isubmit"){
    $GLOBALS[aliasForAccountNumber]="account_number";
    $GLOBALS[aliasForOrderNumber]="order_number";
   }
  }
  
  function settings(){
   if ($_POST[subGoTo]=="systemVariables"){ $this->systemVariables(); exit; }
   if ($_POST[subGoTo]=="databases"){ $this->databases(); exit; }
   if ($_POST[subGoTo]=="options"){ $this->options(); exit; }
   if ($_POST[subGoTo]=="FaceMySQL"){ $this->databases_FaceMySQL(); exit; }
   
   echo '<script>
	$(function() {
	 $( "#accordion" ).accordion({
	  autoHeight: false, navigation: true
     });
	});
	</script>';
	echo "<div id=\"accordionContainer\">";
	echo " <div id=\"accordion\">";
	echo "  <h3>Databases</h3>";
	echo "  <div id=\"settingsDatabases\">";
	$this->databases();
	echo "  </div>";
	
	echo "  <h3>Options</h3>";
	echo "  <div id=\"settingsOptions\">";
	$this->options();
	echo "  </div>";
	
	echo "  <h3>System Variables</h3>";
	echo "  <div id=\"systemVariables\">";
	$this->systemVariables();
	echo "  </div>";
	
	echo "  <h3>PHP Info</h3>";
	echo "  <div id=\"systemVariables\">";
	phpinfo();
	echo "  </div>";
	
	echo " </div>";
	echo "</div>";

  }

 }
?>
<?php
/**
 * @package      ITPrism Modules
 * @subpackage   Vip Amazon Associates
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor.iliev@itprism.co.uk>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * Vip Amazon Associates is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('Restricted access'); // no direct access 

$ips           = $params->get('blocked_ips');
$blockedIps    = explode(",",$ips);

$blockedIps    = array_map('trim', explode(',', $ips)); 
$remoteAddress = JArrayHelper::getValue($_SERVER, "REMOTE_ADDR");

if (!in_array($remoteAddress, $blockedIps)) {
	
    $moduleClassSfx = htmlspecialchars($params->get('moduleclass_sfx'));
    
	$phrase         = "";
    $amazonFilter  = $params->get('amazon_filter',1);
    
    switch ( $amazonFilter ){
    	// Keywords in meta tag
    	case 1:
	        $doc           =   JFactory::getDocument();
	        $keywords      =   $doc->getMetaData("keywords");
	        if ( !empty( $keywords ) ) {
	           $keywords      =   explode(",",$keywords);
	           
	           if ( !empty( $keywords ) ) {
	                $phrase   =   $keywords[array_rand($keywords)];
	           }
	        }
    		break;

   		// Title
    	case 2:
    		
    		$app       =   JFactory::getApplication();
            $phrase    =   $app->getPageTitle();
        
    		break;
    		
   		// Your keywords
    	default:
    		
    		$keywords  = $params->get('amazon_keywords','joomla');
            if ( !empty( $keywords ) ) {
               $keywords      =   explode(",",$keywords);
               
               if ( !empty( $keywords ) ) {
                    $phrase   =   $keywords[array_rand($keywords)];
               }
            }
    		break;
    }
    
    $phrase = JString::trim($phrase);
    $phrase = JString::strtolower($phrase);
    $phrase = rawurlencode($phrase);
    
	$amazonTrackingId  = $params->get('amazon_tracking_id', 'fullmotivation-20');
	$amazonCategory    = $params->get('amazon_category', 'books');
	$amazonSize        = $params->get('amazon_size', 8);
	$amazonBehavior    = $params->get('amazon_behavior', '_top');
	$amazonPrices      = $params->get('amazon_price_options', '');
	$amazonDomain      = $params->get('amazon_domain', 'us');
	
	$amazonBgColor     = $params->get('amazon_bg_colour', '080808');
	$amazonTextColor   = $params->get('amazon_text_colour', 'FFFFFF');
	$amazonLinkColor   = $params->get('amazon_link_colour', '3366FF');
	
	$html              = '<div class="vip-amazon' . $moduleClassSfx . '">
	<iframe ' ;
	$domain_prefix = "";
	$domain_suffix = "";
	switch ( $amazonDomain ) {
		
		
		case "uk":
			
			$html .= 'src="http://rcm-uk.amazon.co.uk';
            $domain_suffix = "-uk";
            $o =2;
            
			break;
		
	   case "de":
            
            $html .= 'src="http://rcm-de.amazon.de';
            $domain_suffix = "-de";
            $o =3;
            
            break;
       
       case "fr":
            
            $html .= 'src="http://rcm-fr.amazon.fr';
            $domain_suffix = "-fr";
            $o =8;
            break;
            
       case "jp":
            
            $html .= 'src="http://rcm-jp.amazon.co.jp';
            $domain_suffix = "-jp";
            $o =5;
            
            break;    

       case "ca":
            
            $html .= 'src="http://rcm-ca.amazon.ca';
            $domain_suffix = "-ca";
            $o =15;
            
            break;  
            
       case "it":
            
            $html .= 'src="http://rcm-it.amazon.it';
            $domain_prefix = "it_";
            $o =29;
            $p = array(20=>20, 13=>26, 11=>29, 42=>42, 48=>48);
            $amazonSize = JArrayHelper::getValue($p,$amazonSize,0);
            break;
                      
	   // United State
		default:
			$html .= 'src="http://rcm.amazon.com';
			$domain_suffix = "";
			$o = 1;
			break;
			
	}
	
	$html .= '/e/cm?t=' . $amazonTrackingId;

	switch ( $amazonPrices ) {
		
		case "nou":
			
			$html .= "&amp;nou=1";
			
			break;
		
	    case "npa":
	    	
	    	$html .= "&amp;npa=1";
            
            break;
            	
		default:
			
			break;
	}
	
	$html .= '&amp;o=' . $o . '&amp;p=' . $amazonSize . '&amp;l=st1&amp;mode=' . $domain_prefix .$amazonCategory . $domain_suffix .'&amp;search=' . $phrase . '&amp;fc1=' .$amazonTextColor . '&amp;lt1=' . $amazonBehavior . '&amp;lc1=' .$amazonLinkColor . '&amp;bg1=' .$amazonBgColor . '&amp;f=ifr" marginwidth="0" marginheight="0"  border="0" frameborder="0" style="border:none;" scrolling="no"';
	
	switch( $amazonSize )  {
		
		case 6:
          $html .= ' width="120" height="150" ';
          break;
        
        case 8:
          $html .= ' width="120" height="240" ';
          break;

        case 9:
          $html .= ' width="180" height="150" ';
          break;

        case 10:
          $html .= ' width="120" height="450" ';
          break;
          
        case 11:
          $html .= ' width="120" height="600" ';
          break;

        case 12:
          $html .= ' width="300" height="250" ';
          break;

        case 13:
          $html .= ' width="468" height="60" ';
          break;
          
        case 15:
          $html .= ' width="468" height="240" ';
          break;
          
        case 16:
          $html .= ' width="468" height="336" ';
          break;
          
        case 48:
          $html .= ' width="728" height="90" ';
          break;
          
        // 14
        default;
          $html .= ' width="160" height="600" ';
        break;
    } 
    
    $html          .= '></iframe></div>';
    
} else {
	$html= $params->get('alt_message');
}

echo $html;
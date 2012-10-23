<?php
/**
 * @package      ITPrism Modules
 * @subpackage   ITPSocialSubscribe
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPSocialSubscribe is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('_JEXEC') or die;

class VipAmazonAssociateHelper {
    
    public static function getPhrases($params) {
        
        // Prepare phrases
    	$phrase         = "";
        $amazonFilter   = $params->get('amazon_filter',1);
        
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
        
        return $phrase;
        
    } 
    
    public static function getDomainOptions($amazonDomain) {
        
        $domainOptions = array(
            "domain" => "",
            "o"=>0,
            "domain_prefix" =>"",
            "domain_suffix" =>""
        );
        
        switch ( $amazonDomain ) {
    		
    		case "uk":
    			
    			$domainOptions["domain"] = 'http://rcm-uk.amazon.co.uk';
                $domainOptions["domain_suffix"] = "-uk";
                $domainOptions["o"] = 2;
                
    			break;
    		
    	   case "de":
                
                $domainOptions["domain"] = 'http://rcm-de.amazon.de';
                $domainOptions["domain_suffix"] = "-de";
                $domainOptions["o"] = 3;
                
                break;
           
           case "fr":
                
                $domainOptions["domain"] = 'http://rcm-fr.amazon.fr';
                $domainOptions["domain_suffix"] = "-fr";
                $domainOptions["o"] = 8;
                break;
                
           case "jp":
                
                $domainOptions["domain"] = 'http://rcm-jp.amazon.co.jp';
                $domainOptions["domain_suffix"] = "-jp";
                $domainOptions["o"] = 5;
                
                break;    
    
           case "ca":
                
                $domainOptions["domain"] = 'http://rcm-ca.amazon.ca';
                $domainOptions["domain_suffix"] = "-ca";
                $domainOptions["o"] = 15;
                
                break;  
                
           case "it":
                
                $domainOptions["domain"] = 'http://rcm-it.amazon.it';
                $domainOptions["domain_prefix"] = "it_";
                $domainOptions["o"] = 29;
                break;
                          
    	   // United State
    		default:
    			$domainOptions["domain"] = 'http://rcm.amazon.com';
    			$domainOptions["domain_suffix"] = "";
    			$domainOptions["o"] = 1;
    			break;
    			
    	}
    	
    	return $domainOptions;
    }
    
    public static function getPrice($amazonPrice) {
        
        $price = "";
        
        switch ( $amazonPrice ) {
    		case "nou":
    			$price = "&amp;nou=1";
    			break;
    	    case "npa":
    	    	$price = "&amp;npa=1";
                break;
    		default:
    			break;
	    }
	    
	    return $price;
    }
    
    public static function getSize($amazonDomain, $amazonSize) {
        
        switch($amazonDomain) {
            
            case "it":
                $p = array(13=>26, 11=>29);
                if(array_key_exists($amazonSize, $p)) {
                    $amazonSize = JArrayHelper::getValue($p, $amazonSize, 0);
                }
                break;

            case "co.uk":
                $p = array(13=>26);
                $amazonSize = JArrayHelper::getValue($p, $amazonSize, 0);
                break;
            default: // .com
                
                break;
        }
        
        return $amazonSize;
    }
    
    public static function getSizeParameters($amazonSize) {
        
        $sizes = array(
            6  => ' width="120" height="150" ',
            8  => ' width="120" height="240" ',
            9  => ' width="180" height="150" ',
            10 => ' width="120" height="450" ',
            11 => ' width="120" height="600" ',
            12 => ' width="300" height="250" ',
            13 => ' width="468" height="60" ', 
            14 => ' width="160" height="600" ',
            15 => ' width="468" height="240" ',
            16 => ' width="468" height="336" ',
            20 => ' width="120" height="90" ', // it
            31 => ' width="120" height="212" ', // co.uk, de
            32 => ' width="180" height="450" ', // de
            33 => ' width="150" height="170" ', // co.uk, de
            36 => ' width="600" height="520" ', // co.uk
            37 => ' width="120" height="170" ', // de
            42 => ' width="728" height="90" ', // it
            48 => ' width="728" height="90" ',
            286 => ' width="200" height="200" ', // co.uk, de, fr
            
        );
        
        $sizeParameters = JArrayHelper::getValue($sizes, $amazonSize, ' width="160" height="600" ');
        
        return $sizeParameters;
        
    }
}
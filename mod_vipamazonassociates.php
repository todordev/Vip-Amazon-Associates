<?php
/**
 * @package      ITPrism Modules
 * @subpackage   Vip Amazon Associates
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor.iliev@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * Vip Amazon Associates is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die; // no direct access 

$ips           = $params->get('blocked_ips');
$blockedIps    = explode(",",$ips);
$blockedIps    = array_map('trim', explode(',', $ips)); 
$remoteAddress = JArrayHelper::getValue($_SERVER, "REMOTE_ADDR");

if (!in_array($remoteAddress, $blockedIps)) {

    $moduleClassSfx = htmlspecialchars($params->get('moduleclass_sfx'));
    
    if($params->get("display_banner", 1)) {
        JLoader::register('VipAmazonAssociateHelper', dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');
        
    	$amazonTrackingId  = $params->get('amazon_tracking_id', 'fullmotivation-20');
    	$amazonCategory    = $params->get('amazon_category', 'books');
    	$amazonBehavior    = $params->get('amazon_behavior', '_top');
    	$amazonPrices      = $params->get('amazon_price_options', '');
    	$amazonDomain      = $params->get('amazon_domain', 'us');
    	
    	$amazonBgColor     = $params->get('amazon_bg_colour', '080808');
    	$amazonTextColor   = $params->get('amazon_text_colour', 'FFFFFF');
    	$amazonLinkColor   = $params->get('amazon_link_colour', '3366FF');
    	
    	// Get banner code
    	$amazonBannerCode  = JString::trim($params->get('amazon_bannercode'));
        if(!empty($amazonBannerCode) AND (strcmp("it", $amazonDomain) == 0)) {
            $amazonBannerCode = "&amp;banner=".$amazonBannerCode;
        } else {
            $amazonBannerCode = ""; 
        }
    	
    	// Get align
        $amazonAlign       = $params->get('amazon_align', 'center');
        if(!empty($amazonAlign)) {
            $amazonAlign = "itp_va_".$amazonAlign;
        }
        
    	// Get size
    	$amazonSize        = $params->get('amazon_size', 8);
    	$amazonSize        = VipAmazonAssociateHelper::getSize($amazonDomain, $amazonSize);
    	
    	$phrase            = VipAmazonAssociateHelper::getPhrases($params);
    	$domainOptions     = VipAmazonAssociateHelper::getDomainOptions($amazonDomain);
    	$price             = VipAmazonAssociateHelper::getPrice($amazonPrices);
    	$sizeParameters    = VipAmazonAssociateHelper::getSizeParameters($amazonSize);
    	
        if($params->get("load_css", 1)) {
            $doc = JFactory::getDocument();
			/** $doc JDocumentHTML **/
            $doc->addStyleSheet("modules/mod_vipamazonassociates/style.css");
        }

    }
    
    require JModuleHelper::getLayoutPath('mod_vipamazonassociates', $params->get('layout', 'default'));
	
} else {
	echo htmlspecialchars($params->get('alt_message'));
}


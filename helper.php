<?php
/**
 * @package      ITPrism
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

class VipAmazonAssociateHelper
{
    /**
     * @param Joomla\Registry\Registry $params
     *
     * @return mixed|string
     */
    public static function getPhrases($params)
    {
        // Prepare phrases
        $phrase       = "";
        $amazonFilter = $params->get('amazon_filter', 1);

        switch ($amazonFilter) {
            // Keywords in meta tag
            case 1:
                $doc      = JFactory::getDocument();
                $keywords = $doc->getMetaData("keywords");
                if (!empty($keywords)) {
                    $keywords = explode(",", $keywords);

                    if (!empty($keywords)) {
                        $phrase = $keywords[array_rand($keywords)];
                    }
                }
                break;

            // Title
            case 2:

                $doc = JFactory::getDocument();
                $phrase = $doc->getTitle();

                break;

            // Your keywords
            default:

                $keywords = $params->get('amazon_keywords', 'joomla');
                if (!empty($keywords)) {
                    $keywords = explode(",", $keywords);

                    if (!empty($keywords)) {
                        $phrase = $keywords[array_rand($keywords)];
                    }
                }
                break;
        }

        $phrase = JString::trim($phrase);
        $phrase = JString::strtolower($phrase);

        return $phrase;

    }

    public static function getDomainOptions($amazonDomain)
    {

        $domainOptions = array(
            "domain"        => "",
            "o"             => 0,
            "domain_prefix" => "",
            "domain_suffix" => ""
        );

        switch ($amazonDomain) {

            case "uk":

                $domainOptions["domain"]        = 'http://rcm-eu.amazon-adsystem.com';
                $domainOptions["domain_suffix"] = "-uk";
                $domainOptions["o"]             = 2;

                break;

            case "fr":

                $domainOptions["domain"]        = 'http://rcm-eu.amazon-adsystem.com';
                $domainOptions["domain_suffix"] = "-fr";
                $domainOptions["o"]             = 8;
                break;


            case "ca":

                $domainOptions["domain"]        = 'http://rcm-na.amazon-adsystem.com';
                $domainOptions["domain_suffix"] = "-ca";
                $domainOptions["o"]             = 15;

                break;

            // United State
            default:
                $domainOptions["domain"]        = 'http://rcm-na.amazon-adsystem.com';
                $domainOptions["domain_suffix"] = "";
                $domainOptions["o"]             = 1;
                break;
        }

        return $domainOptions;
    }

    public static function getPrice($amazonPrice)
    {

        $price = "";

        switch ($amazonPrice) {
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

    public static function getSize($amazonDomain, $amazonSize)
    {

        switch ($amazonDomain) {

            case "co.uk":
                $p          = array(13 => 26);
                $amazonSize = JArrayHelper::getValue($p, $amazonSize, 0);
                break;
            default: // .com

                break;
        }

        return $amazonSize;
    }

    public static function getSizeParameters($amazonSize)
    {

        $sizes = array(
            6   => ' width="120" height="150" ',
            8   => ' width="120" height="240" ',
            9   => ' width="180" height="150" ',
            10  => ' width="120" height="450" ',
            11  => ' width="120" height="600" ',
            12  => ' width="300" height="250" ',
            13  => ' width="468" height="60" ',
            14  => ' width="160" height="600" ',
            15  => ' width="468" height="240" ',
            16  => ' width="468" height="336" ',
            31  => ' width="120" height="212" ', // co.uk, de
            33  => ' width="150" height="170" ', // co.uk, de
            36  => ' width="600" height="520" ', // co.uk
            48  => ' width="728" height="90" ',
            286 => ' width="200" height="200" ', // co.uk, de, fr

        );

        $sizeParameters = JArrayHelper::getValue($sizes, $amazonSize, ' width="160" height="600" ');

        return $sizeParameters;

    }
}

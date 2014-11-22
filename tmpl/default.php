<?php
/**
 * @package      ITPrism Modules
 * @subpackage   VipAmazon Associate
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="vip-amazon <?php echo $moduleClassSfx; ?> <?php echo $amazonAlign; ?>">
    <?php if ($params->get("display_banner", 1)) { ?>
        <iframe
            src="<?php echo $domainOptions["domain"]; ?>/e/cm?t=<?php echo $amazonTrackingId; ?><?php echo $price; ?>&amp;o=<?php echo $domainOptions["o"]; ?>&amp;p=<?php echo $amazonSize; ?>&amp;l=st1&amp;mode=<?php echo $domainOptions["domain_prefix"] . $amazonCategory . $domainOptions["domain_suffix"]; ?>&amp;search=<?php echo rawurlencode($phrase); ?>&amp;fc1=<?php echo $amazonTextColor; ?>&amp;lt1=<?php echo $amazonBehavior; ?>&amp;lc1=<?php echo $amazonLinkColor; ?>&amp;bg1=<?php echo $amazonBgColor; ?>&amp;f=ifr<?php echo $amazonBannerCode; ?>"
            marginwidth="0" marginheight="0" border="0"
            frameborder="0"
            style="border: none;"
            scrolling="no"
            <?php echo $sizeParameters; ?>
            ></iframe>
    <?php
    }

    echo $params->get("customcode");
    ?>
</div>

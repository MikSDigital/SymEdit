<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Twig\Extension;

use SymEdit\Bundle\SettingsBundle\Model\Settings;

class SettingsBundleExtension extends \Twig_Extension
{
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('symedit_settings_get', array($this, 'getSetting')),
            new \Twig_SimpleFunction('symedit_settings_has', array($this, 'hasSetting')),
            new \Twig_SimpleFunction('symedit_settings_default', array($this, 'defaultSetting')),
        );
    }

    public function getSetting($offset)
    {
        return $this->settings->get($offset);
    }

    public function hasSetting($offset)
    {
        return $this->settings->has($offset);
    }

    public function defaultSetting($offset, $default = null)
    {
        return $this->hasSetting($offset) ? $this->getSetting($offset) : $default;
    }

    public function getName()
    {
        return 'SettingsBundleExtension';
    }
}

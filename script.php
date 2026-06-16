<?php
/*
 *  package: Custom Fields - Youtube plugin - FREE Version
 *  copyright: Copyright (c) 2026. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

// No direct access.
\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\Database\DatabaseInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->set(
            InstallerScriptInterface::class,
            new class ($container->get(DatabaseInterface::class)) implements InstallerScriptInterface {
                /**
                 * Minimum Joomla version required to install the extension.
                 */
                private string $minimumJoomlaVersion = '5.0';

                /**
                 * Minimum PHP version required to install the extension.
                 */
                private string $minimumPhpVersion = JOOMLA_MINIMUM_PHP;

                public function __construct(private DatabaseInterface $db)
                {
                }

                public function install(InstallerAdapter $adapter): bool
                {
                    return true;
                }

                public function update(InstallerAdapter $adapter): bool
                {
                    return true;
                }

                public function uninstall(InstallerAdapter $adapter): bool
                {
                    return true;
                }

                public function preflight(string $route, InstallerAdapter $adapter): bool
                {
                    try {
                        if ($route === 'uninstall') {
                            return true;
                        }

                        if (!empty($this->minimumPhpVersion) && version_compare(PHP_VERSION, $this->minimumPhpVersion, '<')) {
                            Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_PHP', $this->minimumPhpVersion), Log::WARNING, 'jerror');

                            return false;
                        }

                        if (!empty($this->minimumJoomlaVersion) && version_compare(JVERSION, $this->minimumJoomlaVersion, '<')) {
                            Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomlaVersion), Log::WARNING, 'jerror');

                            return false;
                        }

                        return true;
                    } catch (\Exception $e) {
                        Log::add('Error during preflight check: ' . $e->getMessage(), Log::ERROR, 'youtube');

                        return false;
                    }
                }

                public function postflight(string $route, InstallerAdapter $adapter): bool
                {
                    try {
                        $this->loadInstallLanguage();

                        if ($route === 'install') {
                            $this->enablePlugin();
                            $this->printInstallMessage();
                        }

                        if ($route === 'uninstall') {
                            $this->printUninstallMessage();
                        }

                        return true;
                    } catch (\Exception $e) {
                        Log::add('Error during postflight: ' . $e->getMessage(), Log::ERROR, 'youtube');

                        return true;
                    }
                }

                private function loadInstallLanguage(): void
                {
                    $language = Factory::getApplication()->getLanguage();
                    $language->load('plg_fields_youtube.sys', JPATH_ADMINISTRATOR)
                        || $language->load('plg_fields_youtube.sys', JPATH_PLUGINS . '/fields/youtube');
                }

                private function enablePlugin(): void
                {
                    try {
                        $query = $this->db->getQuery(true)
                            ->update($this->db->quoteName('#__extensions'))
                            ->set($this->db->quoteName('enabled') . ' = ' . $this->db->quote(1))
                            ->where($this->db->quoteName('type') . ' = ' . $this->db->quote('plugin'))
                            ->where($this->db->quoteName('folder') . ' = ' . $this->db->quote('fields'))
                            ->where($this->db->quoteName('element') . ' = ' . $this->db->quote('youtube'));
                        $this->db->setQuery($query);
                        $this->db->execute();
                    } catch (\Exception $e) {
                        return;
                    }
                }

                private function printInstallMessage(): void
                {
                    echo '<style>a[target="_blank"]::before {display: none;}</style>';
                    echo '<div class="mb-3 text-center"><img src="https://www.joomill-extensions.com/images/joomill-logo.png" alt="Joomill Extensions" /></div>';
                    echo '<div class="mb-3 text-center">' . Text::_('PLG_FIELDS_YOUTUBE_THANKYOU') . '</div>';
                    echo '<br>';
                    echo '<h3>' . Text::_('PLG_FIELDS_YOUTUBE_INSTALL_QUICKSTART') . ':</h3>';
                    echo '<ul>';
                    echo '<li><a style="text-decoration: underline;" href="index.php?option=com_plugins&view=plugins&filter[folder]=fields&filter[element]=youtube" target="_blank">' . Text::_('PLG_FIELDS_YOUTUBE_INSTALL_CONFIGURATION') . '</a></li>';
                    echo '<li><a style="text-decoration: underline;" href="https://www.joomill-extensions.com/documentation/custom-fields-plugins/youtube-configuration" target="_blank">' . Text::_('PLG_FIELDS_YOUTUBE_INSTALL_NEEDHELP') . '</a></li>';
                    echo '</ul>';
                    echo '<hr>';
                    echo '<div class="text-center">' . Text::_('PLG_FIELDS_YOUTUBE_FOLLOWME') . ':</div>';
                    echo $this->socialIcons();
                }

                private function printUninstallMessage(): void
                {
                    echo '<style>a[target="_blank"]::before {display: none;}</style>';
                    echo '<div class="mb-3 text-center"><img src="https://www.joomill-extensions.com/images/joomill-logo.png" alt="Joomill Extensions" /></div>';
                    echo '<br>';
                    echo '<h3 class="text-center">' . Text::_('PLG_FIELDS_YOUTUBE_THANKYOU') . '</h3>';
                    echo '<br>';
                    echo '<div class="text-center">' . Text::_('PLG_FIELDS_YOUTUBE_FOLLOWME') . ':</div>';
                    echo $this->socialIcons();
                }

                private function socialIcons(): string
                {
                    return '<div class="text-center">'
                        . '<a class="m-2" href="https://www.linkedin.com/in/jeroenmoolenschot/" target="_blank"><i class="fa-brands fa-linkedin"> </i></a>'
                        . '<a class="m-2" href="https://www.facebook.com/Joomill" target="_blank"><i class="fa-brands fa-facebook-f"> </i></a>'
                        . '<a class="m-2" href="https://www.instagram.com/Joomill" target="_blank"><i class="fa-brands fa-instagram"> </i></a>'
                        . '<a class="m-2" href="https://bsky.app/profile/joomill.bsky.social" target="_blank"><i class="fa-brands fa-bluesky"> </i></a>'
                        . '<a class="m-2" href="https://joomla.social/@joomill" target="_blank"><i class="fa-brands fa-mastodon"> </i></a>'
                        . '<a class="m-2" href="https://www.threads.net/@joomill" target="_blank"><i class="fa-brands fa-threads"> </i></a>'
                        . '<a class="m-2" href="https://www.twitter.com/Joomill" target="_blank"><i class="fa-brands fa-x-twitter"> </i></a>'
                        . '<a class="m-2" href="https://community.joomla.org/service-providers-directory/listings/67:joomill.html" target="_blank"><i class="fa-brands fa-joomla"> </i></a>'
                        . '</div>';
                }
            }
        );
    }
};

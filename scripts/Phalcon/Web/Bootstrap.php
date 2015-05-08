<?php

/*
  +------------------------------------------------------------------------+
  | Phalcon Developer Tools                                                |
  +------------------------------------------------------------------------+
  | Copyright (c) 2011-2015 Phalcon Team (http://www.phalconphp.com)       |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file docs/LICENSE.txt.                        |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Authors: Andres Gutierrez <andres@phalconphp.com>                      |
  |          Eduar Carvajal <eduar@phalconphp.com>                         |
  |          Serghei Iakovlev <sadhooklay@gmail.com>                       |
  +------------------------------------------------------------------------+
*/

namespace Phalcon\Web;

/**
 * Bootstrap Installer
 *
 * Install/Uninstall Twitter Bootstrap resources
 *
 * @package     Phalcon\Web
 * @copyright   Copyright (c) 2011-2015 Phalcon Team (team@phalconphp.com)
 * @license     New BSD License
 */
class Bootstrap implements InstallerInterface
{
    /**
     * Install Twitter Bootstrap resources
     *
     * @param  string $path Project root path
     * @return $this
     */
    public function install($path)
    {
        // Set paths
        $bootstrapRoot = realpath(__DIR__ . '/../../../') . '/resources/bootstrap';
        $jsBootstrapDir = $path . 'public/js/bootstrap';
        $css = $path . 'public/css/bootstrap';
        $img = $path . 'public/img/bootstrap';

        // Install bootstrap
        if (!is_dir($jsBootstrapDir)) {
            mkdir($jsBootstrapDir, 0777, true);
            touch($jsBootstrapDir . '/index.html');
            copy($bootstrapRoot . '/js/bootstrap.min.js', $jsBootstrapDir . '/bootstrap.min.js');
        }

        if (!is_dir($css)) {
            mkdir($css, 0777, true);
            touch($css . '/index.html');
            copy($bootstrapRoot . '/css/bootstrap.min.css', $css . '/bootstrap.min.css');
            copy($bootstrapRoot . '/css/bootstrap-responsive.min.css', $css . '/bootstrap-responsive.min.css');
        }

        if (!is_dir($img)) {
            mkdir($img, 0777, true);
            touch($img . '/index.html');
            copy($bootstrapRoot . '/img/glyphicons-halflings.png', $img . '/glyphicons-halflings.png');
        }

        return $this;
    }

    /**
     * Uninstall Twitter Bootstrap resources
     *
     * @param  string $path Project root path
     * @return $this
     */
    public function uninstall($path)
    {
        $js  = $path . 'public/js';
        $css = $path . 'public/css';
        $img = $path . 'public/img';

        $installed = array(

            // Files:
            $js . '/bootstrap/bootstrap.min.js',
            $js . '/bootstrap/index.html',
            $css . '/bootstrap/bootstrap.min.css',
            $css . '/bootstrap/bootstrap-responsive.min.css',
            $css . '/bootstrap/index.html',
            $img . '/bootstrap/glyphicons-halflings.png',
            $img . '/bootstrap/index.html',

            // Sub-directories:
            $js . '/bootstrap',
            $css . '/bootstrap',
            $img . '/bootstrap',

            // Directories:
            $js,
            $css,
            $img
        );

        foreach ($installed as $file) {
            if (is_file($file)) {
                unlink($file);
            } elseif (is_dir($file)) {
                // Check if other files were not added
                if (count(glob($file . '/*')) === 0) {
                    rmdir($file);
                }
            }
        }

        return $this;
    }
}

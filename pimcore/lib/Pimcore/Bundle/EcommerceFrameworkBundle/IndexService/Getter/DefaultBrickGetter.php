<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Bundle\EcommerceFrameworkBundle\IndexService\Getter;

class DefaultBrickGetter implements IGetter
{
    public static function get($object, $config = null)
    {
        $brickContainerGetter = 'get' . ucfirst($config->brickfield);
        $brickContainer = $object->$brickContainerGetter();

        $brickGetter = 'get' . ucfirst($config->bricktype);
        $brick = $brickContainer->$brickGetter();
        if ($brick) {
            $fieldGetter = 'get' . ucfirst($config->fieldname);

            return $brick->$fieldGetter();
        }
    }
}

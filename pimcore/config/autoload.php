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
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/** @var $loader \Composer\Autoload\ClassLoader */
$loader = require PIMCORE_COMPOSER_PATH . '/autoload.php';

// tell the autoloader where to find Pimcore's generated class stubs
// this is primarily necessary for tests and custom class directories, which are not covered in composer.json
$loader->addPsr4('Pimcore\\Model\\Object\\', PIMCORE_CLASS_DIRECTORY . '/Object');

// the following code is out of `app/autoload.php`
// see also: https://github.com/symfony/symfony-demo/blob/master/app/autoload.php
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

// ignore apiDoc params (see http://apidocjs.com/) as we use apiDoc in webservice
$apiDocAnnotations = [
    'api', 'apiDefine',
    'apiDeprecated', 'apiDescription', 'apiError',  'apiErrorExample', 'apiExample', 'apiGroup', 'apiHeader',
    'apiHeaderExample', 'apiIgnore', 'apiName', 'apiParam', 'apiParamExample', 'apiPermission', 'apiSampleRequest',
    'apiSuccess', 'apiSuccessExample', 'apiUse', 'apiVersion',
];

foreach ($apiDocAnnotations as $apiDocAnnotation) {
    AnnotationReader::addGlobalIgnoredName($apiDocAnnotation);
}

// some pimcore specific generic includes
// includes not covered by composer autoloader
require_once PIMCORE_PATH . '/lib/helper-functions.php';
require_once PIMCORE_PATH . '/lib/Pimcore.php';

if (defined('PIMCORE_APP_BUNDLE_CLASS_FILE')) {
    require_once PIMCORE_APP_BUNDLE_CLASS_FILE;
}

if (!class_exists('Zend_Date')) {
    // if ZF is not loaded, we need to provide some compatibility stubs
    // for a detailed description see the included file
    require_once PIMCORE_PATH . '/lib/compatibility-stubs.php';
}

\Pimcore::setAutoloader($loader);

return $loader;

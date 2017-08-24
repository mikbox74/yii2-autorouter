<?php

/**
 * @link http://github.com/mikbox74
 * @copyright Copyright (c) 2017 Michail Urakov
 * @license MIT
 */

namespace mikbox74\Autorouter;

/**
 *
 * @author Michail Urakov <mikbox74@gmail.com>
 */
interface AutorouterInterface {

    /**
     * The method must return a rules array for adding in config components.urlManager.rules
     * @return array
     */
    public static function getUrlRules();
}

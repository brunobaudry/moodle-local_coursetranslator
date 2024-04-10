<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace local_coursetranslator\data;

use DeepL\Translator;

require_once(__DIR__ . '/../vendor/autoload.php');

/**
 * Language helper.
 *
 * Stores the source and target languages aswell as preparing arrays of verbose or code options for selects.
 *
 *
 * @package    local_coursetranslator
 * @copyright  2024 Bruno Baudry <bruno.baudry@bfh.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lang_helper {
    /**
     * @var string
     */
    static protected $DEEPLPRO = 'https://api.deepl.com/v2/translate?';
    /**
     * @var string
     */
    static protected $DEEPLFREE = 'https://api-free.deepl.com/v2/translate?';
    /** @var String */
    public mixed $currentlang;
    /** @var String */
    public mixed $targetlang;
    /**
     * @var array|mixed
     */
    public mixed $langs;
    /**
     * @var array|mixed
     */
    public mixed $langcodes;
    /**
     * @var String
     */
    private mixed $apikey;
    /**
     * @var Translator
     */
    private mixed $translator;
    /**
     * @var object
     */
    private mixed $deeplsources;
    /**
     * @var object
     */
    private mixed $deepltargets;

    /**
     * Constructor
     *
     * @throws \coding_exception
     */
    public function __construct() {
        $this->apikey = get_config('local_coursetranslator', 'apikey');
        $this->translator = new \DeepL\Translator($this->apikey);
        $this->deeplsources = $this->translator->getSourceLanguages();
        $this->deepltargets = $this->translator->getTargetLanguages();
        $this->langs = get_string_manager()->get_list_of_translations();
        $this->currentlang = optional_param('lang', current_language(), PARAM_NOTAGS);
        $this->targetlang = optional_param('target_lang', 'en', PARAM_NOTAGS);
    }

    /**
     * Build properties
     *
     * @return void
     */
    /**
     * @param bool $issource
     * @return void
     */
    private function makecodelists(bool $issource = true) {
        $this->langcodes = [];
        $this->translatablelangcodes = [];

        foreach ($this->langs as $key => $lang) {
            array_push($this->langcodes, $key);
            if (in_array($key, $this->supportedlangs)) {
                array_push($this->translatablelangcodes, $key);
            }
        }
    }

    /**
     * creates props for selects.
     *
     * @param bool $issource
     * @param bool $verbose
     * @param bool $fromdeepls
     * @return array
     */
    public function prepareoptionlangs(bool $issource, bool $verbose = true) {
        $tab = [];
        $langs = $this->langs;
        foreach ($langs as $k => $l) {
            $disable = $issource ? $k === $this->targetlang : $k === $this->currentlang;
            $selected = $issource ? $k === $this->currentlang : $k === $this->targetlang;
            $disable = $disable || !$this->islangsupported($k, $issource);
            array_push($tab, [
                    'code' => $k,
                    'lang' => $verbose ? $l : $k,
                    'selected' => $selected ? 'selected' : '',
                    'disabled' => $disable ? 'disabled' : '',
            ]);
        }
        return $tab;
    }

    /**
     * Create HTML props for select.
     *
     * @param bool $issource
     * @param bool $verbose
     * @param bool $fromdeepls
     * @return string
     * @todo MDL-0000 allow regional languages setup (expl EN-GB)
     */
    public function preparehtmlotions(bool $issource, bool $verbose = true) {
        $tab = $this->prepareoptionlangs($issource, $verbose);
        $list = '';
        foreach ($tab as $item) {
            $list .= "<option value='{$item['code']}' {$item['selected']} {$item['disabled']} data-initial-value='{$item['code']}'>
                    {$item['lang']}</option>";
        }
        return $list;
    }

    /**
     * Injects lang attributes to the config object.
     *
     * @param object $config
     * @return object
     * @throws \DeepL\DeepLException
     * @throws \dml_exception
     */
    public function addlangproperties(object &$config) {
        $config->apikey = $this->apikey;
        $config->usage = $this->translator->getUsage();
        $config->limitReached = $config->usage->anyLimitReached();
        $config->lang = $this->targetlang;
        $config->currentlang = $this->currentlang;
        $config->deeplurl = boolval(get_config('local_coursetranslator', 'deeplpro')) ? self::$DEEPLPRO : self::$DEEPLFREE;
        return $config;
    }

    /**
     * Checks if a given lang is supported by Deepl
     *
     * @param string $lang
     * @param bool $issource
     * @param bool $strict
     * @return bool
     */
    private function islangsupported(string $lang, bool $issource, bool $strict = false) {
        $list = $issource ? $this->deeplsources : $this->deepltargets;
        $len = count($list);
        while ($len--) {
            $code = $strict ? $list[$len]->code : substr($list[$len]->code, 0, 2);
            if ($code === $lang || $code === strtoupper($lang)) {
                return true;
            }
        }
        return false;
    }
}

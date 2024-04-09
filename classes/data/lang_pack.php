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
/**
 * Language helper.
 * Stores the source and target languages aswell as preparing arrays of versbos or code options for selects.
 */
class lang_pack {
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
     * @var array|mixed
     */
    public mixed $translatablelangs;
    /**
     * @var array|mixed
     */
    public mixed $translatablelangcodes;
    /**
     * @var array|mixed
     */
    private mixed $supportedlangs;

    /**
     * @throws \coding_exception
     */
    public function __construct() {
        $this->translatablelangs = $this->langs = get_string_manager()->get_list_of_translations();
        $this->currentlang = optional_param('lang', current_language(), PARAM_NOTAGS);
        $this->targetlang = optional_param('target_lang', 'en', PARAM_NOTAGS);
        $this->supportedlangs = explode(',', get_string('supported_languages', 'local_coursetranslator'));
        $this->makeCodeLists();
    }

    /**
     * Build properties
     *
     * @return void
     */
    private function makecodelists() {
        $this->langcodes = [];
        $this->translatablelangcodes = [];

        foreach ($this->langs as $key => $lang) {
            array_push($this->langcodes, $key);
            if (in_array($key, $this->supportedlangs)) {
                array_push($this->translatablelangcodes, $key);
            } else {
                unset($this->translatablelangs[$key]);
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
    public function prepareoptionlangs(bool $issource, bool $verbose = true, bool $fromdeepls = true) {
        $tab = [];
        $langs = $fromdeepls ? $this->translatablelangs : $this->langs;
        foreach ($langs as $k => $l) {
            $disable = $issource ? $k === $this->targetlang : $k === $this->currentlang;
            $selected = $issource ? $k === $this->currentlang : $k === $this->targetlang;
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
     */
    public function preparehtmlotions(bool $issource, bool $verbose = true, bool $fromdeepls = true) {
        $tab = $this->prepareoptionlangs($issource, $verbose, $fromdeepls);
        $list = '';
        foreach ($tab as $item) {
            $list .= "<option value='{$item['code']}' {$item['selected']} {$item['disable']} data-initial-value='{$item['code']}'>
                    {$item['lang']}</option>";
        }
        return $list;
    }
}

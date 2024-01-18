export default {
    actions: {
        validatorsBtns: '[data-key-validator]',
        validator: '[data-key-validator="<KEY>"]',
        validatorIcon: '[data-key-validator="<KEY>"] i',
        checkBoxes: '[data-action="local-coursetranslator/checkbox"]',
        selectAllBtn: '[data-action="local-coursetranslator/select-all"]',
        autoTranslateBtn: '[data-action="local-coursetranslator/autotranslate-btn"]',
        targetSwitcher: '[data-action="local-coursetranslator/target-switcher"]',
        sourceSwitcher: '[data-action="local-coursetranslator/source-switcher"]',
        showNeedUpdate: '[data-action="local-coursetranslator/show-needsupdate"]',
        showUpdated: '[data-action="local-coursetranslator/show-updated"]',
        toggleMultilang: '#toggleMultilang'
    },
    statuses: {
        checkedCheckBoxes: '[data-action="local-coursetranslator/checkbox"]:checked',
        updated: '[data-status="updated"]',
        needsupdate: '[data-status="needsupdate"]',
        keys: '[data-status-key="<KEY>"',
        successMessages: '[data-status="local-coursetranslator/success-message"][data-key="<KEY>"]'
    },
    editors: {
        textarea: '[data-action="local-coursetranslator/textarea"',
        all: '[data-action="local-coursetranslator/editor"]',
        iframes: '[data-action="local-coursetranslator/editor"] iframe',
        contentEditable: '[data-action="local-coursetranslator/editor"] [contenteditable="true"]',
        multiples: {
            checkBoxesWithKey: 'input[type="checkbox"][data-key="<KEY>"]',
            editorChilds: '[data-action="local-coursetranslator/editor"][data-key="<KEY>"] > *',
            textAreas: '[data-action="local-coursetranslator/textarea"][data-key="<KEY>"]',
            editorsWithKey: '[data-action="local-coursetranslator/editor"][data-key="<KEY>"]',
            contentEditableKeys: '[data-key="<KEY>"] [contenteditable="true"]'
        },
        types: {
            basic: '[data-action="local-coursetranslator/editor"][data-key="<KEY>"] [contenteditable="true"]',
            atto: '[data-action="local-coursetranslator/editor"][data-key="<KEY>"] [contenteditable="true"]',
            other: '[data-action="local-coursetranslator/editor"][data-key="<KEY>"] textarea[name="<KEY>[text]"]',
            tiny: '[data-action="local-coursetranslator/editor"][data-key="<KEY>"] iframe'
        }
    },
    sourcetexts: {
        keys: '[data-sourcetext-key="<KEY>"]',
        multilangs: '#<KEY>',
        parentrow: '[data-row-id="<KEY>"]'
    },
    deepl: {
        context: '[data-id="local-coursetranslator/context"]',
        nonSplittingTags: '[data-id="local-coursetranslator/non_splitting_tags"]',
        splittingTags: '[data-id="local-coursetranslator/splitting_tags"]',
        ignoreTags: '[data-id="local-coursetranslator/ignore_tags"]',
        preserveFormatting: '[data-id="local-coursetranslator/preserve_formatting"]',
        formality: '[name="local-coursetranslator/formality"]:checked',
        glossaryId: '[data-id="local-coursetranslator/glossary_id"]',
        tagHandling: '[data-id="local-coursetranslator/tag_handling"]',
        outlineDetection: '[data-id="local-coursetranslator/outline_detection"]',
        splitSentences: '[name="local-coursetranslator/split_sentences"]:checked'
    }
};

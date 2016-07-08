module.exports = {
    "plugins": [
        "stylelint-statement-max-nesting-depth"
    ],
    "rules": {
        "block-no-empty": true,
        "color-no-invalid-hex": true,
        "max-empty-lines": 5,
        "number-leading-zero": "never",
        "declaration-block-trailing-semicolon": "always",
        "selector-list-comma-space-before": "never",
        "selector-no-id": true,
        "statement-max-nesting-depth": [4, { countAtRules: false }],
    }
};
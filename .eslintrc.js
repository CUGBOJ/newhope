module.exports = {
    env: { es6: true, amd: true, browser: true },
    extends: ['plugin:vue/essential', 'eslint:recommended'],
    rules: {
        'strict': 0,
        'semi': ['error', 'never'],
        'indent': ['error', 4],
        'quotes': ['error', 'single'],
        'brace-style': ['error', '1tbs'],
        'quote-props': ['error', 'consistent-as-needed'],
        'comma-dangle': ['error', 'never'],
        'comma-style': ['error', 'last'],
        'space-before-blocks': ['error', 'always'],
        'array-bracket-spacing': ['error', 'never'],
        'object-curly-spacing': ['error', 'never'],
        'object-curly-newline': ['error', {'ObjectExpression': {minProperties: 1}, 'ImportDeclaration': 'never'}],
        'object-property-newline': ['error', {allowAllPropertiesOnSameLine: false}],
        'keyword-spacing': ['error', {'before': true, 'after': true}],
        'key-spacing': ['error', {afterColon: true}],
        'arrow-spacing': ['error', {'before': true, 'after': true}],
        'space-infix-ops': ['error', {'int32Hint': false}],
        'vue/no-parsing-error': [
            'error',
            {
                'x-invalid-end-tag': false
            }
        ]
    },
    globals: {
        Vue: true
    },
    parserOptions: {
        parser: 'babel-eslint'
    }
}

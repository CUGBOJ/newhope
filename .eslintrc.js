module.exports = {
    env: { es6: true, amd: true, browser: true },
    extends: ['plugin:vue/essential', 'eslint:recommended'],
    rules: {
        'strict': 0,
        'semi': ['error', 'never'],
        'indent': ['error', 4],
        'quotes': ['error', 'single'],
        'quote-props': ['error', 'consistent-as-needed'],
        'comma-dangle': ['error', 'never'],
        'space-before-blocks': ['error', 'always'],
        'keyword-spacing': ['error', {'before': true, 'after': true}],
        'key-spacing': ['error', { afterColon: true }],
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

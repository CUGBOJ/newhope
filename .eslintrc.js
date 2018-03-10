module.exports = {
    env: { es6: true, amd: true, browser: true },
    extends: ['eslint:recommended', 'plugin:vue/essential'],
    rules: {
        strict: 0,
        semi: ['error', 'never'],
        indent: ["error", 4],
        quotes: ['error', 'single'],
        'vue/no-parsing-error': [
            'error',
            {
                'x-invalid-end-tag': false
            }
        ]
    },
    globals: {
        Vue: true
    }
}

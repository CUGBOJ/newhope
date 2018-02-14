module.exports = {
    env: { es6: true, amd: true, browser: true },
    extends: ['eslint:recommended', 'plugin:vue/essential'],
    rules: {
        strict: 0,
        semi: ['error', 'never'],
        quotes: ['error', 'single']
    },
    globals: {
        Vue: true
    }
}

export default {
    root: true,
    extends: [
        '@roots/eslint-config',
        'plugin:@wordpress/eslint-plugin/recommended'
    ],
    rules: {
        'no-console': 'error',
        camelcase: ['error', {
            allow: ['^gutenbricks_archive'] // Allow global with plugin name to not be camelCased
        }],
    },
    globals: {
        "jQuery": "readonly",
        "$": "readonly",
        "gutenbricks_archive": "readonly"
    }
};

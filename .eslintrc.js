module.exports = {
	extends: ['airbnb-typescript/base'],
	parserOptions: {
        project: './tsconfig.json',
    },
    rules: {
        'no-param-reassign': ['error', { props: false }],
        'no-console': ['error', { allow: ['warn', 'error'] }],
        'no-new': 0,
    },
    env: {
        browser: true,
        jquery: true,
    },
};

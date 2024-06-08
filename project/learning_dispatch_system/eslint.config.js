import js from "@eslint/js";
import pluginVue from 'eslint-plugin-vue';
import tseslint from 'typescript-eslint';
import globals from "globals";
import vueParser from "vue-eslint-parser";

export default [
    js.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    ...tseslint.configs.recommended,
    {
        files: ['resources/js/**/*.js', 'resources/js/**/*.ts', 'resources/js/**/*.vue'],
        ignores: ["resources/js/**/consts/*.ts", "resources/js/consts/*.js", "resources/js/**/*.d.ts"],
        languageOptions: {
            parser: vueParser,
            parserOptions: { parser: tseslint.parser, sourceType: "module" },
            ecmaVersion: 2022,
            sourceType: "module",
            globals: {
                ...globals.browser,
                myCustomGlobal: "readonly"
            }
        },
        rules: {
            "no-unused-vars": "error",
            "no-undef": "error",
            "no-console": "error",
            // "camelcase": "error",
            "vue/component-tags-order": [
                "error",
                {
                  order: ["script", "template", "style"],
                },
            ],
            "vue/multi-word-component-names": ["off", {
                "ignores": []
            }],
            "vue/no-mutating-props": ["off"],
            "vue/html-self-closing": ["off"],
            "vue/max-attributes-per-line": ["off"],
            "vue/singleline-html-element-content-newline": ["off"],
        },
    }
];

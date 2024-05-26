import globals from "globals";
import pluginJs from "@eslint/js";
import pluginVue from "eslint-plugin-vue";
import eslintConfigPrettier from "eslint-config-prettier";

export default [
  {
    ignores: [
      ".config/*",
      "vendor/*",
      "var/*",
      "translations/*",
      "tests/*",
      "templates/*",
      "src/*",
      "public/*",
      "node_modules/*",
      "migrations/*",
      "docker/*",
      "config/*",
      "bin/*",
      ".github/*",
    ],
  },
  {
    languageOptions: {
      globals: {
        ...globals.browser,
        ...globals.node,
      },
    },
  },
  pluginJs.configs.recommended,
  ...pluginVue.configs["flat/essential"],
  eslintConfigPrettier,
  {
    files: ["**/*.vue"],
    rules: {
      "vue/multi-word-component-names": "off",
    },
  },
];

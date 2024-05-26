<template>
  <p :class="['text-base', 'font-semibold', ...getVariant]">
    {{ title }}
    <span class="text-base font-light text-gray-700">
      {{ text }}
    </span>
  </p>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
    },
    text: {
      type: String,
      required: true,
    },
    variant: {
      type: String,
      default: "black",
      validator: (value) => ["black", "red"].includes(value),
    },
  },
  computed: {
    getVariant() {
      return [this.variant];
    },
  },
};
</script>

<style lang="scss" scoped>
.black {
  @apply text-black;
}

.red {
  @apply text-red-500;
}
</style>

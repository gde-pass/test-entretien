<template>
  <button
    @click.prevent="() => $emit('buttonClick')"
    :class="[
      'rounded',
      'px-4',
      'py-2',
      'font-bold',
      'text-white',
      'disabled:cursor-not-allowed',
      ...getVariant,
    ]"
  >
    {{ text }}
  </button>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      required: true,
    },
    variant: {
      type: String,
      default: "blue",
      validator: (value) => ["green", "blue"].includes(value),
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
.green {
  @apply bg-green-500 hover:bg-green-700 disabled:bg-gray-400;
}

.blue {
  @apply bg-blue-500 hover:bg-blue-700 disabled:bg-gray-400;
}
</style>

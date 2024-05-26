<template>
  <div
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-5"
  >
    <div class="relative rounded-lg bg-white p-8">
      <span
        class="absolute right-3 top-1.5 cursor-pointer text-xl text-gray-500 hover:text-gray-700"
        @click.prevent="() => $emit('closeModal')"
      >
        &times;
      </span>
      <h2 class="mb-4 text-xl font-semibold">
        Veuillez saisir la raison de cette validation
      </h2>
      <input
        class="mb-4 w-full rounded-md border border-gray-300 px-3 py-2"
        type="text"
        :value="messageValidation"
        @change="
          (event) => $emit('change:message-validation', event.target.value)
        "
      />
      <div class="flex justify-center">
        <MyButton
          variant="green"
          text="Envoyer"
          @buttonClick="() => $emit('submit')"
        />
      </div>
    </div>
  </div>
</template>

<script>
import MyButton from "../atoms/MyButton.vue";

export default {
  components: {
    MyButton,
  },
  props: {
    messageValidation: {
      type: String,
      required: true,
    },
  },
};
</script>

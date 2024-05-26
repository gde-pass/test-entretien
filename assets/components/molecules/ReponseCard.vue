<template>
  <div
    :class="[
      'flex',
      'items-center',
      'justify-between',
      'border-2',
      'border-dashed',
      'px-4',
      'py-2',
      reponse.date_validation ? 'bg-green-100' : 'bg-white',
    ]"
  >
    <div>
      <LabelText
        title="Type:"
        :text="getTypeLabel(reponse.type)"
        variant="red"
      />
      <LabelText title="Titre:" :text="reponse.titre" variant="black" />
      <LabelText
        title="Description:"
        :text="reponse.description"
        variant="black"
      />
      <LabelText
        title="Date de création:"
        :text="reponse.date_creation"
        variant="black"
      />
    </div>
    <input
      :id="reponse.id"
      v-if="!reponse.date_validation"
      type="checkbox"
      class="h-6 w-6"
      :checked="isChecked"
      @change="() => $emit('checkboxChange')"
    />
  </div>
</template>

<script>
import { getLabel } from "@/enum/demande_clinique/reponse/type";
import LabelText from "../atoms/LabelText.vue";

export default {
  components: {
    LabelText,
  },
  props: {
    reponse: {
      type: Object,
      required: true,
    },
    isChecked: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    getTypeLabel: getLabel,
  },
};
</script>

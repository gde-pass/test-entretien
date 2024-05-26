<template>
  <div>
    <div class="mb-2">
      <h1 class="text-4xl font-bold">Bienvenue sur ma belle application</h1>
      <p class="text-xl">Listing des demandes cliniques</p>
    </div>
    <div class="flex w-full flex-col gap-2">
      <div
        v-for="depot in depots"
        :key="depot.id"
        class="rounded-xl bg-white p-4 shadow-sm"
      >
        <p class="text-base font-semibold">
          Titre:
          <span class="text-base font-light text-gray-700">
            {{ depot.titre }}
          </span>
        </p>
        <p class="text-base font-semibold">
          Description:
          <span class="text-base font-light text-gray-700">
            {{ depot.description }}
          </span>
        </p>
        <p class="text-base font-semibold">
          Date de création:
          <span class="text-base font-light text-gray-700">
            {{ depot.date_creation }}
          </span>
        </p>
        <div
          class="border-gray my-4 flex flex-col gap-2 rounded-xl border bg-gray-100 p-2"
          v-if="depot.reponses.length"
        >
          <div
            class="border-2 border-dashed bg-white px-4 py-2"
            v-for="reponse in depot.reponses"
            :key="reponse.id"
          >
            <p class="text-base font-semibold text-red-500">
              Type:
              <span class="text-base font-light text-gray-700">
                {{ getTypeLabel(reponse.type) }}
              </span>
            </p>
            <p class="text-base font-semibold">
              Titre:
              <span class="text-base font-light text-gray-700">
                {{ reponse.titre }}
              </span>
            </p>
            <p class="text-base font-semibold">
              Description:
              <span class="text-base font-light text-gray-700">
                {{ reponse.description }}
              </span>
            </p>
            <p class="text-base font-semibold">
              Date de création:
              <span class="text-base font-light text-gray-700">
                {{ reponse.date_creation }}
              </span>
            </p>
          </div>
        </div>
        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button
          class="mt-2 rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700"
          @click="$router.push(`/depots/${depot.id}`)"
        >
          Répondre à la demande
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { getLabel } from "@/enum/demande_clinique/reponse/type";

export default {
  name: "Index",
  computed: {
    ...mapGetters({
      depots: "demande_clinique/depots",
    }),
  },
  methods: {
    getTypeLabel: getLabel,
  },
};
</script>

<template>
  <div class="pb-20 pt-20 text-center">
    <div v-if="foods.length > 0">
      <FoodCard :foods="foods"></FoodCard>
    </div>
    <div v-else class="bg-gray-200 rounded-md p-10 shadow-md mt-5">
      <h1
        class="font-bold text-xl bg-red-500 rounded-md p-10 text-white text-center uppercase"
      >
        NO DATA AVAIBLE
      </h1>
    </div>
  </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import FoodCard from "../../components/FoodCard.vue";

export default {
  name: "SearchComponent",

  components: {
    FoodCard,
  },

  setup() {
    const store = useStore();

    const foods = computed(() => {
      return store.state.food.foods;
    });

    return {
      foods,
    };
  },
};
</script>

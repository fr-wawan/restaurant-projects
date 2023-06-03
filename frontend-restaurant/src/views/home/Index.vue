<template>
  <div>
    <HeroIndex />

    <div class="my-10 container mx-auto">
      <h1 class="text-3xl font-bold uppercase">
        Menu <span class="text-red-500">Lists</span>
      </h1>
      <div>
        <CategoryCard :categories="categories" />
      </div>
      <div class="">
        <h1 class="mt-10 text-3xl font-bold uppercase">
          Food <span class="text-red-500">Lists</span>
        </h1>
        <FoodCard :foods="foods" />

        <div class="mt-10" v-show="nextExists">
          <a
            @click="loadMore"
            class="bg-red-600 text-white p-2 px-3 rounded-md shadow-md cursor-pointer"
            >LIHAT SEMUA <i class="fa fa-long-arrow-alt-right"></i
          ></a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from "vue";
import { useStore } from "vuex";
import CategoryCard from "../../components/CategoryCard.vue";
import HeroIndex from "../../components/HeroIndex.vue";
import FoodCard from "../../components/FoodCard.vue";

export default {
  name: "HomeComponent",

  components: {
    CategoryCard,
    HeroIndex,
    FoodCard,
  },

  setup() {
    const store = useStore();

    onMounted(() => {
      store.dispatch("food/getFood");
      store.dispatch("category/getCategoryHome");
    });

    const foods = computed(() => {
      return store.state.food.foods;
    });

    const nextExists = computed(() => {
      return store.state.food.nextExists;
    });

    const nextPage = computed(() => {
      return store.state.food.nextPage;
    });

    const categories = computed(() => {
      return store.state.category.categories;
    });

    function loadMore() {
      store.dispatch("food/getLoadMore", nextPage.value);
    }

    return { categories, foods, nextExists, nextPage, loadMore };
  },
};
</script>

<template>
  <div>
    <div v-if="categories.length > 0">
      <div
        class="mt-5 grid grid-cols-4 gap-4 md:gap-4 text-center items-center"
      >
        <div
          v-for="category in categories"
          :key="category.id"
          class="col-span-2 md:col-span-2 lg:col-span-1 bg-white rounded-md shadow-md p-4 text-center text-xs"
        >
          <router-link
            :to="{ name: 'category.show', params: { slug: category.slug } }"
            class="font-bold text-md"
          >
            <div>
              <img
                :src="`//localhost:8000${category.image}`"
                class="inline-block rounded-lg mb-2"
              />
            </div>
            {{ category.name.toUpperCase() }}
          </router-link>
        </div>
      </div>
    </div>
    <div v-else>
      <div
        class="mt-5 grid grid-cols-4 gap-4 md:gap-4 text-center items-center"
      >
        <div
          v-for="index in 4"
          :key="index"
          class="sm:col-span-2 md:col-span-2 lg:col-span-2 bg-white rounded-md shadow-md text-center text-xs"
        >
          <ContentLoader />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, onMounted } from "vue";

import { useStore } from "vuex";

import { ContentLoader } from "vue-content-loader";

export default {
  name: "CategoryHomeComponent",

  props: ["categories"],
  components: {
    ContentLoader,
  },

  setup() {
    const store = useStore();

    // onMounted(() => {
    //   store.dispatch("category/getCategoryHome");
    // });

    // const categories = computed(() => {
    //   return store.state.category.categories;
    // });

    // return { categories };
  },
};
</script>

<style></style>

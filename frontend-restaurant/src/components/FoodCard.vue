<template>
  <div class="mt-5 grid grid-cols-4 gap-4 md:gap-4 text-center items-center">
    <div
      v-for="food in foods"
      :key="food.id"
      class="col-span-2 md:col-span-2 lg:col-span-1 bg-white rounded-md shadow-md text-center text-xs"
    >
      <form method="post" @submit.prevent="addToCart(food)">
        <div>
          <img
            :src="`//localhost:8000${food.image}`"
            class="inline-block rounded- mb-2 p-4"
          />
        </div>
        <div>
          <h1 class="text-lg font-bold mt-2">
            {{ food.title }}
          </h1>
          <p class="text-base">Price : {{ formatPrice(food.price) }}</p>

          <div class="w-40 text-lg my-3 mx-auto">
            <label for="Quantity" class="sr-only"> Quantity </label>

            <div class="flex items-center border border-gray-200 rounded">
              <button
                type="button"
                :disabled="quantity == 1"
                @click.prevent="quantity--"
                class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
              >
                &minus;
              </button>

              <input
                type="number"
                id="Quantity"
                class="h-10 w-16 border-transparent text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
                @click.prevent=""
                v-model="quantity"
                min="1"
              />

              <button
                type="button"
                class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
                @click.prevent="quantity++"
              >
                &plus;
              </button>
            </div>
          </div>
        </div>
        <div>
          <router-link
            :to="{ name: 'food.index', params: { slug: food.slug } }"
          >
            <button
              class="border border-gray-700 transition-all hover:bg-gray-700 hover:text-white p-3 text-md uppercase font-semibold px-10 rounded-lg"
            >
              Details
            </button>
          </router-link>
          <button
            class="bg-white transition-all hover:text-white hover:bg-red-500 border border-red-500 p-3 text-md uppercase font-semibold text-red-500 rounded-lg px-10 mx-3 my-3"
          >
            Order
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { computed, onMounted, ref } from "vue";
import { useStore } from "vuex";
import { ContentLoader } from "vue-content-loader";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
export default {
  name: "FoodHomeComponent",

  components: {
    ContentLoader,
  },

  props: ["foods"],

  setup() {
    const store = useStore();

    const quantity = ref(1);
    const toast = useToast();
    const router = useRouter();

    onMounted(() => {
      store.dispatch("food/getFood");
      // store.dispatch("category/getCategoryHome");
    });

    function addToCart(food) {
      let formData = new FormData();

      formData.append("id", food.id);
      formData.append("quantity", quantity.value);

      store
        .dispatch("cart/storeCart", formData)
        .then(() => {
          router.push({ name: "cart" });

          toast.success("Added to Cart Successfully");
        })
        .catch((error) => {
          console.log(error);
        });
    }

    return {
      // foods,
      quantity,
      addToCart,
    };
  },
};
</script>

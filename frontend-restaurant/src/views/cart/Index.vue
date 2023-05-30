<template>
  <div class="container mx-auto mt-20">
    <h1 class="text-3xl mb-10 font-bold uppercase">
      Cart <span class="text-red-500">Lists</span>
    </h1>
    <div class="" v-if="carts?.length > 0">
      <div class="bg-white rounded-lg shadow-lg">
        <div
          v-for="cart in carts"
          class="flex items-center justify-between text-lg p-2 mx-5"
        >
          <img
            :src="`//localhost:8000${cart.food.image}`"
            class="rounded-md mb-2 p-4 w-36"
          />
          <h1>{{ cart.food.title }}</h1>
          <h1>Rp. {{ formatPrice(cart.food.price) }}</h1>

          <div class="flex items-center border border-gray-200 rounded h-10">
            <button
              type="button"
              @click="decrementQuantity(cart)"
              class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
              :disabled="cart.quantity == 1"
            >
              &minus;
            </button>

            <input
              type="number"
              id="Quantity"
              class="h-10 w-16 border border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
              v-model="cart.quantity"
              @input="updateCart(cart)"
            />

            <button
              type="button"
              class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
              @click="incrementQuantity(cart)"
            >
              &plus;
            </button>
          </div>
          <button
            class="bg-red-500 text-white p-3 px-5 rounded-md hover:bg-red-400 flex items-center text-base gap-2"
            @click.prevent="deleteCart(cart)"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-trash"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M4 7l16 0"></path>
              <path d="M10 11l0 6"></path>
              <path d="M14 11l0 6"></path>
              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
            </svg>
            Remove
          </button>
        </div>
        <div class="text-end text-lg mr-6 pb-5">
          <p>Total Price : {{ formatPrice(total) }}</p>
          <router-link :to="{ name: 'checkout' }">
            <button
              class="group border border-blue-800 text-blue-800 hover:text-white transition-all p-3 px-5 rounded-md hover:bg-blue-800 gap-2 mt-5"
            >
              <div class="flex gap-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="icon icon-tabler icon-tabler-shopping-cart stroke-blue-500 group-hover:stroke-white"
                  width="28"
                  height="28"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="#000000"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 17h-11v-14h-2" />
                  <path d="M6 5l14 1l-1 7h-13" />
                </svg>
                Checkout
              </div>
            </button>
          </router-link>
        </div>
      </div>
    </div>
    <div v-else class="bg-gray-200 rounded-md p-10 shadow-md mt-5">
      <h1
        class="font-bold text-xl bg-red-500 rounded-md p-10 text-white text-center uppercase"
      >
        Your carts is empty
      </h1>
    </div>
  </div>
</template>

<script>
import { computed, ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

export default {
  name: "CartIndexComponent",

  setup() {
    const store = useStore();
    const toast = useToast();
    const router = useRouter();

    onMounted(() => {
      store.dispatch("cart/getCart");
    });

    const updateCart = async (cart) => {
      try {
        await new Promise((resolve) => setTimeout(resolve, 1000));

        const response = await store.dispatch("cart/updateCart", cart);
      } catch (error) {
        console.error(error);
      }
    };

    let timeoutId;

    async function updateCartWithDelay(cart) {
      clearTimeout(timeoutId);
      await new Promise((resolve) => {
        timeoutId = setTimeout(resolve, 500);
      });

      await updateCart(cart);
    }

    function decrementQuantity(cart) {
      if (cart.quantity > 1) {
        cart.quantity--;
        updateCartWithDelay(cart);
      }
    }

    function incrementQuantity(cart) {
      cart.quantity++;
      updateCartWithDelay(cart);
    }

    const carts = computed(() => {
      return store.state.cart.cart;
    });

    const total = computed(() => {
      return store.getters["cart/cartTotal"];
    });

    const deleteCart = async (cart) => {
      try {
        await store.dispatch("cart/deleteCart", cart);
      } catch (error) {
        console.error(error);
      }
    };

    return {
      carts,
      deleteCart,
      total,
      incrementQuantity,
      decrementQuantity,
      updateCart,
    };
  },
};
</script>

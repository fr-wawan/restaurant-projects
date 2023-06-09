<template>
  <div class="sticky top-0 left-0 right-0">
    <header class="bg-white p-7">
      <nav class="flex justify-around items-center">
        <h1 class="text-center font-bold md:text-2xl">
          <span class="text-red-500">RESTA</span>URANT
        </h1>
        <ul v-if="!isMobile" class="flex gap-5 font-semibold">
          <li>
            <router-link :to="{ name: 'home.index' }">HOME</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'category.index' }">MENU</router-link>
          </li>
          <li>ABOUT US</li>
          <li>CONTACT</li>
        </ul>
        <div class="flex items-center gap-5">
          <form>
            <div class="flex">
              <div v-if="!isMobile" class="relative w-full">
                <input
                  type="search"
                  id="search-dropdown"
                  class="block p-2 w-40 md:w-full text-sm text-gray-900 bg-gray-50 rounded-xl border border-gray-300"
                  placeholder="Search..."
                  @click="linkToSearch"
                  v-model="search"
                  @keyup="searchQuery"
                  required
                />
              </div>
              <router-link :to="{ name: 'search' }" v-else>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="icon icon-tabler icon-tabler-search"
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
                  <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                  <path d="M21 21l-6 -6"></path>
                </svg>
              </router-link>
            </div>
          </form>

          <router-link
            :to="{ name: 'cart' }"
            v-if="store.getters['auth/isLoggedIn']"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-shopping-cart"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              fill="none"
              stroke-linecap="round"
              data-count="3"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
              <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
              <path d="M17 17h-11v-14h-2"></path>
              <path d="M6 5l14 1l-1 7h-13"></path>
            </svg>
            <span
              class="badge"
              v-if="typeof cartCount == 'number' && cartCount > 0"
              >{{ cartCount }}</span
            >
          </router-link>
          <div
            class="flex items-center"
            @click="toggleDropDown"
            v-if="store.getters['auth/isLoggedIn']"
            v-click-outside-element="closeDropDown"
          >
            <img
              :src="
                profile?.avatar?.includes('storage')
                  ? `http://localhost:8000${profile.avatar}`
                  : profile.avatar
              "
              class="rounded-full w-9 cursor-pointer object-cover"
            />
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-chevron-down cursor-pointer"
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
              <path d="M6 9l6 6l6 -6"></path>
            </svg>
            <div
              class="z-10 bg-white absolute md:right-60 right-20 top-20 rounded-lg shadow w-44"
              v-if="isDropDown"
            >
              <ul class="py-2 text-sm text-gray-700">
                <li>
                  <router-link
                    :to="{ name: 'orders' }"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >My Orders</router-link
                  >
                </li>
                <li>
                  <router-link
                    :to="{ name: 'profile' }"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >Edit Profile</router-link
                  >
                </li>
                <li>
                  <router-link
                    :to="{ name: 'profile.password' }"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >Change Password</router-link
                  >
                </li>
                <li>
                  <a
                    @click="logout"
                    class="block cursor-pointer px-4 py-2 hover:bg-gray-200"
                    >Logout</a
                  >
                </li>
              </ul>
            </div>
          </div>
          <div class="flex gap-5" v-else>
            <router-link
              class="bg-red-600 hover:bg-red-500 p-2.5 text-white rounded-lg px-7"
              :to="{ name: 'register' }"
            >
              Register</router-link
            >
            <router-link
              class="bg-black hover:bg-gray-700 p-2.5 text-white rounded-lg px-7"
              :to="{ name: 'login' }"
            >
              Login</router-link
            >
          </div>
        </div>
      </nav>
    </header>
  </div>
</template>

<script>
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import { ref, onMounted, computed } from "vue";
export default {
  name: "HeaderComponent",

  setup() {
    const isDropDown = ref(false);
    const store = useStore();
    const toast = useToast();
    const router = useRouter();

    function toggleDropDown() {
      isDropDown.value = !isDropDown.value;
    }

    function closeDropDown() {
      isDropDown.value = false;
    }

    onMounted(() => {
      store.dispatch("auth/getUser");
      store.dispatch("cart/getCart");
    });

    const cartCount = computed(() => {
      return store.state.cart.count;
    });

    const profile = computed(() => {
      return store.state.auth.profile;
    });

    const search = ref(null);

    const query = async (search) => {
      try {
        await new Promise((resolve) => setTimeout(resolve, 100));

        const response = await store.dispatch("food/searchFood", search.value);
      } catch (error) {
        console.error(error);
      }
    };

    let timeOutId;
    async function searchQuery() {
      clearTimeout(timeOutId);

      await new Promise((resolve) => {
        timeOutId = setTimeout(resolve, 300);
      });

      await query(search);
    }

    function linkToSearch() {
      router.push({
        name: "search",
      });
    }

    function logout() {
      store.dispatch("auth/logout").then(() => {
        router.push({
          name: "login",
        });

        toast.success("Logout Success!");
      });
    }

    const isMobile = ref(false);

    function checkScreenSize() {
      const width = window.innerWidth;
      isMobile.value = width <= 767;
    }

    window.addEventListener("load", checkScreenSize);
    window.addEventListener("resize", checkScreenSize);

    return {
      isDropDown,
      toggleDropDown,
      logout,
      profile,
      closeDropDown,
      cartCount,
      linkToSearch,
      searchQuery,
      search,
      store,
      isMobile,
    };
  },
};
</script>

<style>
.badge {
  position: absolute;
  top: 20px;
  right: 273px;
  padding: 5px 10px;
  border-radius: 100%;
  background: red;
  color: white;
  font-size: 10px;
}
</style>

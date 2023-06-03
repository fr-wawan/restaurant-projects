<template>
  <div class="pb-20 pt-20 text-center">
    <div class="bg-white w-4/12 p-5 rounded-md mx-auto shadow-md">
      <h1 class="font-bold text-xl my-5">LOGIN</h1>
      <form @submit.prevent="login" @keyup.enter="handleKeyDown" class="mt-5">
        <div class="my-6">
          <input
            type="email"
            class="border border-gray-300 rounded-sm p-2 w-8/12"
            placeholder="Your Email"
            v-model="user.email"
          />
        </div>
        <div class="my-6">
          <input
            type="password"
            class="border border-gray-300 rounded-sm p-2 w-8/12"
            placeholder="Your Password"
            v-model="user.password"
          />
        </div>
        <button
          type="submit"
          class="bg-gray-900 p-3 hover:bg-gray-700 text-white rounded-sm w-8/12 font-bold"
          :class="{ 'bg-gray-500': enterPressed }"
        >
          SIGN UP
        </button>
      </form>
      <div class="text-center my-7">
        Dont have an account ?
        <router-link :to="{ name: 'register' }" class="underline text-blue-600"
          >Register Here</router-link
        >
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

export default {
  name: "RegisterComponent",

  setup() {
    const user = reactive({
      email: "",
      password: "",
    });

    const validation = ref([]);
    const enterPressed = ref(false);

    const store = useStore();

    const router = useRouter();

    const toast = useToast();

    const handleKeyDown = () => {
      enterPressed.value = true;
      setTimeout(() => {
        enterPressed.value = false;
      }, 350);
    };

    function login() {
      let email = user.email;
      let password = user.password;

      store
        .dispatch("auth/login", {
          email,
          password,
        })
        .then(() => {
          router.push({ name: "dashboard" });
          toast.success("Login Berhasil");
        })
        .catch((error) => {
          validation.value = error;

          if (validation.value.email) {
            toast.error(`${validation.value.email[0]}`);
            user.password = "";
          }

          if (validation.value.password) {
            toast.error(`${validation.value.password[0]}`);
            user.password = "";
          }

          if (validation.value.message) {
            toast.error(`${validation.value.message}`);
            user.password = "";
          }
        });
    }

    onMounted(() => {
      if (store.getters["auth/isLoggedIn"]) {
        router.push({ name: "dashboard" });
      }
    });

    return {
      user,
      validation,
      handleKeyDown,
      enterPressed,
      login,
    };
  },
};
</script>

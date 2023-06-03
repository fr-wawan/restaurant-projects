<template>
  <div class="pb-20 pt-20 text-center">
    <div class="bg-white w-4/12 p-5 rounded-md mx-auto shadow-md">
      <h1 class="font-bold text-xl my-5">CREATE ACCOUNT</h1>
      <form
        @submit.prevent="register"
        @keyup.enter="handleKeyDown"
        class="mt-5"
      >
        <div class="my-6">
          <input
            type="text"
            class="border border-gray-300 rounded-sm p-2 w-8/12"
            placeholder="Your Username"
            autofocus
            v-model="user.name"
          />
        </div>
        <div class="my-6">
          <input
            type="text"
            class="border border-gray-300 rounded-sm p-2 w-8/12"
            placeholder="Your Email"
            v-model="user.email"
          />
        </div>
        <div>
          <input
            type="password"
            class="border border-gray-300 rounded-sm p-2 w-8/12"
            placeholder="Your Password"
            v-model="user.password"
          />
        </div>
        <div class="my-6">
          <input
            type="password"
            class="border border-gray-300 rounded-sm p-2 w-8/12"
            placeholder="Your Confirmation Password"
            v-model="user.password_confirmation"
          />
        </div>
        <button
          type="submit"
          class="bg-gray-900 p-3 hover:bg-gray-700 text-white rounded-sm w-8/12 font-bold"
          :class="{ 'bg-gray-500': enterPressed }"
        >
          SIGN UP
        </button>

        <div class="text-center my-7">
          Already have an account ?
          <router-link :to="{ name: 'login' }" class="underline text-blue-600"
            >Login Here</router-link
          >
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

export default {
  name: "RegisterComponent",

  setup() {
    const user = reactive({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
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

    function register() {
      let name = user.name;
      let email = user.email;
      let password = user.password;
      let password_confirmation = user.password_confirmation;

      store
        .dispatch("auth/register", {
          name,
          email,
          password,
          password_confirmation,
        })
        .then(() => {
          router.push({ name: "dashboard" });
          toast.success("Register Successfull!");
        })
        .catch((error) => {
          validation.value = error;

          if (validation.value.name) {
            toast.error(`${validation.value.name[0]}`);
            user.password = "";
            user.password_confirmation = "";
          }
          if (validation.value.email) {
            toast.error(`${validation.value.email[0]}`);
            user.password = "";
            user.password_confirmation = "";
          }
          if (validation.value.password) {
            toast.error(`${validation.value.password[0]}`);
            user.password = "";
            user.password_confirmation = "";
          }
        });
    }
    return {
      user,
      validation,
      register,
      toast,
      handleKeyDown,
      enterPressed,
    };
  },
};
</script>

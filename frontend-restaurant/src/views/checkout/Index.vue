<template>
  <form @submit.prevent="submitTransaction('cod')">
    <div class="container mx-auto mt-10 bg-white p-10 rounded-lg shadowmd">
      <div class="flex gap-10">
        <div>
          <div>
            <!-- <label for="name">Name : </label>
            <input
              type="text"
              name="name"
              id="name"
              v-model="data.name"
              class="block border border-gray-500 placeholder:text-sm rounded p-2 w-full mt-3"
              placeholder="Name..."
            /> -->
            {{ data }}
          </div>
          <div class="flex gap-5 mt-5">
            <div>
              <label for="phone">Phone : </label>
              <input
                type="text"
                name="phone"
                v-model="data.phone"
                id="phone"
                class="block border border-gray-500 placeholder:text-sm rounded mt-3 p-2 w-96"
                placeholder="Phone Number..."
              />
            </div>
            <div>
              <label for="phone">Pin Code : </label>
              <input
                type="text"
                name="phone"
                id="phone"
                v-model="data.pinCode"
                class="block border border-gray-500 placeholder:text-sm rounded mt-3 p-2 w-96"
                placeholder="Pin Code..."
              />
            </div>
          </div>
          <div class="mt-5">
            <label for="address">Address : </label>
            <textarea
              name="address"
              id="address"
              v-model="data.address"
              cols="91"
              rows="8"
              class="border border-gray-500 block mt-3 rounded-md p-5"
              placeholder="Address..."
            ></textarea>
          </div>
          <div class="mt-5">
            <label for="message">User Message : </label>
            <textarea
              name="message"
              id="message"
              cols="91"
              v-model="data.description"
              rows="8"
              class="border border-gray-500 block mt-3 rounded-md p-5"
              placeholder="User Message..."
            ></textarea>
            <input type="text" v-model="data.amount" />
          </div>
        </div>
        <div>
          <table>
            <tr>
              <th class="p-4 border-b border-black">Image</th>
              <th class="p-4 border-b border-black">Food Title</th>
              <th class="p-4 border-b border-black">Price</th>
              <th class="p-4 border-b border-black">Quantity</th>
              <th class="p-4 border-b border-black">Total</th>
            </tr>
            <tr v-for="cart in carts" class="mx-5">
              <td class="text-center mx-5">
                <img
                  :src="`//localhost:8000${cart.food.image}`"
                  class="inline text-center"
                  width="100"
                  alt=""
                />
              </td>
              <td class="p-10">{{ cart.food.title }}</td>
              <td class="p-5">
                {{ formatPrice(cart.food.price) }}
              </td>
              <td class="px-3 text-center">{{ cart.quantity }}</td>
              <td class="p-5">
                {{ countTotal(cart.quantity, cart.food.price) }}
              </td>
            </tr>
          </table>
          <div class="flex justify-between mt-5 text-lg">
            <p>Grand Total :</p>
            <p>{{ formatPrice(total) }}</p>
          </div>
          <div>
            <button class="p-3 bg-blue-700 w-full mt-5 text-white rounded">
              Place Order | COD
            </button>
            <button class="p-3 bg-red-500 w-full mt-5 text-white rounded">
              Pay With MIDTRANS
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { computed, reactive, ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
export default {
  name: "TransactionIndexComponent",

  setup() {
    const store = useStore();
    const toast = useToast();
    const router = useRouter();
    onMounted(() => {
      store.dispatch("cart/getCart");
    });

    const carts = computed(() => {
      return store.state.cart.cart;
    });

    const mappedCarts = computed(() => {
      return carts.value.map((cart) => {
        return {
          id: cart.food.id,
          quantity: cart.quantity,
          price: cart.food.price,
        };
      });
    });
    const total = computed(() => {
      return store.getters["cart/cartTotal"];
    });

    let method = ref("");
    const data = reactive({
      phone: "",
      pinCode: "",
      address: "",
      description: "",
      amount: "",
    });
    function submitTransaction(methods, food) {
      method = methods;
      let paymentMethod = method;
      const cartIds = mappedCarts.value.map((cart) => cart.id);

      const cartQuantity = mappedCarts.value.map((cart) => cart.quantity);

      let formData = new FormData();
      formData.append("phone", data.phone);
      formData.append("pin_code", data.pinCode);
      formData.append("address", data.address);
      formData.append("description", data.description);
      formData.append("payment_method", paymentMethod);
      mappedCarts.value.forEach((cart) => {
        formData.append("foodIds[]", cart.id);
        formData.append("quantity[]", cart.quantity);
        // Append other data fields specific to each data entry if needed
      });
      formData.append("amount", total.value);
      console.log(data.amount);
      if (method == "cod") {
        store
          .dispatch("order/storeOrder", formData)
          .then(() => {
            toast.success("Food in Proccess");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    }

    return {
      carts,
      total,
      data,
      submitTransaction,
    };
  },
};
</script>

<style>
td {
  border-bottom: 1px solid lightgray;
}
</style>

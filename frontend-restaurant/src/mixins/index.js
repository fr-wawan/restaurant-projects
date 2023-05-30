const mixins = {
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    removeTags(html) {
      const div = document.createElement("div");
      div.innerHTML = html;
      return div.textContent;
    },

    countTotal(quantity, price) {
      let total = quantity * price;
      return this.formatPrice(total);
    },
  },
};

export default mixins;

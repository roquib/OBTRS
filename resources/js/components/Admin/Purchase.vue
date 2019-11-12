<template>
  <div class>
    <div class="row">
      <div class="col-12 mx-0">
        <!-- purchase -->
        <div style="background: #563D7C">
          <h5 class="text-light pl-3" style="line-height: 35px">
            Purchase Book
          </h5>
        </div>

        <div class="container">
          <div class="row">
            <!-- Supplier -->
            <div class="form-group col-md-4">
              <label for="supplier">Supplier Name</label>
              <cool-select
                :items="suppliers"
                v-model="supplier"
                id="supplier"
                placeholder="Select Supplier"
              />
              <p class="text-danger" v-if="supplierError">Fillup Supplier</p>
            </div>
            <!-- purchase date -->
            <div class="col-md-3 ml-auto text-right">
              <label for="date">Date: {{ currentDate() | myDate }}</label>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="row mb-3">
            <!-- Product -->
            <div class="form-group col-md-6">
              <label for="product">Book Name</label>
              <cool-select
                :items="products"
                id="product"
                v-model="selectedName"
                placeholder="Select Book"
              />
            </div>

            <!-- quantity -->
            <div class="form-group col-md-3">
              <label for="quantity">Add Quantity</label>
              <input
                v-model="selectedQuantity"
                min="0"
                type="number"
                placeholder="Quantity"
                class="form-control form-control-sm"
              />
            </div>

            <!-- price -->
            <div class="form-group col-md-3">
              <label for="price">Purchase Price</label>
              <input
                v-model="selectedPrice"
                @keyup.enter="addItem"
                min="0"
                type="number"
                name="price"
                placeholder="Price"
                class="form-control form-control-sm"
              />
            </div>

            <div class="col-12 text-right">
              <button
                type="button"
                @click="addItem"
                class="btn btn-primary btn-sm"
              >
                Add Item
              </button>
            </div>
          </div>

          <div class="row">
            {{ getData }}
            <div class="col-12">
              <table class="table table-sm table-striped">
                <tr class="bg-dark">
                  <th>Sln</th>
                  <th>Book Name</th>
                  <th>Quantity</th>
                  <th>Pricie</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
                <tr v-for="(item, index) in shopItems" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.productName }}</td>
                  <td>{{ item.quantity }}</td>
                  <td class="text-left">{{ item.price }} Tk.</td>
                  <td class="text-left">
                    {{ item.quantity * item.price }} Tk.
                  </td>
                  <td>
                    <a href="#" @click="removeItem(index)">
                      <i class="fas fa-times red" style="font-size: 20px;"></i>
                    </a>
                  </td>
                </tr>
                <tfoot>
                  <tr>
                    <th colspan="4" class="text-right">Total</th>
                    <th>{{ grandTotal }} Tk.</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- <form @submit.prevent="purchaseProduct()" mehod="post"> -->

          <div class="col-12 text-right">
            <button
              type="submit"
              @click="purchaseProduct()"
              class="btn btn-primary btn-sm"
            >
              Purchase
            </button>
          </div>
          <!-- </form> -->
        </div>
      </div>
      <!-- end v-else -->
    </div>
  </div>
</template>



<script>
  // for autocomplete
  import { CoolSelect } from "vue-cool-select";

  export default {
    computed: {
      getData() {
        if (this.selectedName != null) {
          const index = this.products.findIndex(
            product => product === this.selectedName
          );

          this.selectedPrice = this.prices[index];
          this.selectedID = this.book_ids[index];
        }
      }
    },
    mounted() {
      // load suppliers
      axios.get("api/supplier-list").then(({ data }) => {
        for (var i = 0; i < data.length; i++) {
          this.suppliers.push(data[i]);
        }
      });
      // load suppliers
      axios.get("api/product-list").then(({ data }) => {
        for (var i = 0; i < data.length; i++) {
          this.products.push(data[i]["name"]);
          this.prices.push(data[i]["price"]);
          this.book_ids.push(data[i]["id"]);
        }
      });
    },
    components: {
      CoolSelect
    },
    data() {
      return {
        suppliers: [],
        supplier: "",
        products: [],
        prices: [],
        prices: [],
        book_ids: [],
        purchaseForm: new Form(),
        search: "",
        grandTotal: 0,
        supplierError: false,

        selectedName: "",
        selectedPrice: 0,
        selectedID: 0,
        selectedQuantity: 1,

        shopItems: [],
        form: {
          productName: "",
          book_id: 0,
          quantity: 1,
          price: 0.0
        }
      };
    },

    methods: {
      currentDate() {
        return new Date();
      },

      removeItem(index) {
        this.shopItems.splice(index, 1);
        var total = 0;
        for (var i = 0; i < Object.keys(this.shopItems).length; i++) {
          total += this.shopItems[i].quantity * this.shopItems[i].price;
        }
        this.grandTotal = total;
      },

      addItem() {
        if (
          this.selectedName != null &&
          this.selectedQuantity > 0 &&
          this.selectedPrice > 0
        ) {
          this.form.productName = this.selectedName;
          this.form.price = this.selectedPrice;
          this.form.book_id = this.selectedID;
          this.form.quantity = parseInt(this.selectedQuantity);
          this.checkAndAddItem(this.form);
          var total = 0;
          for (var i = 0; i < Object.keys(this.shopItems).length; i++) {
            total += this.shopItems[i].quantity * this.shopItems[i].price;
          }
          this.grandTotal = total;
          this.selectedQuantity = 1;
          this.selectedName = "";
          this.selectedPrice = 0;
          this.selectedID = 0;
          this.form = {};
        }
      },

      checkAndAddItem(obj) {
        for (var i = 0; i < this.shopItems.length; i++) {
          if (this.shopItems[i].productName === obj.productName) {
            this.shopItems[i].quantity += parseInt(obj.quantity);
            return;
          }
        }
        this.shopItems.push(obj);
      },

      // results for pagination
      getResults(page = 1) {
        axios.get("api/purchase?page=" + page).then(response => {
          this.purchases = response.data;
        });
      },
      purchaseProduct() {
        if (this.supplier == null) {
          this.supplierError = true;
        } else {
          this.purchaseForm = this.shopItems;
          this.$Progress.start();

          axios({
            method: "post",
            url: "api/purchase/products/" + this.supplier,
            data: {
              shopItems: JSON.stringify(this.shopItems)
            }
          })
            .then(() => {
              Fire.$emit("AfterAction");
              toast.fire({
                type: "success",
                title: "Product purchase successfully"
              });
              this.shopItems = null;
              this.grandTotal = 0;
              this.$Progress.finish();
            })
            .catch(() => {
              this.$Progress.fail();
            });
        }
      },

      // load data for table
      loadPurchases() {
        axios.get("api/purchase").then(({ data }) => (this.purchases = data));
      }
    }, // end method

    created() {
      this.loadPurchases();
      Fire.$on("AfterAction", () => {
        this.loadPurchases();
      });
    }
  };
</script>

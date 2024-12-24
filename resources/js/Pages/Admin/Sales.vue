<script>
import AuthenticatedAdminLayout from "@/Layouts/AuthenticatedAdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Head, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import MenuDropdown from "@/Components/MenuDropdown.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { ref } from "vue";

export default {
  components: {
    Head,
    AuthenticatedAdminLayout,
    InputError,
    InputLabel,
    TextInput,
    SelectInput,
    Modal,
    PrimaryButton,
    Checkbox,
    MenuDropdown,
    DangerButton,
  },
  props: {
    errors: Object,
    pays: Object,
    products: Object,
    users: Object,
  },
  data() {
    const filter = useForm({
      start_at: null,
      end_at: null,
      user: "",
    });

    const selections = ref([]);

    const form = useForm({
      uuid: null,
      name: null,
      payment_mode_id: "",
      products: [],
      amount_paid: null,
    });

    const productFilter = useForm({
      name: null,
    });

    return {
      filteredProducts: this.products,
      selections,
      totalAmountDue: 0,
      form,
      productFilter,
      action: "",
      editContent: false,
      formModal: false,
      destroyModal: false,
      enlistModal: false,
      selectedRow: null,
      filter,
    };
  },
  mounted() {
    this.fetch();

    $(document).on("click", ".dropdown-toggle", (evt) => {
      const data = $(evt.target).attr("dropdown-log");

      if (this.$refs.menuDropdown && evt.target.classList.contains("dropdown-span")) {
        this.$refs.menuDropdown.toggleDropdown(data);
      }
    });

    $(document).on("click", "body", (evt) => {
      if (this.$refs.menuDropdown && !evt.target.classList.contains("dropdown-span")) {
        // Close all dropdowns when clicking outside
        this.$refs.menuDropdown.closeAllDropdowns();
      }
    });

    $(document).on("click", ".edit", (evt) => {
      const data = $(evt.currentTarget).data("id");
      this.showFormModal("edit", data);
    });

    $(document).on("click", ".delete", (evt) => {
      const data = $(evt.currentTarget).data("id");

      this.showDestroyModal("delete", data);
    });
  },
  watch: {
    selections: {
      handler(newSelections) {
        this.form.products = [...newSelections];
      },
      deep: true,
    },
  },
  methods: {
    fetch() {
      $("#data_table").DataTable({
        destroy: true,
        stateSave: true,
        processing: false,
        serverSide: true,
        ajax: {
          url: route("admin.sale.fetch"),
          data: {
            filter: {
              start_at: this.filter.start_at,
              end_at: this.filter.end_at,
              user: this.filter.user,
            },
          },
        },
        columns: [
          {
            data: "date",
            title: "date",
          },
          {
            data: "name",
            title: "name",
          },
          {
            data: "user",
            title: "sales person",
          },
          {
            data: "pay_mode",
            title: "payment method",
          },
          {
            data: "amount_due",
            title: "amount due (GHC)",
            className: "text-right",
          },
          {
            data: "amount_paid",
            title: "amount paid (GHC)",
            className: "text-right",
          },
          {
            data: "amount_debt",
            title: "debt (GHC)",
            className: "text-right",
          },
          {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false,
          },
        ],
        lengthMenu: [
          [10, 25, 50, 100, -1],
          ["10", "25", "50", "100", "All"],
        ],
        columnDefs: [{ width: "5%", targets: -1 }],
        order: [[0, "desc"]],
        createdRow: function (row, data, dataIndex) {
          // Find the dropdown element in the row and set its width
          var dropdownMenu = $(row).find(".dropdown-menu");
          if (dropdownMenu.length > 0) {
            dropdownMenu.width(180); // Set your desired width here
          }
        },
      });
    },
    showFormModal(action, data) {
      this.action = action;
      if (this.action === "edit") {
        this.editContent = true;

        axios
          .post(route("admin.sale.edit"), { uuid: data })
          .then((response) => {
            const sale = response.data.row;
            Object.assign(this.form, sale);
            sale.product.forEach((product) => {
              const amount = parseFloat(product.selling_price).toFixed(2) || 0;
              const qty = product.pivot.qty || 1;

              this.selections.push({
                product_id: product.id,
                name: product.name,
                amount: amount,
                qty: qty || 1,
                stock_level: product.stock_level_at_dispensary,
                totalCost: (amount * qty).toFixed(2) || 0,
              });

              this.updateTotalAmountDue();
            });
          })
          .catch(() => toastr.error("Something went wrong."));
      }

      // Open modal after handling logic
      this.formModal = true;
    },
    hideFormModal() {
      this.formModal = false;
      this.editContent = false;
      this.action = "";
      this.form.reset();
      this.form.clearErrors();
      this.selections = ref([]);
    },
    addSelection(data) {
      const selectedProduct = this.products.find((product) => product.id === data);

      // Check if product is already selected
      if (this.selections.some((s) => s.product_id === data)) {
        toastr.error("Product already selected");
        return;
      }

      // Add product to selections if it exists
      if (selectedProduct) {
        this.selections.push({
          product_id: data,
          name: selectedProduct.name,
          amount: parseFloat(selectedProduct.selling_price).toFixed(2) || 0,
          qty: 1,
          stock_level: selectedProduct.stock_level_at_dispensary,
          totalCost: parseFloat(selectedProduct.selling_price).toFixed(2) || 0,
        });

        this.updateTotalAmountDue();
      }
    },

    updateTotalCost(index) {
      const selection = this.selections[index];

      // Validate stock level
      if (selection.qty > selection.stock_level) {
        toastr.error("Low stock");
        selection.qty = selection.stock_level;
        return;
      }

      // Update total cost for the selected item
      selection.totalCost = (selection.amount * selection.qty).toFixed(2);

      // Recalculate total amount due
      this.updateTotalAmountDue();
    },

    updateTotalAmountDue() {
      // Calculate total amount due by summing all totalCost values
      this.totalAmountDue = this.selections
        .reduce((sum, s) => sum + parseFloat(s.totalCost || 0), 0)
        .toFixed(2);
    },

    removeSelection(index) {
      this.form.clearErrors("products." + index + ".id");
      this.selections.splice(index, 1);
    },
    fetchProducts() {
      const data = this.productFilter.name.trim().toLowerCase();

      this.filteredProducts = data
        ? this.products.filter((product) => product.name.toLowerCase().includes(data))
        : [...this.products];

      return this.products.filter((product) => product.name.includes(data));
    },
    submit() {
      if (!this.editContent) {
        this.form.post(route("admin.sale.store"), {
          onSuccess: () => {
            this.hideFormModal();
            toastr.success("Sales successfully saved");
            this.fetch();
          },
          onError: (errors) => {
            toastr.error("Something went wrong");
          },
        });
      } else {
        this.form.put(route("admin.sale.update", { uuid: this.form.uuid }), {
          onSuccess: () => {
            this.hideFormModal();
            toastr.success("Sales successfully updated");
            this.fetch();
          },
          onError: (errors) => {
            toastr.error("Something went wrong");
          },
        });
      }
    },
    showEnlistModal(action, data) {
      this.action = action;
      this.selectedRow = data;
      this.enlistModal = true;
    },
    hideEnlistModal() {
      this.enlistModal = false;
      this.selectedRow = null;
      this.action = "";
    },
    showDestroyModal(action, data) {
      this.action = action;
      this.selectedRow = data;
      this.destroyModal = true;
    },
    hideDestroyModal() {
      this.destroyModal = false;
      this.selectedRow = null;
      this.action = "";
    },
    destroy() {
      axios
        .post(route("admin.sale.destroy"), {
          uuid: this.selectedRow,
        })
        .then((response) => [
          this.hideDestroyModal(),
          toastr.success("Sales successfully removed"),
          this.fetch(),
        ])
        .catch((error) => console.log(error));
    },
  },
};
</script>

<template>
  <Head title="Sales" />

  <AuthenticatedAdminLayout>
    <MenuDropdown ref="menuDropdown" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">Sales</h2>
    </template>

    <div class="py-12 px-3 md:px-0">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <!-- Filter and Button Section -->
            <div
              class="flex flex-col md:flex-row md:justify-between items-center gap-4 mb-4"
            >
              <!-- Form Fields -->
              <div
                class="flex flex-col md:flex-row justify-between gap-3 lg:gap-4 w-full md:w-3/4 lg:w-2/3"
              >
                <div
                  class="flex flex-col lg:flex-row items-start lg:items-center lg:space-x-2 w-full"
                >
                  <InputLabel for="start_at" value="From" :required="false" />
                  <TextInput
                    @input="fetch"
                    id="start_at"
                    type="date"
                    class="w-full"
                    v-model="filter.start_at"
                    :placeholder="'start_at'"
                    autocomplete="start_at"
                    :class="{ 'border-red-600': filter.errors.start_at }"
                  />
                  <InputError :message="filter.errors.start_at" />
                </div>

                <div
                  class="flex flex-col lg:flex-row items-start lg:items-center lg:space-x-2 w-full"
                >
                  <InputLabel for="end_at" value="To" :required="false" />
                  <TextInput
                    @input="fetch"
                    id="end_at"
                    type="date"
                    class="w-full"
                    v-model="filter.end_at"
                    :placeholder="'end_at'"
                    autocomplete="end_at"
                    :class="{ 'border-red-600': filter.errors.end_at }"
                  />
                  <InputError :message="filter.errors.end_at" />
                </div>

                <div
                  class="flex flex-col lg:flex-row items-start lg:items-center lg:space-x-2 w-full"
                >
                  <InputLabel for="user" value="Collected By" :required="false" />
                  <SelectInput
                    v-model="filter.user"
                    name="user"
                    class="w-full"
                    @change="fetch"
                  >
                    <option :value="''">All</option>
                    <option v-for="user in users" :key="user.id" :value="user.uuid">
                      {{ user.name }}
                    </option>
                  </SelectInput>
                </div>
              </div>

              <!-- Button -->
              <PrimaryButton type="button" @click="showFormModal('add')">
                add sale
              </PrimaryButton>
            </div>

            <!-- Table Section -->
            <div class="flex flex-col">
              <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-w-full sm:px-6 lg:px-8">
                  <div class="overflow-x-auto">
                    <table id="data_table" class="w-full table-striped">
                      <thead class="capitalize border-b bg-gray-100 font-medium">
                        <tr>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            date
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            name
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            sales person
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            payment method
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            amount due (GHC)
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            amount paid (GHC)
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            debt (GHC)
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            action
                          </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- form modal -->
    <Modal
      :show="formModal"
      :closeable="true"
      :modalTitle="this.action + ' sale'"
      @close="hideFormModal"
      :maxWidth="'2xl'"
    >
      <div class="grid grid-cols-7 divide-x">
        <!-- products panel -->
        <div class="col-span-2 py-2 px-4">
          <p class="capitalize font-semibold">all products</p>

          <div class="my-3">
            <form @submit.prevent="fetchProducts">
              <label
                for="product-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only"
                >Search</label
              >
              <div class="relative">
                <div
                  class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                >
                  <svg
                    class="w-4 h-4 text-gray-500"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 20"
                  >
                    <path
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                    />
                  </svg>
                </div>
                <TextInput
                  type="text"
                  id="product-search"
                  class="block w-full p-4 ps-10 text-sm"
                  placeholder="Search Product"
                  v-model="productFilter.name"
                  @input="fetchProducts"
                />
                <PrimaryButton
                  type="submit"
                  class="absolute end-2.5 bottom-2.5 px-3 py-1"
                >
                  Search</PrimaryButton
                >
              </div>
            </form>
          </div>

          <div class="mt-6 h-96 overflow-y-auto">
            <div
              v-for="product in filteredProducts"
              @click="addSelection(product.id)"
              class="cursor-pointer odd:bg-gray-100 py-2 px-3"
            >
              <p class="overflow-hidden whitespace-nowrap text-ellipsis text-gray-800">
                {{ product.name }}
              </p>
            </div>
          </div>
        </div>

        <!-- selected products & billing panel -->
        <div class="col-span-5 px-6 py-2">
          <div>
            <p class="capitalize font-semibold">selected products</p>
            <div class="mt-3" v-if="selections.length >= 1">
              <div class="mb-5" v-for="(selection, row) in selections" :key="row">
                <div class="grid grid-cols-5 gap-x-5 flex items-center">
                  <div class="col-span-2">
                    <InputLabel
                      for="name"
                      value="Product Name"
                      :required="true"
                      v-if="row == 0"
                    />
                    <TextInput
                      id="name"
                      type="text"
                      class="w-full"
                      v-model="selection.name"
                      :placeholder="'Product Name'"
                      autocomplete="name"
                      :disabled="true"
                    />
                  </div>

                  <div class="col-span-1">
                    <InputLabel
                      for="qty"
                      value="Quantity"
                      :required="true"
                      v-if="row == 0"
                    />
                    <TextInput
                      id="qty"
                      type="number"
                      class="w-full"
                      v-model="selection.qty"
                      :min="1"
                      :placeholder="'Quantity'"
                      autocomplete="qty"
                      @input="updateTotalCost(row)"
                      :class="{
                        'border-red-600': form.errors[`products.${row}.qty`],
                      }"
                    />
                    <InputError :message="form.errors[`products.${row}.qty`]" />
                  </div>

                  <div class="col-span-1">
                    <InputLabel
                      for="qty"
                      value="Stock Level"
                      :required="true"
                      v-if="row == 0"
                    />
                    <TextInput
                      id="qty"
                      type="number"
                      class="w-full"
                      v-model="selection.stock_level"
                      :placeholder="'Stock Level'"
                      autocomplete="qty"
                      :disabled="true"
                    />
                  </div>

                  <div class="col-span-1/2">
                    <DangerButton
                      type="button"
                      @click="removeSelection(row)"
                      class="h-8 w-9 flex items-center justify-center"
                    >
                      <span class="material-symbols-outlined"> close </span>
                    </DangerButton>
                  </div>
                </div>
              </div>

              <!-- selected products -->
              <div class="mt-10">
                <p class="capitalize font-semibold">summary</p>

                <div class="mt-3">
                  <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                      <div class="py-2 inline-w-full sm:px-6 lg:px-8">
                        <div class="overflow-x-auto">
                          <table id="data_table" class="w-full table-striped">
                            <thead class="capitalize border-b bg-gray-100 font-medium">
                              <tr>
                                <th
                                  scope="col"
                                  class="text-sm text-gray-900 px-6 py-4 text-left"
                                >
                                  product name
                                </th>
                                <th
                                  scope="col"
                                  class="text-sm text-gray-900 px-6 py-4 text-right"
                                >
                                  price (GHC)
                                </th>
                                <th
                                  scope="col"
                                  class="text-sm text-gray-900 px-6 py-4 text-right"
                                >
                                  Quantity
                                </th>
                                <th
                                  scope="col"
                                  class="text-sm text-gray-900 px-6 py-4 text-right"
                                >
                                  total cost (GHC)
                                </th>
                              </tr>
                            </thead>
                            <tbody class="text-sm">
                              <tr v-for="selection in selections">
                                <td>{{ selection.name }}</td>
                                <td class="text-right">{{ selection.amount }}</td>
                                <td class="text-right">{{ selection.qty }}</td>
                                <td class="text-right">{{ selection.totalCost }}</td>
                              </tr>
                            </tbody>
                            <tr class="bg-gray-200 text-md">
                              <td class="text-right font-bold capitalize" colspan="3">
                                amount due
                              </td>
                              <td class="text-right font-bold capitalize">
                                {{ this.totalAmountDue }}
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- billing panel -->
                  <div class="mt-10">
                    <p class="capitalize font-semibold">billing</p>

                    <div class="my-3">
                      <form @submit.prevent="submit">
                        <div class="grid grid-cols-12 gap-5">
                          <div class="col-span-5">
                            <InputLabel
                              for="name"
                              value="Customer's Name"
                              :required="true"
                            />
                            <TextInput
                              id="name"
                              type="text"
                              class="w-full"
                              v-model="form.name"
                              :placeholder="'Customer\'s Name'"
                              autocomplete="name"
                              :class="{ 'border-red-600': form.errors.name }"
                            />
                            <InputError :message="form.errors.name" />
                          </div>

                          <div class="col-span-4">
                            <InputLabel
                              for="payment_mode_id"
                              value="Payment mode"
                              :required="true"
                            />
                            <SelectInput
                              id="payment_mode_id"
                              v-model="form.payment_mode_id"
                              class="w-full"
                              :class="{ 'border-red-600': form.errors.payment_mode_id }"
                            >
                              <option value="" disabled>-- Select Payment Mode --</option>
                              <option v-for="pay in pays" :key="pay.id" :value="pay.id">
                                {{ pay.title }}
                              </option>
                            </SelectInput>
                            <InputError :message="form.errors.payment_mode_id" />
                          </div>

                          <div class="col-span-3">
                            <InputLabel
                              for="amount_paid"
                              value="Amount Paid (GHC)"
                              :required="true"
                            />
                            <TextInput
                              id="amount_paid"
                              type="text"
                              class="w-full"
                              v-model="form.amount_paid"
                              :placeholder="'Amount Paid (GHC)'"
                              autocomplete="amount"
                              :class="{ 'border-red-600': form.errors.amount_paid }"
                            />
                            <InputError :message="form.errors.amount_paid" />
                          </div>

                          <div class="col-span-full">
                            <PrimaryButton
                              type="submit"
                              :disabled="form.processing"
                              :class="{ 'opacity-25': form.processing }"
                            >
                              <div v-text="editContent ? 'update' : 'save'"></div>
                            </PrimaryButton>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="h-64 flex items-center justify-center" v-else>
              <p class="text-gray-700 text-md font-medium">No products selected</p>
            </div>
          </div>
        </div>
      </div>
    </Modal>
    <!-- end of form modal -->
    <!-- destroy modal  -->
    <Modal
      :show="destroyModal"
      :closeable="true"
      :modalTitle="action + ' sales'"
      @close="hideDestroyModal"
      :maxWidth="'md'"
    >
      <div class="flex justify-center mt-4">
        <p class="text-lg">Are you sure you want to delete this sales?</p>
      </div>

      <div class="flex justify-center mt-6 gap-4">
        <DangerButton @click="destroy" type="submit"> Yes </DangerButton>

        <button
          @click="hideDestroyModal"
          type="button"
          class="block items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:cursor-not-allowed"
        >
          Cancel
        </button>
      </div>
    </Modal>
    <!-- end of destroy modal-->

    <!-- Enlist modal  -->
    <Modal
      :show="enlistModal"
      :closeable="true"
      :modalTitle="action + ' product'"
      @close="hideEnlistModal"
      :maxWidth="'md'"
    >
      <div class="flex justify-center mt-4">
        <p class="text-lg">Are you sure you want to delist this product?</p>
      </div>

      <div class="flex justify-center mt-6 gap-4">
        <DangerButton @click="enlist" type="submit"> Yes </DangerButton>

        <button
          @click="hideEnlistModal"
          type="button"
          class="block items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:cursor-not-allowed"
        >
          Cancel
        </button>
      </div>
    </Modal>
    <!-- end of destroy modal-->
  </AuthenticatedAdminLayout>
</template>

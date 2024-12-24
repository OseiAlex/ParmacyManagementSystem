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
    categories: Object,
    units: Object,
  },
  data() {
    const form = useForm({
      uuid: null,
      name: null,
      generic_name: null,
      manufacturer: null,
      product_category_id: null,
      measuring_unit_id: null,
      cost_price: 0,
      discount: 0,
      markup_percentage: 0,
      restock_level_at_dispensary: 0,
      restock_level_at_store: 0,
      expires_at: null,
    });

    const filter = useForm({
      status: "",
    });

    return {
      form,
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

    $(document).on("click", ".delist", (evt) => {
      const data = $(evt.currentTarget).data("id");
      this.showEnlistModal("delist", data);
    });

    $(document).on("click", ".restore", (evt) => {
      const data = $(evt.currentTarget).data("id");
      this.selectedRow = data;
      this.enlist();

      this.selectedRow = null;
    });

    $(document).on("click", ".delete", (evt) => {
      const data = $(evt.currentTarget).data("id");

      this.showDestroyModal("delete", data);
    });
  },
  methods: {
    fetch() {
      $("#data_table").DataTable({
        destroy: true,
        stateSave: true,
        processing: false,
        serverSide: true,
        ajax: {
          url: route("admin.inventory.product.fetch"),
          data: {
            filter: this.filter.status,
          },
        },
        columns: [
          { data: "name", title: "product name" },
          { data: "status", title: "status" },
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
        columnDefs: [
          { width: "5%", targets: -1 },
          { width: "15%", targets: -2 },
        ],
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
          .post(route("admin.inventory.product.edit"), {
            uuid: data,
          })
          .then((response) => [Object.assign(this.form, response.data.row)])
          .catch((error) => toastr.error("Something went wrong."));
      }

      this.formModal = true;
    },
    hideFormModal() {
      this.formModal = false;
      this.editContent = false;
      this.action = "";
      this.form.reset();
      this.form.clearErrors();
    },
    submit() {
      if (!this.editContent) {
        this.form.post(route("admin.inventory.product.store"), {
          onSuccess: () => {
            this.hideFormModal();
            toastr.success("Product successfully saved");
            this.fetch();
          },
          onError: (errors) => {
            toastr.error("Something went wrong");
          },
        });
      } else {
        this.form.put(route("admin.inventory.product.update", { uuid: this.form.uuid }), {
          onSuccess: () => {
            this.hideFormModal();
            toastr.success("Product successfully updated");
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
        .post(route("admin.inventory.product.destroy"), {
          uuid: this.selectedRow,
        })
        .then((response) => [
          this.hideDestroyModal(),
          toastr.success("Product successfully removed"),
          this.fetch(),
        ])
        .catch((error) => console.log(error));
    },
    enlist() {
      axios
        .post(route("admin.inventory.product.enlist"), {
          uuid: this.selectedRow,
        })
        .then((response) => [
          this.hideEnlistModal(),
          toastr.success(response.data.message),
          this.fetch(),
        ])
        .catch((error) => console.log(error));
    },
  },
};
</script>

<template>
  <Head title="Inventory | Products" />

  <AuthenticatedAdminLayout>
    <MenuDropdown ref="menuDropdown" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Inventory / Products
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-4">
              <div>
                <label class="text-sm"
                  >Show
                  <SelectInput v-model="filter.status" name="status" @change="fetch">
                    <option :value="''">All</option>
                    <option :value="false">Listed</option>
                    <option :value="true">Delisted</option>
                  </SelectInput>
                  products
                </label>
              </div>
              <PrimaryButton
                type="button"
                class="uppercase text-sm inline-flex"
                @click="showFormModal('add')"
              >
                add product
              </PrimaryButton>
            </div>

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
                            Product name
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            Status
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
      :modalTitle="this.action + ' product'"
      @close="hideFormModal"
      :maxWidth="'xl'"
    >
      <form @submit.prevent="submit">
        <div class="grid grid-cols-12 gap-5">
          <div class="col-span-6">
            <InputLabel for="name" value="product name" :required="true" />
            <TextInput
              id="name"
              type="text"
              class="w-full"
              v-model="form.name"
              :placeholder="'Product Name'"
              autocomplete="name"
              :class="{ 'border-red-600': form.errors.name }"
            />
            <InputError :message="form.errors.name" />
          </div>

          <div class="col-span-6">
            <InputLabel for="generic_name" value="generic name" :required="false" />
            <TextInput
              id="generic_name"
              type="text"
              class="w-full"
              v-model="form.generic_name"
              :placeholder="'Generic Name'"
              autocomplete="generic_name"
              :class="{ 'border-red-600': form.errors.generic_name }"
            />
            <InputError :message="form.errors.generic_name" />
          </div>

          <div class="col-span-4">
            <InputLabel for="manufacturer" value="manufacturer" :required="false" />
            <TextInput
              id="manufacturer"
              type="text"
              class="w-full"
              v-model="form.manufacturer"
              :placeholder="'Manufacturer'"
              autocomplete="manufacturer"
              :class="{ 'border-red-600': form.errors.manufacturer }"
            />
            <InputError :message="form.errors.manufacturer" />
          </div>

          <div class="col-span-4">
            <InputLabel
              for="product_category_id"
              value="Product category"
              :required="true"
            />
            <SelectInput
              id="product_category_id"
              v-model="form.product_category_id"
              class="w-full"
              :class="{ 'border-red-600': form.errors.product_category_id }"
            >
              <option value="" disabled>-- Select Product Category --</option>
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.title }}
              </option>
            </SelectInput>
            <InputError :message="form.errors.product_category_id" />
          </div>

          <div class="col-span-4">
            <InputLabel for="measuring_unit_id" value="measuring unit" :required="true" />
            <SelectInput
              id="measuring_unit_id"
              v-model="form.measuring_unit_id"
              class="w-full"
              :class="{ 'border-red-600': form.errors.measuring_unit_id }"
            >
              <option value="" disabled>-- Select Measuring Unit --</option>
              <option v-for="unit in units" :key="unit.id" :value="unit.id">
                {{ unit.title }}
              </option>
            </SelectInput>
            <InputError :message="form.errors.measuring_unit_id" />
          </div>

          <div class="col-span-4">
            <InputLabel for="cost_price" value="cost price" :required="true" />
            <TextInput
              id="cost_price"
              type="text"
              class="w-full"
              v-model="form.cost_price"
              :placeholder="'Cost Price'"
              autocomplete="cost_price"
              :class="{ 'border-red-600': form.errors.cost_price }"
            />
            <InputError :message="form.errors.cost_price" />
          </div>

          <div class="col-span-4">
            <InputLabel for="discount" value="discount (%)" :required="false" />
            <TextInput
              id="discount"
              type="text"
              class="w-full"
              v-model="form.discount"
              :placeholder="'Discount (%)'"
              autocomplete="discount"
              :class="{ 'border-red-600': form.errors.discount }"
            />
            <InputError :message="form.errors.discount" />
          </div>

          <div class="col-span-4">
            <InputLabel for="markup_percentage" value="mark up (%)" :required="false" />
            <TextInput
              id="markup_percentage"
              type="text"
              class="w-full"
              v-model="form.markup_percentage"
              :placeholder="'Mark Up (%)'"
              autocomplete="markup_percentage"
              :class="{ 'border-red-600': form.errors.markup_percentage }"
            />
            <InputError :message="form.errors.markup_percentage" />
          </div>

          <div class="col-span-4">
            <InputLabel
              for="restock_level_at_dispensary"
              value="Restock Level At Dispensary"
              :required="true"
            />
            <TextInput
              id="restock_level_at_dispensary"
              type="text"
              class="w-full"
              v-model="form.restock_level_at_dispensary"
              :placeholder="'Restock Level At Dispensary'"
              autocomplete="restock_level_at_dispensary"
              :class="{ 'border-red-600': form.errors.restock_level_at_dispensary }"
            />
            <InputError :message="form.errors.restock_level_at_dispensary" />
          </div>

          <div class="col-span-4">
            <InputLabel
              for="restock_level_at_store"
              value="Restock Level At Store"
              :required="true"
            />
            <TextInput
              id="restock_level_at_store"
              type="text"
              class="w-full"
              v-model="form.restock_level_at_store"
              :placeholder="'Restock Level At Store'"
              autocomplete="restock_level_at_store"
              :class="{ 'border-red-600': form.errors.restock_level_at_store }"
            />
            <InputError :message="form.errors.restock_level_at_store" />
          </div>

          <div class="col-span-4">
            <InputLabel for="expires_at" value="Expires At" :required="true" />
            <TextInput
              id="expires_at"
              type="date"
              class="w-full"
              v-model="form.expires_at"
              :placeholder="'Expires At'"
              autocomplete="expires_at"
              :class="{ 'border-red-600': form.errors.expires_at }"
            />
            <InputError :message="form.errors.expires_at" />
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
    </Modal>
    <!-- end of form modal -->
    <!-- destroy modal  -->
    <Modal
      :show="destroyModal"
      :closeable="true"
      :modalTitle="action + ' product'"
      @close="hideDestroyModal"
      :maxWidth="'md'"
    >
      <div class="flex justify-center mt-4">
        <p class="text-lg">Are you sure you want to delete this product?</p>
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

<script>
import AuthenticatedDispensaryLayout from "@/Layouts/AuthenticatedDispensaryLayout.vue";
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
    AuthenticatedDispensaryLayout,
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
  },
  data() {
    const form = useForm({
      uuid: null,
      physical_stock_level_at_dispensary: 0,
      computed_stock_level_at_dispensary: 0,
      physical_stock_level_at_store: 0,
      computed_stock_level_at_store: 0,
    });

    const filter = useForm({
      level: "all",
      location: "all",
    });

    return {
      form,
      filter,
      action: "",
      editContent: false,
      formModal: false,
      selectedRow: null,
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

    $(document).on("click", ".stock", (evt) => {
      const data = $(evt.currentTarget).data("id");
      this.showFormModal(data);
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
          url: route("dispensary.inventory.stock.fetch"),
          data: {
            filter: {
              level: this.filter.level,
              location: this.filter.location,
            },
          },
        },
        columns: [
          {
            data: "name",
            title: "product name",
          },
          {
            data: "stock_level_at_dispensary",
            title: "stock level (dispensary)",
            className: "text-right",
          },
          {
            data: "stock_level_at_store",
            title: "stock level (store)",
            className: "text-right",
          },
        ],
        lengthMenu: [
          [10, 25, 50, 100, -1],
          ["10", "25", "50", "100", "All"],
        ],
        columnDefs: [
          { width: "50%", targets: 0 },
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
    showFormModal(data) {
      axios
        .post(route("dispensary.inventory.stock.edit"), {
          uuid: data,
        })
        .then((response) => [Object.assign(this.form, response.data.row)])
        .catch((error) => toastr.error("Something went wrong."));

      this.formModal = true;
    },
    submit() {
      this.form.put(route("dispensary.inventory.stock.update", { uuid: this.form.uuid }), {
        onSuccess: () => {
          this.hideFormModal();
          toastr.success("Product successfully updated");
          this.fetch();
        },
        onError: (errors) => {
          toastr.error("Something went wrong");
        },
      });
    },
    hideFormModal() {
      this.formModal = false;
      this.form.reset();
      this.form.clearErrors();
    },
  },
};
</script>

<template>
  <Head title="Inventory | Stock Levels" />

  <AuthenticatedDispensaryLayout>
    <MenuDropdown ref="menuDropdown" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Inventory / Stock Levels
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="flex items-center space-x-4 mb-4">
              <div>
                <label class="text-sm"
                  >Show
                  <SelectInput v-model="filter.level" name="level" @change="fetch">
                    <option :disabled="true">-- Select Stock Level --</option>
                    <option :value="'all'">All</option>
                    <option :value="'in'">In Stock</option>
                    <option :value="'out'">Out of Stock</option>
                  </SelectInput>
                  products
                </label>
              </div>
              <div>
                <label class="text-sm"
                  >At
                  <SelectInput v-model="filter.location" name="location" @change="fetch">
                    <option :disabled="true">-- Select Location --</option>
                    <option :value="'all'">All</option>
                    <option :value="'dispensary'">Dispensary</option>
                    <option :value="'store'">Store</option>
                  </SelectInput>
                </label>
              </div>
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
                            class="text-sm text-gray-900 px-6 py-4 text-right"
                          >
                            Stock level (dispensary)
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-right"
                          >
                            Stock level (store)
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
      :modalTitle="'stock product'"
      @close="hideFormModal"
      :maxWidth="'md'"
    >
      <form @submit.prevent="submit">
        <div class="grid grid-cols-12 gap-5">
          <div class="col-span-6">
            <InputLabel
              for="physical_stock_level_at_dispensary"
              value="physical stock level (dispensary)"
              :required="true"
            />
            <TextInput
              id="physical_stock_level_at_dispensary"
              type="number"
              class="w-full"
              v-model="form.physical_stock_level_at_dispensary"
              :placeholder="'Physical Stock Level (Dispensary)'"
              autocomplete="physical_stock_level_at_dispensary"
              :class="{
                'border-red-600': form.errors.physical_stock_level_at_dispensary,
              }"
            />
            <InputError :message="form.errors.physical_stock_level_at_dispensary" />
          </div>

          <div class="col-span-6">
            <InputLabel
              for="computed_stock_level_at_dispensary"
              value="computed stock level (dispensary)"
              :required="false"
            />
            <TextInput
              id="computed_stock_level_at_dispensary"
              type="number"
              class="w-full"
              :disabled="true"
              v-model="form.computed_stock_level_at_dispensary"
              :placeholder="'Computed Stock Level (Dispensary)'"
              autocomplete="computed_stock_level_at_dispensary"
              :class="{
                'border-red-600': form.errors.computed_stock_level_at_dispensary,
              }"
            />
            <InputError :message="form.errors.computed_stock_level_at_dispensary" />
          </div>

          <div class="col-span-6">
            <InputLabel
              for="physical_stock_level_at_store"
              value="physical stock level (store)"
              :required="true"
            />
            <TextInput
              id="physical_stock_level_at_store"
              type="number"
              class="w-full"
              v-model="form.physical_stock_level_at_store"
              :placeholder="'Computed Stock Level (Store)'"
              autocomplete="physical_stock_level_at_store"
              :class="{ 'border-red-600': form.errors.physical_stock_level_at_store }"
            />
            <InputError :message="form.errors.physical_stock_level_at_store" />
          </div>

          <div class="col-span-6">
            <InputLabel
              for="computed_stock_level_at_store"
              value="computed stock level (store)"
              :required="false"
            />
            <TextInput
              id="computed_stock_level_at_store"
              type="number"
              class="w-full"
              :disabled="true"
              v-model="form.computed_stock_level_at_store"
              :placeholder="'Computed Stock Level (Store)'"
              autocomplete="computed_stock_level_at_store"
              :class="{ 'border-red-600': form.errors.computed_stock_level_at_store }"
            />
            <InputError :message="form.errors.computed_stock_level_at_store" />
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
  </AuthenticatedDispensaryLayout>
</template>

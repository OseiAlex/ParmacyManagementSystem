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
import { readonly } from "vue";

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
      name: null,
      cost_price: 0,
      discount: 0,
      markup_percentage: 0,
      selling_price: 0,
    });

    return {
      form,
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

    $(document).on("click", ".edit", (evt) => {
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
          url: route("dispensary.inventory.pricing.fetch"),
        },
        columns: [
          {
            data: "name",
            title: "product name",
          },
          {
            data: "cost_price",
            title: "cost price (GHC)",
            className: "text-right",
          },
          {
            data: "markup_percentage",
            title: "markup percentage (%)",
            className: "text-right",
          },
          {
            data: "discount",
            title: "discount (%)",
            className: "text-right",
          },
          {
            data: "selling_price",
            title: "selling price (GHC)",
            className: "text-right",
          }
        ],
        lengthMenu: [
          [10, 25, 50, 100, -1],
          ["10", "25", "50", "100", "All"],
        ],
        columnDefs: [
          { width: "40%", targets: 0 },
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
        .post(route("dispensary.inventory.pricing.edit"), {
          uuid: data,
        })
        .then((response) => [Object.assign(this.form, response.data.row)])
        .catch((error) => toastr.error("Something went wrong."));

      this.formModal = true;
    },
    submit() {
      this.form.put(route("dispensary.inventory.pricing.update", { uuid: this.form.uuid }), {
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
    calculateSellingPrice() {
      const cost_price = parseFloat(this.form.cost_price) || 0;
      const discount = parseFloat(this.form.discount) || 0;
      const markup_percentage = parseFloat(this.form.markup_percentage) || 0;

      const markup_amount = (markup_percentage / 100) * cost_price;
      let selling_price = markup_amount + cost_price;

      const discount_amount = (discount / 100) * selling_price;
      selling_price -= discount_amount;

      this.form.selling_price = selling_price.toFixed(2);
    },
  },
};
</script>

<template>
  <Head title="Inventory | Pricing List" />

  <AuthenticatedDispensaryLayout>
    <MenuDropdown ref="menuDropdown" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Inventory / Pricing List
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
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
                            cost price (GHC)
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-right"
                          >
                            markup percentage (%)
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-right"
                          >
                            discount percentage (%)
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-right"
                          >
                            selling price (GHC)
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
          <div class="col-span-full">
            <InputLabel for="name" value="Product Name" :required="false" />
            <TextInput
              id="name"
              type="text"
              class="w-full"
              :disabled="true"
              v-model="form.name"
              :placeholder="'Product Name'"
              autocomplete="name"
              :class="{
                'border-red-600': form.errors.name,
              }"
            />
            <InputError :message="form.errors.name" />
          </div>

          <div class="col-span-6">
            <InputLabel for="cost_price" value="cost price" :required="true" />
            <TextInput
              @input="calculateSellingPrice"
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

          <div class="col-span-6">
            <InputLabel for="discount" value="discount (%)" :required="false" />
            <TextInput
              @input="calculateSellingPrice"
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

          <div class="col-span-6">
            <InputLabel for="markup_percentage" value="mark up (%)" :required="false" />
            <TextInput
              @input="calculateSellingPrice"
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

          <div class="col-span-6">
            <InputLabel for="selling_price" value="Selling Pricing" :required="false" />
            <TextInput
              id="selling_price"
              type="text"
              class="w-full"
              :disabled="true"
              v-model="form.selling_price"
              :placeholder="'Selling Pricing'"
              autocomplete="price"
              :class="{
                'border-red-600': form.errors.selling_price,
              }"
            />
            <InputError :message="form.errors.selling_price" />
          </div>

          <div class="col-span-full">
            <PrimaryButton
              type="submit"
              :disabled="form.processing"
              :class="{ 'opacity-25': form.processing }"
            >
              update
            </PrimaryButton>
          </div>
        </div>
      </form>
    </Modal>
    <!-- end of form modal -->
  </AuthenticatedDispensaryLayout>
</template>

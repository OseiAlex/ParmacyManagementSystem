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
  },
  data() {
    const form = useForm({
      uuid: null,
      title: null,
    });

    return {
      form,
      action: "",
      editContent: false,
      formModal: false,
      destroyModal: false,
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
      this.showFormModal("edit", data);
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
          url: route("admin.setup.product_category.fetch"),
        },
        columns: [
          { data: "title", title: "name" },
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
          .post(route("admin.setup.product_category.edit"), {
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
        this.form.post(route("admin.setup.product_category.store"), {
          onSuccess: () => {
            this.hideFormModal();
            toastr.success("Product Category successfully saved");
            this.fetch();
          },
          onError: (errors) => {
            toastr.error("Something went wrong");
          },
        });
      } else {
        this.form.put(
          route("admin.setup.product_category.update", { uuid: this.form.uuid }),
          {
            onSuccess: () => {
              this.hideFormModal();
              toastr.success("Product Category successfully updated");
              this.fetch();
            },
            onError: (errors) => {
              toastr.error("Something went wrong");
            },
          }
        );
      }
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
        .post(route("admin.setup.product_category.destroy"), {
          uuid: this.selectedRow,
        })
        .then((response) => [
          this.hideDestroyModal(),
          toastr.success("Product Category successfully removed"),
          this.fetch(),
        ])
        .catch((error) => console.log(error));
    },
  },
};
</script>

<template>
  <Head title="Setup | Product Categories" />

  <AuthenticatedAdminLayout>
    <MenuDropdown ref="menuDropdown" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Setup / Product Categories
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-end items-center mb-4">
              <PrimaryButton
                type="button"
                class="uppercase text-sm inline-flex"
                @click="showFormModal('add')"
              >
                add product category
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
                            title
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
      :modalTitle="this.action + ' product category'"
      @close="hideFormModal"
      :maxWidth="'md'"
    >
      <form @submit.prevent="submit">
        <div class="grid grid-cols-12 gap-5">
          <div class="col-span-full">
            <InputLabel for="title" value="title" :required="true" />
            <TextInput
              id="title"
              type="text"
              class="w-full"
              v-model="form.title"
              :placeholder="'Title'"
              autocomplete="title"
              :class="{ 'border-red-600': form.errors.title }"
            />
            <InputError :message="form.errors.title" />
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
      :modalTitle="action + ' product category'"
      @close="hideDestroyModal"
      :maxWidth="'md'"
    >
      <div class="flex justify-center mt-4">
        <p class="text-lg">Are you sure you want to delete this product category?</p>
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
  </AuthenticatedAdminLayout>
</template>

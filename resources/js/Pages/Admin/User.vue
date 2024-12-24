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
      name: null,
      username: null,
      email: null,
      phone: null,
      is_admin: false,
      password: null,
      password_confirmation: null,
    });

    const profileForm = useForm({
      id: null,
      name: null,
      username: null,
      email: null,
      phone: null,
      is_admin: false,
    });

    const passwordForm = useForm({
      id: null,
      password: null,
      password_confirmation: null,
    });

    return {
      form,
      profileForm,
      passwordForm,
      action: "",
      editContent: false,
      formModal: false,
      profileFormModal: false,
      passwordFormModal: false,
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
      this.showProfileFormModal("edit", data);
    });

    $(document).on("click", ".reset", (evt) => {
      const data = $(evt.currentTarget).data("id");

      this.showPasswordFormModal("edit", data);
    });

    $(document).on("click", ".delete", (evt) => {
      const data = $(evt.currentTarget).data("id");

      this.showDestroyModal("delete", data);
    });
  },
  methods: {
    // user methods
    fetch() {
      $("#data_table").DataTable({
        destroy: true,
        stateSave: true,
        processing: false,
        serverSide: true,
        ajax: {
          url: route("admin.user.fetch"),
        },
        columns: [
          { data: "name", name: "name" },
          { data: "username", name: "username" },
          { data: "email", name: "email" },
          { data: "phone", name: "phone" },
          { data: "role", name: "role" },
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
    showFormModal(action) {
      this.action = action;
      this.formModal = true;
    },
    hideFormModal() {
      this.formModal = false;
      this.editContent = false;
      this.action = "";
      this.form.reset();
      this.form.clearErrors();
    },
    showProfileFormModal(action, data) {
      this.action = action;
      axios
        .post(route("admin.user.edit.profile"), {
          id: data,
        })
        .then((response) => [Object.assign(this.profileForm, response.data.row)])
        .catch((error) => console.log(error));

      this.profileFormModal = true;
    },
    hideProfileFormModal() {
      this.profileFormModal = false;
      this.action = "";
      this.profileForm.reset();
      this.profileForm.clearErrors();
    },
    showPasswordFormModal(action, data) {
      this.action = action;
      this.passwordForm.id = data;

      this.passwordFormModal = true;
    },
    hidePasswordFormModal() {
      this.passwordFormModal = false;
      this.action = "";
      this.passwordForm.reset();
      this.passwordForm.clearErrors();
    },
    submit() {
      this.form.post(route("admin.user.store"), {
        onSuccess: () => {
          this.hideFormModal();
          toastr.success("User successfully saved");
          this.fetch();
        },
        onError: (errors) => {
          toastr.error("Something went wrong");
        },
      });
    },
    submitProfile() {
      this.profileForm.put(route("admin.user.update.profile", this.profileForm.id), {
        onSuccess: () => {
          this.hideProfileFormModal();
          toastr.success("User successfully updated");
          this.fetch();
        },
        onError: (errors) => {
          toastr.error("Something went wrong");
        },
      });
    },
    submitPassword() {
      this.passwordForm.put(route("admin.user.update.password", this.passwordForm.id), {
        onSuccess: () => {
          this.hidePasswordFormModal();
          toastr.success("Password successfully updated");
        },
        onError: (errors) => {
          toastr.error("Something went wrong");
        },
      });
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
        .post(route("admin.user.destroy"), {
          id: this.selectedRow,
        })
        .then((response) => [
          this.hideDestroyModal(),
          toastr.success("User successfully removed"),
          this.fetch(),
        ])
        .catch((error) => console.log(error));
    },
  },
};
</script>

<template>
  <Head title="Manage Users" />

  <AuthenticatedAdminLayout>
    <MenuDropdown ref="menuDropdown" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Users</h2>
    </template>

    <div class="py-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-end items-center mb-4">
              <PrimaryButton
                type="button"
                class="uppercase text-sm inline-flex"
                @click="showFormModal('add')"
              >
                add user
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
                            name
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            username
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            email
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            phone
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            role
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
      :modalTitle="this.action + ' user'"
      @close="hideFormModal"
      :maxWidth="'md'"
    >
      <form @submit.prevent="submit">
        <div class="grid grid-cols-12 gap-5">
          <div class="col-span-full">
            <InputLabel for="name" value="Name" :required="true" />
            <TextInput
              id="name"
              type="text"
              class="w-full"
              v-model="form.name"
              :placeholder="'Name'"
              autocomplete="name"
              :class="{ 'border-red-600': form.errors.name }"
            />
            <InputError :message="form.errors.name" />
          </div>

          <div class="col-span-full">
            <InputLabel for="username" value="username" :required="true" />
            <TextInput
              id="username"
              type="text"
              class="w-full"
              v-model="form.username"
              :placeholder="'Username'"
              autocomplete="username"
              :class="{ 'border-red-600': form.errors.username }"
            />
            <InputError :message="form.errors.username" />
          </div>

          <div class="col-span-full">
            <InputLabel for="email" value="Email" :required="true" />
            <TextInput
              id="email"
              type="email"
              class="w-full"
              v-model="form.email"
              :placeholder="'Email'"
              autocomplete="email"
              :class="{ 'border-red-600': form.errors.email }"
            />
            <InputError :message="form.errors.email" />
          </div>

          <div class="col-span-full">
            <InputLabel for="phone" value="phone" :required="true" />
            <TextInput
              id="phone"
              type="text"
              class="w-full"
              v-model="form.phone"
              :placeholder="'Phone'"
              autocomplete="phone"
              :class="{ 'border-red-600': form.errors.phone }"
            />
            <InputError :message="form.errors.phone" />
          </div>

          <div class="col-span-full">
            <InputLabel for="Role" value="Role" :required="false" />
            <div class="flex items-center space-x-2">
              <Checkbox v-model="form.is_admin" :value="true" />
              <InputLabel for="Role" value="Is Administrator?" :required="false" />
            </div>
            <InputError :message="form.errors.is_admin" />
          </div>

          <div class="col-span-full">
            <InputLabel for="password" value="Password" :required="true" />
            <TextInput
              id="password"
              type="password"
              class="w-full"
              v-model="form.password"
              :placeholder="'Password'"
              autocomplete="password"
              :class="{ 'border-red-600': form.errors.password }"
            />
            <InputError :message="form.errors.password" />
          </div>

          <div class="col-span-full">
            <InputLabel
              for="password_confirmation"
              value="Confirm Password"
              :required="true"
            />
            <TextInput
              id="password_confirmation"
              type="password"
              class="w-full"
              v-model="form.password_confirmation"
              :placeholder="'Confirm Password'"
              autocomplete="password_confirmation"
              :class="{ 'border-red-600': form.errors.password_confirmation }"
            />
            <InputError :message="form.errors.password_confirmation" />
          </div>
          <div class="col-span-full">
            <PrimaryButton
              type="submit"
              :disabled="form.processing"
              :class="{ 'opacity-25': form.processing }"
              >save
            </PrimaryButton>
          </div>
        </div>
      </form>
    </Modal>
    <!-- end of form modal -->

    <!-- profile form modal -->
    <Modal
      :show="profileFormModal"
      :closeable="true"
      :modalTitle="this.action + ' user'"
      @close="hideProfileFormModal"
      :maxWidth="'md'"
    >
      <form @submit.prevent="submitProfile">
        <div class="grid grid-cols-12 gap-5">
          <div class="col-span-full">
            <InputLabel for="name" value="Name" :required="true" />
            <TextInput
              id="name"
              type="text"
              class="w-full"
              v-model="profileForm.name"
              :placeholder="'Name'"
              autocomplete="name"
              :class="{ 'border-red-600': profileForm.errors.name }"
            />
            <InputError :message="profileForm.errors.name" />
          </div>

          <div class="col-span-full">
            <InputLabel for="username" value="username" :required="true" />
            <TextInput
              id="username"
              type="text"
              class="w-full"
              v-model="profileForm.username"
              :placeholder="'Username'"
              autocomplete="username"
              :class="{ 'border-red-600': profileForm.errors.username }"
            />
            <InputError :message="profileForm.errors.username" />
          </div>

          <div class="col-span-full">
            <InputLabel for="email" value="Email" :required="true" />
            <TextInput
              id="email"
              type="email"
              class="w-full"
              v-model="profileForm.email"
              :placeholder="'Email'"
              autocomplete="true"
              :class="{ 'border-red-600': profileForm.errors.email }"
            />
            <InputError :message="profileForm.errors.email" />
          </div>

          <div class="col-span-full">
            <InputLabel for="phone" value="phone" :required="true" />
            <TextInput
              id="phone"
              type="text"
              class="w-full"
              v-model="profileForm.phone"
              :placeholder="'Phone'"
              autocomplete="true"
              :class="{ 'border-red-600': profileForm.errors.phone }"
            />
            <InputError :message="profileForm.errors.phone" />
          </div>

          <div class="col-span-full">
            <InputLabel for="Role" value="Role" :required="false" />
            <div class="flex items-center space-x-2">
              <Checkbox v-model:checked="profileForm.is_admin" :value="true" />
              <InputLabel for="Role" value="Is Administrator?" :required="false" />
            </div>
            <InputError :message="profileForm.errors.is_admin" />
          </div>

          <div class="col-span-full">
            <PrimaryButton
              type="submit"
              :disabled="profileForm.processing"
              :class="{ 'opacity-25': profileForm.processing }"
              >update
            </PrimaryButton>
          </div>
        </div>
      </form>
    </Modal>
    <!-- end of profile form modal -->

    <!-- password form modal -->
    <Modal
      :show="passwordFormModal"
      :closeable="true"
      :modalTitle="this.action + ' password'"
      @close="hidePasswordFormModal"
      :maxWidth="'md'"
    >
      <form @submit.prevent="submitPassword">
        <div class="grid grid-cols-12 gap-5">
          <div class="col-span-full">
            <InputLabel for="password" value="Password" :required="true" />
            <TextInput
              id="password"
              type="password"
              class="w-full"
              v-model="passwordForm.password"
              :placeholder="'Password'"
              autocomplete="password"
              :class="{ 'border-red-600': passwordForm.errors.password }"
            />
            <InputError :message="passwordForm.errors.password" />
          </div>

          <div class="col-span-full">
            <InputLabel
              for="password_confirmation"
              value="Confirm Password"
              :required="true"
            />
            <TextInput
              id="password_confirmation"
              type="password"
              class="w-full"
              v-model="passwordForm.password_confirmation"
              :placeholder="'Confirm Password'"
              autocomplete="password_confirmation"
              :class="{ 'border-red-600': passwordForm.errors.password_confirmation }"
            />
            <InputError :message="passwordForm.errors.password_confirmation" />
          </div>

          <div class="col-span-full">
            <PrimaryButton
              type="submit"
              :disabled="passwordForm.processing"
              :class="{ 'opacity-25': form.processing }"
              >update
            </PrimaryButton>
          </div>
        </div>
      </form>
    </Modal>
    <!-- end of password form modal -->

    <!-- destroy modal  -->
    <Modal
      :show="destroyModal"
      :closeable="true"
      :modalTitle="action + ' user'"
      @close="hideDestroyModal"
      :maxWidth="'md'"
    >
      <div class="flex justify-center mt-4">
        <p class="text-lg">Are you sure you want to delete this user?</p>
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

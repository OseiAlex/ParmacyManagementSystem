<script>
import AuthenticatedAdminLayout from "@/Layouts/AuthenticatedAdminLayout.vue";
import { Head } from "@inertiajs/vue3";

export default {
  components: {
    AuthenticatedAdminLayout,
    Head,
  },
  props: {
    activities: Object,
  },
  mounted() {
    $("#data_table").DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        ["10", "25", "50", "100", "All"],
      ],
      order: [[0, "desc"]],
      columnDefs: [{ width: "60%", targets: -1 }],
    });
  },
};
</script>

<template>
  <Head title="Activity Log" />

  <AuthenticatedAdminLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Activity Log</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
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
                            datetime
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            action
                          </th>
                          <th
                            scope="col"
                            class="text-sm text-gray-900 px-6 py-4 text-left"
                          >
                            description
                          </th>
                        </tr>
                      </thead>
                      <tbody class="text-sm">
                        <tr v-for="activity in activities">
                          <td><span class="hidden">{{ activity.logged_at_string }}</span>{{ activity.logged_at }}</td>
                          <td>
                            <span
                              class="bg-purple-300 px-2 py-1 rounded font-semibold text-purple-900 text-xs"
                            >
                              {{ activity.subject }}
                            </span>
                          </td>
                          <td>{{ activity.content }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedAdminLayout>
</template>

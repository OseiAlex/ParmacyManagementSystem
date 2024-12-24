<script>
import AuthenticatedAdminLayout from "@/Layouts/AuthenticatedAdminLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

export default {
  components: {
    AuthenticatedAdminLayout,
    Head,
  },
  props: {
    errors: Object,
    admins: Number,
    pharmacists: Number,
    products: Number,
    expiredProducts: Number,
    dispensaryShortage: Number,
    storeShortage: Number,
    todaySalesCash: String,
    salesToday: Object
  },
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedAdminLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12 px-3 md:px-0">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col space-y-8">
          <!-- users -->
          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- admins card -->
            <div class="bg-white shadow-sm rounded-md p-6">
              <div class="flex items-center gap-4">
                <div>
                  <span class="material-symbols-outlined"> shield_person </span>
                </div>
                <div>
                  <p class="text-xl font-bold">{{ admins }}</p>
                  <span class="text-gray-500 text-sm font-bold uppercase">
                    Administrator{{ admins != 1 ? "s" : "" }}
                  </span>
                </div>
              </div>
            </div>
            <!-- end of admins card -->

            <!-- pharmacists card -->
            <div class="bg-white shadow-sm rounded-md p-6">
              <div class="flex items-center gap-4">
                <div>
                  <span class="material-symbols-outlined"> person </span>
                </div>
                <div>
                  <p class="text-xl font-bold">{{ pharmacists }}</p>
                  <span class="text-gray-500 text-sm font-bold uppercase">
                    pharmacist{{ pharmacists != 1 ? "s" : "" }}
                  </span>
                </div>
              </div>
            </div>
            <!-- end of pharmacists card -->

            <!-- products card -->
            <div class="bg-white shadow-sm rounded-md p-6">
              <div class="flex items-center gap-4">
                <div>
                  <span class="material-symbols-outlined"> medication </span>
                </div>
                <div>
                  <p class="text-xl font-bold">{{ products }}</p>
                  <span class="text-gray-500 text-sm font-bold uppercase">
                    product{{ products != 1 ? "s" : "" }}
                  </span>
                </div>
              </div>
            </div>

            <!-- expired products card -->
            <div class="bg-white shadow-sm rounded-md p-6">
              <div class="flex items-center gap-4">
                <div>
                  <span class="material-symbols-outlined"> event_busy </span>
                </div>
                <div>
                  <p class="text-xl font-bold">{{ expiredProducts }}</p>
                  <span class="text-gray-500 text-sm font-bold uppercase">
                    expired product{{ expiredProducts != 1 ? "s" : "" }}
                  </span>
                </div>
              </div>
            </div>

            <!-- short products (dispensary) card -->
            <div class="bg-white shadow-sm rounded-md p-6">
              <div class="flex items-center gap-4">
                <div>
                  <span class="material-symbols-outlined"> trending_down </span>
                </div>
                <div>
                  <p class="text-xl font-bold">{{ dispensaryShortage }}</p>
                  <span class="text-gray-500 text-sm font-bold uppercase">
                    product{{ expiredProducts != 1 ? "s" : "" }} shortage at dispensary
                  </span>
                </div>
              </div>
            </div>

            <!-- short products (store) card -->
            <div class="bg-white shadow-sm rounded-md p-6">
              <div class="flex items-center gap-4">
                <div>
                  <span class="material-symbols-outlined"> trending_down </span>
                </div>
                <div>
                  <p class="text-xl font-bold">{{ storeShortage }}</p>
                  <span class="text-gray-500 text-sm font-bold uppercase">
                    product{{ expiredProducts != 1 ? "s" : "" }} shortage at store
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- end of clients -->

          <!-- deals -->
          <div>
            <div class="flex justify-between items-center">
              <p class="font-semibold text-gray-500 text-sm uppercase">sales</p>
            </div>
            <div class="mt-2 grid md:grid-cols-2 lg:grid-cols-3 gap-5">
              <!-- today sales cash card -->
              <div class="bg-white shadow-sm rounded-md p-6">
                <div class="flex items-center gap-4">
                  <div>
                    <span class="material-symbols-outlined"> payments </span>
                  </div>
                  <div>
                    <p class="text-xl font-bold">{{ todaySalesCash }}</p>
                    <span class="text-gray-500 text-sm font-bold uppercase">
                      today sales cash
                    </span>
                  </div>
                </div>
              </div>
              <!-- end of today sales cash card -->
            </div>
          </div>
          <!-- end of deals -->

          <div class="grid grid-cols-1 gap-5">
            <!-- today sales card -->
            <div class="col-span-2 bg-white shadow-sm rounded-md p-6">
              <p class="text-md font-bold capitalize">today sales</p>

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
                          </tr>
                        </thead>
                        <tbody class="text-sm">
                          <tr v-for="sales in salesToday" v-if="salesToday.length >= 1">
                            <td>{{ sales.sold_at }}</td>
                            <td>{{ sales.name }}</td>
                            <td>{{ sales.user.name }}</td>
                            <td>{{ sales.payment_mode.title }}</td>
                            <td class="text-right">{{ sales.amount_due }}</td>
                            <td class="text-right">{{ sales.amount_paid }}</td>
                            <td class="text-right" :class="{ 'text-red-600' : sales.amount_debt < 0  }">{{ sales.amount_debt < 0 ? (-1*sales.amount_debt).toFixed(2) : sales.amount_debt }}</td>
                          </tr>
                          <tr v-else>
                            <td colspan="7" class="text-center text-gray-800 font-medium">
                              No sales yet</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end of hot sales card -->

            <!-- top products card -->
            <!-- <div class="bg-white shadow-sm rounded-md p-6">
              <p class="text-md font-bold capitalize">top products</p>
            </div> -->
            <!-- end of top products card -->
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedAdminLayout>
</template>

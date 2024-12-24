<script setup>
import { ref, computed } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import SidebarNavLink from "@/Components/SidebarNavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link, usePage } from "@inertiajs/vue3";
import ThemeToggle from "@/Components/ThemeToggle.vue";

const showingNavigationDropdown = ref(false);
const isSidebarOpen = ref(false);
const sidebarNavIcon = computed(() =>
  isSidebarOpen.value
    ? "block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 bg-gray-100 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    : "block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
);

const props = defineProps({
  election: Object,
});

// Toggle sidebar for mobile view
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

// Get the current route name for active link highlighting
const { component } = usePage().props;
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar -->
    <div
      class="fixed inset-y-0 left-0 bg-white dark:bg-gray-800 w-96 md:w-72 shadow-md transform transition-transform duration-300 ease-in-out z-50 lg:translate-x-0 lg:overflow-y-auto lg:w-72"
      :class="[isSidebarOpen ? 'translate-x-0' : '-translate-x-full', 'lg:translate-x-0']"
    >
      <div class="flex flex-col">
        <!-- Logo -->
        <div class="shrink-0 flex justify-center items-center py-5">
          <Link :href="route('dispensary.dashboard.index')">
            <ApplicationLogo class="block h-10 w-auto fill-current text-gray-800" />
          </Link>
        </div>
        <!-- Navigation Links -->
        <nav class="flex flex-col p-5 gap-y-5">
          <div>
            <div>
              <SidebarNavLink
                :href="route('dispensary.dashboard.index')"
                :active="route().current('dispensary.dashboard.index')"
              >
                <span class="material-symbols-outlined mr-3">dashboard</span>
                Overview
              </SidebarNavLink>
            </div>

            <div>
              <SidebarNavLink
                :href="route('dispensary.sale.index')"
                :active="route().current('dispensary.sale.index')"
              >
                <span class="material-symbols-outlined mr-3">payments</span>
                sales
              </SidebarNavLink>
            </div>
          </div>

          <!-- inventory -->
          <div>
            <p class="text-gray-600 uppercase font-semibold text-xs tracking-wide pb-2">
              inventory
            </p>

            <SidebarNavLink
              :href="route('dispensary.inventory.pricing.index')"
              :active="route().current('dispensary.inventory.pricing.index')"
            >
              <span class="material-symbols-outlined mr-3">money</span>
              pricing list
            </SidebarNavLink>

            <SidebarNavLink
              :href="route('dispensary.inventory.stock.index')"
              :active="route().current('dispensary.inventory.stock.index')"
            >
              <span class="material-symbols-outlined mr-3"> bar_chart </span>
              Stock Levels
            </SidebarNavLink>

            <!-- <SidebarNavLink :href="route('dispensary.inventory.expired.index')" :active="route().current('dispensary.inventory.expired.index')">
              <span class="material-symbols-outlined mr-3"> event_busy </span>
              top products
            </SidebarNavLink> -->

            <SidebarNavLink
              :href="route('dispensary.inventory.expired.index')"
              :active="route().current('dispensary.inventory.expired.index')"
            >
              <span class="material-symbols-outlined mr-3"> event_busy </span>
              Expired products
            </SidebarNavLink>
          </div>
        </nav>
      </div>
    </div>

    <div
      v-if="isSidebarOpen"
      class="fixed inset-0 bg-black opacity-50 z-100 lg:hidden"
      @click="toggleSidebar"
    ></div>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col lg:ml-72">
      <!-- Header -->
      <header class="flex items-center justify-between bg-white border-b p-4">
        <div class="flex items-center space-x-4">
          <button
            class="text-gray-500 focus:outline-none lg:hidden"
            @click="toggleSidebar"
            aria-label="Toggle Sidebar"
            aria-expanded="isSidebarOpen"
          >
            <svg
              class="h-6 w-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              ></path>
            </svg>
          </button>
          <div>
            <p class="font-semibold text-lg text-gray-800 leading-tight">Dispensary</p>
          </div>
        </div>

        <div class="flex space-x-3 items-center">
          <!-- <div>
            <span class="text-gray-500 text-sm cpaitalize">
            switch to
            <Link :href="route('admin.dashboard.index')" class="text-gray-800 font-bold text-md">Administrator</Link>
            </span>
          </div> -->
          <!-- Settings Dropdown -->
          <div class="relative">
            <Dropdown align="right" width="48">
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <span class="material-symbols-outlined"> account_circle </span>

                    <svg
                      class="-me-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <DropdownLink
                  :href="route('dispensary.profile.edit')"
                  class="inline-flex items-center"
                >
                  <span class="material-symbols-outlined me-1"> person </span> Profile
                </DropdownLink>
                <DropdownLink
                  :href="route('logout')"
                  method="post"
                  as="button"
                  class="inline-flex items-center"
                >
                  <span class="material-symbols-outlined me-1"> logout </span>
                  Log Out
                </DropdownLink>
              </template>
            </Dropdown>
          </div>
        </div>
      </header>

      <!-- Competition Heading -->
      <header class="bg-white shadow-sm py-6 px-4 sm:px-6 lg:px-8">
        <p
          class="font-semibold capitalize text-gray-700 leading-tight"
          v-if="$slots.header"
        >
          <slot name="header" />
        </p>
      </header>

      <!-- Page Content -->
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

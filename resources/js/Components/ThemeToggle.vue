<template>
  <button type="button" @click="toggleTheme" class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
    <span class="material-symbols-outlined">
      {{ theme === "light" ? "dark_mode" : "light_mode" }}
    </span>
  </button>
</template>

<script>
export default {
  data() {
    return {
      theme: localStorage.getItem("theme") || "light", // Default to 'light' if no theme is set
    };
  },
  mounted() {
    // Apply the saved theme or the default theme when the component is mounted
    this.applyTheme(this.theme);
  },
  watch: {
    theme(newTheme) {
      // Apply the new theme and save it to localStorage
      this.applyTheme(newTheme);
      localStorage.setItem("theme", newTheme);
    },
  },
  methods: {
    toggleTheme() {
      // Toggle between light and dark themes
      this.theme = this.theme === "light" ? "dark" : "light";
    },
    applyTheme(theme) {
      // Set the class on the root HTML element
      document.documentElement.className = theme;
    },
  },
};
</script>

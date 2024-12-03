<!-- src/components/ExampleComponent.vue -->
<template>
  <div class="text-center p-4 bg-blue-100 rounded-lg">
    <h1 class="text-2xl font-bold">Hello from Vue 3!</h1>
    <p class="mt-2">This is a Vue component integrated with CakePHP and Vite.</p>
    <h2 class="mt-4">Counter: {{ count }}</h2>
    <p class="mt-2">
      <button @click="increment">Increment</button>
      <button @click="decrement">Decrement</button>
    </p>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'ExampleComponent',
  computed: {
    ...mapGetters(['getCount']),
    count() {
      return this.getCount;
    },
  },
  methods: {
    ...mapActions(['increment', 'decrement']),
  },
};
</script>

<style scoped>
button {
  margin: 5px;
}
</style>

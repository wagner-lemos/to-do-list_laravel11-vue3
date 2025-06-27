<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-full max-w-md">
      <TaskForm :task="store.selectedTask" />
      <button @click="closeModalTask" class="mt-4 text-sm text-gray-600">Fechar</button>
    </div>
  </div>
</template>

<script setup>
import TaskForm from './TaskForm.vue';
import { useTaskStore } from '../stores/taskStore';
const store = useTaskStore();


function closeModalTask() {
  store.selectedTask = null;
  store.modalOpen = false;
}


</script>
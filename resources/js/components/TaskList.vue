<template>
  <div>
    <div v-if="store.loading">Carregando...</div>
    <div v-else>
      <TaskItem v-for="task in store.tasks" :key="task.id" :task="task" />
    </div>
  </div>
</template>

<script setup>
import TaskItem from './TaskItem.vue';
import { useTaskStore } from '../stores/taskStore';

const store = useTaskStore();
store.fetchTasks();
</script>
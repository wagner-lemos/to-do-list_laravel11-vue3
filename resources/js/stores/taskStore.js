import { defineStore } from 'pinia';
import taskService from '../services/taskService';

export const useTaskStore = defineStore('tasks', {
  state: () => ({
    tasks: [],
    loading: false,
    modalOpen: false,
    selectedTask: null,
  }),
  actions: {
    async fetchTasks() {
      this.loading = true;
      this.tasks = await taskService.list();
      this.loading = false;
    },
    async createTask(data) {
      const task = await taskService.create(data);
      this.tasks.unshift(task);
    },
    async updateTask(id, data) {
      const updated = await taskService.update(id, data);
      this.tasks = this.tasks.map(t => t.id === id ? updated : t);
    },
    async deleteTask(id) {
      await taskService.delete(id);
      this.tasks = this.tasks.filter(t => t.id !== id);
    },
    async toggleTask(id) {
      const toggled = await taskService.toggle(id);
      this.tasks = this.tasks.map(t => t.id === id ? toggled : t);
    },
  }
});